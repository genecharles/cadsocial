<?php 
require_once("../../conexao.php");
$id_setor = @$_POST['setor'];

$query = $pdo->query("SELECT * FROM cat_arquivos where setor = '$id_setor' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<select class="form-control sel2" name="categoria" id="categoria" required style="width:100%;"> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}

echo <<<HTML
			<option value="{$res[$i]['id']}">{$res[$i]['nome']}</option>
HTML;
}
echo <<<HTML
		</select> 
	
HTML;
}
?>




<style type="text/css">
	.sel2 {
		line-height: 36px !important;
		font-size:16px !important;
		color:#666666 !important;

	}
	
</style>  


