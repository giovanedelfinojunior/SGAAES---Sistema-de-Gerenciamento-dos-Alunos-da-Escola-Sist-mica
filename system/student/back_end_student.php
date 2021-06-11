<?php
$permissao=1;
include "../../security/authentication/sgaaes_session_authentication.php";
include "../../security/authentication/sgaaes_permission_authentication.php";
include "../../security/database/sgaaes_connection_database.php";
include "../../addons/php/sgaaes_messagerepository_php.php";
include "../../addons/php/sgaaes_dboperations_php.php";
date_default_timezone_set("America/Sao_Paulo");
$data_envio = date("Y-m-d");
$hora_envio = date("G:i");
?>

<html lang='pt-br'>
	<head>
		<link rel="icon" type="image/png" href="../../layout/images/fav2.png" />
		<meta charset="utf-8">
		<title>Ajuste de Ponto - Escola Sistêmica</title>
	    <link rel='stylesheet' href='../../layout/css/sgaaes_layout_student_css.css'>
		<link rel='stylesheet' href='../../layout/css/jquery-ui.min.css'>
		<script type="text/javascript" src="../../addons/js/sgaaes_jquery.js"></script>
		<script type="text/javascript" src="../../addons/js/sgaaes_jquery-ui.min.js"></script>
	</head>
	<body>
    <header>
  			<div id="topo">

            <span>Ajuste de Ponto - Escola Sistêmica</span>
            <a href="../../security/authentication/sgaaes_logout_authentication.php" title="Sair"><button type="button" class="btnlogout">Sair</button></a>
						<?php
							$sql_sel_alunos = "SELECT nome_aluno FROM alunos WHERE usuarios_id='".$_SESSION['idusuario']."' ";
							$sql_sel_alunos_resutado = $conexao->query($sql_sel_alunos);
							$sql_sel_alunos_dados = $sql_sel_alunos_resutado->fetch_array();
						?>
						<h4>Olá,<?php echo $sql_sel_alunos_dados['nome_aluno']; ?></h4>
          <div id="logo1">
            <a href="?"><img src="../../layout/images/escolasistemica2.png"  width="90" height="120"></a>
          </div>
  				<nav id="navegacao">
  				<ul>
  					<li style = "border-right: 60px solid #274E13;"><a href="?folder=consultation&file=sgaaes_view_consultation&ext=php">Consulta de Ajuste de Ponto</a></li>
  					<li><a style="border-right: 60px solid #274E13;" href="?folder=point_adjustment&file=sgaaes_fmins_pointadjustment&ext=php">Registro de Ajuste de Ponto</a></li>
						<li><a style="border-right: 60px solid #274E13;" href="?folder=profile&file=sgaaes_view_profile&ext=php">Informações do Aluno</a></li>
  				</ul>
  				</nav>
  			</div>
  	</header>


<div id ="controle">
<div id ="conteudo">
	<?php
		$title="";
			/*Se a as vareaveis forem definidas "existem". */
			if((isset($_GET['folder']))&&(isset($_GET['file']))&&(isset($_GET['ext']))){
			/*Se o include do caminho não for verdadeiro a mensagem de página não encontrada será exibida.*/
			if(!include $_GET['folder']."/".$_GET['file'].".".$_GET['ext']){
			echo "Página não Encontrada";
			}
		}else{
			/*Verifica se a alguma mensagem a ser exibida.*/

			if(isset($_GET['msg'])){
				$g_msg = $_GET['msg'];
				$img = "warning";
			}else{
		/*se não houver nenhuma mensagem, a mensagem de bem vindo será armazenada na vareavel msg*/
				$sql_sel_ajustesdeponto = "SELECT count(ajustes_de_ponto.id) AS totalpendentes
											FROM ajustes_de_ponto
											INNER JOIN alunos ON(ajustes_de_ponto.alunos_id = alunos.id AND usuarios_id='".$_SESSION['idusuario']."')
											WHERE status_ajuste='s' OR status_ajuste='r'";
				$sql_sel_ajustesdeponto_resultado = $conexao->query($sql_sel_ajustesdeponto);
				$sql_sel_ajustesdeponto_dados = $sql_sel_ajustesdeponto_resultado->fetch_array();

				$g_msg = "Você tem ".$sql_sel_ajustesdeponto_dados['totalpendentes']." pendência(s)!";

		$img = "ok";
		$title = "Bem Vindo Aluno!";
		}
		/*O arquivo com a mensagem será incluido no código*/
		include "back_end_student_initial.php";
	}

?>

</div>
</div>

		<footer>
			© Copyright 2015 Escola Sistêmica. Todos os direitos reservados.
		</footer>
	</body>
</html>
