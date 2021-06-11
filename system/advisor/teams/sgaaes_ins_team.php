<?php
	$p_nome = $_POST['txtnomeequipe'];
	$p_aluno = $_POST['selaluno'];

	$p_aluno = array_unique($p_aluno);

	$td_aluno = count($p_aluno);
	$p_aluno_validacao = true;

	for($i=0; $i<$td_aluno; $i++){
		if($p_aluno[$i]==""){
			$p_aluno_validacao =  false;
			break;
		}
	}

	$msg = "";
	$imagem = "warning.png";

	if(str_replace(' ', '', $p_nome) == ""){

		$msg = mensagenscampos(1,'nome da equipe');

	}else  if(!$p_aluno_validacao){

				$msg = $msg = mensagenscampos(3,'aluno');

			}else{

								$sql_sel_equipes = "SELECT nome_equipe FROM equipes";
								$sql_sel_equipes_resultado = $conexao->query ($sql_sel_equipes);
								$sql_sel_equipes_dados = $sql_sel_equipes_resultado->fetch_array();

								if($sql_sel_equipes_dados['nome_equipe'] == $p_nome){

									$msg = mensagenscampos(4,'equipe');

								}else{

									$tabela = "equipes";

									$dados = array(
										'nome_equipe' => $p_nome
									);

									$resultado = adicionar($tabela, $dados);


									if($resultado){

										$p_equipes_id = $conexao->insert_id;//obtem o id(auto encremento) da ultima equipe inserido;

										for($i=0; $i<$td_aluno; $i++){

											if($p_aluno[$i]==""){
												$p_aluno_validacao =  false;
											}
											if($p_aluno_validacao){

												$tabela = "alunos";

												$condicao = "id='".$p_aluno[$i]."'";

												$dados = array(
													'equipes_id'	=> $p_equipes_id,

												);

												$resultado = atualizar($tabela, $dados, $condicao);

												if(!$resultado){

													$msg = mensagens(2,"Alteração","turma");

												}
											}
										}
									if($resultado){
										$msg = mensagens(1,"Cadastro","equipe");
										$imagem = "ok.png";

									}else{

										$msg = mensagens(2,"Cadastro","equipe");

									}
								}else{

									$msg = mensagens(2,"Cadastro","equipe");

								}
							}
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
