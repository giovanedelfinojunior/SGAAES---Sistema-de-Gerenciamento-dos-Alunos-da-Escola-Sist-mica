<?php
				
	$g_id = $_GET['id'];
	
	$sql_sel_alunos = "SELECT usuarios_id,foto FROM alunos WHERE id='".$g_id."'";
	$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);
	$sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array();
	$id_usuario = $sql_sel_alunos_dados['usuarios_id'];
	
	$tabela = "alunos_has_anotacoes";

	$condicao = "alunos_id = '".$g_id."'";

	$resultado = deletar($tabela, $condicao);

	if($resultado){

		$tabela = "ajustes_de_ponto";

		$condicao = "alunos_id = '".$g_id."'";

		$resultado = deletar($tabela, $condicao);


		if($resultado){
			
			if(file_exists('../../layout/images/upload_images/'.$sql_sel_alunos_dados['foto'])){
				unlink('../../layout/images/upload_images/'.$sql_sel_alunos_dados['foto']);
			}
				
			$tabela = "alunos";

			$condicao = "id = '".$g_id."'";

			$resultado = deletar($tabela, $condicao);

			if($resultado){
			
				$tabela = "usuarios";

				$condicao = "id = '".$id_usuario."'";

				$resultado = deletar($tabela, $condicao);

				if($resultado){

					$msg = mensagens(1, "Exclusão","aluno");
					$imagem = "ok.png";

				}else{

					$msg = mensagens(2, "Exclusão","aluno");

				}
				}else{

					$msg = mensagens(2, "Exclusão","aluno");

				}
		}else{

			$msg = mensagens(2, "Exclusão","aluno");

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
<a href="?folder=managements&file=sgaaes_class_management&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
