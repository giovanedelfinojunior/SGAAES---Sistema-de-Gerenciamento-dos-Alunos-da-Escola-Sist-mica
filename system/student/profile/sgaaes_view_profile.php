<?php

	$sql_sel_alunos = "SELECT alunos.*,
							turmas.*
						FROM turmas
						INNER JOIN alunos ON(alunos.turmas_id = turmas.id)
						WHERE usuarios_id='".$_SESSION['idusuario']."'";
	$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);
	$sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array();

?>
<div id="logo">
	<img src="../../layout/images/escolasistemica2.png">
</div>
<div id="title">Minhas Informações:</div>
<fieldset class ="fieldsetformulario">
	<p>Nome Completo:&nbsp;&nbsp;&nbsp;<?php echo $sql_sel_alunos_dados['nome_aluno']; ?></p>
	<div id="icon">

		<?php
		$modalidade = "";
		$periodo = "";

		if($sql_sel_alunos_dados['modalidade'] == "t"){

			$modalidade = "Técnico";

		}else if($sql_sel_alunos_dados['modalidade'] == "s"){

			$modalidade = "Superior";

		}

		if($sql_sel_alunos_dados['periodo'] == "mat"){

			$periodo = "Matutino";

		}else if($sql_sel_alunos_dados['periodo'] == "ves"){

				$periodo = "Vespertino";

			  }else if($sql_sel_alunos_dados['periodo'] == "not"){

				$periodo = "Noturno";

			  }
		?>
	</div>
	<p>E-mail:&nbsp;&nbsp;&nbsp;<?php echo $sql_sel_alunos_dados['email']; ?></p>
	<p>Turma:&nbsp;&nbsp;&nbsp;<?php echo $sql_sel_alunos_dados['nome_turma']." - ".$modalidade." - ".$periodo; ?></p>
	<p>Usuário:&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['usuarios']; ?></p>
<form name="frmupdsenha" method="post" action="?folder=profile&file=sgaaes_updsenha_profile&ext=php">
	<p>Senha:&nbsp;&nbsp;&nbsp;<input type="password" name="pwdsenha"></p>
	<p>Confirmar Senha:&nbsp;&nbsp;&nbsp;<input type="password" name="pwdsenhaconf"></p>
	<p><center><button type="submit">Enviar</button></center></p>
</form>
</fieldset>
