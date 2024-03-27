<?php 
	session_start();
	require "../../sql/config.php";
	$_SESSION['partitaIniziata']=False;
	$_SESSION['inizioRichieste']=false;
	$_SESSION['n_round']=0;
	$connessione->query("delete from partecipanti where nome_stanza='$_SESSION[nomeStanza]'");
	$connessione->query("update stanze set inCorso=0, ingAperto=0 where nome_stanza='$_SESSION[nomeStanza]'");
	header("Location: ./admin.php");

?>