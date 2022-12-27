<?php 
require_once("../../conexao.php");

echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM estado ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 
				<th>ID</th> 
				<th>Estado</th>
				<th>UF</th>
				<th>País</th> 
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$uf = $res[$i]['uf'];
$pais = $res[$i]['pais'];


$query2 = $pdo->query("SELECT * FROM paises where id = '$pais'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_pais = $res2[0]['nome'];
}else{
	$nome_pais = 'Sem Cargo';
}



echo <<<HTML
			<tr"> 
				<td>{$id}</td> 
				<td>{$nome}</td>
				<td>{$uf}</td>
				<td class="esc">{$nome_pais}</td>
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$nome}', '{$uf}', '{$pais}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>
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



	function editar(id, nome, uf, pais){
		$('#id').val(id);
		$('#nome').val(nome);
		$('#uf').val(uf);
		$('#pais').val(pais).change();			
			
		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');
		$('#uf').val('');
		$('#pais').val('');
	}

</script>



