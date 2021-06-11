<?php
$g_id = $_GET['id'];
$msg = "";
$img ="warning.png";
$tabela = "motivos";
$condicao = "id = '".$g_id."'";
$resultado = deletar($tabela,$condicao);
if ($resultado){
  $id = '1';
  $operacao ='Exclusão';
  $o_que  ='motivo';
  $msg = mensagens($id,$operacao,$o_que);
  $img = "ok.png";
  }else{
    $id = '2';
    $operacao ='Exclusão';
    $o_que  ='motivo';
    $msg = mensagens($id,$operacao,$o_que);
  }
$conexao->close();
 ?>
 <div id="title"></div>
  <div id="mensagens">
    Aviso
    <img src = "../../layout/images/<?php echo $img; ?>">
    <?php echo $msg;?>
  </div>
  <a class="retornar" href="?folder=reasons&file=sgaaes_fmins_reason&ext=php">Retornar</a>
