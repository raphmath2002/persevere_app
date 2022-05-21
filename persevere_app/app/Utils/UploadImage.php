<?php

namespace App\Utils;

use App\Models\{SendEmail};

class UploadImage
{
    public $from;
    public $to;
    public $cc;
    public $bcc;
    public $type;
    public $succeed;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from, $to, $cc, $bcc, $type, $succeed, $message)
    {
        $this->from = $from;
        $this->to = $to;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->type = $type;
        $this->succeed = $succeed;
        $this->message = $message;

        $sendEmail = new SendEmail();
        $sendEmail->from = $this->from;
        $sendEmail->to = $this->to;
        $sendEmail->cc = $this->cc;
        $sendEmail->bcc = $this->bcc;
        $sendEmail->succeed = $this->succeed;
        $sendEmail->message = $this->message;
        $sendEmail->type_email_id = $this->type;
        $sendEmail->save();
    }
}
