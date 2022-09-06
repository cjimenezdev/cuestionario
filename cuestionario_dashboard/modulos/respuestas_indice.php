<?php require_once 'configs/conexion.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSS only -->
	<title>Índice de cuestionarios</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&family=Open+Sans&display=swap" rel="stylesheet">
    
	<style type="text/css">
		body { margin: 0; font-family: 'Open Sans', sans-serif; }
		input, select { margin: 5px; }
		label { font-weight: bold; }
		li { list-style: none;  }
		.lead { font-size: xx-large; color: #3079e9;}
		.card { padding: 25px;  box-shadow: 5px 5px 10px rgba(0, 0, 0, .1); margin:20px; }
		.red { color: red; }
	</style>
</head>
<body>
	<div class="container">
		<div class="card">
			<div class="row">
				<div class="col-12"><br><br>
					<h3 class="lead">Lista de cuestionarios</h3><br>
					<p>Seleccione el cuestionario que desea contestar</p>
				</div>
			</div>
			<div class="row">
				<ul>
					<?php
						$sql = "SELECT cuestionario_id, cuestionario_nombre FROM tbl_cuestionarios WHERE cuestionario_estado = 'a';";
						$query = mysqli_query($conexion, $sql);
						while ($row = mysqli_fetch_array($query)) {
					    	echo '<li>
							<a href="../respuestas.php?n='.$row['cuestionario_id'].'">'.$row['cuestionario_nombre']. '</a>' .
							'&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;'. 
							'<a href="../respuestas_docente.php?n=' . $row['cuestionario_id'] . '">' . 'Formularo para docentes ' . '</a>' .
							'&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;'. '<a href="../puntajes_cuestionario.php?n=' . $row['cuestionario_id'] . '">' . 'Ver puntajes' . '</a>' . 
							'</li>';
					    }
					?>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>