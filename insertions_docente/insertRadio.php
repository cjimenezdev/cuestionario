<?php
/* Verificamos que los datos requeridos no esten indefinidos */
if (
    isset($_POST['id_cuestionario']) && isset($_POST['id_Pregunta'])
    && isset($_POST['respuesta'])) {
    /* Incluimos la conexion */
    require_once '../conexion.php';
    /* Variables recibidas */
    $id_Cuestionario = $_POST['id_cuestionario'];
    $id_Pregunta = $_POST['id_Pregunta'];
    $respuesta = $_POST['respuesta'];
    /* Obtenemos la fecha actual */
    date_default_timezone_set('America/Mexico_City');
    $fechaActual = date('y/m/d');
    if ($respuesta != "") {
        /* Query */
        $sql = "INSERT INTO tbl_radiobutton_docente (Id_Cuestionario, Id_Pregunta, Respuesta, Fecha)
            VALUES ('$id_Cuestionario', '$id_Pregunta', '$respuesta', '$fechaActual');";
        if ($conexion->query($sql) === TRUE) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo "No se ha recibido una respuesta";
    }
} else {
    echo "No se han recibido datos";
}
