<?php
require_once("../connect.php");

$query = "
    SELECT 
        P.matricola,
        U.nome AS nome_utente,
        U.cognome AS cognome_utente,
        L.ISBN,
        L.titolo,
        P.data_uscita,
        P.data_restituzione_prevista
    FROM Prestito P
    JOIN CopiaLibro C ON P.id_copia = C.id_copia
    JOIN Libro L ON C.ISBN = L.ISBN
    JOIN Utente U ON P.matricola = U.matricola
    ORDER BY P.data_uscita DESC
";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Elenco Prestiti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            margin-bottom: 10px;
        }

        .container {
            width: 90%;
            margin: 20px auto;
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
            margin-top: 15px;
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

    <?php include("../navbar.php"); ?>

    <div class="container">
        <h2>Elenco Prestiti</h2>

        <div class="buttons">
            <a href="add.php" class="btn">Aggiungi Prestito</a>
            <a href="delete.php" class="btn">Cancella Prestito</a>
            <a href="search.php" class="btn">Ricerca per Data</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Titolo</th>
                    <th>Matricola</th>
                    <th>Utente</th>
                    <th>Data Uscita</th>
                    <th>Restituzione Prevista</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['ISBN']) ?></td>
                            <td><?= htmlspecialchars($row['titolo']) ?></td>
                            <td><?= htmlspecialchars($row['matricola']) ?></td>
                            <td><?= htmlspecialchars($row['nome_utente']) . " " . htmlspecialchars($row['cognome_utente']) ?></td>
                            <td><?= htmlspecialchars($row['data_uscita']) ?></td>
                            <td><?= htmlspecialchars($row['data_restituzione_prevista']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nessun prestito trovato.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>