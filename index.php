<?php include "security/database/sgaaes_connection_database.php";?>

<html lang='pt-br'>
	<head>
		<link rel="icon" type="image/png" href="layout/images/fav2.png" />
		<meta charset="utf-8">
		<title>Ajuste de Ponto - Escola Sistêmica</title>
		<link rel='stylesheet' href="layout/css/sgaaes_frontend_css.css">
		<script type='text/javascript' src="addons/js/sgaaes_validate_js.js"></script>
	</head>
	<header>
			<div id="topo">
				<span>Ajuste de Ponto - Escola Sistêmica</span>
			</div>
	</header>
	<body>

		<div id ="conteudo">

			<?php
					/*Se a as vareaveis forem definidas "existem". */
					if((isset ($_GET['folder']))&&(isset ($_GET['file']))&&(isset ($_GET['ext']))){
						/*Se o include do caminho não for verdadeiro a mensagem de página não encontrada será exibida.*/
						if(!include $_GET['folder']."/".$_GET['file'].".".$_GET['ext']){
							echo "Página não encontrada!";
						}
					}else{
						/*O arquivo com a mensagem será incluido no código*/
						include "sgaaes_initial.php";
					}
		?>
							</div>
			<footer>
			© Copyright 2015 Escola Sistêmica. Todos os direitos reservados.
		</footer>
	</body>
</html>
