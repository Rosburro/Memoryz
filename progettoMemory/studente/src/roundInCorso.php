<?php
    require "../../sql/config.php";
    session_start();
    
    try {
        $inCorso = mysqli_fetch_all($connessione -> query("select inCorso from round where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
        echo $inCorso;
    } catch (\Throwable $th) {
        echo "0";
    }

?>