<?php require_once 'conexion.php'; 
require_once './configs/dbconnect.php'; 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Encuesta</title>
    <link rel="shortcut icon" href="images/1.png">

    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&family=Open+Sans&display=swap"
        rel="stylesheet">

    <style type="text/css">
    body {
        margin: 0;
        font-family: 'Open Sans', sans-serif;
    }

    input,
    select {
        margin: 5px;
    }

    label {
        font-weight: bold;
    }

    .lead {
        font-size: xx-large;
        color: #3079e9;
    }

    .card {
        padding: 25px;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, .1);
        margin: 20px;
    }

    .red {
        color: red;
    }

    .group {
        display: flex;
    }

    :root {
        --white: #fff;
        --cyan: #cce9eb;
        --darkcyan: #a8dadc;
        --darkblue: #023047;
    }

    .sticky-toolbar-container {
        position: fixed;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        width: 80px;
        z-index: 2;
        text-align: center;
    }

    .sticky-toolbar-container .toggle-toolbar {
        background: var(--cyan);
    }

    .sticky-toolbar-container .toggle-toolbar.open-toolbar {
        position: absolute;
        top: 50%;
        right: 0;
        width: 100%;
        transform: translateY(-50%);
    }

    .sticky-toolbar-container .sticky-toolbar {
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
    }

    .sticky-toolbar-container .toggle-toolbar.open-toolbar,
    .sticky-toolbar-container .sticky-toolbar {
        transition: transform 0.2s;
    }

    .sticky-toolbar-container svg {
        fill: var(--darkblue);
    }

    .sticky-toolbar-container .sticky-toolbar>*,
    .sticky-toolbar-container .toggle-toolbar.open-toolbar {
        padding: 12px;
    }

    .sticky-toolbar-container .sticky-toolbar a {
        position: relative;
        display: inline-block;
        margin-bottom: 1px;
        background: var(--darkcyan);
    }

    .sticky-toolbar-container .sticky-toolbar a::before,
    .sticky-toolbar-container .sticky-toolbar a::after {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
    }

    .sticky-toolbar-container .sticky-toolbar a::before {
        content: attr(data-tooltip);
        right: calc(100% + 5px);
        font-size: 14px;
        white-space: nowrap;
        padding: 4px 8px;
        color: var(--white);
        background: var(--darkblue);
    }

    .sticky-toolbar-container .sticky-toolbar a::after {
        content: "";
        right: 100%;
        width: 0;
        height: 0;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        border-left: 5px solid var(--darkblue);
    }

    .sticky-toolbar-container .sticky-toolbar a:hover::before,
    .sticky-toolbar-container .sticky-toolbar a:hover::after {
        opacity: 1;
    }

    .sticky-toolbar-container.show-toolbar .open-toolbar {
        transform: translateY(-50%) translateX(100%);
    }

    .sticky-toolbar-container.show-toolbar .sticky-toolbar {
        transform: none;
    }
    </style>
</head>

<body id="cuerpo">

    <?php
    $sqlColor = "SELECT color from header";
    $resultColor = mysqli_query($conexion, $sqlColor);
    if ($rowColor = mysqli_fetch_array($resultColor)) {
    ?>

    <header class="color-output" style="background-color: <?php echo ($rowColor['color']);
                                                            } ?>;" <?php

                                                                    $sql = "SELECT * from informacion";
                                                                    $result = mysqli_query($conexion, $sql);

                                                                    while ($row = mysqli_fetch_array($result)) {

                                                                    ?> <i>
        <?php echo '<img src = "data:image/png;base64,' . base64_encode($row['Imagen']) . ' "  width = "130" height = "50"'; ?>
        </i>
    </header>
    <br><br><br>
    <center>
        <p class="title" id="titulo">
            <font><?php echo "Alumnos que contestaron este cuestionario" ?> </font>
        </p>
    </center>
    <?php }  ?>
    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <th>Nombre</th>
            <th>Puntaje</th>
            <th>Fecha</th>
        </thead>
        <tbody>
            <?php
            /* Obtener Id del cuestionario */
            $idCuestionario = $_GET["n"];
            try {
                /* Obtener todos los nombres de los alumnos */
                $sqlAlumnos = "SELECT DISTINCT tbl_checkbox.alumno as alumno, tbl_checkbox.Fecha FROM tbl_checkbox  WHERE tbl_checkbox.id_cuestionario = '$idCuestionario' GROUP BY tbl_checkbox.alumno;";
                
                $resultAlumnos = mysqli_query($conexion, $sqlAlumnos);
                
                while ($rowAlumnos = mysqli_fetch_array($resultAlumnos)) {
                    
                    $alumno = $rowAlumnos['alumno'];
                    
                    /* CheckBox */
                    /* Comparar los resultados de el alumno con las del docente */
                    
                    $sqlCheckAlumnos = "SELECT DISTINCT tbl_checkbox.Id_Cuestionario, tbl_checkbox.Id_Pregunta as Id_Pregunta, tbl_checkbox.Respuesta AS respuestaAlumno, tbl_checkbox.alumno as Alumno, tbl_checkbox_docente.Respuesta AS respuestaDocente FROM tbl_checkbox INNER JOIN tbl_checkbox_docente ON tbl_checkbox.Id_Pregunta = tbl_checkbox_docente.Id_Pregunta WHERE tbl_checkbox.Respuesta = tbl_checkbox_docente.Respuesta AND tbl_checkbox.alumno ='$alumno' AND tbl_checkbox.Id_Cuestionario = $idCuestionario GROUP BY tbl_checkbox.alumno;";
                    
                    $QUERY = $mysqli->query($sqlCheckAlumnos);
                    
                    $arrayComparacion = array();
                    while ($RESULT = $QUERY->fetch_assoc()) {
                        /* Almacenamos los registros en el array */
                        $arrayComparacion[] = $RESULT;
                    }
                    /* Almacenamos las variables */
                    $idPregunta = array_column($arrayComparacion, 'Id_Pregunta'); 
                    $respuestaAlumno = array_column($arrayComparacion, 'respuestaAlumno');
                    $respuestaDocente = array_column($arrayComparacion, 'respuestaDocente');
                    /* Contamos la cantidad de registros del array */
                    $cantidadRegistros = count($arrayComparacion);
                    /* Recorremos todos los registros del array */
                    for ($i = 0; $i < $cantidadRegistros; $i++) {
                        /* Id de la pregunta en cuestion */
                        $id_pregunta = $idPregunta[$i];
                        
                        if($respuestaAlumno[$i] == $respuestaDocente[$i]){
                            /* obtenemos el valor de el puntaje y lo sumamos al score */
                            $sqlCheckPuntaje = "SELECT DISTINCT tc.cuestionario_id, tp.pregunta_id, SUM(tp.puntos) as puntos, tch.alumno FROM tbl_cuestionarios as tc 
                            INNER JOIN tbl_preguntas as tp ON tc.cuestionario_id = tp.id_cuestionario 
                            INNER JOIN tbl_checkbox as tch ON tp.pregunta_id = tch.Id_Pregunta  
                            WHERE tc.cuestionario_id= '$idCuestionario' GROUP BY tch.alumno;";
                            $checkPuntajeQuery = $mysqli->query($sqlCheckPuntaje);
                            $puntajeCheck = array();

                            while ($resultCheckPuntaje = $checkPuntajeQuery->fetch_assoc()) {
                                /* Almacenamos los registros en el array */
                                $puntajeCheck[] = $resultCheckPuntaje;
                            }

                            $puntosCheckBox = array_column($puntajeCheck, 'puntos');
                            $cantidadCheckBox = count($puntajeCheck);
                            
                            for ($j = 0; $j < $cantidadCheckBox; $j++) {
                                $score = $puntosCheckBox[$j];
                            }
                         ?>
            <tr>
                <td><?php echo $alumno;?></td>
                <td><?php echo $score;?></td>
                <td><?php echo $rowAlumnos['Fecha']; ?></td>
            </tr>


            <?php }
            }
               }
            } catch (PDOException $e) {
            echo "Hubo un problema en la conexión: " . $e->getMessage();
            }

            //Cerrar la Conexion
            $database->close();

            ?>
        </tbody>
    </table>



</body>

</html>