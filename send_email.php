<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$errors = [];

echo 'sending ...';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? strip_tags(trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';

    // Validate form fields
    if (empty($name)) {
        $errors[] = 'Name is empty';
    }

    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }

    // If no errors, send email
    if (empty($errors)) {
        // Recipient email address
        $recipient = "akhomsib@gmail.com";
        $emailSubject = 'New contact from your website!';

        // Create a new PHPMailer instance
        $mail = new PHPMailer(exceptions: true);
        try {
            // Configure the PHPMailer server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP           
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->Username   = 'amsibiwebcontact@gmail.com';                     //SMTP username
            $mail->Password   = 'gdtstyrmiaigdwol';                               //SMTP password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption - ENCRYPTION_SMTPS (Port = 465)
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            // Recipients
            $mail->setFrom('amsibiwebcontact@gmail.com', 'Akhona Msibi Website Contact'); // Add Sender
            $mail->addAddress('akhomsib@gmail.com', 'Akhona Msibi');     //Add a recipient
        
            // Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $emailSubject;
            $mail->Body    = 'Hey Akhona, <br>
                <br>
                You have a new contact from your website! <br>
                Please view the details below. <br>
                <br>
                <b>Name: </b>'.$name.' <br>
                <b>Email: </b>'.$email.' <br>
                <b>Subject: </b>'.$subject.' <br>
                <b>Message: </b>'.$message.' <br>
            ';

            // {$_SERVER["HTTP_REFERER"]}
            if($mail->send()){
                $_SESSION['status'] = 'Thank you for reaching out! I will be in touch.';
                header("Location: {$_SERVER["HTTP_REFERER"]}");
                exit(0);
            }
            else {
                $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header("Location: {$_SERVER["HTTP_REFERER"]}");
                exit(0);
            }

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
    } else {
        // Display errors
        echo "The form contains the following errors:<br>";
        foreach ($errors as $error) {
            echo "- $error<br>";
        }
    }
} 
else {
    // If send_mail.php accessed directly, redirect to contact page
    header('Location: contact.php');
    exit(0);
}

?>