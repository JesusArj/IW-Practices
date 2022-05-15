<?php

error_reporting(0);

session_start();

if(!isset($_SESSION['id']) || !isset($_GET['c'])){
    //header('location: index.php');

}

$servername = "sql211.epizy.com";
$username = "epiz_31650333";
$password = "ggzgUIXnNAvOaLM";
$db = "epiz_31650333_ucobank";

$conexion = mysqli_connect($servername, $username, $password, $db);

$consulta = "SELECT cliente, numero, saldo, tipo FROM cuentas WHERE id = " . $_GET['c'];

$resultado = mysqli_query($conexion,$consulta);

if($resultado->num_rows != 1){

    //header('Location: index.html');

}
else{

    while($rows=mysqli_fetch_assoc($resultado)){

        if($_SESSION['id'] != $rows['cliente']){

            //header('Location: index.html');

        }
        else{

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cuenta.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Cuenta</title>
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
        <div class="info">
            <h1>
                <?php

                if($rows["tipo"]==1){
                    echo "Cuenta Nómina";
                }
                else{
                    echo "Cuenta Ahorro";
                }
                ?>
            </h1>
            <ul>
                <li><p><?php echo $rows['numero']; ?></p></li>
                <li class="saldo"><?php echo $rows['saldo']/100; ?> €</li>
            </ul>
        </div>
        <a href="analisis.php?c=<?php echo $_GET['c']; ?>">
            <div class="analisis">
                <ul>
                    <li>Ver análisis de la cuenta</li>
                    <li><img src="icons/chart-column-solid.svg"></li>
                </ul>
            </div>
        </a>
        <div class="operations">
            <h1>Operaciones</h1>
            <div onclick="openBizumModal()">
                <ul>
                    <li>Bizum</li>
                    <li><img src="icons/bizum.png" style="filter: brightness(0) invert(1);"></li>
                </ul>           
            </div>
            <div onclick="openTransferModal()">
                <ul>
                    <li>Transferencia</li>
                    <li><img src="icons/arrow-right-arrow-left-solid.svg"></li>
                </ul>
            </div>
        </div>

        <?php

        $consulta = "SELECT numero, caducidad, cvv FROM tarjetas WHERE cliente = " . $_SESSION['id'] . " AND cuenta = " . $_GET['c'];

        $resultado3 = mysqli_query($conexion,$consulta);

        while($rows2=mysqli_fetch_assoc($resultado3)){

        ?>
        <div class="tarjeta">
            <ul>
                <li>
                    <p class="target">Tarjeta de débito</p>
                    <p><span class="gray">Número:</span> <?php echo $rows2['numero']; ?></p>
                </li>
                <li><span class="gray">Caducidad:</span> <?php echo $rows2['caducidad']; ?></li>
                <li><span class="gray">CVV:</span> <?php echo $rows2['cvv']; ?></li>
            </ul>
        </div>

        <?php
        }
        ?>

        <div class="movimientos-Div">
            <h1>Movimientos</h1>
            <ul class="movimientos">
                <?php

                $consulta = "SELECT cantidad, fecha, concepto, tipo, receptor FROM movimientos WHERE receptor = " . $_SESSION['id'] . " OR emisor = " . $_SESSION['id'];

                $resultado2 = mysqli_query($conexion,$consulta);

                while($rows1=mysqli_fetch_assoc($resultado2)){

                ?>
                <li class="movimiento">
                    <ul>
                        <li>
                            <p class="tipo">
                            <?php
                            if($rows1['tipo']==0){
                                echo "Transferencia";
                            }
                            else if($rows1['tipo']==1){
                                echo "Bizum";
                            }
                            else if($rows1['tipo']==2){
                                echo "Ingreso";
                            }
                            else{
                                echo "Retirada";
                            }
                            ?>
                            </p>
                            <p class="fecha"><?php echo $rows1['fecha']; ?></p>
                            <?php
                            if($rows1['tipo']!=2 && $rows1['tipo']!=3 && $rows['receptor']!=$_SESSION['id']){
                                echo '<p class="emisor">De: </p>';
                            }
                            ?>
                            <p class="concepto"><?php echo $rows1['concepto']; ?></p>
                        </li>
                        <?php
                        if($rows1['receptor'] == $_SESSION['id']){
                            echo '<li class="cantidad">' . $rows1['cantidad']/100 . ' €</li>';
                        }
                        else{
                            echo '<li class="cantidad" style="color: red">-' . $rows1['cantidad']/100 . ' €</li>';
                        }
                        ?>
                    </ul>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>

        <div class="efectivo">
            <div>
                <form action="controllers/ingresar.php" method="post">
                    <input type="number" name="cantidad" id="" placeholder="Importe">
                    <input type="hidden" name="cuenta" value="<?php echo $_GET['c'] ?>">
                    <input type="submit" value="INGRESAR" class="ingresar">
                </form>
            </div>
            <div>
                <form action="controllers/retirar.php" method="post">
                    <input type="number" name="cantidad" id="" placeholder="Importe">
                    <input type="hidden" name="cuenta" value="<?php echo $_GET['c'] ?>">
                    <input type="submit" value="RETIRAR" class="retirar">
                </form>
            </div>
        </div>
    </div>

    <div id="bizumModal" class="modal2" >
        <span class="close" onclick="closeBizumModal()"></span>
        <div class="modal2-content">
            <img class="times" onclick="closeBizumModal()" src="icons/close.svg"></img>
            <h1>Realizar Bizum</h1>
            <form action="controllers/bizum.php" method="post">
                <input type="hidden" name="cuenta" value="<?php echo $_GET['c'] ?>">
                <input type="number" name="cantidad" id="" placeholder="Importe">
                <input type="number" name="number" id="" placeholder="Número de teléfono destinatario">
                <textarea name="concepto" id="" cols="30" rows="10" placeholder="Concepto"></textarea>
                <input type="submit" value="Aceptar">
            </form>    
        </div>
    </div>

    <div id="tranferModal" class="modal2" >
        <span class="close" onclick="closeTransferModal()"></span>
        <div class="modal2-content">
            <img class="times" onclick="closeTransferModal()" src="icons/close.svg"></img>
            <h1>Realizar transferencia</h1>
            <form action="controllers/transferencia.php" method="post">
                <input type="hidden" name="cuenta" value="<?php echo $_GET['c'] ?>">
                <input type="number" name="cantidad" id="" placeholder="Importe">
                <input type="text" name="iban" id="" placeholder="IBAN del destinatario">
                <textarea name="concepto" id="" cols="30" rows="10" placeholder="Concepto"></textarea>
                <input type="submit" value="Aceptar">
            </form>    
        </div>
    </div>


    <div id="notificationModal" class="modal" >
        <img class="times" onclick="closeNotificationModal()" src="icons/close.svg"></img>
        <h1>Notificaciones</h1>
        <div class="notifications" id="mensajes">
            
            <?php

            $consulta = "SELECT id, descripcion FROM mensajes WHERE cliente = 1";//$_SESSION['id'];

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

        function openBizumModal() {
            document.getElementById("bizumModal").style.opacity = "1";
            document.getElementById("bizumModal").style.pointerEvents = "auto";
        }

        function closeBizumModal() {
            document.getElementById("bizumModal").style.opacity = "0";
            document.getElementById("bizumModal").style.pointerEvents = "none";
        }

        function openTransferModal() {
            document.getElementById("tranferModal").style.opacity = "1";
            document.getElementById("tranferModal").style.pointerEvents = "auto";
        }

        function closeTransferModal() {
            document.getElementById("tranferModal").style.opacity = "0";
            document.getElementById("tranferModal").style.pointerEvents = "none";
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
