<?php

include ('nav.php');
?>
<!-- tabla de asistencias para alicia -->

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-light">
                <div class="">
                    <div class=" mt-4">
                        <p class="text-center titulo_p">Historial de personal</p>
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
                                    <input type="date" name="fecha_inicio" id="fecha_in">
                                </div>
                                <div class="col-md-6 text-center">
                                    <h5>Fecha final que desea vizualizar</h5>
                                    <input type="date" name="fecha_final" id="fecha_fi">
                                </div>

                                <div class=" text-center">
                                    <h6>Ingrese nomina de empleado:</h6>
                                    <input type="number" name="nomina" id="nomi" style="border: 2px solid#147586 !important;color:black; background:white";>
                                </div>

                                <br>
                                <br>
                                
                                <br>
                                <br>

                            </div>
                                
                            </div>
                            <br>
                              
                        </form>
                        <br>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" onclick="controlDia()">Buscar</button>
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
<script src="../../js/buscar_rango.js"></script>

</html>

      