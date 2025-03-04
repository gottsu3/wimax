<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Włącz wyświetlanie błędów i logowanie błędów
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$responseMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobieranie danych z formularza
    $name = isset($_POST["name"]) ? htmlspecialchars(trim($_POST["name"]), ENT_QUOTES, 'UTF-8') : '';
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"]), ENT_QUOTES, 'UTF-8') : '';
    $phone = isset($_POST["phone"]) ? htmlspecialchars(trim($_POST["phone"]), ENT_QUOTES, 'UTF-8') : '';
    $message = isset($_POST["message"]) ? htmlspecialchars(trim($_POST["message"]), ENT_QUOTES, 'UTF-8') : '';

    // Sprawdzenie poprawności danych
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        $responseMessage = "Wszystkie pola są wymagane.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $responseMessage = "Niepoprawny adres e-mail.";
    } else {
        // Konfiguracja PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Ustawienia serwera SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'cyberalchemia@gmail.com'; // Twój adres email
            $mail->Password = 'jsmu uabb wzlq hdyo'; // Twoje hasło email lub app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';

            // Odbiorcy
            $mail->setFrom($email, $name);
            $mail->addAddress('cyberalchemia@gmail.com'); // Adres odbiorcy

            // Dodanie niestandardowych nagłówków
            $mail->addCustomHeader('X-Mailer', 'PHPMailer');
            $mail->addCustomHeader('X-Originating-IP', $_SERVER['REMOTE_ADDR']);
            $mail->addCustomHeader('X-Sender-Info', 'Formularz kontaktowy na stronie');

            // Treść wiadomości
            $mail->isHTML(true);
            $mail->Subject = 'Otrzymano nową wiadomość z formularza kontaktowego';

            // Stylizacja CSS
            $mail->Body = "
            <html>
            <head>
              <style>
                body { font-family: Calibri, sans-serif; color: #333; line-height: 1.6; background-color: #d3cacc; margin: 0; padding: 0; }
                .container { width: 100%; max-width: 600px; margin: 20px auto; padding: 20px; border-radius: 8px; background-color: #ffffff; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4); }
                .header { background: linear-gradient(to right, #2c3e50, #34495e, #4f6a7e, #2c3e50); color: #ffffff; padding: 20px; text-align: center; font-size: 24px; border-radius: 8px 8px 0 0; }
                .header img { width: 50px; height: 50px; vertical-align: middle; margin-right: 10px; }
                .header span { vertical-align: middle; }
                .content { margin-top: 20px; padding: 0 20px; }
                .content table { width: 100%; border-collapse: collapse; }
                .content table th, .content table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
                .content table th { background-color: #f8f8f8; }
                .footer { margin-top: 20px; text-align: center; color: #888; font-size: 12px; padding: 10px 0; border-top: 1px solid #ddd; }
                .footer a { color: #007BFF; text-decoration: none; }
              </style>
            </head>
            <body>
              <div class='container'>
                <div class='header'>
                  <img src='https://cdn-icons-png.flaticon.com/512/3369/3369822.png' alt='Logo' />
                  <span>Otrzymano nową wiadomość z formularza kontaktowego</span>
                </div>
                <div class='content'>
                  <table>
                    <tr>
                      <th>Imię</th>
                      <td>$name</td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td>$email</td>
                    </tr>
                    <tr>
                      <th>Telefon</th>
                      <td>$phone</td>
                    </tr>
                    <tr>
                      <th>Wiadomość</th>
                      <td>$message</td>
                    </tr>
                  </table>
                  <p><strong>Data wysłania:</strong> " . date("Y-m-d H:i:s") . "</p>
                  <p><strong>Adres IP nadawcy:</strong> {$_SERVER['REMOTE_ADDR']}</p>
                </div>
                <div class='footer'>
                  Wiadomość wygenerowana automatycznie. <a href='mailto:cyberalchemia@gmail.com'>Skontaktuj się ze mną</a> w razie potrzeby.
                </div>
              </div>
            </body>
            </html>
            ";

            $mail->AltBody = "Imię: $name\nEmail: $email\nTelefon: $phone\n\nWiadomość:\n$message\n\nData wysłania: " . date("Y-m-d H:i:s") . "\nAdres IP nadawcy: {$_SERVER['REMOTE_ADDR']}";

            $mail->send();
            $responseMessage = 'Wiadomość została wysłana pomyślnie. Dziękuję za kontakt. Wkrótce się do Ciebie odezwę!';
        } catch (Exception $e) {
            $responseMessage = "Przykro mi, ale wystąpił błąd podczas wysyłania wiadomości. Spróbuj ponownie później. Błąd: {$mail->ErrorInfo}";
        }
    }
}

// Zwróć odpowiedź
echo htmlspecialchars($responseMessage, ENT_QUOTES, 'UTF-8');
?>
