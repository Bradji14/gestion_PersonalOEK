<?php

session_start();
// session_destroy(); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cambio de contraseña|OEK</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="script.js" defer></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body style="background: #2c3e50;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #3498db, #2c3e50);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #3498db, #2c3e50); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">
    <div class="wrapper">

    
    
<?php

    if (isset($_SESSION['error'])) : ?>
    <script>
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Datos erroneos',
        
        })    
    </script>
<?php
    session_unset();
endif;
?>

        <div class="">

        <h3 class="text-center">Cambio de contraseña</h3>
            <form action="changePas.php" method="post" class="formChange">

                <div class="mb-3">
                    <input type="number" name="id" class="form-control" placeholder="ID">
                </div>
                <div class="mb-3">
                    <input type="password" name="pass" class="form-control" placeholder="Contraseña actual">
                </div>
                <div class="mb-3 new">
                    <input type="password" name="newpass" class="form-control newp" placeholder="Nueva contraseña" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Incluye un numero,una letra en mayuscula,una letra en minuscula y 8 caracteres">
                    <i class="fa-solid fa-eye"></i>

                    <div style="font-size:12px" class="opct">   
                        <p>Minimo 8 caracteres</p>
                        <p>Una letra en mayuscula</p>
                        <p>Una letra en minuscula</p>
                        <p>Un caracter especial</p>
                    </div>
                    

                </div>
                <input type="submit" name="save" class="btn btn-success" value="Guardar">
            </form>

        </div>




      
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
    <script>
    const passwordInput = document.querySelector(".new input");
    const eyeIcon = document.querySelector(".new i");
   
 

    eyeIcon.addEventListener("click", () => {
        // Toggle the password input type between "password" and "text"
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";

        // Update the eye icon class based on the password input type
        eyeIcon.className = `fa-solid fa-eye${passwordInput.type === "password" ? "" : "-slash"}`;
    });
    </script>
</body>

</html>