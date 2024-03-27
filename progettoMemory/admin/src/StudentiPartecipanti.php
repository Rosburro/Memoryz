<?php 
	session_start();
	require "../../sql/config.php";
	$result = $connessione->query("select username from partecipanti where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nel prendere i partecipanti");

/*  <ol>
  <li>Coffee</li>
  <li>Tea</li>
  <li>Milk</li>
</ol>  */

	echo "<ol class='listaPartecipanti'>";
	foreach($result as $riga){
		echo "<li class='elementoListaPartecipanti'>$riga[username]</li>";
	}
	echo "</ol>";

 ?>