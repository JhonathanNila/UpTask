<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $name;
    protected $token;

    public function __construct($email, $name, $token) {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }
    public function sentConfirmation() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '143aeb240ff6d3';
        $mail->Password = 'd38fdb5078523b';

        $mail->setFrom('accounts@uptask.com');
        $mail->addAddress('account@uptask.com', 'uptask.com');
        $mail->Subject = "Account Confirmation";
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= '<p><strong>Hello! ' . $this->name . '</strong> You’ve created your account on UpTask. To access it, please confirm your Account by clicking the button below.</p>';
        $content .= '<p>Click here: <a href="http://localhost:3000/welcome?token=' . $this->token . '">Confirm Account</a></p>';
        $content .= '<p>If you didn’t create this account, please ignore this email</p>';
        $content .= '</html>';

        $mail->Body = $content;
        $mail->send();
    }
}