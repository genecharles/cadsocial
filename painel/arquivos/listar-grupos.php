<?php 
require_once("../../conexao.php");
$id_cat = @$_POST['cat'];

$query = $pdo->query("SELECT * FROM grupo_arquivos where categoria = '$id_cat' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

echo <<<HTML
	<select class="form-control sel2" name="grupo-busca" id="grupo-busca" style="width:100%;"> 
	<option value="">Sem Grupo</option>
HTML;
if($total_reg > 0){
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}

echo <<<HTML
			<option value="{$res[$i]['id']}">{$res[$i]['nome']}</option>
HTML;
}

}
echo <<<HTML
		
		</select> 	
HTML;

?>


<script type="text/javascript">
	$(document).ready(function() {			

			$('#grupo-busca').change(function(){				
				listar();
			});

		});

</script>

<style type="text/css">
	.sel2 {
		line-height: 36px !important;
		font-size:16px !important;
		color:#666666 !important;

	}
	
</style>  


