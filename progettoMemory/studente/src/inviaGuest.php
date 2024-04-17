<?php
    require "roundInCorso.php";//mette a disposizione tutto ciò che serve
    
    //todo vedere se c'è qualche problema qui
    try {
        if($inCorso!=0){
            $inviato =  mysqli_fetch_all($connessione->query("select inviato from partecipanti where username='$_SESSION[nomePartecipante]' and nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
            //print_r($inviato);
            if($inviato==0){
                $punteggio = mysqli_fetch_all($connessione->query("select punteggio from partecipanti where nome_stanza='$_SESSION[stanzaSelezionata]' and username='$_SESSION[nomePartecipante]'"))[0][0];
                $_SESSION["punteggioPlayer"]=$punteggio;
                $_SESSION["punteggioPlayer"]+=$_POST["punteggio"];
            
                //cambia il punteggio del giocatore
                $connessione->query("update partecipanti set inviato=1 where nome_stanza='$_SESSION[stanzaSelezionata]' and username='$_SESSION[nomePartecipante]'") or die("non ha funzionato l'aggiornamento dell'invio dello studente");
                $connessione->query("update partecipanti set punteggio=$_SESSION[punteggioPlayer] where username='$_SESSION[nomePartecipante]' and nome_stanza='$_SESSION[stanzaSelezionata]'");
                echo "1";
                return;
            }
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
    

    echo "0";
    
    
?>