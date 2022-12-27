<?php 
require_once("../../conexao.php");

echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM frequencias ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 
				
				<th>Frequência</th> 
				<th>Dias</th> 
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$frequencia = $res[$i]['frequencia'];
$dias = $res[$i]['dias'];
echo <<<HTML
			<tr> 
				 
				<td>{$frequencia}</td>
				<td>{$dias}</td>
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$frequencia}', '{$dias}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>
					<big><a href="#" onclick="excluir('{$id}', '{$frequencia}')" title="Excluir Item"><i class="fa fa-trash-o text-danger"></i></a></big>
				</td>  
			</tr> 
HTML;
}
echo <<<HTML
		</tbody> 
	</table>
</small>
HTML;
}else{
	echo 'Não possui nenhum registro cadastrado!';
}

?>


<script type="text/javascript">


	$(document).ready( function () {
	    $('#tabela').DataTable({
	    	"ordering": false,
	    	"stateSave": true,
	    });
	    $('#tabela_filter label input').focus();
	} );



	function editar(id, frequencia, dias){
		$('#id').val(id);
		$('#frequencia').val(frequencia);
		$('#dias').val(dias);			
			
		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
	}

	function limparCampos(){
		$('#id').val('');
		$('#frequencia').val('');
		$('#dias').val('');
	}

</script>



