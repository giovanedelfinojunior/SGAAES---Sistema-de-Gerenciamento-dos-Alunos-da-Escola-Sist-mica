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
<fieldset style="margin-bottom: 10px;">
	<legend>Alteração de Anotação</legend>
	<?php

		$g_id = $_GET['id'];

		$sql_sel_anotacoes = "SELECT * FROM anotacoes WHERE id='".$g_id."'";
		$sql_sel_anotacoes_resultado = $conexao->query($sql_sel_anotacoes);
		$sql_sel_anotacoes_dados = $sql_sel_anotacoes_resultado->fetch_array();

	?>
	<form name="frmanotacao" method="post" action="?folder=notes&file=sgaaes_upd_note&ext=php">
		<input type="hidden" name="hidid" value="<?php echo $g_id;?>">
			<h4>OBS: Os campos que possuem asterisco são obrigatórios!</h4>
			<p>Remover Aluno:<select name="selalunorem">

              <option value="" selected>Selecione uma aluno...</option>
              <?php

              	$sql_sel_alunos = "SELECT id, nome_aluno
              							 FROM alunos
              							 INNER JOIN alunos_has_anotacoes ON(alunos_has_anotacoes.alunos_id = alunos.id)
              							 WHERE anotacoes_id='".$g_id."'
              							 ORDER BY nome_aluno ASC";
				$sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);

				while($sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array()){

		              	$id_aluno=$sql_sel_alunos_dados['id'];
		                $nome_aluno=$sql_sel_alunos_dados['nome_aluno'];

		                echo "
		                <option value='$id_aluno'>$nome_aluno</option>
		                ";
		        }
              ?>
            </select>
            </p>
			<p>Remover Equipe:<select name="selequiperem">

              <option value="" selected>Selecione uma equipe...</option>
              <?php

              	$sql_sel_equipes = "SELECT id, nome_equipe
              							 FROM equipes
              							 INNER JOIN equipes_has_anotacoes ON(equipes_has_anotacoes.equipes_id = equipes.id)
              							 WHERE anotacoes_id='".$g_id."'
              							 ORDER BY nome_equipe ASC";
				$sql_sel_equipes_resultado = $conexao->query($sql_sel_equipes);

				while($sql_sel_equipes_dados = $sql_sel_equipes_resultado->fetch_array()){

		              	$id_equipe=$sql_sel_equipes_dados['id'];
		                $nome_equipe=$sql_sel_equipes_dados['nome_equipe'];

		                echo "
		                <option value='$id_equipe'>$nome_equipe</option>
		                ";
		        }
              ?>
            </select>
            </p>
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
      <div class="linhas1"><p>Aluno:
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
      <div class="linhas2"><p>Equipe:
            <select name="selequipe[]" class="selequipe[]" maxlength="45">
                <option value="">Selecione uma turma</option>
            </select>
              <a href="#" class="removerCampoequipe" title="Remover linha"><img width="14" height="14" src="../../layout/images/menos.png"></a></p>
            </div>
     				<?php

					$selected1 = "";
					$selected2 = "";
					$selected3 = "";

					if($sql_sel_anotacoes_dados['classificacao'] == "pos"){

							$selected1 = "selected";

						}else if($sql_sel_anotacoes_dados['classificacao'] == "neg"){

							$selected2 = "selected";

						}else{

							$selected3 = "selected";

						}

				?>
				<p>Classificação:
					<select name="selclassificacao">
						<option value="pos" <?php echo $selected1; ?>>Positiva</option>
						<option value="neg" <?php echo $selected2; ?>>Negativa</option>
						<option value="neu" <?php echo $selected3; ?>>Neutra</option>
					</select></p>
				<p>*Data:
				<input type="date" name="txtdata" placeholder="DD/MM/AAAA" onfocus="this.value='';" value="<?php echo $sql_sel_anotacoes_dados['data_anotacao']; ?>"></p>
				<p>*Anotação:<textarea name="txaanotacao" rows="4" cols="22"><?php echo $sql_sel_anotacoes_dados['anotacao'] ?></textarea></p>
				<p><center><a href="?folder=managements&file=sgaaes_notes_management&ext=php"><button type="button">Retornar</button></a><button type="submit">Alterar</button></center></p>
	</form>
</fieldset>
