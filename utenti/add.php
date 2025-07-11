<?php
require_once("../connect.php");
include("../navbar.php");

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matricola = $_POST["matricola"];
    $nome = mysqli_real_escape_string($connection, $_POST["nome"]);
    $cognome = mysqli_real_escape_string($connection, string: $_POST["cognome"]);;
    $indirizzo = $_POST["indirizzo"];
    $telefono = $_POST["telefono"];

    $user_already_exists_sql = "SELECT matricola FROM Utente WHERE matricola = '$matricola'";
    $query = mysqli_query($connection, $user_already_exists_sql);

    if (!$query) {
        $error_msg =  "Errore: " . mysqli_error($connection);
        exit;
    }

    if (mysqli_num_rows($query) > 0) {
        $error_msg = "Numero di matricola già presente.";
    } else {

        $insert_user_sql = "INSERT INTO Utente (matricola, nome, cognome, indirizzo, telefono) VALUES ('$matricola', '$nome', '$cognome', '$indirizzo', '$telefono')";
        $result = mysqli_query($connection, $insert_user_sql);

        if (!$result) {
            $error_msg = "Errore durante l'inserimento: " . mysqli_error($connection);
        } else {
            mysqli_close($connection);
            header("Location: get.php");
            exit;
        }
    }
    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Nuovo Utente</title>
    <link rel="stylesheet" type="text/css" href="../global.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            margin-bottom: 10px;
        }

        .container {
            width: 600px;
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
    </style>
</head>

<body>
    <?php if (!empty($error_msg)): ?>
        <div class="message">
            <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <h2>Nuovo Utente</h2>

        <form method="POST" action="">
            <label>Matricola:</label>
            <input type="number" name="matricola" required>

            <label>Nome:</label>
            <input type="text" name="nome" required>

            <label>Cognome:</label>
            <input type="text" name="cognome" required>

            <label>Indirizzo:</label>
            <input type="text" name="indirizzo" required>

            <label>Telefono:</label>
            <input type="number" name="telefono" required>

            <button type="submit" class="btn">Inserisci</button>
            <button type="button" class="btn" onclick="window.location.href='get.php'">Esci</button>
        </form>
    </div>
</body>

</html>