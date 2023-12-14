<?php

include ('nav.php');
?>
<!-- tabla de asistencias para alicia -->

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-white">
                <div class="">
                    <div class=" mt-4">
                        <p class="text-center titulo_p">Historial de personal</p>
                    </div>
                </div>
                <br>
                <br>
                <div class="">
                    <div class="">
                        <form action="../../php/exportarList.php" method="POST" class="text-center" id="filesForm">

                            <div class="row">
                            <br>
                    <br>
                    <div class="text-end">
                        <!-- <button type="submit" class="btn btn-success  mb-6">Exporta a Excel <svg
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 20">
                                <path
                                    d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                            </svg></button> -->
                    </div>
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

                            <!-- <div class="col-md-6 text-center">
                            <select  name="control" id="contr">
                                <option selected value="A">Asistencias</option>
                                <option value="R">Retardos</option>
                                <option value="F">Falta</option>
                                <option value="SA">Salidas anticipadas</option>
                                <option value="S">Salidas</option>
                            </select>
                            </div> -->
                            
                            </div>
                        </form>
                        <br>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" onclick="control()">Buscar</button>
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
                                <div class="col-lg-12">
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


    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
            scrollY: '200px',
            scrollCollapse: true,
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

   
});
    </script>
</body>
<script src="../../js/buscar_rango.js"></script>

</html>