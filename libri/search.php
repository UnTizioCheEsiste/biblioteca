<?php
require_once("../connect.php");

$titolo_ricerca = $_GET["titolo"] ?? "";

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
";

if ($titolo_ricerca !== "") {
    $title_search_sql = mysqli_real_escape_string($connection, $titolo_ricerca);
    $query .= " WHERE L.titolo LIKE '%$title_search_sql%' ";
}

$query .= "
    GROUP BY L.ISBN, L.titolo, L.anno_pubblicazione, L.lingua
    ORDER BY L.titolo
";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Ricerca Libro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        input[type="text"] {
            width: 60%;
            padding: 6px;
            margin-right: 10px;
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
            margin-top: 20px;
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
        <h2>Ricerca Libro per Titolo</h2>

        <form method="get">
            <input type="text" name="titolo" placeholder="Inserisci titolo..." value="<?= htmlspecialchars($titolo_ricerca) ?>">
            <button type="submit" class="btn">🔍 Cerca</button>
            <button type="button" class="btn" onclick="window.location.href='get.php'">Esci</button>
        </form>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
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
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["ISBN"]) ?></td>
                            <td><?= htmlspecialchars($row["titolo"]) ?></td>
                            <td><?= htmlspecialchars($row["anno_pubblicazione"]) ?></td>
                            <td><?= htmlspecialchars($row["lingua"]) ?></td>
                            <td><?= htmlspecialchars($row["autori"]) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nessun libro trovato.</p>
        <?php endif; ?>

    </div>

</body>

</html>