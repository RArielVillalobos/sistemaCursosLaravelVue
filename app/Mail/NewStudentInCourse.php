<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewStudentInCourse extends Mailable
{
    use Queueable, SerializesModels;

    private $course;
    private $student_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course,$student_name)
    {
        //
        $this->course=$course;
        $this->student_name=$student_name;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Nuevo Estudiante inscrito en tu curso'))
            //COMO YA LO CONFIGURAMOS NO HACE FALTA EL FROM
            //->from(env('MAIL_FROM_ADRESS'));
        ->markdown('emails.new_student_in_course')
        ->with('course',$this->course)
        ->with('student',$this->student_name);


    }
}
