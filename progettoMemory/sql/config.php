<?php

	$connessione = new mysqli('localhost', 'root', '');
	if(mysqli_connect_errno()){
		echo 'errore con il db';
		exit();
	}

//creazione delle tabelle
	
	$connessione -> query("create database if not exists memoriz;") or die('creazione del db fallita');
	$connessione -> query("use memoriz") or die("errore nell'utilizzo del db");
	$connessione-> query("create table if not exists stanze
							(
								nome_stanza varchar(20) primary key,
								TTLImg int,
								round int,
								ingAperto  TINYINT(1) default 0,
								inCorso  TINYINT(1) default 0
							)") or die("errore nella creazione della tabella stanze");
	
	//far si che ci sia una variabile che controlla se lo studente ha inviato o meno la risposta
	$connessione-> query("create table if not exists partecipanti
							(
								username varchar(20),
								nome_stanza varchar(20) references stanze(nome_stanza) on delete cascade on update cascade,
								punteggio int default 0,
								inviato tinyint(1),
								primary key(username, nome_stanza) 
							)") or die("errore nella creazione della tabella partecipanti");

	$connessione-> query("create table if not exists img_stanza
							(
								id int primary key auto_increment,
								nome_stanza varchar(20) references stanze(nome_stanza) on delete cascade on update cascade,
								imgIndex int default '-1',
								usata tinyint(1) default 0
							)") or die("errore nella creazione della tabella img_stanza");
    //la relazione tra round e stanza e` 1-1
    $connessione->query("create table if not exists round(
							nome_stanza varchar(20) primary key references stanze(nome_stanza) on delete cascade on update cascade,
							n_round int,
							inizio_round time,
							inCorso tinyint(1),
							img_round int
						)")

?>