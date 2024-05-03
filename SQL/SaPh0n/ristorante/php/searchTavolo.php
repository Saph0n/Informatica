<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $data = $_POST['data'];

    // Connessione al database
    require_once "config.php";

    // Controllo connessione
    if ($connessione->connect_error) {
        die("Connessione fallita: " . $connessione->connect_error);
    }

    // Query per cercare prenotazioni per nome cliente o data
    $sql = "SELECT * FROM Prenotazioni WHERE NomeCliente LIKE '%$nome%' OR Giorno = '$data'";

    $result = $connessione->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID Prenotazione</th><th>Nome Cliente</th><th>Data</th><th>ID Tavolo</th></tr>";
        // Stampa i dati di ogni prenotazione trovata
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["IDPrenotazione"]. "</td><td>" . $row["NomeCliente"]. "</td><td>" . $row["Giorno"]. "</td><td>" . $row["IDTavolo"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Non sono state trovate prenotazioni con i criteri di ricerca forniti";
    }

    $connessione->close();
}
?>