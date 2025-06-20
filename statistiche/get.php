<?php
require_once("../connect.php");

$anno = $_GET["anno"] ?? "";
$conteggio = null;

if ($anno !== "") {
    $anno_sql = mysqli_real_escape_string($connection, $anno);
    $query = "SELECT COUNT(*) AS totale FROM Libro WHERE anno_pubblicazione = '$anno_sql'";
    $res = mysqli_query($connection, $query);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $conteggio = $row["totale"];
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Statistiche Libri per Anno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 500px;
            margin: 30px auto;
            text-align: center;
        }

        input[type="number"] {
            padding: 6px;
            width: 150px;
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

        .result {
            margin-top: 25px;
            font-size: 1.2em;
        }

        .buttons {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <?php include("../navbar.php"); ?>

    <div class="container">
        <h2>Statistiche: Libri Pubblicati per Anno</h2>

        <form method="get">
            <label for="anno">Anno:</label>
            <input type="number" name="anno" id="anno" min="1000" max="<?= date('Y') ?>" value="<?= htmlspecialchars($anno) ?>" required>
            <button type="submit" class="btn">Mostra</button>
        </form>

        <?php if ($anno !== ""): ?>
            <div class="result">
                <p>Libri pubblicati nel <strong><?= htmlspecialchars($anno) ?></strong>: <strong><?= $conteggio ?? 0 ?></strong></p>
            </div>
        <?php endif; ?>

        <div class="buttons">
            <a href="auth_get.php" class="btn">Libri per Autore</a>
            <a href="succ_get.php" class="btn">Prestiti per Succursale</a>
        </div>
    </div>

</body>

</html>