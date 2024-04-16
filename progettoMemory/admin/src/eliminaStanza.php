<?php
    ob_start();
    session_start();
    require "../../sql/config.php";
    try {
        $connessione->query("delete from stanze where nome_stanza='$_SESSION[nomeStanza]'");
    } catch (\Throwable $th) {
        header("location: ./admin.php?info=impossibile eliminare la stanza");
    }
    
    $_SESSION['nomeStanza']='None';
    header("location: ./admin.php");
    

    ob_end_flush();
?>