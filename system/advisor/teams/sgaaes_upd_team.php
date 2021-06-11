<?php

	$p_nome = $_POST['txtnomeequipe'];
	$p_alunorem = $_POST['selalunorem'];
	$p_aluno = $_POST['selaluno'];
	$p_id = $_POST['hidid'];

	$p_aluno = array_unique($p_aluno);

	$td_aluno = count($p_aluno);
	$p_aluno_validacao = true;


	/*Validação dos dados!*/
	$msg ="";
	$url_retorno = "?folder=teams&file=sgaaes_fmupd_team&ext=php&id=".$p_id;
	$imagem = "warning.png";
	if(str_replace(' ', '', $p_nome) == ""){
		$msg = mensagenscampos(1,"nome da equipe");
	}else{

				$tabela = "equipes";

				$condicao = "id = '".$p_id."'";

				$dados = array (
					'nome_equipe'  => $p_nome,
				);
				$resultado = atualizar($tabela, $dados, $condicao);

				if($resultado){
					if($p_alunorem <> ""){

						$tabela = "alunos";

						$condicao = "id = '".$p_alunorem."'";

						$dados = array(
							'equipes_id' => '1'
						);

						$resultado = atualizar($tabela, $dados, $condicao);

						if(!$resultado){
							$msg = mensagens(2,"Alteração","equipe");
						}

					}
					for($i=0; $i<$td_aluno; $i++){

						if($p_aluno[$i]==""){
							$p_aluno_validacao =  false;
						}
						if($p_aluno_validacao){

							$sql_sel_alunos = "SELECT id FROM alunos WHERE equipes_id='".$p_id."' AND id='".$p_aluno[$i]."'";

							$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);

							if($sql_sel_alunos_resultado->num_rows == 0){

								$tabela = "alunos";

								$condicao = "id='".$p_aluno[$i]."'";

								$dados = array(
									'equipes_id'	=> $p_id
								);

								$resultado = atualizar($tabela, $dados, $condicao);

								if(!$resultado){

									$msg = mensagens(2,"Alteração","equipe");

								}
							}
						}
					}
					if($resultado){
						$msg = mensagens(1,'Alteração','equipes');;
						$url_retorno = "?folder=teams&file=sgaaes_fmins_team&ext=php";
						$imagem = "ok.png";
					}else{

						$msg = mensagens(2,"Alteração","equipe");

					}
				}else{
					$msg = mensagens(2,'Alteração','equipe');
				}
			}
?>
<div id="mensagens">
Aviso
<img src="../../layout/images/<?php echo $imagem; ?>">
<p><?php echo $msg;  ?></p>
</div>
<a href="<?php echo $url_retorno; ?>" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
