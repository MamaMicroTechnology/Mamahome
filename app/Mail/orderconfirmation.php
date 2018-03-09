<?php

namespace App\Mail;

use App\Requirement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class orderconfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $requirement;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Requirement $requirement)
    {
        $this->requirement = $requirement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@mamahome360.com')
            ->markdown('email.orderconfirmation');
    }
}
