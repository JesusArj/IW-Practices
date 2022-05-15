<?php

error_reporting(0);

session_start();

if(!isset($_SESSION['id']) || !isset($_GET['c'])){
    header('location: index.php');

}

$servername = "sql211.epizy.com";
$username = "epiz_31650333";
$password = "ggzgUIXnNAvOaLM";
$db = "epiz_31650333_ucobank";

$conexion = mysqli_connect($servername, $username, $password, $db);

$consulta = "SELECT cliente, numero, saldo, tipo FROM cuentas WHERE id = " . $_GET['c'];

$resultado = mysqli_query($conexion,$consulta);

if($resultado->num_rows != 1){

    header('Location: index.html');

}
else{

    while($rows=mysqli_fetch_assoc($resultado)){

        if($_SESSION['id'] != $rows['cliente']){

            header('Location: index.html');

        }
        else{

            $actual = $rows['saldo']/100;

            $datos[] = $actual;

            $dias[] = "Ahora";

            $consulta = 'SELECT cantidad, fecha, emisor FROM movimientos WHERE emisor = ' . $_GET['c'] . ' OR receptor = ' . $_GET['c'] . ' ORDER BY fecha desc';

            $resultado2 = mysqli_query($conexion,$consulta);

            $count = 1;

            while($rows2=mysqli_fetch_assoc($resultado2)){

                if($rows2['emisor']==$_GET['c']){

                    $datos[$count] = $datos[$count-1] + ($rows2['cantidad']/100);
                }
                else{
                    $datos[$count] = $datos[$count-1] - ($rows2['cantidad']/100);
                }

                $dias[] = $rows2['fecha'];

                $count = $count +1;
   
            }

            $datos = array_reverse($datos);
            $dias = array_reverse($dias);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/analisis.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Análisis de mi cuenta</title>
</head>
<body>
    <ul class="top-bar">
        <li><img src="img/logo.png" alt="Logo UCOBank"></li>
        <li class="buttons">
            <div class="notificationsIcon" onclick="openNotificationModal()">
                <img src="icons/bell.svg">
            </div>
            <div class="signout">
                <a href="controllers/logout.php"><img src="icons/signout.svg"></a>
            </div>
        </li>
    </ul>
    <div class="all">
        <h1>

            <?php

            if($rows["tipo"]==1){
                echo "Análisis de mi cuenta nómina";
            }
            else{
                echo "Análisis de mi cuenta ahorro";
            }
            ?>
        </h1>
        <p><?php echo $rows["numero"]; ?></p>
        <canvas id="myChart"></canvas>
    </div>
    <span class="back"><a href="cuenta.php?c=<?php echo $_GET['c']; ?>">Volver a mi cuenta</a></span>

    <div id="notificationModal" class="modal" >
        <img class="times" onclick="closeNotificationModal()" src="icons/close.svg"></img>
        <h1>Notificaciones</h1>
        <div class="notifications" id="mensajes">
            
            <?php

            $consulta = "SELECT id, descripcion FROM mensajes WHERE cliente = " .$_SESSION['id'];

            $resultado = mysqli_query($conexion,$consulta);

            while($rows=mysqli_fetch_assoc($resultado)){

            ?>

            <div class="notification" id="<?php echo $rows['id']; ?>">
                <p><?php echo $rows["descripcion"]; ?></p>
                <p class="deleteNoti" onclick="deleteMessage(<?php echo $rows['id']; ?>)">Eliminar mensaje</p>
            </div>
        
            <?php
            
            }

            ?>
            
        </div>
        <span class="delete" onclick="deleteAllMessages()">Vaciar la bandeja de entrada</span>
    </div>

    <script>
        var ctx = document.getElementById("myChart").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php
                          for($i=0; $i<sizeof($dias)-1; $i++){
                              echo "'" . $dias[$i] . "',";
                          }
                          echo "'" . $dias[$i] . "'";
                          ?>],
                datasets: [{
                    label: 'Saldo', // Name the series
                    data: [<?php
                          for($i=0; $i<sizeof($datos)-1; $i++){
                              echo $datos[$i] . ",";
                          }
                          echo $datos[$i];
                          ?>], // Specify the data values array
                    fill: false,
                    borderColor: '#2196f3', // Add custom color border (Line)
                    backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                    borderWidth: 2 // Specify bar border width
                }]},
            options: {
            responsive: true, // Instruct chart js to respond nicely.
            legend: {
                display: false,
            },
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
            }
        });

        function openNotificationModal() {
            document.getElementById("notificationModal").style.opacity = "1";
            document.getElementById("notificationModal").style.pointerEvents = "auto";
        }

        function closeNotificationModal() {
            document.getElementById("notificationModal").style.opacity = "0";
            document.getElementById("notificationModal").style.pointerEvents = "none";
        }

        function deleteAllMessages() {
            $.ajax({
                url: 'controllers/deleteAllMessages.php',
                type: 'POST',
                async: false,
                dataType: 'json',
                data: {
                    cliente: '<?php echo $_SESSION['id'];?>'
                }
            });

            document.getElementById("mensajes").innerHTML = '';
        }

        function deleteMessage(id) {

            $.ajax({
                url: 'controllers/deleteMessage.php',
                type: 'POST',
                async: false,
                dataType: 'json',
                data: {
                    mensaje: id
                }
            });

            $('#' + id).remove();
        }
    </script>
</body>
</html>
<?php

}
}
}

?>