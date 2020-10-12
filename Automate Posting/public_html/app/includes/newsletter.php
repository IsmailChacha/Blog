<?php
    use PHPMailer\PHPMailer\PHPMailer;
    // PHPMailer
    require ROOT_PATH . '/app/Classes/Ninja/PHPMailer/src/PHPMailer.php';
    require ROOT_PATH . '/app/Classes/Ninja/PHPMailer/src/Exception.php';
    require ROOT_PATH . '/app/Classes/Ninja/PHPMailer/src/SMTP.php';
    
    $mailingList = $this->mailingListTable->findAll();
    
    try {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'sbg104.truehost.cloud';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
        $mail->Username   = 'ismail@thelinuxpost.com';                     // SMTP username
        $mail->Password   = 'ismail34389988';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
        $mail->setFrom('ismail@thelinuxpost.com', 'TheLinuxPost');
        $mail->isHTML(true);   
        $mail->Subject = ucwords($this->Title);
        
        // Email variables
        $imagePath = ROOT_PATH . '/assets/images/' . $this->Image;
        $imageTitle = ucwords($this->Title);
        $mail->AddEmbeddedImage($imagePath, "featuredImage");
        $readMoreLink = BASE_URL . '/' . $this->String; 
        $readMoreText = ucwords($this->Title);
        $email = $this->Description;
        
        //Recipients
        foreach($mailingList as $user)
        {
            // $mail->addAddress($mailingList[3]->Email, $mailingList[3]->Name);
            $name = $user->Name ?? 'there';
            $mail->addAddress($user->Email, $name);
            ob_start();
               require ROOT_PATH . '/app/templates/emailtemplate.html.php';
            $template = ob_get_clean();
            $mail->Body = $template;
            $mail->send();
            $mail->clearAddresses();
        }
        
        $status = true;
    } catch (Exception $e) {
        $status = false;
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }