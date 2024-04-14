<?php
    session_start();
    require "../../sql/config.php";
    $img = mysqli_fetch_all($connessione->query("select img_round from round where nome_stanza='$_SESSION[nomeStanza]' and inCorso=1"));
    if(count($img)<=0){
        echo "il round non e` ancora iniziato";
        exit();
    }
    $tempo = mysqli_fetch_all($connessione->query("select inizio_round from round where nome_stanza='$_SESSION[nomeStanza]'"))[0][0];
    $tempo = explode(":", $tempo);//ore:mmin:sec
    $t_corrente = explode(":", date("i:s", time()));//minuti:sec
    
    $diff = $_SESSION["TTLFoto"]-($t_corrente[1]-$tempo[2]);//ttl-(secCorr-secInizioRound)
    $testoP = "";//"$t_corrente[0]; $tempo[1]";//debug

    if($diff<0|| $t_corrente[0]!=$tempo[1]){//controla se il ttl e` stato rispettato e se si e` allo stesso minutoi di quando si e` fatto iniziare il round
        $testoP.="tempo per rispondere esaurito... ; ";
    }else{
        $testoP.="tempo rimanente: $diff; ";
    }
    $img=$img[0][0];
    $personaggio = simplexml_load_file("../../memory.xml")->xpath("./personaggio")[$img];
    $testoP.=$personaggio->n_completo;
    echo $testoP.",".$personaggio->img;

?>