<?php
$permissao=0;
include "../../security/authentication/sgaaes_session_authentication.php";
include "../../security/authentication/sgaaes_permission_authentication.php";
include "../../security/database/sgaaes_connection_database.php";
include "../../addons/php/sgaaes_messagerepository_php.php";
include "../../addons/php/sgaaes_dboperations_php.php";
date_default_timezone_set("America/Sao_Paulo");
$data_envio = date("Y-m-d");
$hora_envio = date("G:i");
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" type="image/png" href="../../layout/images/fav2.png" />
		<meta charset="utf-8">
		<title>Ajuste de Ponto - Escola Sistêmica</title>
	    <link rel='stylesheet' href='../../layout/css/sgaaes_layout_advisor_css.css'>
		<link rel='stylesheet' href='../../layout/css/jquery-ui.min.css'>
		<script type="text/javascript" src="../../addons/js/sgaaes_jquery.js"></script>
		<script type="text/javascript" src="../../addons/js/sgaaes_jquery-ui.min.js"></script>
		<script type='text/javascript' src="../../addons/js/sgaaes_validate_js.js"></script>
	</head>
	<body>
    <header>
  			<div id="topo">
					<span>Ajuste de Ponto - Escola Sistêmica</span>
            <a href="../../security/authentication/sgaaes_logout_authentication.php" title="Sair"><button type="button" class="btnlogout">Sair</button></a>
						<?php
							$sql_sel_orientadores = "SELECT nome_orientador FROM orientadores WHERE usuarios_id='".$_SESSION['idusuario']."' ";
							$sql_sel_orientadores_resutado = $conexao->query($sql_sel_orientadores);
							$sql_sel_orientadores_dados = $sql_sel_orientadores_resutado->fetch_array();
						?>
						<h4>Olá, <?php echo $sql_sel_orientadores_dados['nome_orientador']?></h4>
          <div id="logo1">
            <a href = "?"><img src="../../layout/images/escolasistemica2.png"  width="90" height="120"></a>
          </div>
  				<nav id="navegacao">
  				<ul>
  					<li style = "border-right: 60px solid #274E13;"><a href="#">Registros</a>
  				    <ul>
  				      <li style="border-top:1px solid rgba(0, 0, 0, 0.61); "><a href="?folder=students&file=sgaaes_fmins_student&ext=php">Registro de Aluno</a></li>
								<li><a href="?folder=users&file=sgaaes_fmins_user&ext=php">Registro de Orientador</a></li>
								<li><a href="?folder=classes&file=sgaaes_fmins_class&ext=php">Registro de Turma</a></li>
								<li><a href="?folder=reasons&file=sgaaes_fmins_reason&ext=php">Registro de Motivo</a></li>
								<li><a href="?folder=teams&file=sgaaes_fmins_team&ext=php">Registro de Equipe</a></li>
								<li><a href="?folder=notes&file=sgaaes_fmins_note&ext=php">Registro de Anotações</a></li>
								<li><a href="?folder=requests_point&file=sgaaes_fmins_requestpoint&ext=php">Registro de Solicitação de Ajuste de Ponto</a></li>
  					</ul>
  				  </li>
  					<li><a style="border-right: 60px solid #274E13;" href="#">Gestão</a>
							<ul>
								<li style="border-top:1px solid rgba(0, 0, 0, 0.61);"><a href="?folder=managements&file=sgaaes_pointadjustment_management&ext=php">Gestão de Ajuste de Ponto</a></li>
								<li><a href="?folder=managements&file=sgaaes_notes_management&ext=php">Gestão de Anotações</a></li>
								<li><a href="?folder=managements&file=sgaaes_class_management&ext=php">Gestão de Turma</a></li>
							</ul>
						</li>

					  <li><a style="border-right: 60px solid #274E13;" href="#">Relatórios</a>
  				    <ul>
  				      <li style="border-top:1px solid rgba(0, 0, 0, 0.61);" ><a href="?folder=reports&file=sgaaes_pointadjustment_report&ext=php">Relatório de Ajuste de Ponto</a></li>
  				      <li><a href="?folder=reports&file=sgaaes_notes_report&ext=php">Relatório de Anotações</a></li>
  				      <li><a href="?folder=reports&file=sgaaes_reason_report&ext=php">Relatório de Motivos</a></li>
  				    </ul>
  				  </li>
  				</ul>
  				</nav>
  			</div>
  	</header>
	<body>
		<div id="controle">
		<div id ="conteudo">
			<?php
				$title="";
					/*Se a as variáveis forem definidas "existem". */
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

							$sql_sel_ajustesdeponto = "SELECT count(ajustes_de_ponto.id) AS totalpendentes FROM ajustes_de_ponto
														INNER JOIN alunos	ON(ajustes_de_ponto.alunos_id=alunos.id)
														INNER JOIN turmas ON (alunos.turmas_id=turmas.id)
														INNER JOIN orientadores_has_turmas ON(orientadores_has_turmas.turmas_id = alunos.turmas_id)
														INNER JOIN orientadores ON (orientadores.id = orientadores_has_turmas.orientadores_id)
														INNER JOIN usuarios ON (orientadores.usuarios_id = usuarios.id)
														WHERE status_ajuste='p' AND usuarios.id = '".$_SESSION['idusuario']."'";



							$sql_sel_ajustesdeponto_resultado = $conexao->query($sql_sel_ajustesdeponto);
							$sql_sel_ajustesdeponto_dados = $sql_sel_ajustesdeponto_resultado->fetch_array();

							$g_msg = "Você tem ".$sql_sel_ajustesdeponto_dados['totalpendentes']." pendência(s)!";

							$img = "ok";
							$title = "Bem Vindo Orientador!";
					}
					include "back_end_advisor_initial.php";
				}
			?>

		</div>
		
	</div>
		<footer>
			© Copyright 2015 Escola Sistêmica. Todos os direitos reservados.
		</footer>
	</body>
</html>
