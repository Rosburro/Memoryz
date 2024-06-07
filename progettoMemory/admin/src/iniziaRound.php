<?php
    ob_start();
    session_start();
    require "../../sql/config.php";
    $_SESSION["roundInCorso"]=true;
    
    if(!isset($_SESSION["n_round"])){
        $_SESSION["n_round"]=1;
    }else{
        $_SESSION["n_round"]+=1;
    }   

    // $connessione->query("delete from round where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nell'eliminazione del round");
    
    $query = $connessione->prepare("delete from round where nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
	$query->execute();

    //echo "insert into round ('$_SESSION[nomeStanza]', $_SESSION[n_round], '$time', 1, ".scegli_immagine()." )";
    // $connessione->query("insert into round values('$_SESSION[nomeStanza]', $_SESSION[n_round], utc_time(), 1, ".scegli_immagine()." )") or die("errore nella creazione del round");

    $query = $connessione->prepare("insert into round values(:nomestanza, :nround, utc_time(), 1, ".scegli_immagine()." )");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
    $query->bindParam(':nround', $_SESSION['n_round'], PDO::PARAM_STR);
	$query->execute();


    header('Location: ./admin.php');

    //far si che vendga creato il round per la stanza dentro la sessione
    //$connessione->query("insert into ")


    function scegli_immagine(){
        // $imgIndex=mysqli_fetch_all($GLOBALS["connessione"]->query("select imgIndex from img_stanza where nome_stanza='$_SESSION[nomeStanza]' and usata=0 order by rand() limit 1"))[0][0];
        
        $query = $GLOBALS["connessione"]->prepare("select imgIndex from img_stanza where nome_stanza=:nomestanza and usata=0 order by rand() limit 1");
        $query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
        $query->execute();
        $imgIndex = $query->fetchAll(PDO::FETCH_ASSOC)[0]['imgIndex'];// salva l'immagine random
        


        // $GLOBALS["connessione"]->query("update img_stanza set usata=1 where imgIndex=$imgIndex and nome_stanza='$_SESSION[nomeStanza]'");
        
        $query = $GLOBALS["connessione"]->prepare("update img_stanza set usata=1 where imgIndex=$imgIndex and nome_stanza=:nomestanza");
        $query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
        $query->execute();
        
        return $imgIndex;
    }
    ob_end_flush();
?>