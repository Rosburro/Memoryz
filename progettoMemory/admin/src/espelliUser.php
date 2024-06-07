<?php
    session_start();

    require "../../sql/config.php";

    // $connessione -> query("delete from partecipanti where username='$_POST[username]' and nome_stanza='$_SESSION[nomeStanza]'") or die('error');//todo

    $query=$connessione->prepare("delete from partecipanti where username=:username and nome_stanza=:nomestanza");
    $query->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
    $query->bindParam(':nomestanza', $_SESSION['nomeStanza'], PDO::PARAM_STR);
    $query->execute();

    echo "delete from partecipanti where username='$_POST[username]' and nome_stanza='$_SESSION[nomeStanza]'";

?>