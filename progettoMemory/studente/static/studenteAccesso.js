$(document).ready(function() {
	stanzeAperte()
	setInterval(stanzeAperte, 4_000)

})


function stanzeAperte(){
	//debugger
	let selezionata = document.getElementById("selectStanzaAperta").selectedIndex
	console.log(selezionata)
	$("#selectStanzaAperta").load("prendiStanzeAperte.php", function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
		if(selezionata>=0){
			let stanza =document.getElementById("selectStanzaAperta")
			console.log(stanza.options[selezionata].text)
			//stanza.options[selezionata].selected=true  
			stanza.value = stanza.options[selezionata].text
		}
	})
	
}