<?php
// colori: 
// - bianco FFFFFF
// - black  00171F
// - blue   003459
?>

<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    .navbar {
        background-color: #00171F;
        overflow: hidden;
        border-radius: 4px;
        display: flex;
        justify-items: center;
        align-items: center;
    }

    .navbar .links a {
        color: #FFFFFF;
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
    }
</style>

<div class="navbar">
    <div class="links">
        <a href="../utenti/get.php">Utenti</a>
        <a href="prestiti.php">Prestiti</a>
        <a href="../libri/get.php">Libri</a>
        <a href="statistiche.php">Statistiche</a>
        <a href='../autori/get.php'>Autori</a>
    </div>
</div>