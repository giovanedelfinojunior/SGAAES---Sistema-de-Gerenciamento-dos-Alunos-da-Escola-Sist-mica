<meta charset='utf8'/>
<?php

	$p_nometurma = $_POST['txtnometurma'];
	$p_orientadorrem = $_POST['selorientadorrem'];
	$p_orientador = $_POST['selorientador'];
	$p_modalidade = $_POST['selmodalidade'];
	$p_periodo = $_POST['selperiodo'];
	$p_status = $_POST['selstatus'];
	$p_id = $_POST['hidid'];

	$p_orientador = array_unique($p_orientador);

	$td_orientador = count($p_orientador);
	$p_orientador_validacao = true;

	$msg = "";
	$imagem = "warning.png";
	$url_retorno = "?folder=classes&file=sgaaes_fmupd_class&ext=php&id=".$p_id;

	if($p_orientadorrem <> ""){

		$sql_sel_orientadores = "SELECT id
								FROM orientadores
								INNER JOIN orientadores_has_turmas ON(orientadores_has_turmas.orientadores_id = orientadores.id)
								WHERE turmas_id='".$p_id."'";
		$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);
		$resultado = $sql_sel_orientadores_resultado->num_rows;

	}else{

		$resultado = "";

	}

	$validar = str_replace(' ', '', $p_nometurma);
	if($validar == ""){

		$msg = mensagenscampos(1,'nome da turma');

	}else if($resultado == 1){

				$msg = "Não é possível excluir o último orientador da turma, adicione outro orientador para executar essa ação!";

			}else{

				$sql_sel_turmas = "SELECT nome_turma FROM turmas WHERE nome_turma='".addslashes($p_nometurma)."' AND periodo='".addslashes($p_periodo)."' AND modalidade='".addslashes($p_modalidade)."' AND id <> '".$p_id."'";
				$sql_sel_turmas_resultado = $conexao->query ($sql_sel_turmas);

				if($sql_sel_turmas_resultado->num_rows > 0){

					$msg = mensagenscampos(4,'turma');

				}else{

					$tabela = "turmas";

					$condicao = "id='".$p_id."'";

					$dados = array(
						'nome_turma'	=> $p_nometurma,
						'modalidade'	=> $p_modalidade,
						'periodo'	=> $p_periodo,
						'status'	=> $p_status
					);

					$resultado = atualizar($tabela, $dados, $condicao);

					if($resultado){

						if($p_orientadorrem <> ""){

							$tabela = "orientadores_has_turmas";

							$condicao = "orientadores_id = '".$p_orientadorrem."' AND turmas_id='".$p_id."'";

							$resultado = deletar($tabela, $condicao);

						}

						for($i=0; $i<$td_orientador; $i++){

							if($p_orientador[$i]==""){
								$p_orientador_validacao =  false;
							}
							if($p_orientador_validacao){

								$sql_sel_orientadores = "SELECT id
														FROM orientadores
														INNER JOIN orientadores_has_turmas ON(orientadores_has_turmas.orientadores_id = orientadores.id)
														WHERE turmas_id='".$p_id."' AND orientadores_id='".$p_orientador[$i]."'";
								$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);

								if($sql_sel_orientadores_resultado->num_rows == 0){

									$tabela = "orientadores_has_turmas";

									$dados = array(
										'orientadores_id'	=> $p_orientador[$i],
										'turmas_id' => $p_id
									);

									$resultado = adicionar($tabela, $dados);

									if(!$resultado){

										$msg = mensagens(2,"Alteração","turma");

									}
								}
							}

						}
						if($resultado){

							$msg = mensagens(1,"Alteração","turma");
							$imagem = "ok.png";
							$url_retorno= "?folder=classes&file=sgaaes_fmins_class&ext=php&id=".$p_id;

						}else{

							$msg = mensagens(2,"Alteração","turma");

						}
				}else{

					$msg = mensagens(2,"Alteração","turma");

				}
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
