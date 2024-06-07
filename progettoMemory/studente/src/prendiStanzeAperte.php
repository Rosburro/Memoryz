<?php 

	require "../../sql/config.php";
	//si lascia query non c'e` alcun problema
	$result =$connessione->query("select nome_stanza from stanze where ingAperto=1");
	
	
	print_r($result);
	foreach($result as $riga){
		echo "<option>$riga[nome_stanza]</option>";
	}
?>