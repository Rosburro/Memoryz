<?php

session_start();

if(isset($_SESSION['login'])){
	echo '
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Personalizzazione</title>
			<link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
			<script src="https://cdn.tailwindcss.com"></script>
			<style>
				.fixed-text {
					position: fixed;
					top: 10px;
					right: 10px;
					font-size: 0.75rem; 
					color: #3b82f6;
					border: 2px solid #3b82f6; 
					padding: 0.5rem 1rem;
					border-radius: 9999px; 
					text-align: center; 
					box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
				}
			</style>
		</head>
		<body class="flex items-center justify-center h-screen">
		<div class="fixed-text"><a href="logout.php">Logout</a></div>

		<div style="zoom:200%">
			<button class="btn btn-outline btn-primary m-2" onclick="window.location.href=\'ricerca.php?m\'">Modifica</button>
			<button class="btn btn-outline btn-secondary m-2" onclick="window.location.href=\'agg.php\'">Aggiunta</button>
			<button class="btn btn-outline btn-accent m-2" onclick="window.location.href=\'ricerca.php?c\'">Eliminazione</button>
		</div>
		</body>
		</html>
	';
}

else{
	echo "Accesso negato, accedere prima come amministratore: <a href='../login.php'> pagina login</a>";
}







?>