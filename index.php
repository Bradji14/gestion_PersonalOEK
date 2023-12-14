<?php

session_start();
// session_destroy(); 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/mi.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>OEK | Login</title>

    <style>

#index{
    background-image: url("img/wall6.png");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-repeat: no-repeat;  
}

.change{
    text-decoration:none;
}
.change:hover{
text-decoration:underline;
}
    </style>  

</head>




<body id="index">

<!-- login -->

    <div class="box">

    
<?php

if (isset($_SESSION['entrada'])) : ?>
    <script>
        toastr.error('Registro duplicado');
    </script>
<?php
    session_unset();
endif;
?>

<?php

if (isset($_SESSION['emp'])) : ?>
    <script>
        toastr.error('Nomina no valida');
    </script>
<?php
    session_unset();
endif;
?>

<?php

if (isset($_SESSION['change'])) : ?>
    <script>
       Swal.fire({
                icon: 'success',
                title: 'Exito',
                text: 'Cambio con exito!',
                showCancelButton: false, // There won't be any cancel button
showConfirmButton: false // There won't be any confirm button
                })
    </script>
<?php
    session_unset();
endif;
?>

<?php

if (isset($_SESSION['error'])) : ?>
    <script>
        toastr.error('Datos erroneos');
    </script>
<?php
    session_unset();
endif;
?>

<?php

if (isset($_SESSION['changeErr'])) : ?>
    <script>
       Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No has cambiado tu contraseña!',
                footer: '<a href="vistas/asesores/change.php">Cambiar contraseña</a>',
                showCancelButton: false, // There won't be any cancel button
showConfirmButton: false // There won't be any confirm button
                })
    </script>
<?php
    session_unset();
endif;
?>




        <div class="reloj">
            <p class="fecha"></p>
            <p class="tiempo"></p>
        </div>

        <div class="wrapper">
            
            <div class="mt-5 bg-danger text-center p-2" style="font-size:25px;color:white;">
            <p>Presiona ctr+F5 antes de iniciar tu sesión</p>
            </div>

            <div class="title-text">
                <div class="title login">Registro de asistencias</div>
                
                <div class="title signup">Administrador</div>
            </div>
            <div class="form-container">
                <div class="slide-controls">
                    <input type="radio" name="slide" id="login" checked>
                    <input type="radio" name="slide" id="signup">
                    <label for="login" class="slide login">Asesor</label>
                    <label for="signup" class="slide signup">Admin</label>
                    <div class="slider-tab"></div>
                </div>
            <div class="form-inner">


                <form action="components/savedates.php" method="post" class="login">

                    <div class="input-field">
                        <input type="number" class="input" placeholder="ID" name="nomina" required>
                        <i class='bx bx-id-card'></i>

                        <input type="password" class="input" placeholder="Password" required name="pass" maxlength="18">
                        <i class='bx bxs-key'></i>

                    </div>

                    <div class="input-field">
                        <button name="entrada" class="submit">Entrada</button>
                        <!-- <button name="salida" class="submits" id="out" style="cursor:not-allowed" disabled>Salida</button> -->
                    </div>

                    <div class="input-field">
                        <a href="vistas/asesores/change.php" style="color:white;" class="change">Cambio de contraseña</a>
                    </div>

                </form>


                <form action="login/login.php" method="POST" class="signup">
                    <div class="input-field">
                        <input type="text" class="input" placeholder="User" name="user">
                        <i class='bx bx-user-circle'></i>
                    </div>
                    <div class="input-field">
                    
                        <input type="password" class="input" placeholder="Password" name="pass" maxlength="8">
                        <i class='bx bxs-key'></i>
                    </div>

                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Continuar" name="continue">
                    </div>
                </form>
            </div>
            </div>
        </div>

    </div>

    <script src="js/script.js"></script>

    <script>
        $(document).ready(function() 
        {

            
            const $tiempo = document.querySelector('.tiempo'),
    $fecha = document.querySelector('.fecha');

    function digitalClock(){
    let f = new Date(),
    dia = f.getDate(),
    mes = f.getMonth() + 1,
    anio = f.getFullYear(),
    diaSemana = f.getDay();

    dia = ('0' + dia).slice(-2);
    mes = ('0' + mes).slice(-2)

    let timeString = f.toLocaleTimeString();
    $tiempo.innerHTML = timeString;
    let semana = ['D','L','M','X','J','V','S'];
    // let semana = ['SUN','MON','TUE','WED','THU','FRI','SAT'];
    let showSemana = (semana[diaSemana]);
    $fecha.innerHTML = `${anio}-${mes}-${dia} ${showSemana}`
    }
        setInterval(() => {
            digitalClock()
        }, 1000);


            setTimeout(() => {
                $('#out').css('cursor', 'pointer')
                $('#out').prop('disabled', false)
            }, 2000)


            const loginText = document.querySelector(".title-text .login");
            const loginForm = document.querySelector("form.login");
            const loginBtn = document.querySelector("label.login");
            const signupBtn = document.querySelector("label.signup");
            const signupLink = document.querySelector("form .signup-link a");
            signupBtn.onclick = (() => {
                loginForm.style.marginLeft = "-50%";
                loginText.style.marginLeft = "-50%";
            });
            loginBtn.onclick = (() => {
                loginForm.style.marginLeft = "0%";
                loginText.style.marginLeft = "0%";
            });
            signupLink.onclick = (() => {
                signupBtn.click();
                return false;
            });

        })
    </script>

</body>

</html>