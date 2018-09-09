<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LunchError extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User name.
     *
     * @var $name
     */
    public $name;

    /**
     * Date Order.
     *
     * @var $date
     */
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($date, $name = null)
    {
        $this->name = $name;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->name == null) return $this->from('ngophuongtuan@gmail.com')
            ->view('Email.succes');
        else return $this->from('ngophuongtuan@gmail.com')
            ->view('Email.lunch');
    }
}
