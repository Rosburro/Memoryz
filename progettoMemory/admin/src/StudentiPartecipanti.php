<?php 
	session_start();
	require "../../sql/config.php";
	//echo $_POST['nomeStanza'];
	$result = $connessione->query("select username from partecipanti where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nel prendere i partecipanti");

/*  <ol>
  <li>Coffee</li>
  <li>Tea</li>
  <li>Milk</li>
</ol>  */

	// echo "<tr><td><ol class='listaPartecipanti'>";
	$cont=0;
	foreach($result as $riga){
		$cont++;
		echo "<tr>
				<td>$cont</td>
				<td>$riga[username]</td>
			</tr>";
	}
	// echo "</ol></td></tr>";

 ?>