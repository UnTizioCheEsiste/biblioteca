<?php
require_once("../connect.php"); // Assicura che $conn sia un oggetto mysqli
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Elenco Libri</title>
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

    <?php include("../navbar.php"); ?>

    <div class="container">
        <h2>Elenco dei Libri</h2>

        <div class="buttons">
            <a href="../libri/add.php" class="btn">➕ Aggiungi Libro</a>
            <a href="../libri/search.php" class="btn">🔍 Ricerca per Titolo</a>
            <a href="../libri/auth_search.php" class="btn">👤 Ricerca per Autore</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Titolo</th>
                    <th>Anno</th>
                    <th>Lingua</th>
                    <th>Autore/i</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
            SELECT 
                L.ISBN,
                L.titolo,
                L.anno_pubblicazione,
                L.lingua,
                GROUP_CONCAT(CONCAT(A.nome, ' ', A.cognome) SEPARATOR ', ') AS autori
            FROM 
                Libro L
            LEFT JOIN 
                AutoreLibro AL ON L.ISBN = AL.ISBN
            LEFT JOIN 
                Autore A ON AL.id_autore = A.id_autore
            GROUP BY 
                L.ISBN, L.titolo, L.anno_pubblicazione, L.lingua
            ORDER BY 
                L.titolo
        ";

                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <td>" . htmlspecialchars($row['ISBN']) . "</td>
                        <td>" . htmlspecialchars($row['titolo']) . "</td>
                        <td>" . htmlspecialchars($row['anno_pubblicazione']) . "</td>
                        <td>" . htmlspecialchars($row['lingua']) . "</td>
                        <td>" . htmlspecialchars($row['autori']) . "</td>
                    </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nessun libro trovato.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>