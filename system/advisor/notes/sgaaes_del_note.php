<?php

	$g_id = $_GET['id'];

	$tabela = "alunos_has_anotacoes";

	$condicao = "anotacoes_id = '".$g_id."'";

	$resultado = deletar($tabela, $condicao);

	if($resultado){

		$tabela = "equipes_has_anotacoes";

		$condicao = "anotacoes_id = '".$g_id."'";

		$resultado = deletar($tabela, $condicao);


		if($resultado){

			$tabela = "anotacoes";

			$condicao = "id = '".$g_id."'";

			$resultado = deletar($tabela, $condicao);

			$msg = mensagens(1, "Exclusão","anotação");
			$imagem = "ok.png";

		}else{

			$msg = mensagens(2, "Exclusão","anotação");

		}
	}else{

		$msg = mensagens(2, "Exclusão","aluno");

	}

?>

<div id="mensagens">
	Aviso
	<img src="../../layout/images/<?php echo $imagem; ?>">
	<p><?php echo $msg;  ?></p>
</div>
<a href="?folder=managements&file=sgaaes_notes_management&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
