<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];

    // Connessione al database
    require_once "config.php";

    // Controllo connessione
    if ($connessione->connect_error) {
        die("Connessione fallita: " . $connessione->connect_error);
    }

    // Controllo se la prenotazione esiste
    $checkSql = "SELECT * FROM Prenotazioni WHERE NomeCliente = '$nome'";
    $result = $connessione->query($checkSql);

    if ($result->num_rows > 0) {
        // Query per cancellare la prenotazione
        $sql = "DELETE FROM Prenotazioni WHERE NomeCliente = '$nome'";

        if ($connessione->query($sql) === TRUE) {
            echo "Prenotazione cancellata con successo";
        } else {
            echo "Errore: " . $sql . "<br>" . $connessione->error;
        }
    } else {
        echo "Nessuna prenotazione trovata con questo nome";
    }

    $connessione->close();
}
?>