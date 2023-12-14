<?php

include ('nav.php');

?>


<body>

    <div class="container">
       

           <div class="row">
            <div class="col-md-12">
                <div class="">
                    <div class=" mt-4">
                        <p class="text-center titulo_p">Muestra de permisos autorizados</p>
                    </div>
                </div>
                <br>
                <br>
                <div class="">
                    <div class="">
                        <form action="../php/exportarList.php" method="POST" class="text-center" id="filesForm">

                            <div class="row">
                            <br>
                    <br>
                    
                                <div class="col-md-6 text-center">
                                    <h5>Fecha inicio que desea vizualizar</h5>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio">
                                </div>

                                <div class="col-md-6 text-center">
                                    <h5>Fecha ultima que desea vizualizar</h5>
                                    <input type="date" name="fecha_final" id="fecha_final">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                            <div class=" text-center">
                            <select name="seleccion" id="seleccion">
                                <option value="Movistar">Movistar</option>
                                <option value="HSBC">HSBC</option>
                                <option value="Administrativo">Administrativo</option>
                            </select>
                            </div>
                            
                            </div>
                        </form>
                        <br>
                        <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-outline-primary" onclick="mifuncionPermAu()">Buscar</button>
                        </div>
                       
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

</html>