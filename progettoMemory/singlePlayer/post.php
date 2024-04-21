<?php

session_start();

echo "
      <html>
      <head>
          <title> Memory post </title>
          <meta charset='utf-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
          <link rel='stylesheet' type='text/css' href='styles.css'>
          <script type='text/javascript' src='js.js'></script>
          <style>
              .container {
              display: flex;
              justify-content: space-between;
              align-items: center;
              margin-top: 50px;
              width: 100%;
              }

              .button {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 0;
                width: 6em;
                height: 6em;
                text-align: center;
                text-decoration: none;
                aspect-ratio: 1/1; 
                display: inline-flex;
                justify-content: center;
                align-items: center;
                font-size: 3em;
                margin: 0;
                cursor: pointer;
                border-radius: 50%;
                transition: background-color 0.3s ease;
              }

              .button:hover {
                background-color: #0056b3;
              }

              body{
                zoom:60%;
              }
          </style>
      </head>
      <body>
          <form>";
          
     
if(!isset($_GET['t'])){
    echo "<h1>Sei entrato in un modo illecito</h1>";
}

else{
  echo "<h1 style='text-align:center; font-size:5em;'>Complimenti! Hai vinto!<br><br> </h1>
        <p style='text-align:center; font-size:3em;'>Hai fatto $_GET[t] tenativi, ora scegli cosa fare</p>";


  echo"
      <div class='container'>
      <button type='button' class='button' onclick=window.location.href='index.html'>Home</button>";


if(!isset($_SESSION['ultimaPartita'])){
  echo"<button type='button' class='button' onclick=window.location.href='user.php'>Rigioca</button>";
} 
else{
  echo"<button type='button' class='button' onclick=window.location.href='user.php?quant=$_SESSION[ultimaPartita]'>Rigioca</button>";
  session_destroy();
}
    
}

  echo"
    </div>
    </form>
    </body>
    </html>";


?>
