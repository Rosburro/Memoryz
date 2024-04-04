<?php
    require "../../sql/config.php";
    session_start();
    
    $_SESSION["punteggioPlayer"]+=$_POST["punteggio"];
    
    //cambia il punteggio del giocatore
    
    echo "update partecipanti set punteggio=$_SESSION[punteggioPlayer] where username='$_SESSION[nomePartecipante]' and nome_stanza='$_SESSION[stanzaSelezionata]'";
    $connessione->query("update partecipanti set punteggio=$_SESSION[punteggioPlayer] where username='$_SESSION[nomePartecipante]' and nome_stanza='$_SESSION[stanzaSelezionata]'");

?>