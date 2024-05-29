console.log("script admin visualizza studenti");


$(document).ready(function(){
	//e4cho mandato dentro l'oggetto prelevato
	setInterval(funzione_interval, 1_000);
	$('#theadAdmin').append(
		'<tr>\
			<th></th>\
			<th>username</th>\
		</tr>')
	
})



function funzione_interval(){
	//console.log("entrato dentro l'interval"+$('#nomeStanza').html())

	$("#tabellaAdmin").load("StudentiPartecipanti.php", {nomeStanza:$('#nomeStanza').text()}, function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
		
	})
}