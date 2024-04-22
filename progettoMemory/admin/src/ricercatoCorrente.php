<?php
    session_start();
    require "../../sql/config.php";
    $img = mysqli_fetch_all($connessione->query("select img_round from round where nome_stanza='$_SESSION[nomeStanza]' and inCorso=1"));
    if(count($img)<=0){
        echo "il round non e` ancora iniziato";
        exit();
    }
    $diff = mysqli_fetch_all($connessione->query("select TTLImg-(utc_time()-inizio_round) from round r join stanze s on s.nome_stanza=r.nome_stanza where s.nome_stanza='$_SESSION[nomeStanza]'"))[0][0];
    
    $testoP="";
    if($diff<0){//controla se il ttl e` stato rispettato e se si e` allo stesso minutoi di quando si e` fatto iniziare il round
        $testoP.="tempo per rispondere esaurito... ; ";
    }else{
        $testoP.="tempo rimanente: $diff; ";
    }
    $img=$img[0][0];
    $personaggio = simplexml_load_file("../../memory.xml")->xpath("./personaggio")[$img];
    $testoP.=$personaggio->n_completo;
    echo $testoP.",".$personaggio->img;

?>