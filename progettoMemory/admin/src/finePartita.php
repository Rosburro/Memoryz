<?php 
	session_start();
	require "../../sql/config.php";
	
	$_SESSION['partitaIniziata']=False;
	$_SESSION['inizioRichieste']=false;
	$_SESSION["roundInCorso"]=false;
	$_SESSION['alTermine']=false;//è terminata
	$_SESSION['n_round']=0;



	// $connessione->query("delete from partecipanti where nome_stanza='$_SESSION[nomeStanza]'");

	$query= $connessione->prepare("delete from partecipanti where nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
	$query->execute();


	// $connessione->query("update round set inCorso=0 where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nellaggiornameto del round");

	$query = $connessione->prepare("update round set inCorso=0 where nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
	$query->execute();

	// $connessione->query("update stanze set inCorso=0, ingAperto=0 where nome_stanza='$_SESSION[nomeStanza]'");
	
	$query = $connessione->prepare("update stanze set inCorso=0, ingAperto=0 where nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
	$query->execute();
	
	// $connessione->query("update img_stanza set usata=0 where nome_stanza='$_SESSION[nomeStanza]'");
	
	$query = $connessione->prepare("update img_stanza set usata=0 where nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
	$query->execute();
	
	header("Location: ./admin.php");

?>