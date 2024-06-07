<?php
    require "../../sql/config.php";
    session_start();
    //far si che prenda anche cio` che ha inviato il partecipante
    $punteggi = $connessione->query("select username, punteggio,risposta  from partecipanti where nome_stanza='$_SESSION[nomeStanza]' order by punteggio desc");
    // if(isset($_GET["Classifica"])){
    //     // echo "<tr><td>Classifica finale: </td></tr>";
    // }else {
    //     // echo "<tr><td>Partecipanti della stanza: </td></tr>";
    // }
    $cont=0;
    foreach($punteggi as $punti){
        $cont++;
        echo "<tr>
                <td>$cont</td><td>$punti[username]</td><td>$punti[punteggio]</td><td>$punti[risposta]</td><td><button class='btn btn-outline btn-error btn-xs' onclick='espelliPersona(\"$punti[username]\")'>-</button></td></tr>";
    }


?>