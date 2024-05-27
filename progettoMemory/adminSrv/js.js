
function soluz1(){

    let indice = document.getElementsByName("soluzioni[]").length;


    let soluzione = document.createElement("input");
    

    soluzione.type= "text";
    soluzione.placeholder="Soluzione "+(indice+1);
    soluzione.className = "input input-bordered input-secondary w-full max-w-xs";
    soluzione.name = "soluzioni[]";
    

    indice++;

    

    document.getElementById("daqua").appendChild(soluzione);
    document.getElementById("daqua").appendChild(document.createElement("br"));
    document.getElementById("daqua").appendChild(document.createElement("br"));


}





function sugg1(){

    let indice = document.getElementsByName("sugger[]").length;


    let sugg = document.createElement("input");
    

    sugg.type= "text";
    sugg.placeholder="Suggerimento "+(indice+1);
    sugg.className = "input input-bordered input-secondary w-full max-w-xs";
    sugg.name = "sugger[]";
    

    indice++;

    

    document.getElementById("daqui").appendChild(sugg);
    document.getElementById("daqui").appendChild(document.createElement("br"));
    document.getElementById("daqui").appendChild(document.createElement("br"));


}


function sugg2(){

    let indice = document.getElementsByName("sugger[]").length;


    let sugg = document.createElement("input");
    

    sugg.type= "text";
    sugg.placeholder="Suggerimento "+(indice+1);
    sugg.className = "input input-bordered input-primary w-full max-w-xs";
    sugg.name = "sugger[]";
    

    indice++;

    

    document.getElementById("daqui").appendChild(sugg);
    document.getElementById("daqui").appendChild(document.createElement("br"));
    document.getElementById("daqui").appendChild(document.createElement("br"));


}



function soluz2(){

    
    let indice = document.getElementsByName("soluzioni[]").length;

    let soluzione = document.createElement("input");
    

    soluzione.type= "text";
    soluzione.placeholder="Soluzione "+(indice+1);
    soluzione.className = "input input-bordered input-primary w-full max-w-xs";
    soluzione.name = "soluzioni[]";
    

    indice++;

    

    document.getElementById("daqua").appendChild(soluzione);
    document.getElementById("daqua").appendChild(document.createElement("br"));
    document.getElementById("daqua").appendChild(document.createElement("br"));



}