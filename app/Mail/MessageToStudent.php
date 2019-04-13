<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageToStudent extends Mailable
{
    use Queueable, SerializesModels;
    private $teacherName;
    private $text_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($teacherName,$text_message)
    {

        $this->teacherName=$teacherName;
        $this->text_message=$text_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject(__('Mensaje de :teacher',['teacher'=>$this->teacherName]))
                ->markdown('emails.message_to_student')
                ->with('text_message',$this->text_message);

    }
}
