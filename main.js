// main.js

document.addEventListener("DOMContentLoaded", function() {
    generateCaptcha();
    // reszta kodu
});

function generateCaptcha() {
    var captcha = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for (var i = 0; i < 6; i++) {
        captcha += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    document.getElementById('captchaDisplay').innerText = captcha;
}

// Wywołaj funkcję generującą CAPTCHA przy ładowaniu strony
window.onload = function() {
    generateCaptcha();
    document.getElementById('verifyCaptchaButton').addEventListener('click', function() {
        verifyCaptcha();
    });
}

function verifyCaptcha() {
    var captcha = document.getElementById('captcha_response').value;
    var captcha_key = document.getElementById('captcha_key').value;

    // Wyślij zapytanie AJAX do widoku Django, aby zweryfikować captchę
    $.ajax({
        type: 'POST',
        url: '/verify_captcha/',  
        data: {
            'captcha_response': captcha,
            'captcha_key': captcha_key
        },
        success: function(response) {
            if (response.success) {
                alert("Captcha jest poprawna!");
                document.getElementById('contactForm').submit();
            } else {
                showError("Nieprawidłowa captcha.");
            }
        },
        error: function(xhr, status, error) {
            showError("Wystąpił błąd podczas weryfikacji captchy.");
        }
    });
}

function showError(errorMessage) {
    alert(errorMessage);
}
