<?php

    if(isset($_GET['quant'])){
        $quanteImmagini = $_GET['quant']; //prende quante img
        session_start();
        $_SESSION['ultimaPartita'] = $_GET['quant'];
    }

    else{
        $quanteImmagini = 8;    //consiglio max 16 (16 immagini + 16 consigli)
    }

    $memory = "memory.xml";
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

    //stampa tutte le figurine immagini
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
                        
                            <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='img/unknown.png' width='250' height='400' >
                            <div hidden >
                            <img src='img/$persona[img]' width='250' height='400' >
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
                            <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='img/unknown.png' width='250' height='400' >
                            
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
        echo"
            </table>
            </form>
            </body>
            </html>
    ";



?>

                            