<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Personalizzazione</title>
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		h1{
			zoom: 200%;
		    text-transform: uppercase;
		}
	</style>
</head>
<body>
<h1 align="center"> Selezionare uno scenario </h1>
<form class="flex items-center justify-center h-screen">
<div style="zoom:200%; margin-bottom: 75px;">
	<a href="admin/src/admin.php"> <button type="button" class="btn btn-outline btn-primary m-2" >Gestisci una stanza</button></a>
	<a href="studente/src/studente.php"> <button type="button" class="btn btn-outline btn-secondary m-2">Accedi ad una stanza</button> </a>
	<a href="singlePlayer/index.html"> <button type="button" class="btn btn-outline btn-accent m-2">Gioca al memory</button></a>
</div>
</form>
</body>
</html>