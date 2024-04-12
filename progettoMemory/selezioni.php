<?php
    $memory = "../../memory.xml";
    $personaggi = simplexml_load_file($memory);

    echo "
    <html>
    <head>
     
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
        <script type='text/javascript' src='../static/js_selezioni.js'></script>
        <link rel='stylesheet' type='text/css' href='../static/css_selezioni.css'>
    </head>
    <body>

    <form name='selezione'>
        <br><br><h1 align='center'> Selezionare le immagini </h1><br>
        <div align='center'>
            <table  cellpadding='10'>
    ";

    $count = 0;
    foreach ($personaggi as $personaggio) {
        if ($count == 0) { echo "<tr>"; } 
        if ($count >= 8) {                
            $count = 0;
            echo "</tr>";
        }
        echo "
            <td><br>
                <img src='http://sitinosetosobellino.altervista.org/progettoMemory/img/{$personaggio->img}' width='250' height='400' class='zoom' onclick='cambiaSfondo(this); salvaIndice($personaggio->indice);'> 
                <br> <p style='text-align:center; font-size:26px;'>$personaggio->n_completo </p>
            </td>";
        $count++;
    }
    echo "
            </table>
            
            <div class='immagine'>
            <img src='http://sitinosetosobellino.altervista.org/progettoMemory/img/bottone.png' onclick='conferma()' height='100' width='100'><br>
            <p style='text-align:center; font-size:15px;'>Conferma scelte</p>
            </div>
            
            </div>
        </form>
        </body>
        </html>
    ";



    if (isset($_GET['scelte'])) {
      $scelteRicevute = explode(",", $_GET['scelte']); 

      //print_r($scelteRicevute);

    }
   /* else {
        echo "Errore";
    }*/   
    

?>
