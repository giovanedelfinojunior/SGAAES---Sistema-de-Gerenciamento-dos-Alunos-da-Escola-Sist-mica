<?php
/*Declarando as variaveis e Recebendo dados do formulário*/
addslashes ($p_motivo = $_POST['txtmotivo']);
$p_descricao = $_POST['txadescricao'];
$p_id = $_POST['hidid'];
$msg="";
$img="warning.png";
$url_retorno="?folder=reasons&file=sgaaes_fmupd_reason&ext=php&id=$p_id";
/*-----*/
/*Fazendo Validação dos campos e verificando se o cadastro ja existe.*/
if (str_replace(' ', '', $p_motivo) == ""){
  $msg = "O campo motivo deve ser preenchido!";
}else{
  $sql_sel_motivos = "SELECT motivo FROM motivos WHERE motivo = '".$p_motivo."' AND id <> '".$p_id."'";
  $sql_sel_motivos_resultado = $conexao->query($sql_sel_motivos);
  if($sql_sel_motivos_resultado->num_rows >0){
    $msg = "Este motivo já está cadastrado! ";
/*-----*/
/*Fazendo a Atuaçozação dos dados do banco pelos dados que foram recebidos*/
  }else{
    $tabela = "motivos";
    $dados = array(
      'motivo' => $p_motivo,
      'descricao' => $p_descricao
    );
    $condicao = "id = '".$p_id."'";
    $resultado = atualizar($tabela,$dados,$condicao);
/*-----*/
/*Verificando o retorno do arquivo de operações do banco de dados e preenchendo as variaveis de mensagens,imagem e url de retorno.*/
    if($resultado){
      $id = '1';
      $operacao ='Atualização';
      $o_que  ='motivo';
      $msg = mensagens($id,$operacao,$o_que);
      $img = "ok.png";
      $url_retorno = "?folder=reasons&file=sgaaes_fmins_reason&ext=php";
    }else{
      $id = '2';
      $operacao ='Atualização';
      $o_que  ='motivo';
      $msg = mensagens($id,$operacao,$o_que);

    }
  }

}
$conexao->close();/*Finalizando a conexão com o banco de dados.*/
 ?>
 <div id="title"></div>
  <div id="mensagens">
    Aviso
    <img src = "../../layout/images/<?php echo $img; ?>">
    <?php echo $msg;?>
  </div>
  <a class="retornar" href="<?php echo $url_retorno;  ?>">Retornar</a>
