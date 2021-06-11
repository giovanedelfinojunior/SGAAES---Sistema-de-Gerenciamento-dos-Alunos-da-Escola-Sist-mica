<?php
	$g_id=$_GET['id'];
	
	$msg="";
	$imagem="";
	
	$tabela="ajustes_de_ponto";
	$condicao=" id='".$g_id."' ";
	

	$resultado = deletar ($tabela, $condicao);
	
	if($resultado){
		$msg=mensagens(1,"Exclusão","solicitação de ajuste de ponto");
		$imagem="ok.png";
	}else {
			$msg=mensagens(2,"Exclusão","solicitação de ajuste de ponto");
		}
		
?>
<div id="mensagens">
	Aviso
	<img src="../../layout/images/<?php echo $imagem; ?>">
	<p><?php echo $msg;  ?></p>
</div>
<a href="?folder=requests_point&file=sgaaes_fmins_requestpoint&ext=php" class="retornar">Retornar</a>
<?php	
$conexao->close(); 
?>