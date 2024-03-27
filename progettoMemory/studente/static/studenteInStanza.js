$(document).ready(function(){

	setInterval(function(){
		console.log('entrato')
		$("#partita").load("partitaIniziata.php?nome_stanza="+stanza, function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
			console.log(dati.indexOf(";"))
			//non la cosa migliore del mondo ma funzia
			//si potrebbe cambiare con un get o un post magari
			if(dati.indexOf(";")!=-1){//controlla se ci sono o meno , nella stringa passata delle ; se ci sono significa che gli sto passando info sul round sennò no
				dati = dati.split(";")
				console.log(dati)
			}
		})
	}, 1_000)


})