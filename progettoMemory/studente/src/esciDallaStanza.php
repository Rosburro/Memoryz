<?php
    ob_start();
    session_start();
    require "../../sql/config.php";
    try{
        $connessione->query("delete from partecipanti where nome_stanza='$_SESSION[stanzaSelezionata]' and username='$_SESSION[nomePartecipante]'") or die("errore nella cancellazione del partecipante");
        unset($_SESSION['nomePartecipante']);
        unset($_SESSION['stanzaSelezionata']);
    }catch (\Throwable $th) {
        //in ogni caso ritorna li
        //throw $th;
    }
    header("location: ./studente.php");
    ob_end_flush();
?>