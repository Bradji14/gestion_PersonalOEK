<?php

include ('nav.php');
?>


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
                                <option value="Movistar">Movistar</option>
                                <option value="HSBC">HSBC</option>
                                <option value="Administrativo">Administrativo</option>
                            </select>
                        </form>
                        <br>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-outline-primary" onclick="mifuncion()">Buscar</button>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success  mb-6">Exporta a Excel <svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 20">
                                    <path
                                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                                </svg></button>
                        </div>
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