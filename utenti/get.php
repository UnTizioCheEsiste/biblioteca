<?php
require_once("../connect.php");
include("../navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Utenti</title>
    <link rel="stylesheet" type="text/css" href="../global.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<h2>Elenco degli utenti</h2>

<div class="actions">
        <a href="add.php"><button>➕ Nuovo Utente</button></a>
        <!-- RICORDATI DI CAMBIARE IL storico_utente.php !-->
        <a href="storico_utente.php"><button>Storico Prestiti</button></a>
</div>

<table>
    <tr>
        <th>Matricola</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Indirizzo</th>
        <th>Telefono</th>
    </tr>
<?php
$query = "SELECT matricola, nome, cognome, indirizzo, telefono FROM Biblioteca.Utente";

$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['matricola']}</td>
                <td>{$row['nome']}</td>
                <td>{$row['cognome']}</td>
                <td>{$row['indirizzo']}</td>
                <td>{$row['telefono']}</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Nessun utente trovato</td></tr>";
}
?>

</table>

</body>
</html>