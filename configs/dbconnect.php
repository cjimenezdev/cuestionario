<?php
	/* 
 		Author: Enrique Bernardo Gonzalez Vazquez 
 		Note: Script de conexion con la Base de datos
	*/
	/************************************************************/
  /* Variables para la conexion con la BD */
	$host = "127.0.0.1:3307";
	$username = "root";
	$password = "";
	$BD_Name = "encuestas";
  /* conexion a la DB */
  $mysqli = new mysqli($host,$username,$password,$BD_Name);
  /* Comprobamos la conexion */
  if($mysqli->connect_errno)
  {
    echo("Error en la conexion con el servidor: ".mysqli::$connect_errno);
  }
    /************************************************************/