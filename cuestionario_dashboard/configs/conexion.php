<?php 
	$conexion = new mysqli("127.0.0.1:3307", "root", "", "encuestas");
    mysqli_query($conexion, 'SET NAMES "utf8"');
    mysqli_query($conexion,'SET lc_time_names = "es_ES" ');
    error_reporting(0);  /* no se muestran los errores de php */
    
    if (mysqli_connect_errno()) {
        printf("Error de conexión: ", mysqli_connect_error());
        exit();
    }
?>