$(document).ready(function(){

	setInterval(function(){//far si che esista una variabile booleana che se falsa non fa partire l'if
		console.log('entrato')
		$("#partita").load("partitaIniziata.php", function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
			if(dati=="fine"){//se la stanza e` chiusa
				onClickEsciDallaStanza()
			}

			if(dati=="espulso"){
				window.location.href='../src/resetta.php';
			}
			console.log(dati.indexOf(";"))
			//non la cosa migliore del mondo ma funzia
			//si potrebbe cambiare con un get o un post magari
			console.log(dati)
			dati= dati.split(";")
			if(dati[0]=="iniziato"){//controlla se ci sono o meno , nella stringa passata delle ; se ci sono significa che gli sto passando info sul round sennò no
				if(Number(dati[1])>0){
					window.location.href= "../src/round.php";
				}
				
			}
			
		})}, 1_500)
})