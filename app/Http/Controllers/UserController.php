<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\MyHelper;
use App\Mail\PasswordInfo;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class UserController extends Controller
{
    // User Role
    const SUPERADMIN = 1;
    const ADMIN = 2;
    const REGULAR = 3;

    public function showVotersPage() {
        return MyHelper::renderWithRole('User/Voters', [
            'all_users' => User::where('vote_status', '<>', 'pending')->orderBy('vote_status')->get()->map(function ($user) {
                return [
                    'nim' => $user->nim,
                    'name' => $user->name,
                    'email' => $user->email,
                    'vote_status' => $user->vote_status,
                    'role_id' => $user->role_id,
                ];
            }),
            'pending_users' => User::where('vote_status', 'pending')->orderBy('vote_status')->get()->map(function ($user) {
                return [
                    'nim' => $user->nim,
                    'name' => $user->name,
                    'email' => $user->email,
                    'vote_status' => $user->vote_status,
                    'role_id' => $user->role_id,
                ];
            }),
        ]);
    }

    // Superadmin functions
    private function generateRandomString($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function show(Request $request) {
        return MyHelper::renderWithRole('User/Index', [
            'all_users' => User::orderBy('role_id')->get(),
            'info' => $request->session()->get('info', ''),
        ]);
    }

    public function import(Request $request) {
        // Get csv file
        $file = $request->file('csv');

        // Get file details
        $filename = $file->getClientOriginalName();

        // Moving file
        $location = 'uploads';
        $file->move($location,$filename);
        $filepath = public_path($location . "/" . $filename);

        // Create a CSV reader instance
        //$reader = Reader::createFromFileObject($file->openFile());
        $fileopened = fopen($filepath, "r");
        if($fileopened !== FALSE){
            // while(!feof($fileopened)){
            //     $lines[] = fgetcsv($fileopened,1000,',');
            // }
            // Loop through rows
            $userData = [];
            $counter = 0;
            DB::beginTransaction();
            try {
                // foreach ($reader as $lines => $row) 
                while(($line = fgetcsv($fileopened)) !== FALSE){
                    // Parse NIM and Name: name;NIM;angkatan;email;row
                    $csvRowArray = $line; 
                    //explode(",", $row[0])
                    $name = $csvRowArray[0];
                    $nim = $csvRowArray[1];
                    $angkatan = $csvRowArray[2];
                    $email = $csvRowArray[3];
                    $speadsheetRow = $csvRowArray[4];

                    // Generate User model
                    $user = new User;

                    $user->nim = $nim;
                    $user->name = $name;
                    $user->angkatan = $angkatan;
                    $user->role_id = self::REGULAR; // Regular User
                    $user->email = $email;
                    $user->ss_row = $speadsheetRow;

                    $randomPassword = $this->generateRandomString(10);
                    $user->password = Hash::make($randomPassword);

                    $user->save();

                    // Encrypt and decrypt NIM
                    $nimArray = [];
                    $encrypted = Crypt::encryptString($nim);
                    $decrypted = Crypt::decryptString($encrypted);

                    // Check if successfully decrypt NIM, and encrypted NIM must be unique
                    $status = ($decrypted == $nim) && (!in_array($encrypted, $nimArray));

                    $nimArray[$encrypted] = $nim;

                    array_push($userData, [
                        'nim' => $nim,
                        'name' => $name,
                        'email' => $user->email,
                        'password' => $randomPassword,
                        'status' => $status
                    ]);

                    // Counter for rows
                    $counter += 1;
                }
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
            DB::commit();
        
            return MyHelper::renderWithRole('User/Index', [
                'imported_users' => $userData,
                'row_count' => $counter,
                'all_users' => User::orderBy('role_id')->get(),
            ]);
        }else{
            return "Error parsing CSV!";
        }
    }

    public function sendPasswords(Request $request) {
        // Get csv file
        $file = $request->file('csv');
        // Get file details
        $filename = $file->getClientOriginalName();

        // Moving file
        $location = 'uploads';
        $file->move($location,$filename);
        $filepath = public_path($location . "/" . $filename);

        // Create a CSV reader instance
        //$reader = Reader::createFromFileObject($file->openFile());
        $fileopened = fopen($filepath, "r");
        if($fileopened !== FALSE){

            // Create a CSV reader instance
            //$reader = Reader::createFromFileObject($file->openFile());

            // Loop through rows
            while(($line = fgetcsv($fileopened)) !== FALSE) {
                // Parse NIM, email, and password
                //$nimEmailPassword = explode(";", $row[0]
                $nimEmailPassword = $line;
                $nim = $nimEmailPassword[0];
                $email = $nimEmailPassword[1];
                $password = $nimEmailPassword[2];

                // Send email using queue
                Mail::to($email)
                    ->send(new PasswordInfo($nim, $password));
            }

            return redirect()->route('users')->with('info', "Sukses mengirimkan password");
        }else{
            return "Error parsing CSV!";
        }
    }
}
