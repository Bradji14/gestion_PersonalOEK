<?php
// session_start();

// $usuario=$_SESSION['user'];

// if(!isset($usuario)){
//     header("Location: http://localhost/asistencias_empleados");
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
        <link rel="icon" href="https://oek.com.mx/wp-content/uploads/2022/01/cropped-OEK-favicon-32x32.png">

    <link href="../style/mi.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

</head>

<nav class="navbar navbar-expand-lg hsbc">
    <div class="container-fluid">
       
            <img src="../img/logo2.gif" class="logow">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <!-- <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a> -->
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Asistencias
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="consultaHSBC.php">Asistencia de un dia en
                                especifico</a></li>
                        <li><a class="dropdown-item" href="consulta_rangoHSBC.php">Asistencia de un rango de fechas</a>
                        </li>
                        <!-- <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Alta de Permisos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="permutashsbc.php">Permutas<a></li>
                        <li><a class="dropdown-item" href="permisoshsbc.php">Permiso laboral</a></li>
                        <!-- <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Ver Permisos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="permutasreg.php">Permutas registradas<a></li>
                        <li><a class="dropdown-item" href="permisosreg.php">Permisos registrados</a></li>
                        
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Pemisos Autorizados
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="permutasregAuto.php">Permutas <a></li>
                        <li><a class="dropdown-item" href="permisosregAutoHs.php">Permisos    </a></li>
                    </ul>
                </li>
                <div class="position-absolute top-0 end-0"> 
             
                    <div class="text-end p-4">  
                    <p class="nameNav"> <i class="fa fa-user m-3" style="font-size: 20px;"></i>AGUSTIN LAREDO CARMONA </p>          

                    <a href="../login/cerrar_sesion.php"> <i class="fa-solid fa-right-from-bracket"></i> Cerra sesión</a>
                    </div>

                </div>

            </ul>
        </div>
    </div>
</nav>




<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="">
                    <div class=" mt-4">
                        <p class="text-center titulo_p">Asistencias y salidas entre un rango de fechas</p>
                    </div>
                </div>
                <br>
                <br>
                <div class="">
                    <div class="">
                        <form action="../php/exportar_rango.php" method="POST" class="text-center" id="filesForm">

                            <div class="row">

                                <div class="col-md-6 text-center">
                                    <h5>Fecha inicio que desea vizualizar</h5>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio">
                                </div>

                                <div class="col-md-6 text-center">
                                    <h5>Fecha ultima que desea vizualizar</h5>
                                    <input type="date" name="fecha_final" id="fecha_final">
                                </div>
                            </div>
                            <select name="seleccion" id="seleccion">
                                
                                <option value="HSBC">HSBC</option>
                              
                            </select>
                        </form>
                        <br>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-outline-primary" onclick="mifuncion()">Buscar</button>
                        </div>
                        <!-- <div class="text-end">
                            <button type="submit" class="btn btn-success  mb-6">Exporta a Excel <svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 20">
                                    <path
                                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                                </svg></button>
                        </div> -->
                    </div>
                </div>
                <br />
                <hr />
                <div class="row">
                    <h6 class="text-center">SIMBOLOGIA</h6>
                    <div class="col-md-12 mt-5  d-flex justify-content-between">

                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#0d5982"
                                    class="bi bi-circle-fill" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8" />
                                </svg> ENTRADAS CORRECTAS
                            </p>
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#36941b"
                                    class="bi bi-circle-fill" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8" />
                                </svg> SALIDAS CORRECTAS
                            </p>
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#cd6d00"
                                    class="bi bi-circle-fill" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8" />
                                </svg> RETARDO
                            </p>
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#e0f113"
                                    class="bi bi-circle-fill" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8" />
                                </svg>  FALTAS POR RETARDO
                            </p>
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#f30e0e"
                                    class="bi bi-circle-fill" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8" />
                                </svg>  SALIDAS ANTICIPADAS
                            </p>
                        <!-- <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                color="#0D5982" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> ASISTENCIAS CORRECTAS
                        </p>
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                color="#E41A29" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> SALIDAS CORRECTAS
                        </p>
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                color="#4F8927" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> RETARDOS
                        </p>
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                color="#E0F113" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> FALTAS POR RETARDO
                        </p> -->
                        <!-- <p class=" fw-bold">Sin color -Verificar turno</p> -->
                    </div>

                </div>
                <br>
                <hr />
                <div class="row">
                    <div class="container shadow-lg mb-5 bg-white rounded">
                        <div class="card border-white">
                            <div class="row card-header text-center">
                                <div class="col-lg-4">

                                </div>

                                <!-- <div class="col-lg-4">
                                    <div class="text-center">
                                        <h6>Tabla de Asistencia</h6>
                                    </div> -->
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-right">
                                        <div id="total_asistencia">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-dark">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="datos">
                                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</body>
<script src="../js/buscar_rango.js"></script>

</html>