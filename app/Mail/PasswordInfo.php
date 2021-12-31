<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $nim;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nim, $password)
    {
        $this->nim = $nim;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Informasi Akun ' . env('APP_NAME'))
            ->view('emails.password-info');
    }
}
