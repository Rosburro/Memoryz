<?php
    require "../../sql/config.php";
    session_start();
    $_SESSION["roundInCorso"]=false;

    $connessione->query("update round set inCorso=0 where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nellaggiornameto del round");
    header('Location: ./admin.php');
?>