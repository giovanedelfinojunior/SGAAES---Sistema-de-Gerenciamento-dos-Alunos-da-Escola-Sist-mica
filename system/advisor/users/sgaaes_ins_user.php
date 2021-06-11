<?php
/* Recebendo od dados do formulário */

	$p_nome_orientador = $_POST["txtnomecompleto"];
	$p_nome_usuario = $_POST["txtusuario"];
	$p_email = $_POST["txtemail"];
	$p_senha = $_POST["pwdsenha"];
	$p_confsenha = $_POST["pwdconfirmarsenha"];
	$senha = md5 ($salt.$p_senha); // Criptografando a senha!

	$msg = "";
	$imagem = "warning.png";

	/* Validação dos dados que serão recebidos! */
	if (str_replace(' ', '', $p_nome_orientador) == ""){
			$msg = mensagenscampos(1,'nome do orientador');
		}else if (str_replace(' ', '', $p_nome_usuario) == ""){
				$msg = mensagenscampos(1,'usuario');
			}else if ($p_email == ""){
					$msg = mensagenscampos(1,'e-mail');
				}else if ($p_senha == ""){
						$msg = mensagenscampos(1,'senha');
					}else if ($p_confsenha == ""){
						$msg = mensagenscampos(1,'confirmar senha');
						}else if ($p_senha != $p_confsenha){
							$msg = "As senhas incompatíveis!";
					}else{
						$dominio=explode('@',$p_email);

						if (!ereg('^([a-zA-Z0-9.-_])*([@])([a-z0-9]).([a-z]{2,3})',$p_email)){
							$msg='E-mail inválido!';
						}else if(!checkdnsrr($dominio[1])){
									$msg='E-mail inválido!';
								}else{
									$orientador = explode(" ",$p_nome_orientador);
									if(count($orientador) < 2){

										$msg = "O campo nome completo precisa ter ao menos duas palavras!";

									}else{
										/*Começando a selecionar os dados e as tabelas que serão utilizados */

										$sql_sel_orientadores = "SELECT id FROM orientadores WHERE nome_orientador='".addslashes($p_nome_orientador)."'";
										$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);

										$sql_sel_usuarios = "SELECT usuarios.id
															FROM orientadores
															INNER JOIN usuarios ON(orientadores.usuarios_id = usuarios.id)
															WHERE login = '".$p_nome_usuario."'";//Selecionando o login da tabela usuario, onde o usuario é iagual a $_pnome_usuario!
										$sql_sel_usuarios_resultado = $conexao->query($sql_sel_usuarios);//Executando a síntaxe!

											if($sql_sel_orientadores_resultado->num_rows > 0){// Se o número de linhas for maior que zero...
												$msg = mensagenscampos(4,'orientador'); //Mensagem de aviso!
											}else if ($sql_sel_usuarios_resultado->num_rows > 0){
														$msg = mensagenscampos(5,'nome de usuário'); //Mensagem de aviso!
													}else{
														$tabela = "usuarios";

														$dados = array(
															'login' => $p_nome_usuario,
															'senha' => $senha,
															'permissao' => '0'
														);


															$resultado = adicionar($tabela,$dados);
															if ($resultado){

															$p_usuarios_id = $conexao->insert_id;

															$tabela = "orientadores";

															$dados = array(
																	'nome_orientador'=>$p_nome_orientador,
																	'usuarios_id'=>$p_usuarios_id,
																	'email'=>$p_email

															);

															$resultado = adicionar($tabela, $dados);

															if($resultado){
																$msg = mensagens(1,"Cadastro","orientador");
																$imagem = "ok.png";
															}else{
																$msg = mensagens(2,"Cadastro","orientador");
															}
														}else{
															$msg = mensagens(2,"Cadastro","orientador");
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
<a href="?folder=users&file=sgaaes_fmins_user&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
