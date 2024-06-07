<?php
    session_start();
    require "../../sql/config.php";
    // $img = mysqli_fetch_all($connessione->query("select img_round from round where nome_stanza='$_SESSION[nomeStanza]' and inCorso=1"));
    
    $query = $connessione->prepare("select img_round from round where nome_stanza=:nomestanza and inCorso=1");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
	$query->execute();
    $img = $query->fetchAll(PDO::FETCH_ASSOC);

    
    if(count($img)<=0){
        echo "il round non e` ancora iniziato";
        exit();
    }
    
    // $diff = mysqli_fetch_all($connessione->query("select TTLImg-TIMEDIFF(utc_time(),inizio_round) as tempo from round r join stanze s on s.nome_stanza=r.nome_stanza where s.nome_stanza='$_SESSION[nomeStanza]'"))[0][0];
    
    //query da controllare ho cambiato una cosa nelle colonne
    $query = $connessione->prepare("select TTLImg-TIMEDIFF(utc_time(),inizio_round) as tempo from round r join stanze s on s.nome_stanza=r.nome_stanza where s.nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
	$query->execute();
    $diff = $query->fetchAll(PDO::FETCH_ASSOC)[0]['tempo'];
    
    //echo 'trascordo:'.$diff;
    $testoP="";
    if($diff<0){//controla se il ttl e` stato rispettato e se si e` allo stesso minutoi di quando si e` fatto iniziare il round
        $testoP.="tempo per rispondere esaurito... ; ";
    }else{
        $testoP.="tempo rimanente: $diff; ";
    }
    $img=$img[0]['img_round'];
    $personaggio = simplexml_load_file("../../memory.xml")->xpath("./personaggio")[$img];
    $testoP.=$personaggio->n_completo;
    echo $testoP.",".$personaggio->img;

?>