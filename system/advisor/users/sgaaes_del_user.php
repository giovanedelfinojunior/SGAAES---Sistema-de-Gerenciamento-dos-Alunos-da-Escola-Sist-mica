<?php
	//Declarando as variaveis!
	$g_id = $_GET['id'];

	$imagem = "warning.png";
	$msg = "";

	//Selecionando o id do orientador da tabela de anotações
	$sql_sel_anotacoes = "SELECT orientadores_id FROM anotacoes WHERE orientadores_id='".$g_id."'"; //Selecionando orientadores_id da tabela anotações!
	$sql_sel_anotacoes_resultado = $conexao->query ($sql_sel_anotacoes);//Executando a síntaxe!
		if($sql_sel_anotacoes_resultado->num_rows>0){ //Se o número de linhas encontradas for igual a 1 não prosseguirá para as outras funçõs e aparecerá uma mensagem de aviso!

			$msg = "Não é possível realizar a exclusão, pois ele há anotações vinculadas a ele!"; //Se ele for o único orientador da turma, não será possível excluí-lo!

		}else{

				//Selecionando o id do orientador e o nome da turma na tabela orientadores_has_turmas!
				 		$sql_sel_orientadores_turmas = "SELECT turmas_id
												FROM orientadores_has_turmas
												INNER JOIN turmas ON(orientadores_has_turmas.turmas_id = turmas.id)
												INNER JOIN orientadores ON(orientadores_has_turmas.orientadores_id = orientadores.id)
												WHERE orientadores_id='".$g_id."'";//Selecionando o orientadores _id da tabela orientadores_has_turmas!
						$sql_sel_orientadores_turmas_resultado = $conexao->query($sql_sel_orientadores_turmas);//Executando a síntaxe!
						$unico_orientador = true;
						while($sql_sel_orientadores_turmas_dados = $sql_sel_orientadores_turmas_resultado->fetch_array()){
							$sql_sel_turmas = "SELECT turmas_id, nome_turma
																FROM orientadores_has_turmas
																INNER JOIN turmas ON(orientadores_has_turmas.turmas_id = turmas.id)
																WHERE turmas_id='".$sql_sel_orientadores_turmas_dados['turmas_id']."'";
							$sql_sel_turmas_resultado = $conexao->query($sql_sel_turmas);
							if($sql_sel_turmas_resultado->num_rows == 1){
								$unico_orientador = false;
								break;
							}
						}

				if(!$unico_orientador){ //Verificando se ele é o único orientador cadastrado na turma em que ele foi cadastrado!
					$sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array();
					$msg = "Não é possível realizar a exclusão, pois ele  é o único orientador da turma ".$sql_sel_turmas_dados['nome_turma']."!"; //Se ele for o único orientador da turma, não será possível excluí-lo!
				}else{

					$sql_sel_orientadores = "SELECT * FROM orientadores";//Selecionando os dados da tabela orientadores!
					$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores); //Executando a síntaxe!

					if($sql_sel_orientadores_resultado->num_rows == 1){ //Verificando no banco de dados se ele é o único orientador cadastrado, caso ele seja o único orientador aparecerá a mensagem a baixo
						$msg = "Não é possível realizar a exclusão, pois ele é o único orientador!";
					}else{
								$tabela = "anotacoes";
								$condicao = "orientadores_id ='".$g_id."'";
								$resultado = deletar ($tabela,$condicao);
								if($resultado){

											//Se não ele passa para a tabela orientadores_has_turmas para excluir o orientador
											//Deletando o orientador na tabela orientadores_has_turmas!
											$tabela = "orientadores_has_turmas";
											$condicao ="orientadores_id='".$g_id."'";
											$resultado = deletar ($tabela,$condicao);
											if($resultado){ //Se a exclusão deu certo nesta tabela, prosseguirá para a tabela orientadores!
												$sql_sel_usuarios = "SELECT * FROM orientadores WHERE id= '".$g_id."'";// Selecionando os dados da tabela orientadores, onde id é igual a $g_id!
												$sql_sel_usuarios_resultado = $conexao->query($sql_sel_usuarios);//Executando a síntaxe
												$sql_sel_usuarios_dados = $sql_sel_usuarios_resultado->fetch_array();//Guardando os dados!
													//Deletando o orientador e os dados do orientador na tabela orientadores!
													$tabela = "orientadores";
													$condicao = "id='".$g_id."'";
													$resultado = deletar($tabela,$condicao);
														if($resultado){//Se deu certo a exclusão na tabela orientadores, passará para a exclusão na tabela de usuários!
															//Deletando o orientador e os dados do orientador na tabela usuarios
																$tabela = "usuarios";
																$condicao = "id='".$sql_sel_usuarios_dados['usuarios_id']."'";
																$resultado = deletar ($tabela, $condicao);
																if($resultado){//Se as exclusões deram certo até aqi aparecerá a mensagem de aviso abaixo!
																	$msg = mensagens(1,"Exclusão","orientador");
																	$imagem = "ok.png";
																}else{//Caso não tenha dado certo as exclusões aparecerá a mensagem abaixo!
																	$msg = mensagens(2,"Exclusão","orientador");
																}
															}else{
																	$msg = mensagens(2,"Exclusão","orientador");
																}
												}else{
													$msg = mensagens(2,"Exclusão","orientador");
												}
											}else{
												$msg = mensagens(2,"Exclusão","orientador");
											}
					}
				}
			}
?>
<div id="mensagens">
	Aviso
	<img src="../../layout/images/<?php echo $imagem; ?>">
	<p><?php echo $msg;  ?></p>
</div>
<a href="?folder=users&file=sgaaes_fmins_user&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
