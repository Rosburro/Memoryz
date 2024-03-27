<?php 
	session_start();
	require "../../sql/config.php";
	$_SESSION['inizioRichieste']=True;
	$_SESSION['partitaIniziata']=false;
	$connessione->query("update stanze set inCorso=0, ingAperto=1 where nome_stanza='$_SESSION[nomeStanza]'") 
	or die("errore nel far iniziare le entrate");
	header('Location: ./admin.php');
 ?>