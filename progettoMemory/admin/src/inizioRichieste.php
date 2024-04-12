<?php 
	ob_start();
	session_start();
	if($_SESSION['immaginiSelezionate']!='all' && count($_SESSION['immaginiSelezionate'])<$_SESSION['numeroRound']){
		header("Location: ./admin.php?info=\"non e possibile avere un numero inferiore di immagini rispetto ai round\"");
		exit();
	}
	require "../../sql/config.php";
	$_SESSION['inizioRichieste']=True;
	$_SESSION['partitaIniziata']=false;
	$connessione->query("update stanze set inCorso=0, ingAperto=1 where nome_stanza='$_SESSION[nomeStanza]'") 
	or die("errore nel far iniziare le entrate");
	header('Location: ./admin.php');
	ob_end_flush();
 ?>