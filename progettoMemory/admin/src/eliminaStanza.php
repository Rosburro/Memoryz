<?php
    ob_start();
    session_start();
    require "../../sql/config.php";
    try {

        // $connessione->query("delete from stanze where nome_stanza='$_SESSION[nomeStanza]'");  //deprecato
        $query = $connessione->prepare("delete from stanze where nome_stanza=:nomestanza");
        $query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
        $query->execute();

    } catch (\Throwable $th) {
        header("location: ./admin.php?info=impossibile eliminare la stanza");
    }
    
    $_SESSION['nomeStanza']='None';
    header("location: ./admin.php");
    
    session_destroy();
    ob_end_flush();
?>