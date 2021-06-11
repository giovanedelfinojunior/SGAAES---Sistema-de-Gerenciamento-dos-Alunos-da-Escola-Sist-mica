<?php
//Declarando as variáveis!
	$p_nome_orientador = $_POST["txtnomecompleto"];
	$p_nome_usuario = $_POST["txtusuario"];
	$p_email = $_POST["txtemail"];
	$p_senha = $_POST["pwdsenha"];
	$p_confsenha = $_POST["pwdconfirmarsenha"];
	$p_id = $_POST["hidid"];

	$msg = "";
	$imagem = "warning.png";
	$url_retorno = "?folder=users&file=sgaaes_fmupd_user&ext=php&id=".$p_id;

	//Fazendo a validação dos campos!
	if (str_replace(' ', '', $p_nome_orientador) == ""){ //Se o campo Nome completo estiver vazio....
		$msg = mensagenscampos(1,'nome do orientador'); //Aparece mensagem de aviso!
	}else if (str_replace(' ', '', $p_nome_usuario) == ""){//Se o campo Usuário estiver vazio....
				$msg = mensagenscampos(1,'usuário');//Aparece mensagem de aviso!
			}else if ($p_email == ""){//Se o campo E-mail estiver vazio...
						$msg = mensagenscampos(1,'e-mail');//Aparece mensagem de aviso!
					}else if ($p_senha != $p_confsenha){//Se os dados do campo senha e confirme a senha forem diferentes...
								$msg = "Senhas incompatíveis!"; //Aparece mensagem de aviso!
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
												$sql_sel_orientadores = "SELECT id FROM orientadores WHERE nome_orientador='".addslashes($p_nome_orientador)."' AND id<>'".$p_id."'";
												$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);

												$sql_sel_usuarios = "SELECT usuarios.id
																	FROM orientadores
																	INNER JOIN usuarios ON(orientadores.usuarios_id = usuarios.id)
																	WHERE login = '".$p_nome_usuario."' AND orientadores.id<>'".$p_id."'";//Selecionando o login da tabela usuario, onde o usuario é iagual a $_pnome_usuario!
												$sql_sel_usuarios_resultado = $conexao->query($sql_sel_usuarios);//Executando a síntaxe!

													if($sql_sel_orientadores_resultado->num_rows > 0){// Se o número de linhas for maior que zero...
														$msg = mensagenscampos(4,'orientador'); //Mensagem de aviso!
													}else if($sql_sel_usuarios_resultado->num_rows > 0){// Se o número de linhas for maior que zero...
														$msg = mensagenscampos(5,'nome de usuário'); //Mensagem de aviso!
													}else{//Se não
														//Altera os dados na tabela usuarios\
														$senha = "";
														if($p_senha != ""){
															$senha .= md5 ($salt.$p_senha); //Criptografando a senha!
														}else{
															$sql_sel_usuarios = "SELECT senha
																					FROM orientadores
																					INNER JOIN usuarios ON(orientadores.usuarios_id = usuarios.id)
																					WHERE orientadores.id<>'".$p_id."'";
															$sql_sel_usuarios_resultado = $conexao->query($sql_sel_usuarios);
															$sql_sel_usuarios_dados = $sql_sel_usuarios_resultado->fetch_array();

															$senha = $sql_sel_usuarios_dados['senha'];
														}
													$tabela = "usuarios";
													$condicao = "id='".$p_id."'";
													$dados = array(
														'login' => $p_nome_usuario,
														'senha' => $senha
													);
													$resultado = atualizar($tabela,$dados,$condicao);
														if ($resultado){ //Se o reultado der certo ele passa para a próxima tabela (de orientadores)!
														//altera os dados na tabela orientadores!
														$tabela = "orientadores";
														$condicao = "id = '".$p_id."'";

														$dados = array(
														'nome_orientador'=>$p_nome_orientador,
														'email'=>$p_email
														);
														$resultado = atualizar($tabela,$dados,$condicao);
															if($resultado){
																$msg = mensagens(1,"Alteração","orientador");
																$imagem = "ok.png";
																$url_retorno = "?folder=users&file=sgaaes_fmins_user&ext=php";
															}else{
																$msg = mensagens(2,"Alteração","orientador");
															}
														}else{
															$msg = mensagens(2,"Alteração","orientador");
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
