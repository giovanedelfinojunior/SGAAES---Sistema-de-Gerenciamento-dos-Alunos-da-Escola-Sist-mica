<?php
	
	$p_alunorem = $_POST['selalunorem'];
	$p_equiperem = $_POST['selequiperem'];
	$p_aluno = $_POST['selaluno'];
	$p_equipe = $_POST['selequipe'];
	$p_classificacao = $_POST['selclassificacao'];
	$p_data = $_POST['txtdata'];
	$p_anotacao = $_POST['txaanotacao'];
	$p_id = $_POST['hidid'];

	$p_aluno = array_unique($p_aluno);
	$p_equipe = array_unique($p_equipe);

	$td_aluno = count($p_aluno);
	$p_aluno_validacao = true;
	$td_equipe = count($p_equipe);
	$p_equipe_validacao = true;


	/*Validação dos dados!*/
	$msg ="";
	$url_retorno = "?folder=notes&file=sgaaes_fmupd_note&ext=php&id=".$p_id;
	$imagem = "warning.png";
	if($p_data == ""){
		$msg = mensagenscampos(1,"data");
	}else if($p_anotacao == ""){
				$msg = mensagenscampos(1,"anotação");
			}else{

			
				$tabela = "anotacoes";
				
				$condicao = "id = '".$p_id."'";
				
				$dados = array (
					'classificacao'  => $p_classificacao,
					'data_anotacao' => $p_data,
					'anotacao' => $p_anotacao
				);
				$resultado = atualizar($tabela, $dados, $condicao);
				if($resultado){
					if($p_alunorem <> ""){
						
						$tabela = "alunos_has_anotacoes";

						$condicao = "alunos_id = '".$p_alunorem."' AND anotacoes_id='".$p_id."'";

						$resultado = deletar($tabela, $condicao);

					}
					for($i=0; $i<$td_aluno; $i++){

						if($p_aluno[$i]==""){
							$p_aluno_validacao =  false;
						}
						if($p_aluno_validacao){

							$sql_sel_alunoanotacoes = "SELECT * FROM alunos_has_anotacoes WHERE anotacoes_id='".$p_id."' AND alunos_id='".$p_aluno[$i]."'";
													
							$sql_sel_alunoanotacoes_resultado = $conexao->query($sql_sel_alunoanotacoes);
							
							if($sql_sel_alunoanotacoes_resultado->num_rows == 0){

								$tabela = "alunos_has_anotacoes";
								
								$dados = array(
									'alunos_id'	=> $p_aluno[$i],
									'anotacoes_id' => $p_id
								);
						
								$resultado = adicionar($tabela, $dados);

								if(!$resultado){

									$msg = mensagens(2,"Alteração","anotacao");

								}
							}
						}
					}
					if($resultado){
						if($p_equiperem <> ""){
						
							$tabela = "equipes_has_anotacoes";

							$condicao = "equipes_id = '".$p_equiperem."' AND anotacoes_id='".$p_id."'";

							$resultado = deletar($tabela, $condicao);

						}
						for($i=0; $i<$td_equipe; $i++){


							if($p_equipe[$i]==""){
								$p_equipe_validacao =  false;
							}
							if($p_equipe_validacao){

								$sql_sel_equipeanotacoes = "SELECT anotacoes_id FROM equipes_has_anotacoes WHERE anotacoes_id='".$p_id."' AND equipes_id='".$p_equipe[$i]."'";
								$sql_sel_equipeanotacoes_resultado = $conexao->query($sql_sel_equipeanotacoes);
								
								if($sql_sel_equipeanotacoes_resultado->num_rows == 0){

									$tabela = "equipes_has_anotacoes";
									
									$dados = array(
										'equipes_id'	=> $p_equipe[$i],
										'anotacoes_id' => $p_id
									);
							
									$resultado = adicionar($tabela, $dados);

									if(!$resultado){

										$msg = mensagens(2,"Alteração","anotacao");

									}
								}
							}
						}
						if($resultado){
							$msg = mensagens(1,'Alteração','anotação');;
							$url_retorno = "?folder=managements&file=sgaaes_notes_management&ext=php";
							$imagem = "ok.png";
						}else{
							
							$msg = mensagens(2,"Alteração","anotação");
						
						}
				}else{
					$msg = mensagens(2,'Alteração','anotação');
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