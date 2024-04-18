<?php

    if(isset($_GET['quant'])){
        $quanteImmagini = $_GET['quant']; //prende quante img
        session_start();
        $_SESSION['ultimaPartita'] = $_GET['quant'];
    }

    else{
        $quanteImmagini = 8;    //consiglio max 16 (16 immagini + 16 consigli)
    }

    $memory = "../memory.xml";
    $arrayXML = simplexml_load_file($memory);
    


    //echo inzializzazione pagine html,js,css
    echo " 
        <html>
        <head>
            <title> Memory </title>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
            <link rel='stylesheet' type='text/css' href='styles.css'>
            <script type='text/javascript' src='js.js'></script>
        </head>";

    //impaginazione schermata utente con tabella immagini
    echo"

        <body onload='mescolaTabella(); salvaCont()'>
            <form name='memory'>
            <table align='center' id='tabella' cellpadding='10'>
            

    ";

    $array1 = json_decode(json_encode($arrayXML), true);    //conversione da array xml a array php


    //ciclo per eliminare l'array di array personaggi (solo per comodità)
    $personaggiComplete = array();
    $cont = 0;
    foreach ($array1 as $array2) {
        foreach ($array2 as $persona) {
            $personaggiComplete[$cont] = $persona;
            $cont++;
        }
    }

    shuffle($personaggiComplete);   //mescola l'array prima di scegliere i 16 personaggi (per non prendere sempre gli stessi)
    //print_r($personaggi);
    

    for($i=0; $i<$quanteImmagini; $i++){
        $personaggi[$i] = $personaggiComplete[$i];
    }

    shuffle($personaggi);           //mescola l'array prima di mettere in tabella (per non dover mescolare le colonne della tabella)

    //TABELLA 4 IMG
    


    if($quanteImmagini == 16){sediciPC($personaggi,$quanteImmagini);}
    if($quanteImmagini == 4){quattro($personaggi,$quanteImmagini);}
    if($quanteImmagini == 8){otto($personaggi,$quanteImmagini);}
    if($quanteImmagini == 10){dieci($personaggi,$quanteImmagini);}




    echo"                
            </form>
            </body>
            </html>
    ";



    //FUNZIONI IN BASE AL N DI IMG

    function sediciPC($personaggi,$quanteImmagini){
        $count = 0;
        foreach ($personaggi as $persona) {
            if ($count == 0) { 
                echo "<tr>"; 
            } 
            if ($count >= $quanteImmagini/2) {                
                $count = 0;
                echo "</tr><tr>";
            }
            echo "
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png' width='250' height='400' >
                    <div hidden >
                    <img src='http://sitinosetosobellino.altervista.org/progettoMemory/img/$persona[img]' width='250' height='400' >
                    </div>
                
                </td>";
        $count++;
        }

        //stampa tutte le figurine info
        shuffle($personaggi);
        $count = 0;
        foreach ($personaggi as $persona) {
            if ($count == 0) { 
                echo "<tr>"; 
            } 
            if ($count >= $quanteImmagini/2) {                
                $count = 0;
                echo "</tr><tr>";
            }
            echo "<td> <br>
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png' width='250' height='400' >
                    
                    <div hidden >
                    <h1> $persona[n_completo]</h1> ";
            foreach ($persona["sugg"] as $consiglio){
                echo "<p>$consiglio</p>";
            }   
            echo "
                    </div>    
                    </td>";     
        $count++;
        }
            echo"</table>";
    }


    function quattro($personaggi,$quanteImmagini){
        echo "<tr>";
        foreach ($personaggi as $persona) {
            
            echo "
                
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png' width='250' height='400' >
                    <div hidden >
                    <img src='http://sitinosetosobellino.altervista.org/progettoMemory/img/$persona[img]' width='250' height='400' >
                    </div>
                
                </td>
                ";
        
        }
        echo "</tr>";

        //stampa tutte le figurine info
        shuffle($personaggi);
        echo "<tr>";
        foreach ($personaggi as $persona) {
            
            echo "<td> <br>
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png' width='250' height='400' >
                    
                    <div hidden >
                    <h1> $persona[n_completo]</h1> ";
            foreach ($persona["sugg"] as $consiglio){
                echo "<p>$consiglio</p>";
            }   
            echo "
                    </div>    
                    </td>";     

        }
        echo "</tr></table>";
    }


    function otto($personaggi,$quanteImmagini){
        echo "<tr>";
        $contatore = 1;
        foreach ($personaggi as $persona) {
            if($contatore>4){echo"</tr>"; $contatore=1;}
            echo "
                
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png' width='250' height='400' >
                    <div hidden >
                    <img src='http://sitinosetosobellino.altervista.org/progettoMemory/img/$persona[img]' width='250' height='400' >
                    </div>
                
                </td>
                ";
            $contatore++;
        }
        echo "</tr>";

        //stampa tutte le figurine info
        shuffle($personaggi);
        echo "<tr>";
        $contatore = 1;
        foreach ($personaggi as $persona) {
            if($contatore>4){echo"</tr>"; $contatore=1;}
            echo "<td> <br>
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png' width='250' height='400' >
                    
                    <div hidden >
                    <h1> $persona[n_completo]</h1> ";
            foreach ($persona["sugg"] as $consiglio){
                echo "<p>$consiglio</p>";
            }   
            echo "
                    </div>    
                    </td>";     
            $contatore++;
        }
        echo "</tr></table>";
    }


    function dieci($personaggi,$quanteImmagini){
        echo "<tr>";
        $contatore = 1;
        foreach ($personaggi as $persona) {
            if($contatore>5){echo"</tr>"; $contatore=1;}
            echo "
                
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png' width='250' height='400' >
                    <div hidden >
                    <img src='http://sitinosetosobellino.altervista.org/progettoMemory/img/$persona[img]' width='250' height='400' >
                    </div>
                
                </td>
                ";
            $contatore++;
        }
        echo "</tr>";

        //stampa tutte le figurine info
        shuffle($personaggi);
        echo "<tr>";
        $contatore = 1;
        foreach ($personaggi as $persona) {
            if($contatore>5){echo"</tr>"; $contatore=1;}
            echo "<td> <br>
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png' width='250' height='400' >
                    
                    <div hidden >
                    <h1> $persona[n_completo]</h1> ";
            foreach ($persona["sugg"] as $consiglio){
                echo "<p>$consiglio</p>";
            }   
            echo "
                    </div>    
                    </td>";     
            $contatore++;
        }
        echo "</tr></table>";
    }


?>

                            
