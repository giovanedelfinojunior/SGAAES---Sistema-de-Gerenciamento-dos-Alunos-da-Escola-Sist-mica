<!--HTML-->
<fieldset>
	<legend>Registro de Orientador</legend>
	<form name="frmorientador" method="post" action="?folder=users&file=sgaaes_ins_user&ext=php" >
		<h4>OBS: Todos os campos são obrigatórios!</h4>
		<p>Nome Completo:<input type="text" name="txtnomecompleto" maxlength="45"></p>
		<p>Usuário:</td>
			<input type="text" name="txtusuario" maxlength="45"></p>
			<p>E-mail:<input type="text" name="txtemail" maxlength="90"></p>
			<p>Senha:</td>
			<input type="password" name="pwdsenha" maxlength=""><p>
			<p>Confirme sua senha:</td>
			<input type="password" name="pwdconfirmarsenha" maxlength=""></p>
		 <p align="center"><button type="reset">Limpar</button><button type="submit">Registrar</button></p>
	</form>
</fieldset>
<!--PHP-->
<?php
	$sql_sel_orientadores = "SELECT id, usuarios_id, nome_orientador, email FROM orientadores ORDER BY nome_orientador ASC"; //Selecionando o id, usuarios_id, nome_orientador e email da tabela orientadores
	$sql_sel_orientadores_resultado = $conexao->query ($sql_sel_orientadores);//Executando a sintaxe!
?>
<!--HTML-->
<!--Tabela do relatório de orientadores cadastrados-->
<fieldset style="min-width:450px; margin-top:20px; margin-bottom: 10px">
	<legend>Orientadores Registrados</legend>
	<table border="1">
		<thead>
			<tr>
				<th width="30%">Nome Completo</th>
				<th width="40%">E-mail</th>
				<th width="1%">Alterar</th>
				<th width="1%">Excluir</th>
			</tr>
		</thead>
		<tbody>
	<!--PHP-->
			<?php
				$sql_sel_orientadores_resultado->num_rows;	//Traz o número de registros que são incluídos no $sql_sel_orientadores_resultado!
				if($sql_sel_orientadores_resultado->num_rows==0){ // Se o número de linhas encontradas for igual a zero ecebe mensagem abaixo (Nenhum registro encontrado!)
			?>
	<!--HTML-->
			<tr>
				<td colspan = "4">Nenhum registro encontrado!</td>
			</tr>
	<!--PHP-->
				<?php
					}else{
						while ($sql_sel_orientadores_dados = $sql_sel_orientadores_resultado->fetch_array()){ //Guardando os dados!
				?>
	<!--HTML e PHP-->
			<tr>
				<td><?php echo $sql_sel_orientadores_dados ['nome_orientador'];?></td>
				<td><?php echo $sql_sel_orientadores_dados ['email'];?></td>
				<td align="center"><a href="?folder=users&file=sgaaes_fmupd_user&ext=php&id=<?php echo $sql_sel_orientadores_dados['id'];?>"title="Editar orientador"><img src="../../layout/images/edit.png"></a></td>
				<td align="center"><a onClick="return deletar('orientador','<?php echo $sql_sel_orientadores_dados['nome_orientador'] ?>')" href="?folder=users&file=sgaaes_del_user&ext=php&id=<?php echo $sql_sel_orientadores_dados['id'];?>" onclick="return deletar"><img src="../../layout/images/delete.png"></a></td>
			</tr>
	<!--PHP-->
				<?php
					}
				}
				?>
	<!--HTML-->
		</tbody>
	</table>
</fieldset>
