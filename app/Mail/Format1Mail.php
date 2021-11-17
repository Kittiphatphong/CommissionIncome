<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Format1Mail extends Mailable
{
    use Queueable, SerializesModels;

   protected $your_subject;
   protected $your_title;
   protected $your_content;
    public function __construct($your_subject,$your_title,$your_content)
    {
        $this->your_subject = $your_subject;
        $this->your_title = $your_title;
        $this->your_content = $your_content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.format1')
            ->subject($this->your_subject)
            ->with('title',$this->your_title)
            ->with('content',$this->your_content);
    }
}
