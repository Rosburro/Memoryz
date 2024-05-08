<?php
    
    
    //variabili prj finale
    //    /*
    $urlUnknown = "http://sitinosetosobellino.altervista.org/progettoMemory/img/unknown.png";
    $urlImmagine = "http://sitinosetosobellino.altervista.org/progettoMemory/img/";
    $memory = "../memory.xml";
    //    */


    //varibili in loco mio
    /*
    $memory = "memory.xml";
    $urlImmagine = "img/";
    $urlUnknown = "img/unknown.png";
    */


    //PRENDE IN GET IL N DI FIGURINE
    if(isset($_GET['quant'])){
        $quanteImmagini = $_GET['quant']; //prende quante img
        session_start();
        $_SESSION['ultimaPartita'] = $_GET['quant'];
    }

    else{
        $quanteImmagini = 8;    //consiglio max 16 (16 immagini + 16 consigli)
    }



    //PARTE ARRAY
    $arrayXML = simplexml_load_file($memory);
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
    

    //FINE ARRAY


    




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
            <div class='avviso-non-desktop'>
                Questa pagina è ottimizzata per l'uso su desktop. Si prega di visitarla da un dispositivo desktop per una migliore esperienza.
            </div>
            <div class='solo-desktop'>
            <form name='memory'>
            <table align='center' id='tabella' cellpadding='10'>
            

    ";



    //FUNZIONI DI STAMPA PER LE FIGURINE

    if($quanteImmagini == 4){quattro($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine);}
    if($quanteImmagini == 8){otto($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine);}
    if($quanteImmagini == 10){dieci($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine);}
    if($quanteImmagini == 12){dodici($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine);}
    if($quanteImmagini == 14){quattordici($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine);}
    if($quanteImmagini == 16){sedici($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine);}



    echo"                
            </form>
            </div>
            </body>
            </html>
    ";



    //FUNZIONI IN BASE AL N DI IMG

    function sedici($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine){
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
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
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
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    
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


    function quattro($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine){
        echo "<tr>";
        foreach ($personaggi as $persona) {
            $imgPers = $urlImmagine.$persona["img"];
            echo "
                
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    <div hidden >
                    <img src='$imgPers' width='250' height='400' >
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
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    
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


    function otto($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine){
        echo "<tr>";
        $contatore = 1;
        foreach ($personaggi as $persona) {
            $imgPers = $urlImmagine.$persona["img"];
            if($contatore>4){echo"</tr>"; $contatore=1;}
            echo "
                
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    <div hidden >
                    <img src='$imgPers' width='250' height='400' >
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
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    
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


    function dieci($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine){
        echo "<tr>";
        $contatore = 1;
        foreach ($personaggi as $persona) {
            $imgPers = $urlImmagine.$persona["img"];

            if($contatore>5){echo"</tr>"; $contatore=1;}
            echo "
                
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    <div hidden >
                    <img src='$imgPers' width='250' height='400' >
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
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    
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

    function dodici($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine){
        echo "<tr>";
        $contatore = 1;
        foreach ($personaggi as $persona) {
            $imgPers = $urlImmagine.$persona["img"];

            if($contatore>6){echo"</tr>"; $contatore=1;}
            echo "
                
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    <div hidden >
                    <img src='$imgPers' width='250' height='400' >
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
            if($contatore>6){echo"</tr>"; $contatore=1;}
            echo "<td> <br>
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    
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


    function quattordici($personaggi,$quanteImmagini,$urlUnknown,$urlImmagine){
        echo "<tr>";
        $contatore = 1;
        foreach ($personaggi as $persona) {
            $imgPers = $urlImmagine.$persona["img"];

            if($contatore>7){echo"</tr>"; $contatore=1;}
            echo "
                
                <td><br>
                
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    <div hidden >
                    <img src='$imgPers' width='250' height='400' >
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
            if($contatore>7){echo"</tr>"; $contatore=1;}
            echo "<td> <br>
                    <img id='immagineUnknown' onclick='giraFigurina(this,$persona[indice])' src='$urlUnknown' width='250' height='400' >
                    
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
