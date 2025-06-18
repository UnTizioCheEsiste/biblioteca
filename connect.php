<?php
    try{
        $connection = mysqli_connect("localhost", "root", "password", "Biblioteca"); 
    } catch(mysqli_sql_exception $e) {
		die("Errore nella connessione al DB: " . $e->getMessage());
	}
?>