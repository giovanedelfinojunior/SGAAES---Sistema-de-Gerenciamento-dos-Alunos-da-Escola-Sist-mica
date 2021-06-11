<?php
	$p_nome = $_POST['txtnomecompleto'];
	$p_epiteto = $_POST['txtepiteto'];
	$p_turma = $_POST['selturma'];
	$p_email = $_POST['txtemail'];

	$msg = "";
	$imagem = "warning.png";
	$usuario = "";

	if(str_replace(' ', '', $p_nome) == ""){

		$msg = mensagenscampos(1,'nome do aluno');

	}else if(str_replace(' ', '', $p_epiteto) == ""){

				$msg = mensagenscampos(1,'epiteto');

			}else if(str_replace(' ', '', $p_turma) == ""){

						$msg = mensagenscampos(1,'turma');

					}else if(str_replace(' ', '', $p_email) == ""){

								$msg = mensagenscampos(1,'email');

							}else{

								$sql_sel_alunos = "SELECT nome_aluno,email,epiteto FROM alunos WHERE turmas_id='".$p_turma."' AND  (nome_aluno='".addslashes($p_nome)."' OR email='".addslashes($p_email)."' OR epiteto='".addslashes($p_epiteto)."')";
								$sql_sel_alunos_resultado = $conexao->query ($sql_sel_alunos);
								$sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array();

								if($sql_sel_alunos_dados['nome_aluno'] == $p_nome){

									$msg = mensagenscampos(4,'aluno');

								}else if($sql_sel_alunos_dados['email'] == $p_email){

											$msg = mensagenscampos(5,'e-mail');

										}else if($sql_sel_alunos_dados['epiteto'] == $p_epiteto){

													$msg = mensagenscampos(5,'epiteto');

												}else{

													$p_login = explode(" ",$p_nome);

													if(count($p_login) < 2){

														$msg = "O campo nome completo precisa ter ao menos duas palavras!";

													}else{
														$dominio=explode('@',$p_email);

														if (!ereg('^([a-zA-Z0-9.-_])*([@])([a-z0-9]).([a-z]{2,3})',$p_email)){
															$msg='E-mail inválido!';
														}else if(!checkdnsrr($dominio[1])){
																	$msg='E-mail inválido!';
																}else{
																	$org_login = $p_login['0']."_".$p_login['1'];

																	$org_login = strtolower(preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $org_login ) ));

																	if($org_login == '_'){

																		$msg = "Informe um nome válido!";

																	}else{

																		$sql_sel_usuarios = "SELECT login FROM usuarios WHERE login='".addslashes($org_login)."'";
																		$sql_sel_usuarios_resultado = $conexao->query($sql_sel_usuarios);

																		if($sql_sel_usuarios_resultado->num_rows > 0){

																			$al_num = "";
																			$numero = '123456789';
																			for($i = 0; $i < 3; $i++){

																				$conta = rand(0,8);
																				$al_num .= $numero[$conta];

																			}
																			$org_login .= $al_num;

																		}

																		$p_senha =  strtolower(preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $p_login['0'] ) ))."123";
																		$hash_senha = md5($salt.$p_senha);

																		$tabela = "usuarios";

																		$dados = array(
																			'login'	=> $org_login,
																			'senha'	=> $hash_senha,
																			'permissao' => 1

																		);

																		$resultado = adicionar($tabela, $dados);

																		if($resultado){
																			$f_imagem = $_FILES['fl_imagem'];
																			$pasta = "../../layout/images/upload_images/";
																			$extensao = strtolower(end(explode('.', $f_imagem['name'])));
																			$nome_imagem = date('dmy').time().'.'.$extensao;
																			$upload = move_uploaded_file($f_imagem['tmp_name'],$pasta.$nome_imagem);

																			$p_usuarios_id = $conexao->insert_id;//obtem o id(auto encremento) do ultimo usuário inserido;

																			$tabela = "alunos";

																			$dados = array(
																				'usuarios_id' => $p_usuarios_id,
																				'turmas_id' => $p_turma,
																				'nome_aluno' => $p_nome,
																				'epiteto'	=> $p_epiteto,
																				'turmas_id'	=> $p_turma,
																				'foto' => $nome_imagem,
																				'email' => $p_email
																			);

																			$resultado = adicionar($tabela, $dados);

																			if($resultado){

																				$msg = mensagens(1,"Cadastro","aluno");
																				$imagem = "ok.png";
																				$usuario = "Usuário:<input type='text' name='txtusuario' readonly='readonly' value='$org_login'>";

																			}else{

																				$msg = mensagens(2,"Cadastro","aluno");

																			}
																		}else{

																			$msg = mensagens(2,"Cadastro","aluno");

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
	<p><?php echo $usuario ?></p>
</div>
<a href="?folder=students&file=sgaaes_fmins_student&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
