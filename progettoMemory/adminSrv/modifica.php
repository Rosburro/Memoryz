<?php

	$xmlFile = '../memory.xml';
	$xml = simplexml_load_file($xmlFile);

  if(isset($_POST['conf'])){

    $indice = $_GET['i'];

    $pathImmagine = "";

    
    if(isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])){
      move_uploaded_file($_FILES['img']['tmp_name'],"../img/".$_FILES['img']['name']);
      $pathImmagine = $_FILES['img']['name'];
    }


    foreach ($xml->personaggio as $personaggio) {
      if ($personaggio->indice == $indice) {
          // Rimuovi i nodi esistenti prima di aggiungere i nuovi dati
          unset($personaggio->n_completo);
          unset($personaggio->sugg);
          unset($personaggio->guess);

          // Riempie con i nuovi dati
          $personaggio->addChild('n_completo', $_POST['ncompleto']);
          if ($pathImmagine != "") {
              $personaggio->img = $pathImmagine;
          }
          // Aggiungi i nuovi suggerimenti
          foreach ($_POST['sugger'] as $suggerimento) {
              if ($suggerimento != "") {
                  $personaggio->addChild('sugg', $suggerimento);
              }
          }
          // Aggiungi le nuove soluzioni
          foreach ($_POST['soluzioni'] as $soluz) {
              if ($soluz != "") {
                  $personaggio->addChild('guess', $soluz);
              }
          }
          break; // Esci dal ciclo dopo aver modificato il personaggio
      }
    }

    $xml->asXML($xmlFile);
    
    header("location:wait.php");
    exit;
  } 


	if(!isset($_GET['i'])){
		header("location:index.html");
	}
  else if(isset($_GET['i'])){
  	echo '
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Modifica</title>
      <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
      <script src="https://cdn.tailwindcss.com"></script>
      <script type="text/javascript" src="js.js"></script>
      <style>
        h1{
          zoom: 200%;
          text-transform: uppercase;
          text-align: center;
        }
      </style>
    </head>
    <body>
    <form name="invio" method="POST" enctype="multipart/form-data">
    <h1> Modifica il personaggio </h1>
    <br>
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
      <div align="center">';


      foreach ($xml as $personaggi => $personaggio) {
        if($personaggio->indice == $_GET['i']){
          echo'
            Nome completo <br>
           <input type="text" required name="ncompleto" value="'.$personaggio->n_completo.'" placeholder="Nome completo" class="input input-bordered input-primary w-full max-w-xs" /> <br><br> Suggerimenti <br><div id="daqui">';
         

          foreach($personaggio->sugg as $suggerimento){
            echo '<input type="text" name="sugger[]" value="'.$suggerimento.'" placeholder="Suggerimento" class="input input-bordered input-primary w-full max-w-xs" /><br> <br>';
          }
          
          echo '</div>
      <button type="button" class="btn btn-outline" onclick="sugg2()">Nuovo suggerimento</button><br><br><br>

      Immagine <br>

      <input type="file" name="img" class="file-input file-input-bordered file-input-primary w-full max-w-xs" /> <p> (Aggiungere solamente se si vuole sostituire un immagine!) </p><br><div id="daqua"><br>Soluzioni <br>';

          

          foreach($personaggio->guess as $soluzioni){
            echo '<input type="text" name="soluzioni[]" value="'.$soluzioni.'" placeholder="Soluzione" class="input input-bordered input-primary w-full max-w-xs" /><br> <br>';
          }

      } 
    }
      

      

    echo'
      </div>
      <button type="button" class="btn btn-outline" onclick="soluz2()">Nuova soluzione</button>

      <br><br><br>
      <div style="text-align: center;">
        <button name="conf" style="zoom: 200%; margin-right: 100px; margin-bottom: 75px;" class="btn btn-success">Conferma</button>
        <button type="button" onclick="window.location.href=\'index.html\' "style="zoom: 200%;" class="btn btn-error">Annulla</button>
      </div>
    </div> 
    <div class="btm-nav">
      <button type="button" class="text-primary active" onclick="window.location.href=\'index.html\'" >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
      </button> 
    </div>
	  </form>
      </body>
      </html>
    ';
    }

    

      
     
?>