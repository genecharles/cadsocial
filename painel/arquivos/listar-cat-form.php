<?php 
require_once("../../conexao.php");
$id_setor = @$_POST['setor'];
$id_cat = @$_POST['cat'];

$query = $pdo->query("SELECT * FROM cat_arquivos where setor = '$id_setor' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

echo <<<HTML
	<select class="form-control sel2" name="categoria" id="categoria" style="width:100%;"> 
	<option value="">Sem Categoria</option>
HTML;
if($total_reg > 0){
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


<script type="text/javascript">
	$(document).ready(function() {			

			$('#categoria').change(function(){
				listarGruposForm();
			});

			if('<?=$id_cat?>' != "" && '<?=$id_cat?>' != 0  && '<?=$id_cat?>' != 1){
				$('#categoria').val('<?=$id_cat?>').change();
			}else{
				$('#categoria').val('').change();
			}

		});
</script>

<style type="text/css">
	.sel2 {
		line-height: 36px !important;
		font-size:16px !important;
		color:#666666 !important;

	}
	
</style>  


