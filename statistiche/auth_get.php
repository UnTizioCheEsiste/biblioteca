<?php
require_once("../connect.php");

// Query: conta i libri associati a ciascun autore
$query = "
    SELECT 
        A.nome, 
        A.cognome, 
        COUNT(AL.ISBN) AS num_libri
    FROM Autore A
    LEFT JOIN AutoreLibro AL ON A.id_autore = AL.id_autore
    GROUP BY A.id_autore, A.nome, A.cognome
    ORDER BY num_libri DESC
";

$result = mysqli_query($connection, $query);
$statistiche = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $statistiche[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Statistiche Libri per Autore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 30px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            margin-right: 10px;
            padding: 8px 12px;
            margin-top: 10px;
            background-color: #003459;
            color: white;
            text-decoration: none;
            border-radius: 4px;
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
        <h2>Numero di Libri Scritti per Autore</h2>

        <?php if (!empty($statistiche)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Autore</th>
                        <th>Numero di Libri</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statistiche as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['nome'] . ' ' . $s['cognome']) ?></td>
                            <td><?= htmlspecialchars($s['num_libri']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nessun autore trovato.</p>
        <?php endif; ?>
        <button type="button" class="btn" onclick="window.location.href='get.php'">Esci</button>
    </div>

</body>

</html>