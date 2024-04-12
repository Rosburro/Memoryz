<?php
    session_start();
    require "../../sql/config.php";
    $connessione->query("delete from partecipanti where nome_stanza='$_SESSION[stanzaSelezionata]' and username='$_SESSION[nomePartecipante]'") or die("errore nella cancellazione del partecipante");
    unset($_SESSION['nomePartecipante']);
    unset($_SESSION['stanzaSelezionata']);
    header("location: ./studente.php");

?>