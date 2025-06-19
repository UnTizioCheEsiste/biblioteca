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
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        h2 {
            margin-bottom: 10px;
        }

        .buttons {
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            margin-right: 10px;
            padding: 8px 12px;
            background-color: #003459;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #00171F;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Elenco degli utenti</h2>

        <div class="actions" class="buttons">
            <a href="add.php" class="btn">➕ Aggiungi Utente</a>
            <!-- RICORDATI DI CAMBIARE IL storico_utente.php !-->
            <a href="storico_utente.php" class="btn">📚 Storico Prestiti</a>
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
    </div>

</body>

</html>