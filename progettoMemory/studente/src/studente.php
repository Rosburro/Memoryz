<?php ob_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content="width=device-width, initial-scale=1">
	<title>studente</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	
</head>

<body>
	
	
	<?php
		//TODO verificare se il nome nella get è corretto o meno
		session_start();

		//TODO da mettere ancora le guess (una volta che dario le ha implementate nel js)
		if(isset($_SESSION['nomePartecipante']) && isset($_SESSION['stanzaSelezionata'])){
			echo "<link rel='stylesheet' href='../static/studenteInCorso.css'>
					<script src='../static/studenteInStanza.js'></script>";
			echo "<button onclick='onClickEsciDallaStanza()'>esci dalla stanza</button>
					<p>max round: $_SESSION[round]<br>tempo ogni round: $_SESSION[TTL]s</p>

					<div id='partita' class='partita'></div>";
			echo "<script>let stanza='$_SESSION[stanzaSelezionata]'</script>";
		}else{
			echo "
			<script type='text/javascript' src='../static/studenteAccesso.js'></script>
				<form action='partecipa.php' method='get'>
					<select id='selectStanzaAperta' name='stanzaSelezionata'>
						
					</select>
					<input type='text' name='nomePartecipante' id='nome'>
					<input type='submit' name='inviaForm' value='porco' id='invia'>
				
				</form>";
		}
	ob_end_flush();
	?>

	<script>

		function onClickEsciDallaStanza(){
			window.location.href="esciDallaStanza.php";
		}
	</script>

	

</body>
</html>