<?php
require_once("../connect.php");

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $isbn = $_POST["isbn"];
    $titolo = $_POST["titolo"];
    $anno = $_POST["anno"];
    $lingua = $_POST["lingua"];
    $succursale = $_POST["succursale"];
    $autori = $_POST["autori"] ?? [];


    $book_sql = "INSERT INTO Libro (ISBN, titolo, anno_pubblicazione, lingua)
                    VALUES ('$isbn', '$titolo', '$anno', '$lingua')";
    $query = mysqli_query($connection, $book_sql);

    if ($query) {

        foreach ($autori as $id_autore) {
            $auth_sql = "INSERT INTO AutoreLibro (id_autore, ISBN)
                             VALUES ('$id_autore', '$isbn')";
            mysqli_query($connection, $auth_sql);
        }

        $copy_sql = "INSERT INTO CopiaLibro (ISBN, succursale)
                        VALUES ('$isbn', '$succursale')";
        mysqli_query($connection, $copy_sql);

        $msg = "✅ Libro inserito con successo!";
    } else {
        $msg = "Errore: " . mysqli_error($connection);
    }
}

$succursali = [];
$res_succ = mysqli_query($connection, "SELECT nome FROM Succursale");
while ($row = mysqli_fetch_assoc($res_succ)) {
    $succursali[] = $row["nome"];
}

$autori = [];
$res_aut = mysqli_query($connection, "SELECT id_autore, nome, cognome FROM Autore ORDER BY cognome, nome");
while ($row = mysqli_fetch_assoc($res_aut)) {
    $autori[] = $row;
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Aggiungi Libro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 600px;
            margin: 20px auto;
        }

        label {
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 6px;
            margin-bottom: 12px;
        }

        select[multiple] {
            height: 120px;
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

        .success {
            margin: 10px 0;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            margin: 10px 0;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
        }

        p {
            font-size: 11px;
            color: gray;
        }
    </style>
</head>

<body>

    <?php include("../navbar.php"); ?>

    <div class="container">
        <h2>Aggiungi un Nuovo Libro</h2>

        <?php if ($msg): ?>
            <div class="<?= strpos($msg, '✅') === 0 ? 'success' : 'error' ?>">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" required>

            <label for="titolo">Titolo:</label>
            <input type="text" id="titolo" name="titolo" required>

            <label for="anno">Anno di pubblicazione:</label>
            <input type="number" id="anno" name="anno" required min="1000" max="2100">

            <label for="lingua">Lingua:</label>
            <input type="text" id="lingua" name="lingua" required>

            <label for="succursale">Succursale:</label>
            <select id="succursale" name="succursale" required>
                <option value="">-- Seleziona una succursale --</option>
                <?php foreach ($succursali as $nome): ?>
                    <option value="<?= htmlspecialchars($nome) ?>"><?= htmlspecialchars($nome) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="autori">Autori:</label>
            <select id="autori" name="autori[]" multiple required>
                <?php foreach ($autori as $a): ?>
                    <option value="<?= $a['id_autore'] ?>">
                        <?= htmlspecialchars($a['nome'] . ' ' . $a['cognome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p>Per selezionare più di un autore, utilizzare la combinazione <i>ctrl + click</i>.</p>

            <button type="submit" class="btn">Aggiungi Libro</button>
            <button type="button" class="btn" onclick="window.location.href='get.php'">Esci</button>
        </form>
    </div>

</body>

</html>