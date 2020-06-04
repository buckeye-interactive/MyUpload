<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MediaApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $mediaItem;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($media)
    {
        $this->mediaItem = $media;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $media = $this->mediaItem;
        
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->view('emails.approved', compact([
                       'media'
                    ]));
    }
}
