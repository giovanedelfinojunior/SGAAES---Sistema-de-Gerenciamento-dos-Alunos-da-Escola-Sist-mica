<?php

	$p_senha = $_POST['pwdsenha'];
	$p_confsenha = $_POST['pwdsenhaconf'];

	$hash_senha = md5($salt.$p_senha);

	$msg = "";
	$imagem = "warning.png";

	if($p_senha == ""){

		$msg = mensagenscampos(1,'senha');

	}else if($p_confsenha == ""){

		$msg = mensagenscampos(1,'confirmar senha');

			}else if($p_senha <> $p_confsenha){

				$msg = mensagenscampos(2,'senhas');

					}else{

						$tabela = "usuarios";

						$condicao = "id='".$_SESSION['idusuario']."'";

						$dados = array(

									'senha' => $hash_senha

								);

						$resultado = atualizar($tabela,$dados,$condicao);

						if($resultado){

							$msg = $msg = mensagens(1,"Alteração","senha");
							$imagem = "ok.png";

						}else{

							$msg = mensagens(2,"Alteração","senha");

						}

					}
?>

<div id="mensagens">
	Aviso
	<img src="../../layout/images/<?php echo $imagem; ?>">
	<p><?php echo $msg;  ?></p>
</div>
<a href="?folder=profile&file=sgaaes_view_profile&ext=php" class="retornar">Retornar</a>
<?php
$conexao->close();
?>
