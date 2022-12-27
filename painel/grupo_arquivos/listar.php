<?php 
require_once("../../conexao.php");

echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM grupo_arquivos ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				 
				<th>Nome</th> 
				<th>Categoria</th> 
				<th class="esc">Setor</th>
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$categoria = $res[$i]['categoria'];
$setor = $res[$i]['setor'];

$query2 = $pdo->query("SELECT * FROM cat_arquivos where id = '$categoria'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cat = $res2[0]['nome'];
}

$query2 = $pdo->query("SELECT * FROM setor_arquivos where id = '$setor'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_setor = $res2[0]['nome'];
}
echo <<<HTML
			<tr> 
				<td>{$nome}</td> 
				<td>{$nome_cat}</td>
				<td class="esc">{$nome_setor}</td>
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$nome}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>
					<big><a href="#" onclick="excluir('{$id}', '{$nome}')" title="Excluir Item"><i class="fa fa-trash-o text-danger"></i></a></big>
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



	function editar(id, nome){
		$('#id').val(id);
		$('#nome').val(nome);			
			
		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');
	}

</script>



