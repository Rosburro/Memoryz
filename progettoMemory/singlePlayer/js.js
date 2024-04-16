let cont = 0;                       //conta quante volte l'user gira le figurine
let check = [];                     //array che contiene gli indici delle figurine girate 
let dueElementiPrima = [];          //array che contiene gli ultimi 2 elementi cliccati (da visibili a invisibili, quindi tornano visibili)
let dueElementiDopo = [];           //array che contiene gli ultimi 2 elementi cambiati (da invisibili a visibili, quindi tornano invisibili)
let onClickImg = [];                //array che contiene la funzione onclick di ogni immagine (giraFigurina(this, proprioIndice))
let contaMosse = 0;                 //conta quanti tentativi fa l'utente prima di vincere
let quantiP;                        //variabile che contiene quante caselle ci sono (metà immagini metà info)
    


function salvaCont(){
    let figure = document.querySelectorAll("#immagineUnknown"); 
    quantiP = figure.length/2; 
}


function giraFigurina(oggetto,index){

    if(cont < 2){   //se non ha ancora fatto 2 mosse

        //salva info
        check.push(index);
        dueElementiPrima.push(oggetto);



        //prendi e salva l'elemento dopo l'immagine (div con scritte se è figurina info - img con personaggio se è img)
        let elementoSucc = oggetto.nextElementSibling;
        dueElementiDopo.push(elementoSucc);

        //nascondi figurina unknown (oggetto) e mostra figurina nascosta (elementoSucc)
        oggetto.hidden = true;
        elementoSucc.hidden = false;

        cont++; //utente ha fatto una mossa
        //console.log(check);
    }


    //se l'utente ha fatto 2 mosse
    if(cont == 2){
        controlla();
        //disabilita la possibilità di cliccare su altre figurine durante il controllo (3s)
        disabilitaOnClick();
    }

}

function controlla() {
    //se gli index delle figurine sono diversi reset(true) (gira di nuovo)
    if (check[0] != check[1]) {
        document.body.classList.add("flashErrore");

        // Rimuove la classe "flash" dopo un certo intervallo di tempo
        setTimeout(function() {
            document.body.classList.remove("flashErrore");
            reset(true); // chiamata a reset() dopo 3 secondi
        }, 1500); // Durata del lampeggio (3 secondi)


    } else {
        document.body.classList.add("flashCorretto");

        // Rimuove la classe "flash" dopo un certo intervallo di tempo
        setTimeout(function() {
            document.body.classList.remove("flashCorretto");
            reset(false); // chiamata a reset() dopo 3 secondi
        }, 1500); // Durata del lampeggio (3 secondi)
    }
}


function reset(bool){

    if(bool){ //se sono diverse, gira di nuovo 
            dueElementiPrima[0].hidden = false;
            dueElementiPrima[1].hidden = false;
            dueElementiDopo[0].hidden = true;
            dueElementiDopo[1].hidden = true;

    }

    else{
        dueElementiDopo[0].hidden = true;
        dueElementiDopo[1].hidden = true;
        quantiP--;  //ogni volta che azzecca un immagine, cont-- dal n di img
    }
    

    cont = 0;
    check = [];
    dueElementiDopo = [];
    dueElementiPrima = [];
    onclickIndiceOriginele = [];
    abilitaOnClick(); //riabilita la possibilità di cliccare le immagini
    contaMosse++;     //dopo aver girato 2 figurine, aggiungi 1 mossa fatta


    if(quantiP==0){ //se il giocatore ha esaurito le immagini, ha vinto
        window.location.href = "post.php?t="+contaMosse;  //cambia pagina
    }


}


// dopo 2 scelte la funzione rimuove ad ogni immagine la funzione onclick
function disabilitaOnClick(){
        
    let immagini = document.querySelectorAll("#immagineUnknown");   //tutte le le figurine ancora sconosciute  
    immagini.forEach(function(img) {
        onClickImg.push(img.getAttribute("onclick"));   //salva la funzione in un array
        img.removeAttribute("onclick");
    });


}

//dopo la fine del turno tutte le figurine sconosciute tornano cliccabili 
function abilitaOnClick(){
    
    let immagini = document.querySelectorAll("#immagineUnknown");
    immagini.forEach(function(img,i) {
        img.setAttribute("onclick", onClickImg[i]);
    });

}



// MIX TABELLA (ad ogni reload)

function mescolaTabella() {
    let tabella = document.getElementById("tabella");
    let numRows = tabella.rows.length;
    let numCols = tabella.rows[0].cells.length;

    
    let celle = [];
    for (let i = 0; i < numRows; i++) {
        let row = [];
        for (let j = 0; j < numCols; j++) {
            row.push(tabella.rows[i].cells[j].innerHTML);
        }
        celle.push(row);
    }

    //mix righe
    celle.sort(function() {
        return Math.random() - 0.5;
    });

    //mix colonne
    let newcelle = [];
    for (let j = 0; j < numCols; j++) {
        let column = [];
        for (let i = 0; i < numRows; i++) {
            column.push(celle[i][j]);
        }
        column.sort(function() {
            return Math.random() - 0.5;
        });
        newcelle.push(column);
    }

    //tabella disordinata
    for (let i = 0; i < numRows; i++) {
        for (let j = 0; j < numCols; j++) {
            tabella.rows[i].cells[j].innerHTML = newcelle[j][i];
        }
    }
}