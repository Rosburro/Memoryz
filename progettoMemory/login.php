<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Accesso</title>
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
	<form name="login" method="post" class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">

		<h1 class="text-2xl font-bold mb-6 text-center">ACCESSO</h1>

		<label class="input input-bordered flex items-center gap-2 mb-4">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
				<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
			</svg>
			<input name="nome" type="text" class="grow" placeholder="Nome utente" />
		</label>

		<label class="input input-bordered flex items-center gap-2 mb-6">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
				<path fill-rule="evenodd" d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z" clip-rule="evenodd" />
			</svg>
			<input type="password" name="pass" class="grow" placeholder="Password" />
		</label>

		<button type="submit" name="ok" class="btn btn-wide w-full">Accedi</button>

	</form>
</body>
</html>


<?php

$username = "v.vianelli"; //nome
$password = "ProvaProva"; //password (da cambiare obv)

if(isset($_POST['ok'])){
	if(isset($_POST["nome"]) && isset($_POST["pass"])){
		if($_POST['nome']!="" && $_POST['pass']!=""){
			$nomeUtente = strtolower($_POST['nome']);
			$passUtente = $_POST['pass'];

			if($nomeUtente==$username && $passUtente==$password){
				session_start();
				$_SESSION['login'] = "loggato";
				header("location:adminSrv/wait.php");	
			}

		}
	}
}


?>