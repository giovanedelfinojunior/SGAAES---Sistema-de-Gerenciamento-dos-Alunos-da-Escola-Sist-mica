<fieldset style="width: 400px;">
    <legend>Registro de Aluno</legend>
    <h4>OBS: Os campos que possuem asterico são obrigatórios!</h4>
    <form name="frmrgtstudent" method="post" onsubmit="return validaregistroaluno()" action="?folder=students&file=sgaaes_ins_student&ext=php" enctype="multipart/form-data">
      <p>*Nome Completo:<input type="text" name="txtnomecompleto" maxlength="45"></p>
      <p>*Epiteto:<input type="text" name="txtepiteto" maxlength="45"></p>
      <p>*Turma pertencente:
        <select name="selturma">
          <option value="">Escolha</option>
          <?php

            $sql_sel_turmas = "SELECT * FROM turmas";
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


          ?>
              <option value="<?php echo $sql_sel_turmas_dados['id']; ?>"><?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo; ?></option>
          <?php

            }

          ?>
        </select>
      </p>
      <p>Imagem:<input type="file" name="fl_imagem" accept="image/*" id="file_input"/></p>
      <p>*Email:<input type="text" name="txtemail" maxlength="90"></p>
      <p>Usuário:<input type="text" name="txtusuario" maxlength="45" readonly="readonly" value="Usuário Autômatico"></p>
	  <p>Senha será gerada autômaticamente</p>
      <p><center><button type="reset">Limpar</button><button type="submit">Registrar</button></center></p>
  </form>
</fieldset>
