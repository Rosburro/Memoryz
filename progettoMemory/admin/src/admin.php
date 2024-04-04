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
</head>
<body>
		<!-- TODO cambiare tutta la gestione di file in db -->
		

		<?php 
		//NB: comando da utilizzare per prendere tutte le immagini
		// $memory = "../../memory.xml";
		// $personaggi = simplexml_load_file($memory);
		// $personaggi = $personaggi->xpath("./personaggio//*");
		require '../../sql/config.php';
			session_start();

			if($_SESSION['n_round']>$_SESSION['numeroRound']){
				echo "partita finita";
				
				//cose che servono per finire la partita (uguali al file finePartita.php
				$_SESSION['partitaIniziata']=False;
				$_SESSION['inizioRichieste']=false;
				$_SESSION['n_round']=0;
				$connessione->query("delete from partecipanti where nome_stanza='$_SESSION[nomeStanza]'");
				$connessione->query("update stanze set inCorso=0, ingAperto=0 where nome_stanza='$_SESSION[nomeStanza]'");
				echo "<button onclick='onClickterminaPartita()'>termina partita</button>";
				//header("location: ./finePartita.php");
			}

			 $fileStanze="../../tmp/tutteStanze.txt";

			//cosa per le immagini
			
			controllo_variabili_sessione();

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

			if(isset($_GET['invioImpostazioni'])){
				$ttl = intval($_GET['TTLFoto']);
				$nRound=$_GET['nRound'];
				$stanza = $_GET['titoloStanza'];
				//echo "entrato nel secondo if".!isset($_SESSION['TTLFoto']);
				if($ttl>0) {
					//echo "entrato nel set del session";
					$_SESSION['TTLFoto']=$ttl;
				}

				if($nRound>0){
					$_SESSION['numeroRound']=$nRound;
				}
				
				$controllo_nome_stanza = controllo_stanza_esistente($stanza);
				
				if($_SESSION["nomeStanza"]!="None" && $controllo_nome_stanza){
					rimuovi_stanza($_SESSION['nomeStanza']);
				}
				if($controllo_nome_stanza){
					$_SESSION['nomeStanza']=$stanza;
					aggiungi_stanza($stanza);
				}

				header("Location: ./admin.php");
			}

			if(isset($_SESSION['partitaIniziata']) && $_SESSION['partitaIniziata']==True){//partita iniziata

				
				echo "partita in corso";
				
				echo "<script src='../static/scriptAdminPartitaIniziata.js'></script>";
				echo "<button onclick='onClickterminaPartita()'>termina partita</button>";
				if($_SESSION["roundInCorso"]==0){
					echo "<button onclick='onClickIniziaRound()' id='iniziaTerminaRound'>inizia round</button>";
				}else{
					echo "<button onclick='onClickFineRound()' id='iniziaTerminaRound'>fine round</button>";
				}
				echo "round corrente: $_SESSION[n_round]<br>";
				


			}else if(controllo_vsessione_settate()){//redirect alla pagina di configurazione
				//echo "entrato nel session ttl";
				scrivi_form_impostazioni();

			}else  if ((!isset($_SESSION['inizioRichieste']) || $_SESSION['inizioRichieste']==False) /*&& (!isset($_SESSION['partitaIniziata']) || $_SESSION['partitaIniziata']=False)*/){//bottone per inizio delle richieste
				
				echo "<div id='divImpostazioni'></div>
						<button id='cambiaImpostazioni' onclick='scrivi_form_impostazioni()'> cambia impostazioni </button>";
				echo "<button id='inizioRichieste' onclick='onClickInizia()'>inizio Richieste</button>";

			}else {//attessa delle persone che entrino e bottone di chiusura
				//TODO: fare un if per controllare se i campi compilati sono validi
				echo "in attesa di persone... ";
				echo "<button onclick='onClickChiudiEntrate()'>chiudi entrate inizia gioco</button>";
				echo "<script src='../static/scriptAdminVisualizzaStudenti.js'></script>";
			}
			
			echo "<table id='tabellavisualizzazione'></table>";





			function scrivi_form_impostazioni(){
				echo "
					<p>CONPILARE SOLO I CAMPI NECESSARI</p>
					<form action='admin.php'>
						<label for='ttlfoto'>immettere il tempo che lo studente ha per ogni foto</label>
						<input type='number' id='ttlfoto' name='TTLFoto'><br>
						<input type='number' placeholder='numero dei round' name='nRound' id='nRound'><br>
						<label for='titoloStanza'>immettere il nome della stanza</label>
						<input type='text' id='titoloStanza' name='titoloStanza' placeholder='campo obbligatorio'>
						<input type='submit' value='invio impostazioni' name='invioImpostazioni'>
					</form>
					<button onclick='onclickBottoneSelezionaImmagini()'>seleziona immagini</button>";
			}

			function controllo_vsessione_settate(){
				return (!isset($_SESSION['TTLFoto']) || $_SESSION['TTLFoto']<=0) || (!isset($_SESSION['numeroRound']) || $_SESSION['numeroRound']<=0) || (!isset($_SESSION['nomeStanza']) || $_SESSION['nomeStanza']=="None");
			}

			function visualizza_impostazioni(){
				echo "tempo settato: ".$_SESSION['TTLFoto']."<br>";
				echo "round settatio: ".$_SESSION['numeroRound']."<br>";
				echo "nome della stanza: ".$_SESSION['nomeStanza']."<br>";
				$img_sel = "";
				if($_SESSION['immaginiSelezionate']=="all"){
					$img_sel="all";
				}else{
					$img_sel = implode(",",$_SESSION['immaginiSelezionate']);
				}
				echo "immagini selezionate: ".$img_sel."<br>";
			}

			function controllo_variabili_sessione(){//default
				if(!isset($_SESSION['immaginiSelezionate']))$_SESSION['immaginiSelezionate']="all";
				if(!isset($_SESSION['TTLFoto']))$_SESSION['TTLFoto']=15;
				if(!isset($_SESSION['nomeStanza']))$_SESSION['nomeStanza']='None';
				if(!isset($_SESSION['numeroRound']))$_SESSION['numeroRound']=5;
				if(!isset($_SESSION["roundInCorso"]))$_SESSION["roundInCorso"]=false;
				if(!isset($_SESSION['n_round']))$_SESSION['n_round']=1;
			}

			function aggiungi_stanza($nome_stanza){//aggiunge il titolo della stanza al file
				//TODO far si che vengano controrllare le stringhe per prevenire l'sql injection 
				$GLOBALS['connessione']->query("insert into stanze (nome_stanza,TTLImg, round) values('$_SESSION[nomeStanza]', '$_SESSION[TTLFoto]', '$_SESSION[numeroRound]')")
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
				if($nome_stanza=="" || str_replace(" ","",$nome_stanza)=="" || $nome_stanza=="None")return false;
				$risultato = mysqli_fetch_all($GLOBALS['connessione']->query("select count(*) as 'esistente' from stanze where nome_stanza='$nome_stanza'"))[0];
				
				if($risultato[0]==1)return false;//se e` stata trovata una stanza con quel nome allora non va bene 
				else return true;
			}

			function setta_immagini($immagini){
				$GLOBALS['connessione']->query("delete from img_stanza where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nell'eliminazione delle immagini della stanza");
				echo $immagini;
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
						$GLOBALS['connessione']->query("insert into img_stanza (nome_stanza, imgIndex) values('$_SESSION[nomeStanza]',".$appoggio_immagini[$i].")") or die("errore nell'inserire un immagine della stanza");
					}
				}
			}



			//FINE DEL PHP
		?>
		<table class='tabellaAdmin' id='tabellaAdmin'>
			<tr>
				<td class='partecipanti' id='partecipanti'>
					
				</td>
				<td class='score' id='score'>
					
				</td>
			</tr>
		</table>


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

				$("<p>CONPILARE SOLO I CAMPI NECESSARI</p>\
					<form action='admin.php'>\
						<label for='ttlfoto'>immettere il tempo che lo studente ha per ogni foto</label>\
						<input type='number' id='ttlfoto' name='TTLFoto'><br>\
						<input type='number' placeholder='numero dei round' name='nRound' id='nRound'><br>\
						<label for='titoloStanza'>immettere il nome della stanza</label>\
						<input type='text' id='titoloStanza' name='titoloStanza' placeholder='campo obbligatorio'>\
						<input type='submit' value='invia impostazioni' name='invioImpostazioni'>\
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