<?php
    require "../../sql/config.php";
    session_start();
    $punteggi = $connessione->query("select username, punteggio from partecipanti where nome_stanza='$_SESSION[nomeStanza]' order by punteggio desc");
    if(isset($_GET["Classifica"])){
        echo "<tr><td>Classifica finale: </td></tr>";
    }else {
        echo "<tr><td>Partecipanti della stanza: </td></tr>";
    }
    
    foreach($punteggi as $punti){
        echo "<tr>
                <td>User: $punti[username]</td><td>Punteggio: $punti[punteggio]</td></tr>";
    }


?>