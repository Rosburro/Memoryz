<?php
    session_start();
    require "../../sql/config.php";
    
    $inCorso=0;
    try {
        $inCorso = mysqli_fetch_all($connessione -> query("select inCorso from round where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
        echo $inCorso;
    } catch (\Throwable $th) {
        echo "0";
    }

?>