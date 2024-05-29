<?php ob_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content="width=device-width, initial-scale=1">
	<title>studente</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<link rel="stylesheet" href="../static/style_stanza.css">
</head>

<body>
	
	
	<?php
		//TODO verificare se il nome nella get è corretto o meno
		session_start();
		//si potrebbe far visualizzare anche qui la classifica
		//TODO da mettere ancora le guess (una volta che dario le ha implementate nel js)
		if(isset($_SESSION['nomePartecipante']) && isset($_SESSION['stanzaSelezionata'])){
			echo "<link rel='stylesheet' href='../static/studenteInCorso.css'>
					<script src='../static/studenteInStanza.js'></script>";
			echo "<button onclick='onClickEsciDallaStanza()'>esci dalla stanza</button>
					<p>max round: $_SESSION[round]<br>tempo ogni round: $_SESSION[TTL]s</p>

					<div id='partita' class='partita'></div>";
			echo "<script>let stanza='$_SESSION[stanzaSelezionata]'</script>";
		}else{
			session_destroy();
			echo "
			<script type='text/javascript' src='../static/studenteAccesso.js'></script>
				<form action='partecipa.php' method='get' align='center'>
					<table border='0'>
						<tr id='tr'>
							<th>ID Stanza<br></th><th>Nome</th>
						</tr>
						<tr>
							<td align='right'><select id='selectStanzaAperta' name='stanzaSelezionata'></td>
							<td><input type='text' placeholder='Azzi' name='nomePartecipante' id='nome'>
							<input type='submit' name='inviaForm' value='Entra' id='invia'></td>
						</tr>
					</table>
					<br>
					<div id='G'>GUIDA</div>
					<table>
						<tr>
							<th id='th'>Istruzioni</th><th id='th'>Informazioni</th>
						</tr>
						<tr>
							<td id='P'>
								<b>1.</b>Questa è la sala d'attesa. Nel mentre si aspetta la Prof, è possibile scegliere il nome.<br><br>
								<b>2.</b>Qando la Prof crerà la stanza, l'ID verrà seleziona in automatico.<br><br>
								<b>3.</b>Cliccare il pulsante 'Entra' quando si desidera entrare nella stanza.<br><br>
								<b>4.</b>!!!LA PARTITA NON INIZIERA' FINO A QUANDO LA PROF <br>NON CONFERMERA' L'INIZIO
							</td>
							<td>
								<b>Come funziona il gioco?<br></b><br>
								Quando la partita inizia, verranno visualizzate delle
								immagini. L'obiettivo è di indovinare il nome.<br><br>
								<b>Ci sono i punti?</b><br><br>
								Si possono guadagnare fino a 100 punti per round. 
								I punti vengono dati in base al tempo passato ad indovinare.<br>
								<br><b>Se non mi ricordo il nome?</b><br><br>
								Per faciliare il compito, il nome verrà visualizzato lentamente con il tempo.
								In aggiunta esistono i <b>Consigli</b> che a costo di 5 punti verrà visualizzato un consiglio. 
							</td>
						</tr>
					
					</table>
					
						
					</select>
					
				
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