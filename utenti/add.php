<?php
require_once("strumenti/connect.php");
include("strumenti/navbar.php");

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matricola = $_POST["matricola"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
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
</head>

<body>
    <?php if (!empty($error_msg)): ?>
        <div class="message">
            <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <h2>Nuovo Utente</h2>

    <form method="POST" action="">
        <label>Matricola:</label>
        <input type="text" name="matricola" required>

        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>Cognome:</label>
        <input type="text" name="cognome" required>

        <label>Indirizzo:</label>
        <input type="text" name="indirizzo" required>

        <label>Telefono:</label>
        <input type="number" name="telefono" required>

        <button type="submit">Inserisci</button>
        <button type="button" class="exit-btn" onclick="window.location.href='get.php'">Esci</button>
    </form>
</body>

</html>