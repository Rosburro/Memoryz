<?php

session_start();
if(isset($_SESSION['login'])){

	echo '
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Aggiunta</title>
			<link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
			<script src="https://cdn.tailwindcss.com"></script>
			<script type="text/javascript" src="js.js"></script>
			<style>
				h1{
					zoom: 200%;
				    text-transform: uppercase;
				}
			</style>


		</head>
		<body class="flex items-center justify-center"> 
		<form name="pop" id="pop" method="POST" enctype="multipart/form-data">
		<div class="text-center">
			<h1> Aggiunta di un nuovo personaggio </h1><br><br>

			Nome completo <br>
			<input type="text" required name="ncompleto" placeholder="Nome completo" class="input input-bordered input-secondary w-full max-w-xs" /> <br><br>Suggerimenti <br>

			<div id="daqui">
			<input type="text" required name="sugger[]" placeholder="Suggerimento 1" class="input input-bordered input-secondary w-full max-w-xs" /> <br> <br>	
			</div>
			<button type="button" class="btn btn-outline" onclick="sugg1()">Nuovo suggerimento</button><br><br>
			Immagine <br>
			<input type="file" name="img" required class="file-input file-input-bordered file-input-secondary w-full max-w-xs" />

			<br><br>


			<div  role="alert" class="alert shadow-lg">
			  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
			  <div>
			    <h3 class="font-bold">Attenzione Alle Soluzioni!</h3>
			    Aggiungere tutte le possibili soluzioni (es. Vittorio Emanuele, Vittorio Emanuele III, Vittorio Emanuele 3, Emanuele 3, Emanuele Vittorio ecc..)<br> <div class="text-xs"> Lettere maiuscole o minuscole non fanno differenza</div>
			  </div> 
			</div>

			<br>Soluzioni<br>

			<div id="daqua">
				<input type="text" required name="soluzioni[]" placeholder="Soluzione 1" class="input input-bordered input-secondary w-full max-w-xs" /> <br><br>
			</div>

			<button type="button" class="btn btn-outline" onclick="soluz1()">Nuova soluzione</button>
			<button type="submit" name="invio" class="btn btn-success">Salva Personaggio</button>
			<br><br>
			
			<br><br>
			
			
			<br>

			

	';

	if(isset($_POST['invio'])){
		

		// Percorso del file XML
		$xmlFile = '../memory.xml';

		// Carica il file XML
		$xml = new DOMDocument('1.0');
		$xml->preserveWhiteSpace = false;
		$xml->formatOutput = true;
		$xml->load($xmlFile);



		$var = $xml->getElementsByTagName('personaggio');

		// Trova l'ultimo personaggio nel file XML
		$lastCharacter = $var->item($var->length-1);

		// Ottieni l'indice dell'ultimo personaggio
		$lastIndex = intval($lastCharacter->getElementsByTagName('indice')->item(0)->nodeValue);



		$nuovoIndice = $lastIndex+1;

		move_uploaded_file($_FILES['img']['tmp_name'],"../img/".$_FILES['img']['name']);
		$pathImmagine = $_FILES['img']['name'];
		

		// Crea un nuovo nodo personaggio
	$newCharacter = $xml->createElement('personaggio');
	$xml->documentElement->appendChild($newCharacter);

	// Aggiungi i dettagli del nuovo personaggio
	$newCharacter->appendChild($xml->createElement('n_completo', $_POST["ncompleto"]));
	$newCharacter->appendChild($xml->createElement('indice', $nuovoIndice));
	$newCharacter->appendChild($xml->createElement('img', $pathImmagine)); 

	foreach ($_POST['soluzioni'] as $k) {
		if($k != ""){
			$newCharacter->appendChild($xml->createElement('guess', $k));
		}
	}

	foreach ($_POST['sugger'] as $k) {
		if($k != ""){
			$newCharacter->appendChild($xml->createElement('sugg', $k));
		}
	}
		
		$xml->save($xmlFile); //salvataggio


		header("location:wait.php");

	}



	echo '
		</div>
		<div class="btm-nav">
		  <button type="button" class="text-secondary active" onclick="window.location.href=\'index.php\'" >
		    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
		  </button>
		</div>


	</form></body></html>';

}

else{
	echo "Accesso negato, accedere prima come amministratore: <a href='../login.php'> pagina login</a>";
}
?>