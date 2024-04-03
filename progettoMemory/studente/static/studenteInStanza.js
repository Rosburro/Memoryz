$(document).ready(function(){

	setInterval(function(){//far si che esista una variabile booleana che se falsa non fa partire l'if
		console.log('entrato')
		$("#partita").load("partitaIniziata.php?nome_stanza="+stanza, function(dati,stat,xhr){//non passo alcun dato poichè è tuttosalvato nella sessione
			console.log(dati.indexOf(";"))
			//non la cosa migliore del mondo ma funzia
			//si potrebbe cambiare con un get o un post magari
			console.log(dati)
			if(dati.indexOf(";")!=-1){//controlla se ci sono o meno , nella stringa passata delle ; se ci sono significa che gli sto passando info sul round sennò no
				dati = dati.split(";")
				console.log(dati)
				// funzia
				let ttl =dati[2]
				let appData =new Date()
				let appDataRicevuta = dati[1].split(":")
				let ora = (appData.getHours()>12) ? appData.getHours()-12 : appData.getHours()

				console.log(appDataRicevuta[0]+", "+ora+", "+appDataRicevuta[1]+", "+appData.getMinutes())
				if(appDataRicevuta[0]==ora && appDataRicevuta[1]==appData.getMinutes() || 1==1){
					let differenzaStart= Number(dati[1].split(":")[2])-appData.getSeconds()
					console.log("differenza: "+differenzaStart)
					//vedere se va la differenzxa
					//TTL:ttl,img:dati[0],start:differenzaStart
					window.location.href= "../src/round.php?TTL="+ttl+"&img="+dati[0]+"&start="+differenzaStart;
				}//todo else fine round
				
				//window.location.href="roundInCorso?TTL="+ttl+"&img="+img+"&start="+differenzaStart+""

			}
			
		})
	}, 1_000)


})