<?php
// Sprawdź, czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdź, czy wszystkie pola formularza zostały wypełnione
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['message'])) {
        // Pobierz dane z formularza
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];

        // Zastosuj odpowiednie walidatory i obróbkę danych (np. filtrowanie danych wejściowych)
        // Tutaj możesz dodać swoje walidatory i logikę, aby zapewnić poprawność i bezpieczeństwo danych

        // Obsłuż reCAPTCHA
        $recaptcha_response = $_POST['g-recaptcha-response'];
        $secret_key = '6LdSMNYpAAAAAMXgXOjFlE2H5o6JYS8z_Q_eXleH'; // Podmień na swój klucz prywatny reCAPTCHA

        // Wyslij zapytanie do Google w celu weryfikacji reCAPTCHA
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secret_key,
            'response' => $recaptcha_response
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);

        // Sprawdź, czy reCAPTCHA została pomyślnie zweryfikowana
        if ($captcha_success->success == false) {
            echo "BŁĄD: ReCAPTCHA nie została pomyślnie zweryfikowana.";
        } else if ($captcha_success->success == true) {
            // Tutaj możesz przetwarzać dane formularza, np. zapisując je do bazy danych lub wysyłając e-mail

            // Przykład: Wysłanie e-maila
            $to = "sowex1994@gmail.com";
            $subject = "Nowa wiadomość od $name";
            $message_body = "Wiadomość od: $name\n\nEmail: $email\n\nTelefon: $phone\n\nTreść wiadomości:\n$message";
            $headers = "From: $email\n";

            if (mail($to, $subject, $message_body, $headers)) {
                echo "Dziękujemy za wysłanie wiadomości!";
            } else {
                echo "Wystąpił problem podczas wysyłania wiadomości. Spróbuj ponownie później.";
            }
        }
    } else {
        echo "BŁĄD: Wszystkie pola formularza są wymagane!";
    }
}
?>