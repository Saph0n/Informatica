<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data = $_POST['data'];
    $posti = $_POST['posti'];

    // Connessione al database
    require_once "config.php";

    // Controllo connessione
    if ($connessione->connect_error) {
        die("Connessione fallita: " . $connessione->connect_error);
    }

    // Query per trovare un tavolo disponibile
    $sql = "SELECT IDTavolo 
            FROM Tavoli 
            WHERE Capacita >= '$posti' AND IDTavolo NOT IN (SELECT IDTavolo FROM Prenotazioni WHERE Giorno = '$data')
            ORDER BY Capacita ASC";

    $result = $connessione->query($sql);

    if ($result->num_rows > 0) {
        // Prendi l'ID del tavolo disponibile
        $row = $result->fetch_assoc();
        $idTavolo = $row["IDTavolo"];

        // Query per inserire la nuova prenotazione
        $sql = "INSERT INTO Prenotazioni (NomeCliente, EmailCliente, Giorno, IDTavolo, NumeroPersone) VALUES ('$nome', '$email', '$data', $idTavolo, $posti)";

        if ($connessione->query($sql) === TRUE) {
            echo "Prenotazione effettuata con successo";
        } else {
            echo "Errore: " . $sql . "<br>" . $connessione->error;
        }
    } else {
        echo "Non ci sono tavoli disponibili per la data e il numero di posti richiesti";
    }

    $connessione->close();
}
?>