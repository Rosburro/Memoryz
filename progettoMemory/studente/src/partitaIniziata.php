<?php
    session_start();
    if(isset($_SESSION["stanzaSelezionata"])){
        require "../../sql/config.php";
        //frtvhre il vontrnuto efare tutt
        //controlla se la partita e` inizizata

        //controllo se il partecipante e` ancora dentro la stanza

        $partecipante_dentro = mysqli_fetch_all($connessione->query("select count(*) as esistente from partecipanti where username='$_SESSION[nomePartecipante]' and nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
         
        if($partecipante_dentro=='0'){
            echo "espulso";
            exit();
        }
        
        $inCorso = mysqli_fetch_all($connessione-> query("select inCorso, ingAperto from stanze where nome_stanza='$_SESSION[stanzaSelezionata]'"));
         
        //print_r($inCorso);
        if($inCorso==null || ($inCorso[0][0]==0 && $inCorso[0][1]==0)){//se la stanza e` chiusa allora avvisa il client di tornare alla pagina iniziale
            //echo "<script></script>"
            echo "fine";
            exit();
        }
        $inCorso=$inCorso[0][0];
        //controllo se il round e` iniziato
        //echo 'in corso = '.$inCorso[0][0];
        if($inCorso==1){
            $inCorso = mysqli_fetch_all($connessione-> query("select r.inCorso, img_round, inizio_round, TTLImg-TIMEDIFF(utc_time(),inizio_round) from round r join stanze s on s.nome_stanza=r.nome_stanza where r.nome_stanza='$_SESSION[stanzaSelezionata]'"));
            if(count($inCorso)!=0){
                $inCorso=$inCorso[0];
                //print_r($inCorso);

                //$inCorso[1] = ($inCorso[1]==15) ? 1 : 0;
                
                if($inCorso[0]==1){
                    //echo "iniziato round";
                    echo "iniziato;$inCorso[3]";//invia le info per far caricare la pagina nel modo corretto (il tempo di creazione e l'immagine del round)
                    
                }else{
                    echo "<br>il round deve ancora iniziare";
                }
            }else{
                echo "<br>il round deve ancora iniziare";
            }
            // print_r(count($inCorso));
            // print_r($_GET['nome_stanza']);
            
            
        }else{
            echo "<br>la partita deve ancora iniziare";
        }
        
        
    }

?>