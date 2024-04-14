console.log("script admin visualizza studenti");


$(document).ready(function(){
	//e4cho mandato dentro l'oggetto prelevato
	setInterval(funzione_interval, 1_000);
	
	
})



function funzione_interval(){
	console.log("entrato dentro l'interval")
	$("#tabellaAdmin").load("StudentiPartecipanti.php", function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
		
	})
}