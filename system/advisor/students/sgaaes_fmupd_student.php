<fieldset style="width: 400px;">
	<?php

		$g_id = $_GET['id'];

		$sql_sel_alunos = "SELECT alunos.*,
								  usuarios.*
							 FROM alunos
							 INNER JOIN usuarios ON(usuarios.id = alunos.usuarios_id)
							 WHERE alunos.id = '".$g_id."'";
		$sql_sel_alunos_resultado = $conexao->query ($sql_sel_alunos);
		$sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array();

	?>
    <legend>Alteração de Aluno</legend>
    <h4>OBS:todos os campos com asterisco são obrigatórios</h4>
    <form name="frmrgtstudent" method="post" onsubmit="return validaregistroaluno()" action="?folder=students&file=sgaaes_upd_student&ext=php"  enctype="multipart/form-data">
		<input type="hidden" name="hidid" value="<?php echo $g_id; ?>">
		<p>*Nome Completo:<input type="text" name="txtnomecompleto" maxlenght="45" value="<?php echo $sql_sel_alunos_dados['nome_aluno'] ?>"></p>
		<p>*Epiteto:<input type-"text" name="txtepiteto" maxlength="45" value="<?php echo $sql_sel_alunos_dados['epiteto'] ?>"></p>
		<p>*Turma pertencente:
		<select name="selturma">
		  	<?php

			    $sql_sel_turmas = "SELECT * FROM turmas ORDER BY nome_turma ASC";
			    $sql_sel_turmas_resultado = $conexao->query($sql_sel_turmas);

			    while($sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array()){


		              if($sql_sel_turmas_dados['modalidade'] == "t"){

		                $modalidade = "Técnico";

		              }else{

		                $modalidade = "Superior";

		              }

		              if($sql_sel_turmas_dados['periodo'] == "mat"){

		                  $periodo = "Matutino";

		              }else if($sql_sel_turmas_dados['periodo'] == "ves"){

		                      $periodo = "Vespertino";

		                      }else if($sql_sel_turmas_dados['periodo'] == "not"){

		                          $periodo = "Noturno";

		                        }

			    	$opc_selecionada = "";

			    	if($sql_sel_turmas_dados['id'] == $sql_sel_alunos_dados['turmas_id']) {

			    		$opc_selecionada = "selected";

			    	}

			?>
  					<option value="<?php echo $sql_sel_turmas_dados['id']; ?>" <?php echo $opc_selecionada; ?>><?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo; ?></option>
  			<?php

    			}

  			?>
		</select>
		</p>
		<p><p>Imagem:<input type="file" name="fl_imagem" accept="image/*" id="file_input" value=""/></p>
		<p>*Email:<input type="text" name="txtemail" maxlength="90" value="<?php echo $sql_sel_alunos_dados['email'] ?>"></p>
		<p>*Usuário:<input type="text" name="txtusuario" maxlength="45" value="<?php echo $sql_sel_alunos_dados['login'] ?>"></p>
		<p>Nova senha:<input type="password" name="pwdsenha" maxlength="45" value=""></p>
		<p>Confirmar Senha:<input type="password" name="pwdconfsenha" maxlength="45" value=""></p>
		<p><center><a href="?folder=managements&file=sgaaes_class_management&ext=php"><button type="button">Retornar</button></a><button type="submit">Alterar</button></center></p>
	</form>
</fieldset>
