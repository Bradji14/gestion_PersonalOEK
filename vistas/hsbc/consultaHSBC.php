<?php

include ('nav.php');
// session_start();


if(!isset($_SESSION['user'])){

    header('location:http://192.168.100.200:50/asistencias_empleados/');
}
else{
    ?>
<body>

<div class="container">

<?php
            if(isset($_SESSION['check'])):?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?=$_SESSION['check']?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            session_unset();
            endif?>

<?php
    if (isset($_SESSION['lista'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?= $_SESSION['lista'] ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        session_unset();
    endif ?>

    <div class="row">
        <div>
            <form action="../php/exportar_especifico.php" method="POST" class="text-center">
             

                <br>
                <br>
                

            </form>



            <form action="hsbclista.php" method="POST" class="text-center text-light">

                 <div class="d-flex justify-content-center">

                 <div class="col-md-4">
                 <p class="fw-normal titulo_p mt-4">Fecha exacta que desea visualizar</p>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">

                    <br>
                    <br>
                    <select name="seleccion" id="seleccion" class="form-select" >
                        <option value="HSBC">HSBC</option>
                       
                    </select>
                    <br />
                    <br />
                    <input type="submit" class="btn btn-danger" value="Continuar">  
                    <!-- <a type="button" class="btn btn-outline-primary" href="hola.php" >Buscar</a> -->
                 </div>
                    

                </div>

            </form>


        </div>
    </div>
    <br />
    <hr />
    <!-- <div class="row">
        <h6 class="text-center">SIMBOLOGIA</h6>
     
        <div class="col-md-12 mt-5 d-flex justify-content-between">
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
        </div>
    

    </div> -->
    <br>
    <hr />
    

    
</div>




</body>
<script src="../js/buscar.js"></script>

</html>
<?php
}
