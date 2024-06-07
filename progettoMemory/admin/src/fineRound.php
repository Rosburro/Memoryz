<?php session_start();
    require "../../sql/config.php";
    
    $_SESSION["roundInCorso"]=false;

    // $connessione->query("update round set inCorso=0 where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nellaggiornameto del round");
    
    $query = $connessione->prepare("update round set inCorso=0 where nome_stanza=:nomestanza");
    $query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
    $query->execute();

    //TODO: punteggio da sottrarre da controllarte con dario
    //$partecipanti_ignavi = $connessione->query("update partecipanti set punteggio=punteggio-5 where nome_stanza='$_SESSION[nomeStanza]' and inviato=0 and punteggio>0");
        
    //setta che nessuno ha inviato ancora la risposta

    // $connessione->query("update partecipanti set inviato=0, risposta='' where nome_stanza='$_SESSION[nomeStanza]'");
    
    $query = $connessione->prepare("update partecipanti set inviato=0, risposta='' where nome_stanza=:nomestanza");
    $query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
    $query->execute();

    header('Location: ./admin.php');
?>