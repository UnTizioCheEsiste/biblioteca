<?php
require_once("../connect.php");

$nome = $_GET["nome"] ?? "";
$cognome = $_GET["cognome"] ?? "";

$libri_per_anno = [];

if ($nome !== "" || $cognome !== "") {
    $nome_sql = mysqli_real_escape_string($connection, $nome);
    $cognome_sql = mysqli_real_escape_string($connection, $cognome);

    $query = "
        SELECT 
            L.ISBN,
            L.titolo,
            L.anno_pubblicazione,
            L.lingua,
            CONCAT(A.nome, ' ', A.cognome) AS autore
        FROM 
            Libro L
        JOIN 
            AutoreLibro AL ON L.ISBN = AL.ISBN
        JOIN 
            Autore A ON AL.id_autore = A.id_autore
        WHERE 
            A.nome LIKE '%$nome_sql%' AND
            A.cognome LIKE '%$cognome_sql%'
        ORDER BY 
            L.anno_pubblicazione, L.titolo
    ";

    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $anno = $row["anno_pubblicazione"] ?? "Sconosciuto";
        $libri_per_anno[$anno][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Ricerca per Autore</title>
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

        .search-form input {
            padding: 6px;
            margin-right: 10px;
            width: 200px;
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

        h3 {
            margin-top: 30px;
            background-color: #f0f0f0;
            padding: 5px 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        <h2>Ricerca Libri per Autore</h2>

        <form method="get" class="search-form">
            <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($nome) ?>">
            <input type="text" name="cognome" placeholder="Cognome" value="<?= htmlspecialchars($cognome) ?>">
            <button type="submit" class="btn">Cerca</button>
            <button type="button" class="btn" onclick="window.location.href='get.php'">Esci</button>
        </form>

        <?php if ($nome !== "" || $cognome !== ""): ?>
            <?php if (!empty($libri_per_anno)): ?>
                <?php foreach ($libri_per_anno as $anno => $libri): ?>
                    <h3>Anno: <?= htmlspecialchars($anno) ?></h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ISBN</th>
                                <th>Titolo</th>
                                <th>Lingua</th>
                                <th>Autore</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($libri as $libro): ?>
                                <tr>
                                    <td><?= htmlspecialchars($libro['ISBN']) ?></td>
                                    <td><?= htmlspecialchars($libro['titolo']) ?></td>
                                    <td><?= htmlspecialchars($libro['lingua']) ?></td>
                                    <td><?= htmlspecialchars($libro['autore']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nessun libro trovato per l'autore inserito.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>

</html>