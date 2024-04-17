<?php
    session_start();
    require "../../sql/config.php";
    
    $inCorso=0;
    try {
        $inCorso = mysqli_fetch_all($connessione -> query("select inCorso from round where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
        if($inCorso!=0){
            $inCorso = mysqli_fetch_all($connessione->query("select (utc_time()-inizio_round)>0 from round where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
            
            echo $inCorso;
            exit();
        }else{
            echo "-1";
        }
        
    } catch (\Throwable $th) {
        echo "-1";
    }

?>