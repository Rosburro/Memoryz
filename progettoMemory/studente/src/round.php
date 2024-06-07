<?php ob_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2, user-scalable=1">
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../../studente/static/style.css">
</head>

<!-- TODO vedere perchè viene scritto il testo contenuto dentro lo script-->
<body>

<?php
	//echo $_GET['TTL'].", ".$_GET['img'].", ".$_GET["start"];
	session_start();
	require "../../sql/config.php";
	// $immagine = mysqli_fetch_all($connessione ->query("select img_round from round where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];

	$query = $connessione->prepare("select img_round from round where nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza',$_SESSION['stanzaSelezionata'], PDO::PARAM_STR);
	$query->execute();
	$immagine = $query->fetchAll(PDO::FETCH_ASSOC)[0]['img_round'];
	// $immagine = $immagine[0]['img_round'];

	//print_r($immagine);
	$personaggio = simplexml_load_file("../../memory.xml")->xpath("./personaggio")[$immagine];
	//echo $personaggio -> img;
	//print_r($personaggio);

	//echo "il personaggio si chiama: ".$personaggio -> n_completo;
	//echo "<script>alert('ciao')</script>";
    //echo "asdsadasdasdasdasd";
	//TODO: sistemare il tempo
	
	
	// $tempi = mysqli_fetch_all($connessione -> query("select TTLImg, (utc_time()-inizio_round) as rimanente from round r join stanze s on s.nome_stanza=r.nome_stanza where r.nome_stanza='$_SESSION[stanzaSelezionata]'"))[0];
	
	$query = $connessione->prepare("select TTLImg, TIMEDIFF(utc_time(),inizio_round)-0 as rimanente from round r join stanze s on s.nome_stanza=r.nome_stanza where r.nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza',$_SESSION['stanzaSelezionata'], PDO::PARAM_STR);
	$query->execute();
	$tempi = $query->fetchAll(PDO::FETCH_ASSOC)[0];

	//print_r($tempi);

	// $sugg_max = mysqli_fetch_all($connessione->query("select max_suggerimenti from stanze where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];
    
	$query = $connessione->prepare("select max_suggerimenti from stanze where nome_stanza=:nomestanza");
	$query->bindParam(':nomestanza',$_SESSION['stanzaSelezionata'], PDO::PARAM_STR);
	$query->execute();
	$sugg_max = $query->fetchAll(PDO::FETCH_ASSOC)[0]['max_suggerimenti'];



	$parola = $personaggio -> n_completo;

	//$parola = str_replace("'", "\\'", $parola);
    
	//vedere se serve: se serve bisogna correggere la query e adattarla a PDO
	//per ora i sugg_rim sono uguali ai max_suggerimenti
	// $sugg_rimasti = $sugg_max-mysqli_fetch_all($connessione->query("select suggerimenti from partecipanti where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0][0];


	$script_js = "<script style='visibility: hidden;display:none;'>
			let time = $tempi[TTLImg];
			const sugg_max = $sugg_max;
			let sugg_partita = sugg_max;
			let sugg_rim = $sugg_max;
			let t_start = ".$tempi['rimanente'].";
			let parola = '".$parola."';
			let punteggioTot = $_SESSION[punteggioPlayer];
			let path_immagine = 'http://sitinosetosobellino.altervista.org/progettoMemory/img/".($personaggio -> img) ."';
			let lista_consigli= [";

	//array suggerimenti
	if($sugg_max!=0){
		$suggerimenti = $personaggio->sugg;
		for($i=0;$i<count($suggerimenti)-1 && $i<$sugg_max-1;$i++){
			$script_js.="'".$suggerimenti[$i]."',";
		}
		$script_js.="'".$suggerimenti[count($suggerimenti)-1]."'];";
	}else{
		$script_js.="];";
	}
	
	//array possibilki nomi validiZz
	
	$guess = $personaggio -> guess;
	$script_js.="
				let guess = [";
	for($i=0;$i<count($guess)-1;$i++){
		$script_js.="'". $guess[$i]."',";
	}
	$script_js.="'".$guess[count($guess)-1]."']; </script>";

	
	
	echo $script_js;
	ob_end_flush();
?>



<!--<button id="invio"></button>-->
	<pre><b>
	<p id='v'></p>
	</b></pre>


	<script src="../../studente/static/index.js" ></script>
</body>
</html>