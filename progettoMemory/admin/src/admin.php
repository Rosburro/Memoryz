<?php ob_start();?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta Http-Equiv='Cache-Control' Content='no-cache'>
    <meta Http-Equiv='Pragma' Content='no-cache'>
    <meta Http-Equiv='Expires' Content='0'>
	<title>profe</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<link rel="stylesheet" href="../static/admin_css.css">
	<link rel="stylesheet" href="../static/css_admin.css">
</head>
<body style='zoom:110%' >
		<img src="../../img/admin.jpg">
		<h1 id="titolo">MEMORI</h1>
		<div id="lato-dx">aaaaaaaaaa</div>
		<div id="lato-sx">aaaaaaaaaa</div>
		
		
		<?php 
		session_start();
		//NB: comando da utilizzare per prendere tutte le immagini
		// $memory = "../../memory.xml";
		// $personaggi = simplexml_load_file($memory);
		// $personaggi = $personaggi->xpath("./personaggio//*");
		require '../../sql/config.php';
			controllo_variabili_sessione();
			if(isset($_GET['info']) && $_GET['info']!=""){
				echo "<script>alert($_GET[info])</script>";
			}

			if($_SESSION['n_round']>$_SESSION['numeroRound'] || ($_SESSION['n_round']==$_SESSION['numeroRound'] && !$_SESSION["roundInCorso"])){
				echo "partita finita";
				
				//cose che servono per finire la partita (uguali al file finePartita.php)
				
				$_SESSION['partitaIniziata']=False;
				$_SESSION['inizioRichieste']=false;
				$_SESSION["roundInCorso"]=false;
				$_SESSION['alTermine']=true;
				//$_SESSION['n_round']=0;
				//$connessione->query("delete from partecipanti where nome_stanza='$_SESSION[nomeStanza]'");
				$connessione->query("update stanze set inCorso=1, ingAperto=0 where nome_stanza='$_SESSION[nomeStanza]'");
				
				echo "<script>$('#tabellaAdmin').ready(
					function(){

						$('#tabellaAdmin').load('punteggioStudenti.php', function(dati,stat,xhr){
							//console.log('entrato'+dati)
						})
					}
					
				)</script>";
				echo "<br><button onclick='onClickterminaPartita()'>termina partita</button><br>";
				
				//header("location: ./finePartita.php");
			}

			 
			//cosa per le immagini
			
			

			if(isset($_GET['scelte'])){
				if($_GET['scelte']=="all"){
					$_SESSION['immaginiSelezionate']=$_GET['scelte'];
				}else{
					$_SESSION['immaginiSelezionate']=explode(',',$_GET['scelte']);
				}
				
				if($_SESSION['nomeStanza']!="None"){
					setta_immagini($_SESSION['immaginiSelezionate']);
				}
			}
			visualizza_impostazioni();
			
			//fine cosa immagini

			if(isset($_GET['invioImpostazioni'])){// correggete l'sql injection
				$ttl =   $_GET['TTLFoto'];
				$nRound=$_GET['nRound'];
				$stanza = $_GET['titoloStanza'];
				$suggerimenti = $_GET['suggerimenti'];
				$info_errori="";
				//echo "entrato nel secondo if".!isset($_SESSION['TTLFoto']);
				if($ttl>0) {
					//echo "entrato nel set del session";
					
					$_SESSION['TTLFoto']=$ttl;
				}else if($ttl!=""){
					$info_errori.="non e` possibile settare un tempo per ogni immagine inferiore o uguale a 0; ";
					
				}

				if ($suggerimenti>=0 && $suggerimenti<=4){
					$_SESSION['suggerimenti']=$suggerimenti;
				}

				if($nRound>0){
					$_SESSION['numeroRound']=$nRound;
				}else if($nRound!=""){
					$info_errori.="non e` possibile inserire un numero di round inferiore o uguale a 0; ";
				}
				
				
				if($stanza!="" && str_replace(" ","",$stanza)!=""){
					//echo "entrato"; 
					$controllo_nome_stanza = controllo_stanza_esistente($stanza);
					if(!$controllo_nome_stanza){
					$info_errori.="il nome della stanza inserito non e' disponibile";
					}
					//echo "controllo nome: $controllo_nome_stanza";
					if($_SESSION["nomeStanza"]!="None" && $controllo_nome_stanza){
						rimuovi_stanza($_SESSION['nomeStanza']);
					}
					if($controllo_nome_stanza){
						$_SESSION['nomeStanza']=$stanza;
						aggiungi_stanza($stanza);
					}
				}
				

				header("Location: ./admin.php". (($info_errori!="") ? "?info=\"$info_errori\"" : ""));
			}

			if(isset($_SESSION['partitaIniziata']) && $_SESSION['partitaIniziata']==True){//partita iniziata

				
				echo "partita in corso";
				
				echo "<script src='../static/scriptAdminPartitaIniziata.js'></script>";
				echo "<button onclick='onClickterminaPartita()'>termina partita</button>";
				if($_SESSION["roundInCorso"]==0){
					echo "<button onclick='onClickIniziaRound()' id='iniziaTerminaRound' style='pointer-events: none;'>inizia round</button>";
				}else{
					echo "<button onclick='onClickFineRound()' id='iniziaTerminaRound' style='pointer-events: none;'>fine round</button>";
				}
				echo "round corrente: $_SESSION[n_round]<br>";
				


			}else if(controllo_vsessione_settate()){//redirect alla pagina di configurazione
				//echo "entrato nel session ttl";
				scrivi_form_impostazioni();

			}else  if ((!isset($_SESSION['inizioRichieste']) || $_SESSION['inizioRichieste']==False) && (!isset($_SESSION['alTermine']) or $_SESSION['alTermine']==false) ){//bottone per inizio delle richieste
				
				echo "<div id='divImpostazioni'></div>
						<button id='cambiaImpostazioni' onclick='scrivi_form_impostazioni()'> cambia impostazioni </button>";
				echo "<button id='inizioRichieste' onclick='onClickInizia()'>inizio Richieste</button>";

			}else if((!isset($_SESSION['alTermine']) or $_SESSION['alTermine']==false)){//attessa delle persone che entrino e bottone di chiusura
				//TODO: fare un if per controllare se i campi compilati sono validi
				echo "in attesa di persone... ";
				echo "<button onclick='onClickChiudiEntrate()'>Inizia Partita</button>";
				echo "<script src='../static/scriptAdminVisualizzaStudenti.js'></script>";
			}
			
			//echo "<table id='tabellavisualizzazione'></table>";

			

			function alert_info($stringa){
				echo "<script>alert('$stringa')</script>";
			}

			function scrivi_form_impostazioni(){
				echo "
					<h2>COMPILARE SOLO I CAMPI NECESSARI</h2>
					<form action='admin.php'>
						<label for='ttlfoto'>Tempo per un round: </label>
						<input type='number' placeholder='30secondi' id='ttlfoto' name='TTLFoto'><br>
						<label>Numero di Round: </label>
						<input type='number' placeholder='numero round' name='nRound' id='nRound'><br>
						<label>Numero Consigli: </label>
						<select name='suggerimenti'><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option></select>
						<br>
						<label for='titoloStanza' id='importante'>Nome stanza:</label>
						<input type='text' id='titoloStanza' name='titoloStanza' placeholder='campo obbligatorio'>
						<input type='submit' value='invio impostazioni' name='invioImpostazioni'>
					</form>
					<button onclick='onclickBottoneSelezionaImmagini()'>seleziona immagini</button>";
			}

			function controllo_vsessione_settate(){
				return (!isset($_SESSION['TTLFoto']) || $_SESSION['TTLFoto']<=0) || (!isset($_SESSION['numeroRound']) || $_SESSION['numeroRound']<=0) || (!isset($_SESSION['nomeStanza']) || $_SESSION['nomeStanza']=="None");
			}

			function visualizza_impostazioni(){
				if(!$_SESSION['partitaIniziata'] && !$_SESSION['inizioRichieste']){
					echo "<form action='eliminaStanza.php'><input type='submit' value='Elimina stanza'></form><br>";// bottone che serve ad eliminare la stranza
				}
				echo "<label>Tempo per Round: ".$_SESSION['TTLFoto']."</label><br>";
				echo "<label>Numero round: ".$_SESSION['numeroRound']."</label><br>";
				echo "<label>Suggerimenti per round: ".$_SESSION['suggerimenti']."</label><br>";
				echo "<label>Nome della stanza: ".$_SESSION['nomeStanza']."</label><br>";
				$img_sel = "";
				if($_SESSION['immaginiSelezionate']=="all"){
					$img_sel="all";
				}else{
					$img_sel = implode(",",$_SESSION['immaginiSelezionate']);
				}
				echo "<label>Immagini selezionate: ".$img_sel."</label><br>";
			}

			function controllo_variabili_sessione(){//default
				if(!isset($_SESSION['immaginiSelezionate']))$_SESSION['immaginiSelezionate']="all";
				if(!isset($_SESSION['TTLFoto']))$_SESSION['TTLFoto']=15;
				if(!isset($_SESSION['nomeStanza']))$_SESSION['nomeStanza']='None';
				if(!isset($_SESSION['numeroRound']))$_SESSION['numeroRound']=5;
				if(!isset($_SESSION["roundInCorso"]))$_SESSION["roundInCorso"]=false;
				if(!isset($_SESSION['n_round']))$_SESSION['n_round']=1;
				if(!isset($_SESSION['inizioRichieste']))$_SESSION['inizioRichieste']=false;
				if(!isset($_SESSION['partitaIniziata']))$_SESSION['partitaIniziata']=false;
				if(!isset($_SESSION['suggerimenti']))$_SESSION['suggerimenti']=3;
				if(!isset($_SESSION['alTermine']))$_SESSION['alTermine']=false;
			}

			function aggiungi_stanza($nome_stanza){//aggiunge il titolo della stanza al file
				//TODO far si che vengano controrllare le stringhe per prevenire l'sql injection 
				$GLOBALS['connessione']->query("insert into stanze (nome_stanza) values('$_SESSION[nomeStanza]')")
				or die("errore nell'aggiunta della stanza");
				//TODO testare questa parte di codice
				setta_immagini($_SESSION["immaginiSelezionate"]);
				
				
				//$GLOBALS['connessione']->query("insert into img_stanza()") or die("errore nell'inserimento delle immagini");


			}

			function rimuovi_stanza($nome_stanza){//rimuove la stanza con il nome passato
				$GLOBALS['connessione']->query("delete from stanze where nome_stanza='$nome_stanza'") or die("errore nell'eliminazione della stanza");
				$GLOBALS['connessione']->query("delete from img_stanza where nome_stanza='$nome_stanza'") or die("errore nell'eliminazione delle immagini della stanza");
			}

			function controllo_stanza_esistente($nome_stanza){//controllo se è valido il titolo della finestra
				if($nome_stanza=="None")return false;
				
				echo "<br>Nome della stanza: $nome_stanza";
				$risultato = mysqli_fetch_all($GLOBALS['connessione']->query("select count(*) as 'esistente'  from stanze where nome_stanza='$nome_stanza'"))[0];
				//echo "<br>nome stanza: $risultato[1]";
				if($risultato[0]==1)return false;//se e` stata trovata una stanza con quel nome allora non va bene 
				else return true;
			}

			function setta_immagini($immagini){
				$GLOBALS['connessione']->query("delete from img_stanza where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nell'eliminazione delle immagini della stanza");
				//print_r($immagini);//debug
				if($immagini=="all"){
					
					$personaggi = count((simplexml_load_file("../../memory.xml"))->xpath("./personaggio"));
					// echo " ".count((simplexml_load_file("../../memory.xml"))->xpath("./personaggio"));
					for($i=0;$i<$personaggi;$i++){
						$GLOBALS['connessione']->query("insert into img_stanza (nome_stanza, imgIndex) values('$_SESSION[nomeStanza]',$i)") or die("errore nell'inserire un immagine della stanza");
						//echo $i." ";
					}
				}else{
					$appoggio_immagini = $_SESSION["immaginiSelezionate"];
					for($i=0;$i<count($appoggio_immagini);$i++){
						// si diminuisce di uno l'index perchè è aumentato di uno (se si cambia e si mette che parte da 0 togliere il -1)
						$GLOBALS['connessione']->query("insert into img_stanza (nome_stanza, imgIndex) values('$_SESSION[nomeStanza]',".($appoggio_immagini[$i]-1).")") or die("errore nell'inserire un immagine della stanza");
					}
				}
			}



			//FINE DEL PHP

		ob_end_flush();
		 ?>
		<div id="contenitoreTabEImg" class="contenitoreTab">
			<table class='tabellaAdmin' id='tabellaAdmin'>
				
			</table>
			<div class="divImgDaIndovinare">
				<p id="nomeTizio" class="nomeTizio"></p>
				<img id="contenitoreImg" class="contenitoreImg" height="300px">
			</div>
			
			
		</div>

			<!-- TODO: far si che il js e il css vengano spostati in un file separato -->
		<script type="text/javascript">



			function onClickInizia(){
				location.replace("inizioRichieste.php")
			}
			function onClickChiudiEntrate(){
				location.replace("iniziaPartita.php")
			}
			function onClickterminaPartita(){
				//window.location.href="finePartita.php"
				location.replace("finePartita.php")
			}
			function scrivi_form_impostazioni(){

				$("<h2>COMPILARE SOLO I CAMPI NECESSARI</h2>\
					<form action='admin.php'>\
						<label for='ttlfoto'>Tempo per un round: </label>\
						<input type='number' placeholder='30secondi' id='ttlfoto' name='TTLFoto'><br>\
						<label>Numero di Round: </label>\
						<input type='number' placeholder='numero round' name='nRound' id='nRound'><br>\
						<label>Numero Consigli: </label>\
						<select name='suggerimenti'><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option></select><br>\
						<label for='titoloStanza' id='importante'>Nome stanza:</label>\
						<input type='text' id='titoloStanza' name='titoloStanza' placeholder='campo obbligatorio'>\
						<input type='submit' value='invio impostazioni' name='invioImpostazioni'>\
					</form>\
					<button onclick='onclickBottoneSelezionaImmagini()'>seleziona immagini</button><br>\
					<button id='closeImpostazioni' onclick='onclickCloseImpostazioni()'>chiudi la modifica impostazioni</button>").appendTo("#divImpostazioni");

				$("#cambiaImpostazioni").hide()
			}

			function onclickCloseImpostazioni(){
				$("#divImpostazioni").html("<button id='cambiaImpostazioni' onclick='scrivi_form_impostazioni()'> cambia impostazioni </button>")
			}

			function onclickBottoneSelezionaImmagini(){
				console.log('entrato nel selezione di immagini')
				window.location.href='selezioni.php'
			}

			function onClickIniziaRound(){
				window.location.href="iniziaRound.php";

			}

			function onClickFineRound(){
				window.location.href="fineRound.php";
			}


		</script>

		<style type="text/css">
			button{
				margin-top: 0.5vh;
			}

		</style>

</body>
</html>