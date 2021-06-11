<?php
  $g_id = $_GET['id'];
?>
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
 <?php
  $sql_sel_equipes = "SELECT nome_equipe FROM equipes WHERE id='".$g_id."'";
  $sql_sel_equipes_resultado = $conexao->query($sql_sel_equipes);
  $sql_sel_equipes_dados = $sql_sel_equipes_resultado->fetch_array();
?>
<fieldset style="min-width: 200px;">
  <legend>Alteração de Equipe</legend>
	<h4>OBS: Todos os campos com asterisco são obrigatórios!</h4>
  <form name="frmrgtequipe" method="post" onsubmit="return validaregistroequipe()" action="?folder=teams&file=sgaaes_upd_team&ext=php" enctype="multipart/form-data">
    <input type="hidden" name="hidid" value="<?php echo $g_id; ?>">
    <p>*Nome da Equipe:<input type="text" name="txtnomeequipe" value="<?php echo $sql_sel_equipes_dados['nome_equipe']?>" maxlength="45"></p>
    <p>Remover Aluno:<select name="selalunorem">

        <option value="" selected>Selecione um aluno...</option>
        <?php

          $sql_sel_alunos = "SELECT id, nome_aluno FROM alunos WHERE equipes_id='".$g_id."' ORDER BY nome_aluno ASC";
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
    <div class="linhas1" style="text-decoration:none;"><p>Aluno:
    <select name="selaluno[]" class="selaluno[]">
                <option value="">Selecione uma turma</option>
              </select>
      <a href="#" class="removerCampo" title="Remover linha"><img width="14" height="14" src="../../layout/images/menos.png"></a></p>
    </div>
        <p><center><a href="?folder=teams&file=sgaaes_fmins_team&ext=php"><button type="button">Retornar</button></a><button type="submit">Alterar</button></center></p>
  </form>
</fieldset>
