<?php
    require "../../sql/config.php";
    session_start();
    $punteggi = $connessione->query("select username, punteggio from partecipanti where nome_stanza='$_SESSION[nomeStanza]'");
    
    echo "<tr><td>partecipanti della stanza: </td></tr>";
    foreach($punteggi as $punti){
        echo "<tr>
                <td>user: $punti[username]</td><td>punteggio: $punti[punteggio]</td></tr>";
    }


?>