<?php
include "funciones.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <center> En breve será redirigido a la página principal para poder hacer login </center>

    <script>
        function redireccionarPagina() {
            window.location = "index.php";
        }
        setTimeout("redireccionarPagina()", 5000);
    </script>



</body>


</html>