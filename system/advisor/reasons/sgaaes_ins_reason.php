<?php
  $p_motivo = $_POST['txtmotivo'];
  $p_descricao = $_POST['txadescricao'];
  $img = "warning.png";
  $msg = "";


$validar = str_replace(' ', '', $p_motivo);
addslashes($p_motivo);
  if($validar == ""){
    $msg = "O campo motivo deve ser preenchido!";
  }else{
    $sql_sel_motivos = "SELECT motivo FROM motivos WHERE motivo = '".$p_motivo."' ";
    $sql_sel_motivos_resultado = $conexao->query($sql_sel_motivos);
    if($sql_sel_motivos_resultado->num_rows>0){
      $msg = "Este motivo já está cadastrado!";
    }else{
        $tabela = 'motivos';
        $dados = array(
                'motivo'=>$p_motivo,
                'descricao'=>$p_descricao
              );
        $resultado = adicionar($tabela,$dados);
        if ($resultado){
          $id = '1';
          $operacao ='Inserção';
          $o_que  ='motivo';
          $msg = mensagens($id,$operacao,$o_que);
          $img = "ok.png";
        }else {
          $id = '2';
          $operacao ='Inserção';
          $o_que  ='motivo';
          $msg = mensagens($id,$operacao,$o_que);
        }
    }
}
$conexao->close();
 ?>
 <div id="title"></div>
  <div id="mensagens">
    Aviso
    <img src = "../../layout/images/<?php echo $img; ?>">
    <?php echo $msg?>
</div>
  <a class="retornar" href="?folder=reasons&file=sgaaes_fmins_reason&ext=php">Retornar</a>
