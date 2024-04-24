<?php
// Sprawdź, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz dane z formularza
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Ustaw adres e-mail docelowy
    $to = "sowex1994@gmail.com";

    // Ustaw temat wiadomości
    $subject = "Nowa wiadomość od $name";

    // Utwórz treść wiadomości
    $email_body = "Imię: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Telefon: $phone\n";
    $email_body .= "Wiadomość:\n$message";

    // Ustaw nagłówki wiadomości
    $headers = "From: $email";

    // Wyślij wiadomość e-mail
    if (mail($to, $subject, $email_body, $headers)) {
        // Wiadomość została wysłana pomyślnie
        echo "<p>Wiadomość została wysłana. Dziękujemy!</p>";
    } else {
        // Błąd podczas wysyłania wiadomości
        echo "<p>Wystąpił błąd podczas wysyłania wiadomości. Spróbuj ponownie później.</p>";
    }
}
?>