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
<fieldset style="width:300px;">
	<legend>Registro de Turma</legend>
	<h4>OBS: todos os campos são obrigatórios!</h4>
	<form name="frmrgtclass" onsubmit="return validaregistroturma()" method="post" action="?folder=classes&file=sgaaes_ins_class&ext=php">
		<p>Nome da Turma:
		<input type="text" name="txtnometurma" maxlength="45"></p>
		Orientadores:<a href="#" class="adicionarCampo" title="Adicionar item"><img width="14" height="14" src="../../layout/images/mais.png"></a>
            <div class="linhas"><p><select name="selorientador[]" id="selorientador[]">
              <option value="" selected>Selecione um orientador...</option>
              <?php
              	$sql_sel_orientadores = "SELECT id, nome_orientador FROM orientadores ORDER BY nome_orientador ASC";//selecionar id e nome do orientador na tabela orientadores e odenar por nome do orientador em ordem crescente.
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
			<option value="">Escolha</option>
			<option value="t">Técnico</option>
			<option value="s">Superior</option>
		</select></p>
		<p>Período:
		<select name="selperiodo">
			<option value="">Escolha</option>
			<option value="mat">Matutino</option>
			<option value="ves">Vespertino</option>
			<option value="not">Noturno</option>
		</select></p>
		<p><center><button type="reset">Limpar</button><button type="submit" id="btn-cadastrar" value="Cadastrar">Registrar</button></center></p>
	</form>
</fieldset>
<?php

	$sql_sel_turmas = "SELECT *,id AS idturma  FROM turmas ORDER BY nome_turma ASC";
	$sql_sel_turmas_resultado = $conexao->query ($sql_sel_turmas);

?>
<fieldset style="width:550px; margin-top:20px; margin-bottom: 10px">
<legend>Turmas Registradas</legend>
<table border="1" width="800">
	<thead>
		<tr>
			<th width="40%">
				Nome da Turma
			</th>
			<th width="30%">
				Orientadores
			</th>
			<th width="10%">
				Status
			</th>
			<th width="10%">
				Alterar
			</th>
			<th width="10%">
				Excluir
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if($sql_sel_turmas_resultado->num_rows == 0){
		?>
		<tr>
			<td colspan="5">Nenhuma Turma Registrada</td>
		</tr>
		<?php
			}else{

				while($sql_sel_turmas_dados=$sql_sel_turmas_resultado->fetch_array()){

					$status = "";

					if($sql_sel_turmas_dados['status'] == "a"){

						$status = "Ativo";

					}else{

						$status = "Inativo";

					}


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
  	?>
		<tr>
			<td><?php echo	$sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo ?></td>
			<td><?php

      $sql_sel_orientadores = "SELECT orientadores.nome_orientador
      						FROM orientadores_has_turmas
      						INNER JOIN orientadores ON(orientadores_has_turmas.orientadores_id = orientadores.id)
      						INNER JOIN turmas ON(orientadores_has_turmas.turmas_id = turmas.id)
      						WHERE orientadores_has_turmas.turmas_id = '".$sql_sel_turmas_dados['idturma']."'";
      $sql_sel_orientadores_resultado = $conexao->query($sql_sel_orientadores);
      $orientadores = "";
      while($sql_sel_orientadores_dados = $sql_sel_orientadores_resultado->fetch_array()){
        $orientadores .= $sql_sel_orientadores_dados['nome_orientador'].", ";
      }
      $orientadores = substr($orientadores, 0, -2);
      echo $orientadores;
      ?>
      </td>
			<td><?php echo $status; ?></td>
			<td><a href="?folder=classes&file=sgaaes_fmupd_class&ext=php&id=<?php echo $sql_sel_turmas_dados['idturma']; ?>" title="Alterar registro"><img src="../../layout/images/edit.png"></td>
			<td><a onClick="return deletar('turma','<?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo ?>')" href="?folder=classes&file=sgaaes_del_class&ext=php&id=<?php echo $sql_sel_turmas_dados['idturma']; ?>" title="Excluir registro"><img src="../../layout/images/delete.png"></td>
		</tr>
		<?php
				}
      }
		?>

	</tbody>
</table>
</fieldset>
