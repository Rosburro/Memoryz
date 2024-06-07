<?php
    ob_start();
    session_start();
    require "../../sql/config.php";
    try{

        // $connessione->query("delete from partecipanti where nome_stanza='$_SESSION[stanzaSelezionata]' and username='$_SESSION[nomePartecipante]'") or die("errore nella cancellazione del partecipante");
        
        // INIZIO PROVA

        $stanzaSelezionata = $_SESSION['stanzaSelezionata'];
        $username = $_SESSION['nomePartecipante'];

        $query = $connessione->prepare("delete from partecipanti where nome_stanza=:stanzaSelezionata and username=:nomePartecipante") or die("errore nella cancellazione del partecipante");
        $query->bindParam(':stanzaSelezionata', $stanzaSelezionata, PDO::PARAM_INT);
        $query->bindParam(':nomePartecipante', $username, PDO::PARAM_STR)
        $query->execute();

        // FINE PROVA

        unset($_SESSION['nomePartecipante']);
        unset($_SESSION['stanzaSelezionata']);
    }catch (\Throwable $th) {
        //in ogni caso ritorna li
        //throw $th;
    }
    header("location: ./studente.php");
    ob_end_flush();
?>