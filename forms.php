<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function storeInCsv($name, $email)
{
    $file = 'pre-register.csv';
    $data = [
        'name' => $name,
        'email' => $email,
        'datum' => date('Y-m-d H:i:s')
    ];
    $fp = fopen($file, 'a');
    fputcsv($fp, $data);
    fclose($fp);
}

if (isset($_POST['preregister'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    storeInCsv($name, $email);
    header('Location: index.php?preregister=success');
    exit;
}


if (isset($_POST['submitted'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $usernameSmtp = 'AKIARQLZ7MA7QJLDSQGW';
    $passwordSmtp = 'BCl+IT/NdHN7HJ23RolPTcaB/8hOosQ7wHZE6aFRJM3+';

    //$configurationSet = 'ConfigSet';
    $host = 'email-smtp.us-east-1.amazonaws.com';
    $port = 587;

    $sender = "noreply@remedymatch.dev";
    $senderName = "RemedyMatch";

    $subject = "Ihre Nachricht an das Team von RemedyMatch:" . $_POST["subject"];
    $recipient = 'remedymatch2020@gmx.de';

    $bodyHtml = '<html>
  <body>
  <h1>Nachricht an das Team von RemedyMatch</h1>
   
  <p>Folgende Frage wurde über das Kontaktformular gestellt:</p>
  
  ' . $message . '
  
  <p> Die Kontaktdaten sind: 
  </br> Name: ' . $name . ' </br>
  EMail: ' . $email . '</p>
  <p>Diese E-Mail wurde automatisch erstellt, bitte antworten Sie nicht auf diese Email.</p>
   
  </body>
  </html>';


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->setFrom($sender, $senderName);

        $mail->Username = $usernameSmtp;
        $mail->Password = $passwordSmtp;
        $mail->Host = $host;
        $mail->Port = $port;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->CharSet = 'utf-8';
        if (!empty($configurationSet)) {
            $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
        }

        $mail->addAddress($recipient);
        
        $mail->AddReplyTo($email, 'Reply to '.$name);
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $bodyHtml;
        $mail->Send();

        header('Location: index.php?emailSent=success');
    } catch (\phpmailerException $e) {

        echo '<script type="text/javascript">';
        echo 'alert("Leider ist ein Fehler beim Versand aufgetreten")';
        echo '</script>';

    } catch (\Exception $e) {

        echo '<script type="text/javascript">';
        echo 'alert("Leider ist ein Fehler beim Versand aufgetreten")';
        echo '</script>';

    }
}