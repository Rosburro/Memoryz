<?php 
	session_start();
	require "../../sql/config.php";
	//echo $_POST['nomeStanza'];
	// $result = $connessione->query("select username from partecipanti where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nel prendere i partecipanti");


	//TODO
	$query = $connessione->prepare("select username from partecipanti where nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);

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
				<td><button class='btn btn-outline btn-error btn-xs' onclick='espelliPersona(\"$riga[username]\")'>-</button></td>
			</tr>";
	}
	// echo "</ol></td></tr>";

 ?>