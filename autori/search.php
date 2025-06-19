<?php
require_once("../connect.php");

$nome = $_GET["nome"] ?? "";
$cognome = $_GET["cognome"] ?? "";
$autori = [];

if ($nome !== "" || $cognome !== "") {
    $nome_sql = mysqli_real_escape_string($connection, $nome);
    $cognome_sql = mysqli_real_escape_string($connection, $cognome);

    $query = "
        SELECT nome, cognome, data_nascita, luogo_nascita
        FROM Autore
        WHERE nome LIKE '%$nome_sql%' AND cognome LIKE '%$cognome_sql%'
        ORDER BY cognome, nome
    ";

    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $autori[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Ricerca Autori</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        input {
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
        <h2>Ricerca Autori per Nome e Cognome</h2>

        <form method="get">
            <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($nome) ?>">
            <input type="text" name="cognome" placeholder="Cognome" value="<?= htmlspecialchars($cognome) ?>">
            <button type="submit" class="btn">🔍 Cerca</button>
            <button type="button" class="btn" onclick="window.location.href='get.php'">Esci</button>
        </form>

        <?php if ($nome !== "" || $cognome !== ""): ?>
            <?php if (!empty($autori)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Data di Nascita</th>
                            <th>Luogo di Nascita</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($autori as $autore): ?>
                            <tr>
                                <td><?= htmlspecialchars($autore['nome']) ?></td>
                                <td><?= htmlspecialchars($autore['cognome']) ?></td>
                                <td><?= htmlspecialchars($autore['data_nascita']) ?></td>
                                <td><?= htmlspecialchars($autore['luogo_nascita']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nessun autore trovato con i criteri inseriti.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>

</html>