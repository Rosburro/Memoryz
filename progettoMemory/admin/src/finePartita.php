<?php 
	session_start();
	require "../../sql/config.php";
	$_SESSION['partitaIniziata']=False;
	$_SESSION['inizioRichieste']=false;
	$_SESSION["roundInCorso"]=false;
	$_SESSION['n_round']=0;
	$connessione->query("delete from partecipanti where nome_stanza='$_SESSION[nomeStanza]'");
	$connessione->query("update round set inCorso=0 where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nellaggiornameto del round");
	$connessione->query("update stanze set inCorso=0, ingAperto=0 where nome_stanza='$_SESSION[nomeStanza]'");
	$connessione->query("update img_stanza set usata=0 where nome_stanza='$_SESSION[nomeStanza]'");
	//$connessione->query("update partecipanti set inviato=0 where nome_stanza='$_SESSION[nomeStanza]'");
	header("Location: ./admin.php");

?>