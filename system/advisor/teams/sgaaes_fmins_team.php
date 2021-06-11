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

    function valoresAntigos (){
      //recebe todas as posições do campo selcategoria[] e salva na variável categorias
      var turmas = document.getElementsByName('selturma[]');
      //da posição 0 até a posição final do array...
      for (var i=0;i<turmas.length;i++){
        //...captura e salva o valor atual do campo selcategoria no array criado no carregamento da página para os valores antigos
        turmaAntigo[i] = turmas[i].value;
      }
    }

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
    function(busca){
      //repassa o que foi encontrado na busca ao select de produtos correspondente ao de categorias qe foi modificado os produtos encontrados
      $(alunoMudar[atual]).html(busca);
      //chama a função valoresAntigos para guardar os valores atuais das categorias como antigos
      valoresAntigos();
      //fecha a função busca e o processo do post
    });
    //fecha a função mostraprodutos
    }
  //função de validação dos campos do mestre detalhe
    function validaDetalhe(){
    //recebe os valores das categorias preenchidas
    var turmasValidar = document.getElementsByName('selturma[]');
    //recebe os valores dos produtos preenchidos
    var alunosValidar = document.getElementsByName('selaluno[]');
    //estrutura para-faça para repetir a validação enquanto i for menor que o tamanho do array, sendo que i começa de 0 e tem incremento 1
    for (var i = 0;i < turmasValidar.length; i++){
      //cria a variável linha com valor de "i mais um" para a mensagem avisar corretamente qual campo não foi preenchido
      var linha = i+1;
      //se a posição atual dos arrays de categoria e/ou produto estiverem vazios,
      if ((turmasValidar[i].value=="")||(alunosValidar[i].value=="")){
      alert ("A linha "+linha+" não foi completamente preenchida.");
      return false;
      }
    }

    }
 </script>
<fieldset style="min-width: 200px;">
  <legend>Registro de Equipe</legend>
  <h4>OBS:todos os campos são obrigatórios</h4>
  <form name="frmrgtequipe" method="post" onsubmit="return validaregistroequipe()" action="?folder=teams&file=sgaaes_ins_team&ext=php" enctype="multipart/form-data">
    <p>Nome da Equipe:<input type="text" name="txtnomeequipe" maxlength="45"></p>
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
      <div class="linhas1" style="text-decoration:none;"><p>Nome do Aluno:
    <select name="selaluno[]" class="selaluno[]">
                <option value="">Selecione uma turma</option>
              </select>
      <a href="#" class="removerCampo" title="Remover linha"><img width="14" height="14" src="../../layout/images/menos.png"></a></p>
    </div>
        <p><center><button type="reset">Limpar</button><button type="submit">Registrar</button></center></p>
  </form>
</fieldset>
<fieldset style="width: 600px;margin-top:20px;margin-bottom: 10px;">
<legend>Equipes Registradas</legend>
<table border="1">
  <thead>
    <tr>
      <th width="40%">
        Nome da Equipe
      </th>
      <th width="20%">
        Alunos
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

      $sql_sel_equipes = "SELECT * FROM equipes";
      $sql_sel_equipes_resultado = $conexao->query($sql_sel_equipes);

      if($sql_sel_equipes_resultado->num_rows == 0){
    ?>
    <tr>
      <td colspan="5">Nenhuma Equipe Registrada</td>
    </tr>
    <?php
      }else{

        while($sql_sel_equipes_dados=$sql_sel_equipes_resultado->fetch_array()){
    ?>
          <tr>
            <td><?php echo  $sql_sel_equipes_dados['nome_equipe']; ?></td>
            <td><?php

            $sql_sel_alunos = "SELECT alunos.nome_aluno FROM alunos WHERE equipes_id = '".$sql_sel_equipes_dados['id']."'";
            $sql_sel_alunos_resultado = $conexao->query($sql_sel_alunos);
            $alunos = "";
            while($sql_sel_alunos_dados = $sql_sel_alunos_resultado->fetch_array()){
              $alunos .= $sql_sel_alunos_dados['nome_aluno'].", ";
            }
            $alunos = substr($alunos, 0, -2);
            echo $alunos;
            ?>
            </td>
            <td><a href="?folder=teams&file=sgaaes_fmupd_team&ext=php&id=<?php echo $sql_sel_equipes_dados['id']; ?>" title="Alterar registro"><img src="../../layout/images/edit.png"></td>
            <td width="10%"><a onClick="return deletar('equipe','<?php echo $sql_sel_alunos_dados['nome_equipe'] ?>')" href="?folder=teams&file=sgaaes_del_team&ext=php&id=<?php echo $sql_sel_equipes_dados['id']; ?>" title="Excluir registro"><img src="../../layout/images/delete.png"></a></td>
          </tr>
          <?php
              }
            }
          ?>
  </tbody>
</table>
</fieldset>
