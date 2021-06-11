<?php
				
	$g_id = $_GET['id'];
	
	$tabela = "equipes_has_anotacoes";

	$condicao = "equipes_id = '".$g_id."'";

	$resultado = deletar($tabela, $condicao);

	if($resultado){

		$tabela = "alunos";

		$condicao = "equipes_id = '".$g_id."'";

		$dados = array(
			'equipes_id' => '1'
		);

		$resultado = atualizar($tabela, $dados, $condicao);

		if($resultado){
			
				
			$tabela = "equipes";

			$condicao = "id = '".$g_id."'";

			$resultado = deletar($tabela, $condicao);

			if($resultado){

					$msg = mensagens(1, "Exclusão","equipe");
					$imagem = "ok.png";

			}else{

				$msg = mensagens(2, "Exclusão","equipe");

			}
		}else{

			$msg = mensagens(2, "Exclusão","equipe");

		}

	}else{

		$msg = mensagens(2, "Exclusão","equipe");

	}

?>

<div id="mensagens">
	Aviso
	<img src="../../layout/images/<?php echo $imagem; ?>">
	<p><?php echo $msg;  ?></p>
</div>
<a href="?folder=teams&file=sgaaes_fmins_team&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
