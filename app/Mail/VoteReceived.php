<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoteReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $nim;
    public $name;
    public $time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nim, $name, $time)
    {
        $this->nim = $nim;
        $this->name = $name;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Suara Telah Diterima')
            ->view('emails.vote-received');
    }
}
