<?php 
	ob_start();
	session_start();
	require "../../sql/config.php";
	if(isset($_GET['inviaForm'])){
		//TODO sistemare il nome a modinjo o ci sono casini, (non case sensitive)
		//defence for injection
		
		if(!isset($_GET['stanzaSelezionata'])) header("location: studente.php");

		echo  $_GET["stanzaSelezionata"];
		if(controllo_nome_partecipante($_GET['nomePartecipante'], $_GET["stanzaSelezionata"])){
			//echo "entrato qui ppppp";
			// $connessione-> query("insert into partecipanti (username, nome_stanza) values('$_GET[nomePartecipante]', '$_GET[stanzaSelezionata]')")
			// or die("errore nell'inserimento del partecipante");
			
			$query = $connessione->prepare("insert into partecipanti (username, nome_stanza) values(:username, :nomestanza)");
			$query->bindParam(':nomestanza',$_GET['stanzaSelezionata'], PDO::PARAM_STR);
			$query->bindParam(':username',$_GET['nomePartecipante'], PDO::PARAM_STR);
			$query->execute();
			
			$_SESSION['nomePartecipante'] = $_GET['nomePartecipante'];
			$_SESSION['stanzaSelezionata'] = $_GET['stanzaSelezionata'];

			// $info = mysqli_fetch_all($connessione->query("select TTLImg, round from stanze where nome_stanza='$_SESSION[stanzaSelezionata]'"))[0];
			
			$query = $connessione->prepare("select TTLImg, round from stanze where nome_stanza=:nomestanza");
			$query->bindParam(':nomestanza',$_SESSION['stanzaSelezionata'], PDO::PARAM_STR);
			$query->execute();
			$info = $query->fetchAll(PDO::FETCH_ASSOC)[0];
			
			
			$_SESSION["TTL"] = $info['TTLImg'];
			$_SESSION["round"]= $info['round'];
			$_SESSION["punteggioPlayer"]=0;
			header("location: studente.php");
		}else{
			header("location: studente.php");
		}
	}



	// function controllo_nome_partecipante($nome_partecipante, $nome_stanza){//returna se è valido
	// 	if($nome_partecipante=="None" || $nome_partecipante=="" || str_replace(" ", "", $nome_partecipante)==""){
	// 		//echo "entrato dentro l'if";
	// 		return false;
	// 	}
	// 	$file = file("../../tmp/partecipanti/".$nome_stanza."_partecipanti.txt");
	// 	$nome_partecipante.="\n";
	// 	foreach($file as $line){
	// 		if($line==$nome_partecipante){
	// 			echo "entrato dentro l'if del for";
	// 			return false;
	// 		}
	// 	}

	// 	return true;
	// }

	function controllo_nome_partecipante($nome_partecipante, $nome_stanza){//controllo se è valido il titolo della finestra
		//sql injection
		$_GET['nomePartecipante'] = $nome_partecipante;
		if($nome_partecipante=="None" || $nome_partecipante=="" || str_replace(" ", "", $nome_partecipante)==""){
			//echo "entrato dentro l'if";
			return false;
		}

		// $risultato = mysqli_fetch_all($GLOBALS['connessione']->query("select count(*) as 'esistente' from partecipanti where nome_stanza='$nome_stanza' and username='$nome_partecipante'"))[0];
		
		$query = $GLOBALS['connessione']->prepare("select count(*) as esistente from partecipanti where nome_stanza=:nomestanza and username=:username");
        $query->bindParam(':nomestanza',$nome_stanza, PDO::PARAM_STR);
		$query->bindParam(':username',$nome_partecipante, PDO::PARAM_STR);
        $query->execute();
        $risultato = $query->fetchAll(PDO::FETCH_ASSOC)[0];



		if($risultato['esistente']==1)return false;//se e` stata trovata una stanza con quel nome allora non va bene 
		else return true;
	}
	ob_end_flush();
?>