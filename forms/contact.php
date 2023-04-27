<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal form
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Verifica che i dati non siano vuoti
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Per favore, compila tutti i campi del modulo e inserisci un indirizzo email valido.";
        exit;
    }

    // Imposta le informazioni del messaggio
    $recipient = "tua-email@tuo-dominio.com";
    $subject = "Nuovo messaggio da $name";
    $email_content = "Nome: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Messaggio:\n$message\n";

    // Invia l'email
    if (mail($recipient, $subject, $email_content)) {
        http_response_code(200);
        echo "Grazie! Il tuo messaggio è stato inviato.";
    } else {
        http_response_code(500);
        echo "Qualcosa è andato storto e non siamo riusciti ad inviare il tuo messaggio. Riprova più tardi.";
    }
} else {
    http_response_code(403);
    echo "C'è stato un problema con l'invio del tuo messaggio. Per favore, riprova.";
}
?>
