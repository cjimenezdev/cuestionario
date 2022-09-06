<?php require_once 'conexion.php';
$headerColor = "";
$id = $_GET["n"];
$sql = "SELECT cuestionario_nombre FROM tbl_cuestionarios WHERE cuestionario_id = '$id';";
$query = mysqli_query($conexion, $sql);
if ($row = mysqli_fetch_array($query)) {
	$cuestionario_nombre = $row['cuestionario_nombre'];
}

$sql = "SELECT COUNT(pregunta_id) AS total FROM tbl_preguntas WHERE id_cuestionario = '$id';";
$query = mysqli_query($conexion, $sql);
if ($row = mysqli_fetch_array($query)) {
	$total = $row['total'];
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<title>Encuesta</title>
	<link rel="shortcut icon" href="images/1.png">

	<link rel="stylesheet" href="css/estilos.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



	<!-- google fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&family=Open+Sans&display=swap" rel="stylesheet">

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
				<font><?php echo $row["Titulo"]; ?> </font>
			</p>
		</center>
		<center>
			<p class="text" id="descripcion"> <?= nl2br($row['Descripcion']) ?>;</p>
		</center><br>

		<center> <?php echo '<img src = "data:image/png;base64,' . base64_encode($row['Imagen']) . ' "  width = "300px" height = "150px"'; ?></center><?php }  ?>
	<br><br>





	<p class="text2" style="text-align:left;"> (*) Campos obligatorios</p><br><br>

	<form action="" method="post" enctype="multipart/form-data" id="formulario">
		<div class="container">
			<div class="row">
			</div>
			<form id="mainForm" method="POST" action="">
				<?php
				$cont = 0;
				$sql = "SELECT pregunta_id, pregunta_texto, pregunta_tipo FROM tbl_preguntas WHERE pregunta_estado = 'a' AND id_cuestionario = '$id' ORDER BY pregunta_posicion ASC;";

				$query = mysqli_query($conexion, $sql);
				while ($row = mysqli_fetch_array($query)) {
					$cont++;
					$pregunta_id = $row['pregunta_id'];

					echo '<div class="row card">';

					switch ($row['pregunta_tipo']) {
						case 'text':
							echo '<div class="col-3"><label class="lblPreguntaText" for="' . $cont . '_' . $row['pregunta_id'] . '">' . $row['pregunta_texto'] . ' <sup class="red">*</sup></label><input type="hidden" id="' . $cont . '" name="' . $row['pregunta_id'] . '" value="' . $row['pregunta_id'] . '"></div>';
							echo '<input type="hidden" class="txt" id="' . $cont . '" name="tipo' . $cont . '" value="text">';
							echo '<div class="col-9"><input type="text" id="' . $row['pregunta_id'] . '" name="respuestaInputText" required="" class="form-control"></div>';
							break;

						case 'select':
							echo '<div class="col-3"><label class="lblPregunta" for="' . $cont . '_' . $row['pregunta_id'] . '">' . $row['pregunta_texto'] . ' <sup class="red">*</sup></label><input type="hidden" id="' . $cont . '" name="' . $row['pregunta_id'] . '" value="' . $row['pregunta_id'] . '"></div>';
							echo '<input type="hidden" id="tipo' . $cont . '" name="tipo' . $cont . '" value="select">';
							echo '<div class="col-9">';
							echo '<select id="' . $row['pregunta_id'] . '" name="respuestaSelect" class="form-control">';
							$query2 = mysqli_query($conexion, "SELECT opcion_id, opcion_texto FROM tbl_opciones WHERE id_pregunta = '$pregunta_id';");
							while ($row2 = mysqli_fetch_array($query2)) {
								echo '<option value="' . $row2['opcion_id'] . '">' . $row2['opcion_texto'] . '</option>';
							}
							echo '</select>';
							echo '</div>';
							break;

						case 'radio':
							echo '<div class="col-3"><label class="lblPregunta" for="' . $cont . '_' . $row['pregunta_id'] . '">' . $row['pregunta_texto'] . ' <sup class="red">*</sup></label><input type="hidden" id="' . $cont . '" name="' . $row['pregunta_id'] . '" value="' . $row['pregunta_id'] . '"></div>';
							echo '<input type="hidden" id="tipo' . $cont . '" name="tipo' . $cont . '" value="radio">';
							echo '<input type="hidden" id="radio' . $cont . '" name="radio' . $cont . '" value="' . $pregunta_id . '">';
							echo '<div class="col-9">';
							$query2 = mysqli_query($conexion, "SELECT opcion_id, opcion_texto FROM tbl_opciones WHERE id_pregunta = '$pregunta_id';");
							while ($row2 = mysqli_fetch_array($query2)) {
								echo '<div class="form-check">';
								echo '<input class="form-check-input" type="radio" name="radioForm" id="' . $row['pregunta_id'] . '" value="' . $row2['opcion_texto'] . '">';

								echo '<label class="form-check-label" for="' . $row2['opcion_id'] . '">' . $row2['opcion_texto'] . '</label>';
								echo '</div>';
							}
							echo '</div>';
							break;

						case 'check':
							echo '<div class="col-3"><label class="lblPregunta" for="' . $cont . '_' . $row['pregunta_id'] . '">' . $row['pregunta_texto'] . ' <sup class="red">*</sup></label><input type="hidden" id="' . $cont . '" name="' . $row['pregunta_id'] . '" value="' . $row['pregunta_id'] . '"></div>';
							echo '<input type="hidden" id="tipo' . $cont . '" name="tipo' . $cont . '" value="check">';
							echo '<input type="hidden" id="check' . $cont . '" name="check' . $cont . '" value="' . $pregunta_id . '">';
							echo '<div class="col-9">';
							$query2 = mysqli_query($conexion, "SELECT opcion_id, opcion_texto FROM tbl_opciones WHERE id_pregunta = '$pregunta_id';");
							while ($row2 = mysqli_fetch_array($query2)) {
								echo '<div class="form-check">';
								echo '<input class="form-check-input" type="checkbox" name="CheckForm" id="' . $row['pregunta_id'] . '" value="' . $row2['opcion_texto'] . '">';
								echo '<label class="form-check-label" for="' . $row2['opcion_id'] . '">' . $row2['opcion_texto'] . '</label>';
								echo '</div>';
							}
							echo '</div>';
							break;

						default:
							break;
					}
					echo '</div>';
				}
				?>
				<div class="row">
					<div class="col-3"></div>
					<div class="col-9">
						<div class="group">
							<div class="col-6 text-center">
								<input type="submit" id="guardarBtn" name="guardarBtn" class="btn btn-sm btn-success" value="Guardar">
							</div>
							<div class="col-6 text-center">
								<input type="submit" name="cancelarBtn" id="cancelarBtn" class="btn btn-sm btn-danger" value="Cancelar" onclick="limpiarForm();">
							</div>
						</div>
					</div>
				</div>
				<form>
		</div>
		<!-- Script para limpiar formulario -->
		<script type="text/javascript">
			/* Funcion para borrar el formulario */
			function limpiarForm() {
				Swal.fire({
					icon: 'warning',
					title: '¿Cancelar y borrar los datos?',
					showCancelButton: true,
					cancelButtonText: 'No',
					confirmButtonText: 'Si'
				}).then((result) => {
					if (result.isConfirmed) {
						$("#formulario")[0].reset();
					}
				});
			}
		</script>
		<!-- Script para la obtencion de datos del formulario -->
		<script src="js/senData_Docente.js"></script>
</body>

</html>