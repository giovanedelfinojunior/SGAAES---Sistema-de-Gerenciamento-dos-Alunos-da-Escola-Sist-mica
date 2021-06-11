 <script type="text/javascript">
  orientadorAntigo = new Array();
  orientadorAntigo[0] = "";

  $(function () {
    function removeCampo() {
      $(".removerCampo").unbind("click");
      $(".removerCampo").bind("click", function () {
        if($("div.linhas").length > 1){
         $(this).parent().parent().remove();
          valoresAntigos();
        }else{
          alert("A última linha não pode ser removida.");
        }
      });
    }
    $(".adicionarCampo").click(function () {
      novoCampo = $("div.linhas:first").clone();
      novoCampo.find("input").val("");
      novoCampo.insertAfter("div.linhas:last");
      valoresAntigos();
      removeCampo();
    });
  });

  function valoresAntigos (){
    var orientadores = document.getElementsByName('selorientador[]');
    for (var i=0;i<orientadores.length;i++){
      orientadorAntigo[i] = orientadores[i].value;
    }
  }

  function validaDetalhe(){
    var orientadoresValidar = document.getElementsByName('selorientador[]');
    for (var i = 0;i < orientadoresValidar.length; i++){
      var linha = i+1;
      if ((orientadoresValidar[i].value=="")){
        alert ("A linha "+linha+" não foi completamente preenchida.");
        return false;
      }
    }

  }
  </script>
<fieldset style="width:350px;margin-bottom: 10px;">
<?php

	$g_id = $_GET['id'];

	$sql_sel_turmas = "SELECT * FROM turmas WHERE id = '".$g_id."'";
	$sql_sel_turmas_resultado = $conexao->query ($sql_sel_turmas);
	$sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array();

?>
	<legend>Alteração de Turma</legend>
	<h4>OBS: todos os campos com * são obrigatórios!</h4>
	<form name="frmrgtclass" onsubmit="return validaregistroturma()" method="post" action="?folder=classes&file=sgaaes_upd_class&ext=php">
		<input type="hidden" name="hidid" value="<?php echo $g_id; ?>">
		<p>*Nome da Turma:
		<input type="text" name="txtnometurma" value="<?php echo $sql_sel_turmas_dados['nome_turma']; ?>" maxlength="45"></p>
		<p>Remover Orientador:<select name="selorientadorrem">

              <option value="" selected>Selecione um orientador...</option>
              <?php

              	$sql_sel_orientadores = "SELECT id, nome_orientador
              							 FROM orientadores
              							 INNER JOIN orientadores_has_turmas ON(orientadores_has_turmas.orientadores_id = orientadores.id)
              							 WHERE turmas_id='".$g_id."'
              							 ORDER BY nome_orientador ASC";
				$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);

				while($sql_sel_orientadores_dados = $sql_sel_orientadores_resultado->fetch_array()){

		              	$id_orientador=$sql_sel_orientadores_dados['id'];
		                $nome_orientador=$sql_sel_orientadores_dados['nome_orientador'];

		                echo "
		                <option value='$id_orientador'>$nome_orientador</option>
		                ";
		        }
              ?>
            </select>
            </p>
			Adicionar Orientadores:<a href="#" class="adicionarCampo" title="Adicionar item"><img width="14" height="14" src="../../layout/images/mais.png"></a>
            <div class="linhas"><p><select name="selorientador[]" id="selorientador[]">

              <option value="" selected>Selecione um orientador...</option>
              <?php

              	$sql_sel_orientadores = "SELECT id, nome_orientador FROM orientadores";//selecionar id e nome do orientador na tabela orientadores e odenar por nome do orientador em ordem crescente.
				$sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);

				while($sql_sel_orientadores_dados = $sql_sel_orientadores_resultado->fetch_array()){

	              	$id_orientador=$sql_sel_orientadores_dados['id'];
	                $nome_orientador=$sql_sel_orientadores_dados['nome_orientador'];

	                echo "
	                <option value='$id_orientador'>$nome_orientador</option>
	                ";
		        }
              ?>
            </select>
            <a href="#" class="removerCampo" title="Remover linha"><img width="14" height="14" src="../../layout/images/menos.png"></a>
            </p>
        	</div>
			<p>Modalidade:
			<select name="selmodalidade">
			<?php
				$opc_selecionadatec = "";
				$opc_selecionadasup = "";
				if($sql_sel_turmas_dados['modalidade'] == "t"){

					$opc_selecionadatec = "selected";

				}else if($sql_sel_turmas_dados['modalidade'] == "s"){

					$opc_selecionadasup = "selected";

				}
			?>
				<option value="t" <?php echo $opc_selecionadatec; ?>>Técnico</option>
				<option value="s" <?php echo $opc_selecionadasup; ?>>Superior</option>
			<?php
			?>
			</select></p>
			<p>Período:
				<select name="selperiodo">
				<?php
				$opc_selecionadamat = "";
				$opc_selecionadaves = "";
				$opc_selecionadanot = "";

				if($sql_sel_turmas_dados['periodo'] == "mat"){

					$opc_selecionadamat = "selected";

				}else if($sql_sel_turmas_dados['periodo'] == "ves"){

					$opc_selecionadaves = "selected";

						}else{

							$opc_selecionadanot = "selected";

						}
				 ?>
				<option value="mat" <?php echo $opc_selecionadamat; ?>>Matutino</option>
				<option value="ves" <?php echo $opc_selecionadaves; ?>>Vespertino</option>
				<option value="not" <?php echo $opc_selecionadanot; ?>>Noturno</option>
			</select></p>
			<p>Status:
			<select name="selstatus">
				<?php
				$opc_selecionadaat = "";
				$opc_selecionadain = "";

				if($sql_sel_turmas_dados['status'] == "a"){

					$opc_selecionadaat = "selected";

				}else{

					$opc_selecionadain = "selected";

				}

				 ?>
				<option value="a" <?php echo $opc_selecionadaat; ?>>Ativo</option>
				<option value="i" <?php echo $opc_selecionadain; ?>>Inativo</option>
			</select></p>

			<p><center><a href="?folder=classes&file=sgaaes_fmins_class&ext=php"><button type="button">Retornar</button></a><button type="submit">Alterar</button></center></p>
		</form>
		</fieldset>
