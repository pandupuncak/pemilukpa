<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\MyHelper;
use App\Http\Requests\StoreVoteRequest;
use App\Mail\VoteReceived;
use App\Models\VoteLog;
use App\Models\VoteRequest;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Sheets;
use Storage;

define("VOTE_REQUESTS_ROUTE", "vote.requests");

class VoteController extends Controller
{
    public function showVotePage() {
        // If show description based on user status
        $user = Auth::user();

        if ($user->isUserCanVote() && MyHelper::isVotingPeriod()) {
            // render vote page
            return MyHelper::renderWithRole('Vote/Index');
        } else {
            // redirect
            return redirect('dashboard');
        }
    }

    public function showVoteResultsPage()
    {
        if (MyHelper::isResultOpenPeriod() || Auth::user()->isSuperadmin()) {
            return MyHelper::renderWithRole('Vote/Results', [
                'votes' => VoteRequest::where('status', 'approved')->oldest()->get()->map(function ($vote) {
                    return [
                        'voted_president' => $vote->voted_president,
                    ];
                }),
                'status' => 2 // Ready
            ]);
        } else {
            return MyHelper::renderWithRole('Vote/Results', [
                'status' => 1 // Not ready yet
            ]);
        }
    }

    public function showVoteRequestsPage(Request $request)
    {
        return MyHelper::renderWithRole('Vote/Requests', [
            'can' => [
                'admin-action' => Auth::user()->can('admin-action'),
            ],
            'done_requests' => VoteRequest::where('status', '<>', 'pending')->get()->map(function ($vote) {
                return [
                    'id' => $vote->id,
                    'photo_url' => Storage::url($vote->photo_url),
                    'status' => $vote->status,
                    'voted_president' => $vote->voted_president,
                    'action_by' => $vote->action_by,
                    'updated_at' => $vote->updated_at->format('d M Y, H:i'),
                    'created_at' => $vote->created_at->format('d M Y, H:i'),
                ];
            }),
            'info' => $request->session()->get('info', ''),
            'error' => $request->session()->get('error', ''),
        ]);
    }

    public function createVoteRequest(StoreVoteRequest $request) {
        $user = Auth::user();
        // Validate photo type and size
        $request->validated();

        // Check if a user can vote
        if ($user->isUserCanVote() && MyHelper::isVotingPeriod()) {
            // Create new VoteRequest
            DB::beginTransaction();
            try {
                // Save and auto-approve vote request
                $voteRequest = new VoteRequest;
                $voteRequest->nim = Crypt::encryptString($user->nim);

                $voteRequest->voted_president = $request->president;
                $voteRequest->status = 'approved';

                $voteRequest->save();
                $voteNumber = DB::table('vote_requests')->count();

                // Increase president candidate vote by 1
                $president = $voteRequest->voted_president;
                $voteLogMessage = "Request approved, selected: $president";

                // Create vote log
                $voteLog = new VoteLog;
                $voteLog->message = $voteLogMessage;
                $voteLog->save();

                // Update vote_status of user
                $user->vote_status = 'approved';
                $user->save();

                // Prepare user data
                $email = $user->email;
                $emailOffice = $user->nim . '@office.itb.ac.id';
                $nim = $user->nim;
                $name = $user->name;
                $time = $voteRequest->created_at;

                // Update spreadsheet
                $spreadsheetIds = [
                    '1k2VUmjjQdo4OhPrffrzvA0wMVYXU8MCX9alm9kw7aKk',
                    '1dj2yp07mEft94hx14XyKt0tNvYvrZDxLEJyC1HxcrY8'
                ];
                $sheetIds = ['0', '85510360'];
                $userRow = $user->ss_row;
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
            // Commit DB Transaction
            DB::commit();

            // WARNING: Always append vote log first, then update user vote status
            // Append vote log
            Sheets::spreadsheet($spreadsheetIds[1])
                ->sheetById($sheetIds[1])
                ->range('Sheet1!A:E')
                ->append([[$voteNumber, $president]]);

            // Update user vote status in spreadsheet
            Sheets::spreadsheet($spreadsheetIds[0])
                ->sheetById($sheetIds[0])
                ->range('Sheet1!A:C')
                #->range('A' . ($userRow + 1))
                ->update([[$nim, $name, "Telah Memilih"]]);

            // Send mail to registered email
            Mail::to($email)
                ->send(new VoteReceived($nim, $name, $time));

            // Send another mail to office ITB mail
            Mail::to($emailOffice)
                ->send(new VoteReceived($nim, $name, $time));

            return redirect('dashboard');
        } else {
            // Reject vote request
            return redirect('dashboard');
        }
    }
}
