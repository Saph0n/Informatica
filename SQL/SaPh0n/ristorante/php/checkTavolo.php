<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['data'];

    // Connessione al database
    require_once "config.php";

    // Controllo connessione
    if ($connessione->connect_error) {
        die("Connessione fallita: " . $connessione->connect_error);
    }

    // Query per trovare i tavoli disponibili per una certa data
    $sql = "SELECT IDTavolo, NumeroTavolo, Capacita FROM Tavoli WHERE IDTavolo NOT IN (SELECT IDTavolo FROM Prenotazioni WHERE Giorno = '$data')";

    $result = $connessione->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID Tavolo</th><th>Numero Tavolo</th><th>Capacità</th></tr>";
        // Stampa i dati di ogni tavolo disponibile
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["IDTavolo"]. "</td><td>" . $row["NumeroTavolo"]. "</td><td>" . $row["Capacita"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Non ci sono tavoli disponibili per la data selezionata";
    }

    $connessione->close();
}
?>