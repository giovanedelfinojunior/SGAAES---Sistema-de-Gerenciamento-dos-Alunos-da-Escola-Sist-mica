<script type="text/javascript">
  turmaAntigo = new Array();
  turmaAntigo[0] = "";

  $(function () {
    function removeCampo() {
      $(".removerCampo").unbind("click");
      $(".removerCampo").bind("click", function () {
        if($("div.linhas1").length > 1){
         $(this).parent().parent().remove();
          valoresAntigos();
        }else{
          alert("A última linha não pode ser removida.");
        }
      });
    }
    $(".adicionarCampo").click(function () {
      novoCampo = $("div.linhas1:first").clone();
      novoCampo.find("input").val("");
      novoCampo.insertAfter("div.linhas1:last");
      valoresAntigos();
      removeCampo();
    });
  });

  //função que mostra a lista de produtos ao lado da categoria CORRETA
    function mostraalunos(){

    //recebe todas as posições do campo selproduto[] e salva na variável produtoMudar
    var alunoMudar = document.getElementsByName('selaluno[]');
    //recebe todas as posições do campo selcategoria[] e salva na variável categoriaAtual
    var turmaAtual = document.getElementsByName('selturma[]');
    //verifica da posição 0 até a posição final do array...
    for (var j=0;j<alunoMudar.length;j++){
      //...se o valor antigo da categoria for diferente do valor atual da categoria.
      if (turmaAntigo[j] != turmaAtual[j].value){
      //se sim, é porque essa foi a posição alterada, portanto repassa a posição atual para a variável 'atual'
      atual=j;
      }
    }
        //passa o valor novo do selcategoria que foi alterado para a variável cod
    id_turmaaluno = turmaAtual[atual].value;
    //mostra o Aguarde no campo
    $(alunoMudar[atual]).html("<option>Aguarde</option>");
    //envia o código por post para a página buscadinamica.php, que pesquisa dinamicamente pelo código quais os produtos correspondentes àquela categoria
    $.post("../../addons/php/sgaaes_dynamicsearch.php", {id_turmaaluno:id_turmaaluno},
    //inicia a função busca
    function(buscaaluno){
      //repassa o que foi encontrado na busca ao select de produtos correspondente ao de categorias qe foi modificado os produtos encontrados
      $(alunoMudar[atual]).html(buscaaluno);
      //chama a função valoresAntigos para guardar os valores atuais das categorias como antigos
      valoresAntigos();
      //fecha a função busca e o processo do post
    });
    //fecha a função mostraprodutos
    }
  $(function () {
    function removeCampoequipe() {
      $(".removerCampoequipe").unbind("click");
      $(".removerCampoequipe").bind("click", function () {
        if($("div.linhas2").length > 1){
         $(this).parent().parent().remove();
          valoresAntigos();
        }else{
          alert("A última linha não pode ser removida.");
        }
      });
    }
    $(".adicionarCampoequipe").click(function () {
      novoCampoequipe = $("div.linhas2:first").clone();
      novoCampoequipe.find("input").val("");
      novoCampoequipe.insertAfter("div.linhas2:last");
      valoresAntigos();
      removeCampoequipe();
    });
  });

      function valoresAntigos(){
      //recebe todas as posições do campo selcategoria[] e salva na variável categorias
      var turmas = document.getElementsByName('selturma[]');
      //da posição 0 até a posição final do array...
      for (var i=0;i<turmas.length;i++){
        //...captura e salva o valor atual do campo selcategoria no array criado no carregamento da página para os valores antigos
        turmaAntigo[i] = turmas[i].value;
      }
    }
    function mostraequipes(){

    //recebe todas as posições do campo selproduto[] e salva na variável produtoMudar
    var equipeMudar = document.getElementsByName('selequipe[]');
    //recebe todas as posições do campo selcategoria[] e salva na variável categoriaAtual
    var turmaAtual = document.getElementsByName('selturmaequipe[]');
    //verifica da posição 0 até a posição final do array...
    for (var j=0;j<equipeMudar.length;j++){
      //...se o valor antigo da categoria for diferente do valor atual da categoria.
      if (turmaAntigo[j] != turmaAtual[j].value){
      //se sim, é porque essa foi a posição alterada, portanto repassa a posição atual para a variável 'atual'
      atual=j;
      }
    }
        //passa o valor novo do selcategoria que foi alterado para a variável cod
    id_turmaequipe = turmaAtual[atual].value;
    //mostra o Aguarde no campo
    $(equipeMudar[atual]).html("<option>Aguarde</option>");
    //envia o código por post para a página buscadinamica.php, que pesquisa dinamicamente pelo código quais os produtos correspondentes àquela categoria
    $.post("../../addons/php/sgaaes_dynamicsearch.php", {id_turmaequipe:id_turmaequipe},
    //inicia a função busca
    function(buscaequipe){
      //repassa o que foi encontrado na busca ao select de produtos correspondente ao de categorias qe foi modificado os produtos encontrados
      $(equipeMudar[atual]).html(buscaequipe);
      //chama a função valoresAntigos para guardar os valores atuais das categorias como antigos
      valoresAntigos();
      //fecha a função busca e o processo do post
    });
    //fecha a função mostraprodutos
    }
 </script>
<fieldset style="width:35%;margin-bottom: 10px;">
	<legend>Registro de Anotação</legend>
	<form name="frmanotacao" method="post" onsubmit="return validaregistroanotacao()" action="?folder=notes&file=sgaaes_ins_note&ext=php">
		<h4>OBS: Os campos que possuem asterisco são obrigatórios!</h4>
		Turma:<select name="selturma[]" id="selturma[]" onChange="mostraalunos()">
      <option value="">Escolha</option>
      <?php
        $sql_sel_turmas = "SELECT * FROM turmas ORDER BY nome_turma ASC";
        $sql_sel_turmas_resultado = $conexao->query($sql_sel_turmas);
        $nome_turma = "Todas as Turmas";
        while($sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array()){
          $modalidade = "";
          $periodo = "";
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
          <option value="<?php echo $sql_sel_turmas_dados['id'] ?>"><?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo ?></option>
      <?php

        }

       ?>
      </select>
      <h6 style="margin: 0px;">Só é possível alterar a turma com apenas um campo de aluno!</h6>
      <a href="#" class="adicionarCampo" title="Adicionar item"><img width="14" height="14" src="../../layout/images/mais.png"></a>
    <div class="linhas1"><p>*Aluno:
    <select name="selaluno[]" id="selaluno[]">
                <option value="">Selecione uma turma</option>
              </select>
      <a href="#" class="removerCampo" title="Remover linha"><img width="14" height="14" src="../../layout/images/menos.png"></a></p>
    </div>
  Turma:<select name="selturmaequipe[]" id="selturmaequipe[]" onChange="mostraequipes()">
      <option value="">Escolha</option>
      <?php
        $sql_sel_turmas = "SELECT * FROM turmas ORDER BY nome_turma ASC";
        $sql_sel_turmas_resultado = $conexao->query($sql_sel_turmas);
        $nome_turma = "Todas as Turmas";
        while($sql_sel_turmas_dados = $sql_sel_turmas_resultado->fetch_array()){
          $modalidade = "";
          $periodo = "";
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
          <option value="<?php echo $sql_sel_turmas_dados['id'] ?>"><?php echo $sql_sel_turmas_dados['nome_turma']." - ".$modalidade." - ".$periodo ?></option>
      <?php

        }

       ?>
      </select>
      <h6 style="margin: 0px;">Só é possível alterar a turma com apenas um campo de equipe!</h6>
      <a href="#" class="adicionarCampoequipe" title="Adicionar item"><img width="14" height="14" src="../../layout/images/mais.png"></a>
		<div class="linhas2"><p>*Equipe:
            <select name="selequipe[]" class="selequipe[]" maxlength="45">
                <option value="">Selecione uma turma</option>
            </select>
            	<a href="#" class="removerCampoequipe" title="Remover linha"><img width="14" height="14" src="../../layout/images/menos.png"></a></p>
            </div>
        </p>
		<p>*Classificação:
			<select name="selclassificacao">
				<option value="">Escolha</option>
				<option value="pos">Positiva</option>
				<option value="neg">Negativa</option>
				<option value="neu">Neutra</option>
			</select></p>
		<p>*Data:<input type="date" name="txtdata" placeholder="DD/MM/AAAA" onfocus="this.value='';"></p>
		<p>*Anotação:<textarea name="txaanotacao" rows="4" cols="22"></textarea></p>
		<p align="center"><button type="reset">Limpar</button><button type="submit">Registrar</button></p>
	</form>
</fieldset>
