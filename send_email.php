<?php
// Include PHPMailer library files (adjust the path if needed)
require 'vendor/autoload.php';  // If installed via Composer
// require 'PHPMailer/PHPMailer.php'; // If installed manually

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $serviceType='staff';
    $serviceType = htmlspecialchars($_POST['serviceType']);
    $fullName = htmlspecialchars($_POST['full_name']);
    $contactNumber = htmlspecialchars($_POST['contact_number']);
    $email = htmlspecialchars($_POST['email']);
    $techStack = htmlspecialchars($_POST['tech_stack']);
    $message = htmlspecialchars($_POST['message']);

    // PHPMailer configuration
    $mail = new PHPMailer(true);  // Passing `true` enables exceptions

    try {
        // Server settings
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'furqanuh860@gmail.com';               // SMTP username (your email)
        $mail->Password   = 'gpfc tnbv dhxr lpbs';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom($email, $fullName);      // Sender's email address and name
        $mail->addAddress($email, $fullName); // Add a recipient (e.g., your email)

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "
            <h2>Contact Form Submission Details</h2>
            <p><strong>Service Type:</strong> $serviceType</p>
            <p><strong>Full Name:</strong> $fullName</p>
            <p><strong>Contact Number:</strong> $contactNumber</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Preferred Tech Stack:</strong> $techStack</p>
            <p><strong>Message:</strong><br>$message</p>
        ";
        $mail->AltBody = "Service Type: $serviceType\n
                          Full Name: $fullName\n
                          Contact Number: $contactNumber\n
                          Email: $email\n
                          Preferred Tech Stack: $techStack\n
                          Message:\n$message";

        // Send email
        $mail->send();
        echo "<script>
        alert('Thank you for contacting us! Your email has been sent successfully.');
        setTimeout(function() {
            window.location.href = 'index.html';
        }, 3000);  // Redirect after 3 seconds
      </script>";
    } catch (Exception $e) {
        echo "<script>
                alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
              </script>";
    }
} else {
    // If the form wasn't submitted via POST, redirect back to the form
    header("Location: index.html"); // Replace with your form page
    exit;
}
?>
