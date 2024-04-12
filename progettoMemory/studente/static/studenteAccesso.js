$(document).ready(function() {

	setInterval(stanzeAperte, 1_000)

})

function stanzeAperte(){
	$("#selectStanzaAperta").load("prendiStanzeAperte.php", function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
		
	})
}