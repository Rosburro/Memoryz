console.log("script admin visualizza studenti");


$(document).ready(function(){
	//e4cho mandato dentro l'oggetto prelevato
	setInterval(funzione_interval, 1_000);
	$('#theadAdmin').append(
		'<tr>\
			<th></th>\
			<th>username</th>\
			<th>espelli</th>\
		</tr>')
	
})



function funzione_interval(){
	//console.log("entrato dentro l'interval"+$('#nomeStanza').html())

	$("#tabellaAdmin").load("StudentiPartecipanti.php", {nomeStanza:$('#nomeStanza').text()}, function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
		
	})
}


function espelliPersona(username){
	console.log('usernae da espellere>'+username)
	$.post('../src/espelliUser.php', {username:username}, function(dati){//il nome della stanza preso tramite la var si sessione
		console.log('fatto>'+dati)
	})
}