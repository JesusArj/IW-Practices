<?php

error_reporting(0);

session_start();

if(!isset($_SESSION['id'])){
    header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>UCOBANK | Menú principal</title>
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
        <a href="analysis.html">
            <div class="analisis">
                Ver análisis general
            </div>
        </a>
        <div class="cuentas">
            <h1>Cuentas</h1>

            <?php

            $servername = "sql211.epizy.com";
            $username = "epiz_31650333";
            $password = "ggzgUIXnNAvOaLM";
            $db = "epiz_31650333_ucobank";

            $conexion = mysqli_connect($servername, $username, $password, $db);

            $consulta = "SELECT id, tipo, numero, saldo FROM cuentas WHERE cliente = " . $_SESSION['id'];

            $resultado = mysqli_query($conexion,$consulta);

            while($rows=mysqli_fetch_assoc($resultado)){

            ?>
            
            <a href="cuenta.php?c=<?php echo $rows["id"]; ?>">
                <div class="cuenta">
                    <ul>
                        <li>
                            <p>
                                <?php

                                if($rows["tipo"]==1){
                                    echo "Cuenta Nómina";
                                }
                                else{
                                    echo "Cuenta Ahorro";
                                }
                                ?>
                            </p>
                            <p class="iban"><?php echo $rows["numero"]; ?></p>
                        </li>
                        <li>
                            <?php echo $rows["saldo"]/100 . " €"; ?>
                        </li>
                    </ul>
                </div>
            </a>

            <?php

            }

            ?>

        </div>
        <div class="tarjetas">
            <h1>Tarjetas</h1>

            <?php

            $consulta = "SELECT numero FROM tarjetas WHERE cliente = " . $_SESSION['id'];

            $resultado = mysqli_query($conexion,$consulta);

            while($rows=mysqli_fetch_assoc($resultado)){

            ?>

            <ul>
                <li>
                    <p class="tipo-tarjeta">Tarjeta de débito</p>
                    <p class="numero"><?php echo $rows["numero"]; ?></p>
                </li>
            </ul>

            <?php
            
            }

            ?>
        </div>
    </div>


    <div id="notificationModal" class="modal" >
        <img class="times" onclick="closeNotificationModal()" src="icons/close.svg"></img>
        <h1>Notificaciones</h1>
        <div class="notifications" id="mensajes">
            
            <?php

            $consulta = "SELECT id, descripcion FROM mensajes WHERE cliente = " . $_SESSION['id'];

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