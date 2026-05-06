<?php


function sendMail($to, $subject, $message)
{

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;charset=UTF-8\r\n";
    $headers .= "From: LogiTrace <no-reply@Logitrace.com>\r\n";

    return mail($to, $subject, $message, $headers);
}
?>