<?php
	$p_nome = $_POST['txtnomecompleto'];
	$p_epiteto = $_POST['txtepiteto'];
	$p_turma = $_POST['selturma'];
	$p_email = $_POST['txtemail'];
	$p_login = $_POST['txtusuario'];
	$p_senha = $_POST['pwdsenha'];
	$p_confsenha = $_POST['pwdconfsenha'];
	$p_id = $_POST['hidid'];

	$msg = "";
	$imagem = "warning.png";
	$url_retorno = "?folder=students&file=sgaaes_fmupd_student&ext=php&id=".$p_id;

	if(str_replace(' ', '', $p_nome) == ""){

		$msg = mensagenscampos(1,'nome do aluno');

	}else if(str_replace(' ', '', $p_epiteto) == ""){

				$msg = mensagenscampos(1,'epiteto');

			}else if(str_replace(' ', '', $p_email) == ""){

					$msg = mensagenscampos(1,'email');

				}else{
					$dominio=explode('@',$p_email);
					if (!ereg('^([a-zA-Z0-9.-_])*([@])([a-z0-9]).([a-z]{2,3})',$p_email)){
							$msg='E-mail inválido!';
						}else if(!checkdnsrr($dominio[1])){
										$msg='E-mail inválido!';
									}if (!ereg('^([a-zA-Z0-9.-_])*([@])([a-z0-9]).([a-z]{2,3})',$p_email)){
							$msg='E-mail inválido!';
						}else if(!checkdnsrr($dominio[1])){
										$msg='E-mail inválido!';
									}else if($p_login == ""){

												$msg = mensagenscampos(1,'usuário');

											}else if(($p_senha == "")&&($p_confsenha <> "")){

														$msg = mensagenscampos(1,'senha');

													}else if(($p_confsenha == "")&&($p_senha <> "")){

																$msg = mensagenscampos(1,'confirmação de senha');

															}else if($p_senha != $p_confsenha){

																		$msg = mensagenscampos(2,'senha');

																}else{

																	$nome = explode(" ",$p_nome);

																	if(count($nome) < 2){

																		$msg = "O campo nome completo precisa ter ao menos duas palavras!";

																	}else{

																		$sql_sel_alunos = "SELECT usuarios_id,nome_aluno,email,epiteto FROM alunos WHERE id <> '".$p_id."' AND (nome_aluno='".addslashes($p_nome)."' OR email='".addslashes($p_email)."' OR epiteto='".addslashes($p_epiteto)."')";
																		$sql_sel_alunos_resultado = $conexao->query ($sql_sel_alunos);
																		$sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array();

																		if($sql_sel_alunos_dados['nome_aluno'] == $p_nome){

																			$msg = mensagenscampos(4,'aluno');

																		}else if($sql_sel_alunos_dados['email'] == $p_email){

																					$msg = mensagenscampos(5,'e-mail');

																				}else if($sql_sel_alunos_dados['epiteto'] == $p_epiteto){

																							$msg = mensagenscampos(5,'epiteto');

																						}else{

																							$sql_sel_alunos = "SELECT usuarios_id,foto FROM alunos WHERE id = '".$p_id."'";
																							$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);
																							$sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array();

																							$sql_sel_usuarios = "SELECT login FROM usuarios WHERE login='".addslashes($p_login)."' AND id <> '".$sql_sel_alunos_dados['usuarios_id']."'";
																							$sql_sel_usuarios_resultado = $conexao->query($sql_sel_usuarios);

																							if($sql_sel_usuarios_resultado->num_rows > 0){

																								$msg = mensagenscampos(5,'usuário');

																							}else{
																								$f_imagem = $_FILES['fl_imagem'];
																								if($f_imagem['error'] == ""){
																									$pasta = "../../layout/images/upload_images/";
																									$extensao = strtolower(end(explode('.', $f_imagem['name'])));
																									$nome_imagem = date('dmy').time().'.'.$extensao;
																									$upload = move_uploaded_file($f_imagem['tmp_name'],$pasta.$nome_imagem);
																									if(file_exists('../../layout/images/upload_images/'.$sql_sel_alunos_dados['foto'])){
																										unlink('../../layout/images/upload_images/'.$sql_sel_alunos_dados['foto']);
																									}
																								}else{

																									$nome_imagem = $sql_sel_alunos_dados['foto'];

																								}

																								$tabela = "alunos";

																								$condicao = "id='".$p_id."'";

																								$dados = array(
																									'turmas_id' => $p_turma,
																									'nome_aluno' => $p_nome,
																									'epiteto'	=> $p_epiteto,
																									'foto' => $nome_imagem,
																									'email' => $p_email
																								);

																								$resultado = atualizar($tabela, $dados, $condicao);


																								if($resultado){

																									$sql_sel_senhausuarios = "SELECT senha FROM usuarios WHERE id='".$sql_sel_alunos_dados['usuarios_id']."'";
																									$sql_sel_senhausuarios_resultado = $conexao->query($sql_sel_senhausuarios);
																									$sql_sel_senhausuarios_dados = $sql_sel_senhausuarios_resultado->fetch_array();
																										if(($p_senha == "")&&($p_confsenha == "")){

																											$hash_senha = $sql_sel_senhausuarios_dados['senha'];

																										}else{
																											$hash_senha = md5($salt.$p_senha);
																										}

																									$tabela = "usuarios";

																									$condicao = "id='".$sql_sel_alunos_dados['usuarios_id']."'";

																									$dados = array(

																										'login'	=> $p_login,
																										'senha'	=> $hash_senha

																									);

																									$resultado = atualizar($tabela, $dados, $condicao);

																									if($resultado){

																										$msg = mensagens(1,"Alteração","aluno");
																										$imagem = "ok.png";
																										$url_retorno = "?folder=managements&file=sgaaes_class_management&ext=php";

																									}else{

																										$msg = mensagens(2,"Alteração","aluno");

																									}
																								}else{

																									$msg = mensagens(2,"Alteração","aluno");

																								}
																							}
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
<a href="<?php echo $url_retorno; ?>" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
