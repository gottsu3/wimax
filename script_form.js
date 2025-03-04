document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();
        submitForm();
    });
});

function submitForm() {
    const form = document.getElementById('contactForm');
    const formData = new FormData(form);

    fetch('submit_form.php', {
        method: 'POST',
        body: formData
    })
    
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        const responseDiv = document.getElementById('formResponse');
        responseDiv.className = 'response';
        if (data.includes('Wiadomość została wysłana pomyślnie.')) {
            responseDiv.classList.add('success');
            responseDiv.innerText = data;
        } else {
            responseDiv.classList.add('error');
            responseDiv.innerText = 'Przykro mi, ale wystąpił błąd podczas wysyłania wiadomości. Spróbuj ponownie później.' + data;
        }
    })
    .catch(error => {
        const responseDiv = document.getElementById('formResponse');
        responseDiv.className = 'response error';
        responseDiv.innerText = 'Przykro mi, ale wystąpił błąd podczas wysyłania wiadomości. Spróbuj ponownie później.';
    });
    
}