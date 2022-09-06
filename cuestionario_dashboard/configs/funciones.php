<?php
	require_once 'conexion.php';

	// cuestionarios
	$cuestionario_id = $_POST["cuestionario_id"];
	$cuestionario_nombre = $_POST["cuestionario_nombre"];
	$cuestionario_descripcion = $_POST["cuestionario_descripcion"];
	$cuestionario_estado = $_POST["cuestionario_estado"];

	// preguntas
	$pregunta_id = $_POST["pregunta_id"];
	$pregunta_texto = $_POST["pregunta_texto"];
	$pregunta_tipo = $_POST["pregunta_tipo"];
	$pregunta_posicion = $_POST["pregunta_posicion"];
	$pregunta_estado = $_POST["pregunta_estado"];
	$id_cuestionario = $_POST["id_cuestionario"];
	$valor_puntos = $_POST['pregunta_puntos'];



	switch ($_GET["accion"]) {
		case 'mostrarCuestionarios':
			$sql = "SELECT cuestionario_id, cuestionario_nombre FROM tbl_cuestionarios";
			$query = mysqli_query($conexion, $sql);
			echo '<option>Seleccione:</option>';
		    while ($row = mysqli_fetch_array($query)) {
		    	echo '<option value="'.$row['cuestionario_id'].'">'.$row['cuestionario_nombre'].'</option>';
		    }
		break;

		case 'guardarCuestionario':
			if (empty($cuestionario_id)) { /* insertar */

				$sql = "INSERT INTO tbl_cuestionarios (cuestionario_nombre, cuestionario_descripcion, cuestionario_estado) VALUES ('$cuestionario_nombre', '$cuestionario_descripcion', '$cuestionario_estado');";
				if ($conexion -> query($sql) === TRUE) {
		    		echo 1;
			    } else {
			    	echo 0;
			    }

			} else { /* actualizar */

				$sql = "UPDATE tbl_cuestionarios SET cuestionario_nombre = '$cuestionario_nombre', cuestionario_descripcion = '$cuestionario_descripcion', cuestionario_estado = '$cuestionario_estado' WHERE cuestionario_id = '$cuestionario_id';";
				if ($conexion -> query($sql) === TRUE) {
		    		echo 1;
			    } else {
			    	echo 0;
			    }
			}	
		break;

		case 'editarCuestionario':
			$id = $_POST["id"];
			$sql = "SELECT * FROM tbl_cuestionarios WHERE cuestionario_id = '$id';";

			$query = $conexion->query($sql);
            $row = $query->fetch_assoc();
			echo json_encode($row);
		break;

		case 'mostrarPreguntas':
			$sql = "SELECT pregunta_id, pregunta_texto, b.cuestionario_nombre FROM tbl_preguntas a JOIN tbl_cuestionarios b ON a.id_cuestionario = b.cuestionario_id;";
			$query = mysqli_query($conexion, $sql);
			echo '<option>Seleccione:</option>';
		    while ($row = mysqli_fetch_array($query)) {
		    	echo '<option value="'.$row['pregunta_id'].'">'.$row['pregunta_texto'].' - '.$row['cuestionario_nombre'].'</option>';
		    }
		break;

		case 'guardarPreguntas':
			if (empty($cuestionario_id)) { /* insertar */			
				$sql = "INSERT INTO tbl_preguntas (pregunta_texto, pregunta_tipo, pregunta_posicion, pregunta_estado, id_cuestionario, puntos) VALUES ('$pregunta_texto', '$pregunta_tipo', '$pregunta_posicion', '$pregunta_estado', '$id_cuestionario', '$valor_puntos');";

				if ($conexion -> query($sql) === TRUE) {
		    		echo 1;
			    } else {
			    	echo 0;
			    }

			} else { /* update */
				$sql = "UPDATE tbl_preguntas SET pregunta_texto = '$pregunta_texto', pregunta_tipo = '$pregunta_tipo', pregunta_posicion = '$pregunta_posicion', pregunta_estado = '$pregunta_estado', id_cuestionario = '$id_cuestionario' WHERE pregunta_id = '$pregunta_id';";
				if ($conexion -> query($sql) === TRUE) {
		    		echo 1;
			    } else {
			    	echo 0;
			    }
			}
		break;		

		case 'editarPreguntas':
			$id = $_POST["id"];
			$sql = "SELECT * FROM tbl_preguntas WHERE pregunta_id = '$id';";

			$query = $conexion->query($sql);
            $row = $query->fetch_assoc();
			echo json_encode($row);
		break;

		case 'guardarRespuestas':
			$pregunta = $_POST["pregunta"];
			$respuesta = $_POST["respuesta"];

			$sql = "INSERT INTO tbl_respuestas (respuesta_text, id_pregunta) VALUES ('$respuesta','$pregunta'); ";
			if ($conexion -> query($sql) === TRUE) {
	    		
		    }
		break;

		case 'validarOpciones':
			$id = $_POST["id"];

			$sql = "SELECT pregunta_tipo FROM tbl_preguntas WHERE pregunta_id = '$id';";
			$query = mysqli_query($conexion, $sql);
			if ($row = mysqli_fetch_array($query)) {
				echo $row['pregunta_tipo'];
		    }
		break;

		case 'guardarOpciones':
			$id = $_POST["id"];			
			$texto = $_POST["texto"];

			$sql = "INSERT INTO tbl_opciones (opcion_texto, id_pregunta) VALUES ('$texto','$id'); ";
			if ($conexion -> query($sql) === TRUE) {
	    		
		    }
		break;

		case 'cargarOpciones':
			$id = $_POST["id"];	

			$sql = "SELECT opcion_id, opcion_texto FROM tbl_opciones WHERE id_pregunta = '$id';;";
			$query = mysqli_query($conexion, $sql);
			echo '<option>Seleccione:</option>';
		    while ($row = mysqli_fetch_array($query)) {
		    	echo '<option value="'.$row['opcion_id'].'">'.$row['opcion_texto'].'</option>';
		    }
		break;

		case 'borrarOpciones':
			$id = $_POST["id"];	

			$sql = "DELETE FROM tbl_opciones WHERE opcion_id = '$id';";
			if ($conexion -> query($sql) === TRUE) {
	    		echo 1;
		    }
		break;
	}
?>