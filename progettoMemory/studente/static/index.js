let nascosto = "";//nome autore nascosto che con il tempo apparirà
let nascosto_visualizza = "";//la stringa che va visualizzata
const parola = "Leopardi".toLocaleLowerCase();//nome autore
const carattere = "-";//il carattere per indicare un lettera
const spazio = " ";//il carattere per indicare uno stazio quindi non una lettera da inserire
const font_size = 100;//percentuale grandezza font
let time = 20;//tempo limite
time = time-0.1;//scalo perchè è lento
let t_start = 0;//contatore tempo passato dallo start
/*let ore_start = new Date().getHours();//settiamo le ore per vedere lo strat
let min_start = new Date().getMinutes();//settiamo i minuti per vedere lo strat
let sec_start = new Date().getSeconds();//settiamo i secondi per vedere lo strat*/
let risposta = ""; //variabile dove verrà salvata la risposta dopo il click conferma (o se scade il tempo)
const sugg_max = 3;//numero sugg decisi dalla prof DA NON CAMBIARE DURANTE LA PARTITA
let sugg_partita = sugg_max;//numero sugg ad inizio partita (non so se unirlo a sugg_max) [VIENE CAMBIATA A FINE ROUND]
let sugg_rim = sugg_max;//suggerimenti rimaneti in tutta la partita
let lista_consigli = ["cons1","cons2","cons3"];//lista consigli per immagine ( da prendere in input dal file di Betters)
let cont = time/2; // contatore per quando le lettere che appaiono
let punteggioTot = 0;//punteggio finale
let punteggio = 0;//punteggio del round
let tap = false;//se è stato cliccato il conferma
const p_max = 100;//punteggio massiomo in un round

//punteggio massimo: 100p
//consiglio -30p solo se è nella prima meta del tempo
//oltre metà tempo iniziano ad apparire le lettere
//-x punti in base al tempo
/*esempio:

 per la prima metà -40% 0 -35% (dei rimanenti in caso di consiglio(-30p))
 nella seconda parte appaiono le lettere -rimanente% (il punteggio non scende sotto -5));
 se non si clicca conferma ed è corretto +15p se ci clicca +15p + punteggio rimanente;
 se si clicca conferma ed è sbagliato -5 (per incentivare la richiesta del consiglio)
*/


$(document).ready(function(){
    const body = document.body;

    //clock
    let interval = setInterval(function(){
		if(t_start>=time)End();
		else{
			t_start+=0.5;
            console.log(`cont: ${cont}`);
            if(t_start >= cont){Rivela();cont++;}
			console.log(`Tempo attuale: ${t_start.toFixed(2)}`);
		}
    }, 500);


    parola.split('').forEach(function(lettera){
	    //console.log(lettera);
	    if(lettera == " "){nascosto += spazio;nascosto_visualizza+=spazio+" ";}
	    else {nascosto += carattere;nascosto_visualizza+=carattere+" ";}
    });
	console.log(nascosto);

    //creazione parola nascosta (--- - - )
    let v = document.getElementById("v");
	v.innerHTML = nascosto_visualizza;
	v.style = "font-size: "+font_size+"%;";

    //creazione della casella di testo
    let input = document.createElement("input");
    input.type="text";
    input.id="input";
    body.appendChild(input);

    //creazione bottone
    $("<button id='invio'></button>").appendTo("body");

    invio.textContent="conferma";
    $('#invio').on('click',function(){
        risposta=input.value.toLocaleLowerCase();
        console.log(risposta);
        tap = true;
        End();
    });

    $("<button id='sugg'></button>").appendTo("body");
    sugg.textContent="s";
    $('#sugg').on("click",function(){
        if(sugg_rim>0){consiglio();sugg_rim--;}
        
        console.log(sugg_rim);
    });

    function consiglio(){
        console.log("consigli rimasti: ");
        let id = lista_consigli.length-sugg_rim;
        $("<label id="+id+"></label>").appendTo("body");
        $("#"+id).text(lista_consigli[lista_consigli.length-sugg_rim]);

    }

	function End(){
        console.log("end");
		clearInterval(interval);

        //disabilito i pulsanti
        $("#sugg").prop("disabled",true);
        $("#invio").prop("disabled",true);

        let t_rimasto = time - t_start;
        //console.log("t_rim: "+t_rimasto);
        //console.log(t_start)
        //console.log(`proporzione: ${((t_start*0.35)/time)*p_max}`);

        if (risposta == "") risposta = input.value.toLocaleLowerCase();
        if(risposta == parola){
            //calcolo punteggio
            if(t_rimasto >= cont/*riutilizzo cont per comodità*/){
                //buona fortuna nel cercare di capirci qualcosa
                punteggio = p_max - (((t_start*0.35)/time) * p_max) - (sugg_partita - sugg_rim)*30;
            }else{
                punteggio = p_max - ((t_start/time) * p_max) - (sugg_partita - sugg_rim)*30;
            }
            if(tap)punteggio+=15;
            if(punteggio>100)punteggio=100;

            body.style="background-color:green;";
            //punteggio = punteggio.toFixed(2);
        }
        else {
            if(tap==true)punteggio=-5;
            if(sugg_rim<sugg_partita)punteggio=-5;
            if(risposta == '')punteggio=-5;

            sugg_partita=sugg_rim;
            body.style="background-color:red;";
            //punteggio = punteggio.toFixed(2);
        }

        punteggioTot += punteggio;
        console.log(`Punteggio Round: ${punteggio.toFixed(2)}`);
        console.log(`Punteggio Sessione: ${punteggioTot.toFixed(2)}`);
        //epilessia
		//body.style= "background-color: red;";
		//$("body").fadeToggle(10);
    }
    function Rivela(){

        //console.log("entrato");
        let arr_lettere = parola.split('');
        let arr_nascosto = nascosto.split('');

        let indice_car = Math.round(Math.random()*arr_lettere.length);

        if(arr_nascosto[indice_car]!=' ' && arr_nascosto[indice_car]!='-')Rivela();
        arr_nascosto[indice_car] = arr_lettere[indice_car];

        nascosto = arr_nascosto.join('');

        arr_nascosto.forEach(function(lettera){
            lettera+=" ";
        });
        nascosto_visualizza = arr_nascosto.join(' '); 
        
        v.innerHTML = nascosto_visualizza;
        v.style = "font-size: "+font_size+"%;";

        v.innerHTML = nascosto;
        v.style = "font-size: "+font_size+"%;";
    }
});
