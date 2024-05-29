console.log("scriptAdminPartitaIniziata");

let ttl = 0

$(document).ready(function(){
	$('#divImgDaIndovinare').show()
	$('#theadAdmin').append(
		'<tr>\
			<th></th>\
			<th>partecipante</th>\
			<th>punteggio</th>\
			<th>risposta</th>\
		</tr>')
	
	setInterval(funzionePunteggio, 1_000)//controlla i punteggi che hanno attualmente i partecipanti
	setInterval(funzioneAggiornaImmagine, 1_000)//aggiorna l'immagine e vede se e` iniziato o meno il round
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
			if($("#contenitoreImg").attr("src")!="../../img/"+app[1]){
				$("#contenitoreImg").attr("src", "../../img/"+app[1])
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