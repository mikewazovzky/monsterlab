<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WebsiteFeedback extends Mailable // implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $feedbackData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($feedbackData)
    {
        $this->feedbackData = $feedbackData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('WebsiteFeedback: ' . $this->feedbackData['subj'])
            ->markdown('emails.feedback');
    }
}
