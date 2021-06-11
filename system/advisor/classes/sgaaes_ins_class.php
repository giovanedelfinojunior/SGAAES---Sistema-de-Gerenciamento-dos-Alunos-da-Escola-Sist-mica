<meta charset='utf8'/>
<?php

	$p_nometurma = $_POST['txtnometurma'];
	$p_orientador = $_POST['selorientador'];
	$p_modalidade = $_POST['selmodalidade'];
	$p_periodo = $_POST['selperiodo'];

	$p_orientador = array_unique($p_orientador);

	$td_orientador = count($p_orientador);
	$p_orientador_validacao = true;

	for($i=0; $i<$td_orientador; $i++){
		if($p_orientador[$i]==""){
			$p_orientador_validacao =  false;
			break;
		}
	}


	$msg = "";
	$imagem = "warning.png";
	$validar = str_replace(' ', '', $p_nometurma);
	if($validar == ""){

		$msg = mensagenscampos(1,'nome da turma');

	}else if(!$p_orientador_validacao){

				$msg = mensagenscampos(3,'orientadores');

			}else if($p_modalidade == ""){

				$msg = mensagenscampos(1,'modalidade');

					}else if($p_periodo == ""){

						$msg = mensagenscampos(1,'período');

					}else{

						$sql_sel_turmas = "SELECT nome_turma FROM turmas WHERE nome_turma='".addslashes($p_nometurma)."' AND periodo='".addslashes($p_periodo)."' AND modalidade='".addslashes($p_modalidade)."'";
						$sql_sel_turmas_resultado = $conexao->query ($sql_sel_turmas);

						if($sql_sel_turmas_resultado->num_rows > 0){

							$msg = mensagenscampos(4,'turma');

						}else{

							$tabela = "turmas";

							$dados = array(
								'nome_turma'	=> $p_nometurma,
								'modalidade'	=> $p_modalidade,
								'periodo'	=> $p_periodo,
								'status'	=> "a"
							);

							$resultado = adicionar($tabela, $dados);

							if($resultado){

								$sql_sel_turmas = "SELECT id FROM turmas WHERE nome_turma='".addslashes($p_nometurma)."'";
								$sql_sel_turmas_resultado = $conexao->query ($sql_sel_turmas);
								$sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array();

								for($i=0; $i<$td_orientador; $i++){

									$tabela = "orientadores_has_turmas";

									$dados = array(
										'orientadores_id'	=> $p_orientador[$i],
										'turmas_id'	=> $sql_sel_turmas_dados['id']

									);

									$resultado = adicionar($tabela, $dados);

								}
								if($resultado){

									$msg = mensagens(1,"Cadastro","turma");
									$imagem = "ok.png";

								}else{

									$msg = mensagens(2,"Cadastro","turma");

								}
							}else{

								$msg = mensagens(2,"Cadastro","turma");

							}
						}

					}
?>

<div id="mensagens">
	Aviso
	<img src="../../layout/images/<?php echo $imagem; ?>">
	<p><?php echo $msg;  ?></p>
</div>
<a href="?folder=classes&file=sgaaes_fmins_class&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
