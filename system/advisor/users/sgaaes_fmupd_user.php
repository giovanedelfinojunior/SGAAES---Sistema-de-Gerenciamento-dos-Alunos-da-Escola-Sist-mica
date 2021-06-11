<?php
	$g_id = $_GET['id'];
	$sql_sel_orientadores = "SELECT orientadores.*,
			usuarios.*
	FROM orientadores
	INNER JOIN usuarios ON(orientadores.usuarios_id = usuarios.id)
	WHERE orientadores.id='".$g_id."'";
	$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);
	$sql_sel_orientadores_dados = $sql_sel_orientadores_resultado->fetch_array();
?>
<fieldset>
	<legend>Alteração de Orientador</legend>
	<form name="frmorientador" method="post" action="?folder=users&file=sgaaes_upd_user&ext=php">
	<input type="hidden" name="hidid" value= "<?php echo $g_id ?>">
		<h4>OBS: Todos os campos com asterisco são obrigatórios!</h4>
		<p>
			*Nome Completo:
			<td><input type="text" name="txtnomecompleto" maxlength="45" value="<?php echo $sql_sel_orientadores_dados['nome_orientador']; ?>">
		</p>
		<p>
			*Usuário:
			<td><input type="text" name="txtusuario" maxlength="45" value="<?php echo $sql_sel_orientadores_dados['login'];?>">
		</p>
		<p>
			*E-mail:
			<input type="text" name="txtemail" maxlength="90" value="<?php echo $sql_sel_orientadores_dados['email'];?>">
		<p>
			Senha:
			<input type="password" name="pwdsenha" maxlength="">
		</p>
		<p>
			Confirme sua senha:
			<input type="password" name="pwdconfirmarsenha" maxlength="">
		</p>
		<p align="center">
			<a href="?folder=users&file=sgaaes_fmins_user&ext=php"><button type="button">Retornar</button></a><button type="submit">Alterar</button>
		</p>
	</form>
</fieldset>
