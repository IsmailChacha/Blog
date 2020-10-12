<?php
    use PHPMailer\PHPMailer\PHPMailer;

    // PHPMailer
    require ROOT_PATH . '/app/Classes/Ninja/PHPMailer/src/PHPMailer.php';
    require ROOT_PATH . '/app/Classes/Ninja/PHPMailer/src/Exception.php';
    require ROOT_PATH . '/app/Classes/Ninja/PHPMailer/src/SMTP.php';
    
    try {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = 'ismail@thelinuxpost.com';
        $mail->Password = 'ismail34389988';
        $mail->setFrom($email, $name);
        $mail->addAddress($to, $toName);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
        
        $status = true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        $status = false;
    }