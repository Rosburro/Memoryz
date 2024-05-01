<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vittoria</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #afeeee;
        }

        .btn {
            border-radius: 9999px;
            padding: 10px 20px; 
            font-size: 2rem;
        }

        .title {
            font-size: 2rem; 
            font-weight: bold; 
            color: #333; 
            margin-bottom: 20px; 
        }

        .paragraph {
            font-size: 1.5rem; 
            color: #555; 
            margin-bottom: 40px; 
        }

        @media screen and (min-width: 1366px) {
            .btn {
                margin: 0 15rem; 
            }
        }
    </style>
</head>
<body>
    <div class="container mx-auto p-4">
        <?php
        if (!isset($_GET['t'])) {
            echo "<h1 class='title text-center'>Sei entrato in modo illecito</h1>";
        } else {
            echo "
                <h1 class='title text-center'>Complimenti! <br>Hai vinto!</h1>
                <p class='paragraph text-center'>Hai fatto $_GET[t] tentativi, ora scegli cosa fare</p><br>
                <div class='flex justify-between'>
                <button class='btn bg-blue-500 text-white' onclick=\"window.location.href='index.html'\">Home</button>";

            session_start();   
            if (!isset($_SESSION['ultimaPartita'])) {
                echo "<button class='btn bg-green-500 text-white' onclick=\"window.location.href='user.php'\">Rigioca</button>";
            } else {
                echo "<button class='btn bg-green-500 text-white' onclick=\"window.location.href='user.php?quant=$_SESSION[ultimaPartita]'\">Rigioca</button>";
                session_destroy();
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
