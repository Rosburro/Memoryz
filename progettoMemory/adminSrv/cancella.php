<?php

session_start();
  if(isset($_SESSION['login'])){


  	$xmlFile = '../memory.xml';
  	$xml = simplexml_load_file($xmlFile);

  	if(!isset($_GET['i'])){
  		header("location:index.php");
  	}
      else if(isset($_GET['i'])){
      	echo '
        <!DOCTYPE html>
        <html>
        <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>Elimina</title>
          <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
          <script src="https://cdn.tailwindcss.com"></script>
          <style>
          h1{
            zoom: 200%;
            text-transform: uppercase;
            text-align: center;
          }
        </style>
        </head>
        <body>
        <form name="invio" method="POST">
        <h1> Sicuro di eliminare il personaggio ? </h1><br>
          <div class="overflow-x-auto">
          <table class="table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Suggerimenti</th>
                <th>Soluzioni</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
              
            
      foreach ($xml as $personaggi => $personaggio) {
      	if($personaggio->indice == $_GET['i']){
      		echo '
            <tr>
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar">
                    <div class="mask mask-squircle w-12 h-12">
                      <img src="../img/'.$personaggio->img.'" alt="no image" />
                    </div>
                  </div>
                  <div>
                    <div class="font-bold">'.$personaggio->n_completo.'</div>
                  </div>
                </div>
              </td>
              <td>';
                $suggArray = json_decode(json_encode($personaggio->sugg), true);
                echo implode(", ", $suggArray);
              echo '</td>
              <td>';

                $guessArray = json_decode(json_encode($personaggio->guess), true);
                echo implode(", ", $guessArray);

              echo '</td>
            </tr>

        ';
      	}
         
      }

      echo '
  	        </tbody> 
  	        </table>
  	     </div>
  	     <br><br><br>
  	     <div style="text-align: center;">
  		    <button name="btn" style="zoom: 200%; margin-right: 100px;" class="btn btn-success">Conferma</button>
  		    <button type="button" onclick="window.location.href=\'index.php\' "style="zoom: 200%;" class="btn btn-error">Annulla</button>
  		</div>
      <div class="btm-nav">
        <button type="button" class="text-accent active" onclick="window.location.href=\'index.php\'" >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
        </button>
      </div>
  	  </form>
        </body>
        </html>
      ';
      }

      if(isset($_POST['btn'])){

  		$indice = $_GET['i'];
  		    foreach ($xml->personaggio as $personaggio) {
  		        if ($personaggio->indice == $indice) {
  		            unset($personaggio[0]);
  		            break;
  		        }
  		    }

  		    foreach ($xml->personaggio as $personaggio) {
  		        if ($personaggio->indice > $indice) {
  		            $personaggio->indice = intval($personaggio->indice) - 1;
  		        }
  		    }

  		
  		$xml->asXML($xmlFile);
  		header("location:wait.php");
      }
    }  
    else{
      echo "Accesso negato, accedere prima come amministratore: <a href='../login.php'> pagina login</a>";
    }

?>