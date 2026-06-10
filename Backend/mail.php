<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../vendor/autoload.php";

function posljiRegistracijskiMail($email, $ime) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;

        $mail->Username = "sportnodrustvoferi@gmail.com";
        $mail->Password = "icvrambzylhmmeue";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->CharSet = "UTF-8";

        $mail->setFrom("tadej.basa71@gmail.com", "Športno Društvo FERI");
        $mail->addAddress($email, $ime);

        $mail->isHTML(true);
        $mail->Subject = "Uspešna registracija";
        $mail->Body = "
            <h2>Pozdravljen/a, $ime!</h2>
            <p>Uspešno si se registriral/a v Športno društvo FERI.</p>
            <p>Veseli smo, da si se nam pridružil.</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
?>