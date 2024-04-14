<?php 

	require "../../sql/config.php";
	$result =$connessione->query("select nome_stanza from stanze where ingAperto=1") or die("errore nel prendere le stanze aperte");
	print_r($result);
	foreach($result as $riga){
		echo "<option value='$riga[nome_stanza]'>$riga[nome_stanza]</option>";
	}
?>