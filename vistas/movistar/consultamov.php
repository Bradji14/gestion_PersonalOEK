<?php

include ('nav.php');

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

                    <!-- <div class="text-end">
                        <button type="submit" class="btn btn-success  mb-6">Exporta a Excel <svg
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 20">
                                <path
                                    d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                            </svg></button>
                    </div> -->

                </form>

                <form action="movlista.php" method="POST" class="text-center">

                    <div class="d-flex justify-content-center">

                        <div class="col-md-4">
                            <p class="fw-normal titulo_p mt-4 text-light">Fecha exacta que desea visualizar</p>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">

                            <br>
                            <br>
                            <select name="seleccion" id="seleccion" class="form-select">
                                <option value="Movistar">Movistar</option>

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
                
                
            </div> -->


    </div>
    <br>
    <hr />
    <!--  -->


    </div>




</body>
<script src="../js/buscar.js"></script>

</html>