<?php
    session_start();
    require "../../sql/config.php";
    //require "roundInCorso.php";//mette a disposizione tutto ciò che serve
    //todo vedere se c'è qualche problema qui
    try {
        // $inCorso = mysqli_fetch_all($connessione->query("select (utc_time()-inizio_round)<=TTLImg from round r join stanze s on s.nome_stanza=r.nome_stanza where s.nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
        
        // INIZIO PROVA

        $nome_stanza = $_SESSION['stanzaSelezionata'];

        $query = $connessione->prepare("select (utc_time()-inizio_round)<=TTLImg from round r join stanze s on s.nome_stanza=r.nome_stanza where s.nome_stanza=:nome_stanza");
        $query->bindParam(':nome_stanza',$nome_stanza, PDO::PARAM_STR);
        $query->execute();

        // FINE PROVA

        //echo "ttl: ".$inCorso."; ";
        if($inCorso>0){
            
            // $inviato =  mysqli_fetch_all($connessione->query("select inviato from partecipanti where username='$_SESSION[nomePartecipante]' and nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
            
            // INIZIO PROVA

            $nomePartecipante = $_SESSION['nomePartecipante'];
            $nome_stanza = $_SESSION['nome_stanza'];

            $query = $connessione->prepare("select inviato from partecipanti where username=:nomePartecipante and nome_stanza=:nome_stanza");
            $query->bindParam(':nomePartecipante', $username, PDO::PARAM_STR);
            $query->bindParam(':nome_stanza', $nome_stanza, PDO::PARAM_STR);
            $query->execute();


            // FINE PROVA 

            //echo "inviato: ".$inviato."; ";
            //print_r($inviato);
            if($inviato==0){
                $punteggio = mysqli_fetch_all($connessione->query("select punteggio from partecipanti where nome_stanza='$_SESSION[stanzaSelezionata]' and username='$_SESSION[nomePartecipante]'"))[0][0];
                $_SESSION["punteggioPlayer"]=$punteggio;
                $_SESSION["punteggioPlayer"]+=$_POST["punteggio"];
              //  echo "punteggioToto: $_SESSION[punteggioPlayer], punteggio loc: $_POST[punteggio]";
                //cambia il punteggio del giocatore
                $risposta = str_replace('\'', '',$_POST['risposta']);
                $connessione->query("update partecipanti set inviato=1, risposta='$risposta' where nome_stanza='$_SESSION[stanzaSelezionata]' and username='$_SESSION[nomePartecipante]'") or die("non ha funzionato l'aggiornamento dell'invio dello studente");
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