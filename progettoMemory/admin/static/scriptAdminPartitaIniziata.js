console.log("scriptAdminPartitaIniziata");


$(document).ready(function(){
	
	setInterval(funzionePunteggio, 1_000)
	
})


function funzionePunteggio(){
	$("#tabellaAdmin").load("punteggioStudenti.php", function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
		
	})
}

function onClickterminaPartita(){
	//window.location.href="finePartita.php"
	location.replace("finePartita.php")
}