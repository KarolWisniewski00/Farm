<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExampleEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $token;
    /**
     * Create a new message instance.
     *
     * @param $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('karol.wisniewski2901@gmail.com', 'FARM')
        ->subject('Frorget password')
        ->view('mail',['token'=>$this->token]);
    }

}
