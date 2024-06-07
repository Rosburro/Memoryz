<?php
    session_start();
    require "../../sql/config.php";
    
    $inCorso=0;
    try {
        // $inCorso = mysqli_fetch_all($connessione -> query("select inCorso from round where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
        
        $query = $connessione->prepare("select inCorso from round where nome_stanza=:nomestanza");
        $query->bindParam(':nomestanza',$_SESSION['stanzaSelezionata'], PDO::PARAM_STR);
        $query->execute();
        $inCorso = $query->fetchAll(PDO::FETCH_ASSOC)[0]['inCorso'];
        
        if($inCorso!=0){
            // $inCorso = mysqli_fetch_all($connessione->query("select ((TTLImg-TIMEDIFF(utc_time(),inizio_round))>0 or inviato=1) as roundincorso from round r join stanze s on s.nome_stanza=r.nome_stanza join partecipanti p on p.nome_stanza=s.nome_stanza where s.nome_stanza='$_SESSION[stanzaSelezionata]' and username='$_SESSION[nomePartecipante]'"))[0][0];
            
            $query = $connessione->prepare("select ((TTLImg-TIMEDIFF(utc_time(),inizio_round))>0 or inviato=1) as roundincorso from round r join stanze s on s.nome_stanza=r.nome_stanza join partecipanti p on p.nome_stanza=s.nome_stanza where s.nome_stanza=:nomestanza and username=:username");
            $query->bindParam(':nomestanza',$_SESSION['stanzaSelezionata'], PDO::PARAM_STR);
            $query->bindParam(':username',$_SESSION['nomePartecipante'], PDO::PARAM_STR);
            $query->execute();
            $inCorso = $query->fetchAll(PDO::FETCH_ASSOC)[0]['roundincorso'];

            echo "in corso: ".$inCorso;
            exit();
        }else{
            echo "-1";
        }
        
    } catch (\Throwable $th) {
        echo "-1";
    }

?>