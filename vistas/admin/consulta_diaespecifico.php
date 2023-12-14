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



        <div class="row">
            <div>
                <!-- <form action="../php/exportar_especifico.php" method="POST" class="text-center">
                 

                    <br>
                    <br>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success  mb-6">Exporta a Excel <svg
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 20">
                                <path
                                    d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                            </svg></button>
                    </div>

                </form> -->



                <form action="paseListaGen.php" method="POST" class="text-center text-light">

                     <div class="text-center">

                        <p class="fw-normal titulo_p mt-4">Fecha exacta que desea visualizar</p>
                        <input type="date" name="fecha_inicio" id="fecaz_inicio">

                        <br>
                        <br>
                        <select name="seleccion" id="seleccion">
                            <!-- <option value="Movistar">Movistar</option>
                            <option value="HSBC">HSBC</option> -->
                            <option value="Administrativo">Administrativo</option>
                        </select>
                        <br />
                        <br />
                        <input type="submit" id="ptm">  
                        <!-- <a type="button" class="btn btn-outline-primary" href="hola.php" >Buscar</a> -->

                    </div>

                </form>


            </div>
        </div>
        <br />
        <hr />
      
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
                            </div>
                        </div> -->
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




</body>
<script src="../js/buscar.js"></script>

<!-- <script>
    var ptm=document.querySelector('#ptm');
    

    ptm.addEventListener('click',function(e){
        var fecha=document.querySelector('#fecaz_inicio').value;
        e.preventDefault();
        console.log(fecha);
    })
</script> -->

</html>