<?php
    $memory = "../../memory.xml";
    $personaggi = simplexml_load_file($memory);

    echo "
	    <html>
	    <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'>
	        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
	        <script type='text/javascript' src='../static/js_selezioni.js'></script>
	        <link rel='stylesheet' type='text/css' href='../static/css_selezioni.css'>
            <style>
                @import url('https://fonts.cdnfonts.com/css/rouge-script');
                @import url('https://fonts.cdnfonts.com/css/droid-serif-2');
            </style>

	    </head>
	    <body>

	    <form name='selezione'>
	        <br><br><br><br><br><h1> Quali autori vuole scegliere? </h1><br><br>
	        <div align='center'>
	            <table  cellpadding='10'>
    ";

    $count = 0;
    foreach ($personaggi as $personaggio) {
        if ($count == 0) { 
            echo "<tr>"; 
        } 
        if ($count >= 6) {                
            $count = 0;
            echo "</tr>";
        }
        echo "
            <td style='text-align:center; vertical-align:top;'  height='400' width='275'><br>
                <img src='../../img/{$personaggio->img}' width='250' height='400' class='zoom' onclick='cambiaSfondo(this); salvaIndice($personaggio->indice);'> 
                <br> <p class='autore'>$personaggio->n_completo </p>
            </td>";
        $count++;
    }
    echo "
            </table>
            
            <div class='bottone_scelte'>
            <img class='zoomBottone' src='../../img/bottone1.png' onclick='conferma()' height='100' width='100'><br>
            </div>

            <div class='bottone_tutte'>
            <img class='zoomBottone' src='../../img/bottone2.png' onclick='tutte()' height='100' width='100'><br>
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
    else {
        //echo "Errore";
    }   
    

?>
