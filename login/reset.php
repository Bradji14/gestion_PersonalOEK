<?php
session_start();


include_once "../bd/conexion.php";

// $stmt2="UPDATE users set password='$pas' WHERE id='$id'";
// $query2 = $conn->prepare($stmt2);
// $query2->execute();
// header("Location: http://localhost/asistencias_empleados");


if(isset($_POST['continue'])){

    

    $user=$_POST['user'];
    $pass=$_POST['pass'];

    if(!empty($user) && !empty($pass)){

    $stmt2="UPDATE users set password ='$pass' WHERE usuario='$user'";
    $query2 = $conn->prepare($stmt2);
    $query2->execute();
    $numeroDeFilas = $query2->rowCount();


        if($numeroDeFilas<=0){
            $_SESSION['fail']="nomina no encontrada";
            header("Location: http://192.168.100.200:50/asistencias_empleados/login/reset.php");

        }
        else{
            $_SESSION['succes']="Contraseña cambiada";
            header("Location: http://192.168.100.200:50/asistencias_empleados");
        }
            
           
        }
        else{
            $_SESSION['vacio']="Llene los campos";
            header("Location: http://192.168.100.200:50/asistencias_empleados");

        }
    }
   
    
   



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login | OEK</title>
    <link rel="icon" href="https://oek.com.mx/wp-content/uploads/2022/01/cropped-OEK-favicon-32x32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../style/mi.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body style="background-image: url('../img/wall2.jpg');">


<?php
        if(isset($_SESSION['vacio'])):?>
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?=$_SESSION['vacio']?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
    <?php
        session_unset();
        endif;
        
        ?>

<?php
        if(isset($_SESSION['fail'])):?>
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?=$_SESSION['fail']?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
    <?php
        session_unset();
        endif;
        
        ?>
<div class="login-box">

                  
                  <!-- <img src="img/MUNDO.png" class="avatar" alt="Avatar Image"> -->
                  <h1>Cambio de contraseña</h1>
                  <form action="reset.php" method="POST">
                      <!-- USERNAME INPUT -->
                      <label for="username">Ingrese su nomina</label>
                      <input type="text" placeholder="Enter nomina" name="user">
                      <!-- PASSWORD INPUT -->
                      <label for="password">Nueva contraseña</label>
                      <input type="password" placeholder="Enter Password" name="pass" maxlength="8">
                      <input type="submit" value="Continuar" name="continue">
                      <a href="../index.php">Regresar</a><br>
          
                  </form>
              </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>