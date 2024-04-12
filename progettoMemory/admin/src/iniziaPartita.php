<?php ob_start();
	session_start();
	require "../../sql/config.php";	
	
	$_SESSION['partitaIniziata']=True;
	$_SESSION['inizioRichieste']=False;
	$connessione->query("update stanze set inCorso=1, ingAperto=0 where nome_stanza='$_SESSION[nomeStanza]'") 
	or die("errore nel far iniziare la partita");
	//RIMANDA ALLA PAGINA PRINCIPALE
	header('Location: ./admin.php');
	ob_end_flush();
 ?>