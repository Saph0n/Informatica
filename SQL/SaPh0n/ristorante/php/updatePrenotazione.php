<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $giorno = $_POST['giorno'];
    $persone = $_POST['persone'];

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
        // Controllo se il tavolo è disponibile nel nuovo giorno e può ospitare il nuovo numero di persone
        $checkTableSql = "SELECT IDTavolo 
                          FROM Tavoli 
                          WHERE Capacita >= '$persone' AND IDTavolo NOT IN (SELECT IDTavolo FROM Prenotazioni WHERE Giorno = '$giorno')
                          ORDER BY Capacita ASC";
        $tableResult = $connessione->query($checkTableSql);

        if ($tableResult->num_rows > 0) {
            // Prendi l'ID del tavolo disponibile
            $row = $tableResult->fetch_assoc();
            $idTavolo = $row["IDTavolo"];

            // Query per modificare la prenotazione
            $sql = "UPDATE Prenotazioni SET Giorno = '$giorno', NumeroPersone = $persone, IDTavolo = $idTavolo WHERE NomeCliente = '$nome'";

            if ($connessione->query($sql) === TRUE) {
                echo "Prenotazione modificata con successo";
            } else {
                echo "Errore: " . $sql . "<br>" . $connessione->error;
            }
        } else {
            echo "Non ci sono tavoli disponibili per la data e il numero di posti richiesti";
        }
    } else {
        echo "Nessuna prenotazione trovata con questo nome";
    }

    $connessione->close();
}
?>