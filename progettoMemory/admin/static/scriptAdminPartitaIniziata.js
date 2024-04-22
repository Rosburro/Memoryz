console.log("scriptAdminPartitaIniziata");

let ttl = 0

$(document).ready(function(){

	
	setInterval(funzionePunteggio, 1_000)
	setInterval(funzioneAggiornaImmagine, 1_000)
	setTimeout(function(){$("#iniziaTerminaRound").ready(function(){
		$("#iniziaTerminaRound").css("pointer-events", "all")
	})}, 2_000)//toglie il blocco ai bottoni fine round e inizia per evitare che si clicchino troppo in fretta e causino errore allo studente
})


function funzionePunteggio(){
	
	$("#tabellaAdmin").load("punteggioStudenti.php", function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
		
	})
}

function funzioneAggiornaImmagine(){
	$.get("ricercatoCorrente.php",function(dati) {
		let app = dati.split(",")//converte in array i dati passati
		if(app.length==2){
			$("#nomeTizio").text(app[0])
			if($("#contenitoreImg").attr("src")!="http://sitinosetosobellino.altervista.org/progettoMemory/img/"+app[1]){
				$("#contenitoreImg").attr("src", "http://sitinosetosobellino.altervista.org/progettoMemory/img/"+app[1])
			}
		}else{
			$("#nomeTizio").text(dati)
		}
	})
}

function onClickterminaPartita(){
	//window.location.href="finePartita.php"
	location.replace("finePartita.php")
}