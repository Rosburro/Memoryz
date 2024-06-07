<?php
  session_start();
	if(isset($_SESSION['login'])){
    $xmlFile = '../memory.xml';
    $xml = simplexml_load_file($xmlFile);

    $onClick = "opzioni.html?";

    if(isset($_GET['c'])){
      $onClick = "cancella.php?i=";
    }

    else if(isset($_GET['m'])){
      $onClick = "modifica.php?i=";
    }

    else{
      header("location:index.php");
    }

    echo '
      <!DOCTYPE html>
      <html>
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ricerca</title>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>
      </head>
      <body>
        <div class="overflow-x-auto">
        <table class="table">
          <thead>
            <tr>
              <th>Selezionato</th>
              <th>Nome</th>
              <th>Suggerimenti</th>
              <th>Soluzioni</th>
              <th></th>
            </tr>
          </thead>
          <tbody>';
            
          
    foreach ($xml as $personaggi => $personaggio) {
       echo '
          <tr>
            <th>
                <button onclick="window.location.href=\''. $onClick .$personaggio->indice . '\' " class="btn btn-circle btn-outline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
          </button>
            </th>
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

    echo '
          </tbody>

          
        </table>
      </div>
      <br><br><br><br>
      <div class="btm-nav">
      <button type="button" class="active" onclick="window.location.href=\'index.php\'" >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
      </button>
    </div>

      </body>
      </html>
    ';
  }
      

  else{
    echo "Accesso negato, accedere prima come amministratore: <a href='../login.php'> pagina login</a>";
}

?>