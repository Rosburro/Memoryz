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
	$immagine = $_GET['img']+0;
	$personaggio = simplexml_load_file("../../memory.xml")->xpath("./personaggio")[$immagine];
	//echo $personaggio -> img;
	//print_r($personaggio);

	//echo "il personaggio si chiama: ".$personaggio -> n_completo;
	//echo "<script>alert('ciao')</script>";
    //echo "asdsadasdasdasdasd";
    echo $_GET['TTL'];
    $script_js = "<script style='visibility: hidden;display:none;'>
			let time = $_GET[start];
			let t_start = ".($_GET['TTL']-$_GET['start']).";
			let parola = '".$personaggio -> n_completo."';
			let punteggioTot = $_SESSION[punteggioPlayer];
			let path_immagine = 'http://sitinosetosobellino.altervista.org/progettoMemory/img/".($personaggio -> img) ."';
			let lista_consigli= [";

	//array suggerimenti
	$suggerimenti = $personaggio->sugg;
	for($i=0;$i<count($suggerimenti)-1;$i++){
		$script_js.="'".$suggerimenti[$i]."',";
	}
	$script_js.="'".$suggerimenti[count($suggerimenti)-1]."'];";
	//array possibilki nomi validiZz
	$guess = $personaggio -> guess;
	$script_js.="
				let guess = [";
	for($i=0;$i<count($guess)-1;$i++){
		$script_js.="'$guess[$i]',";
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