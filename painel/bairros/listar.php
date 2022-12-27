<?php 
require_once("../../conexao.php");

echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM bairros ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 
				<th>ID</th> 
				<th>Bairro</th>
				<th>Cidade</th> 
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$cidade = $res[$i]['cidade'];
$ativo = $res[$i]['ativo'];


$query2 = $pdo->query("SELECT * FROM cidades where id = '$cidade'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cidade = $res2[0]['nome'];
}else{
	$nome_cidade = 'Sem Cargo';
}

if($ativo == 'Sim'){
		$icone = 'fa-check-square';
		$titulo_link = 'Desativar Item';
		$acao = 'Não';
		$classe_linha = '';
	}else{
		$icone = 'fa-square-o';
		$titulo_link = 'Ativar Item';
		$acao = 'Sim';
		$classe_linha = 'text-muted';
	}

echo <<<HTML
			<tr class="{$classe_linha}"> 
				<td>{$id}</td> 
				<td>{$nome}</td>
				<td class="esc">{$nome_cidade}</td>
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$nome}', '{$cidade}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>
					<big><a href="#" onclick="excluir('{$id}', '{$nome}')" title="Excluir Item"><i class="fa fa-trash-o text-danger"></i></a></big>
					<big><a href="#" onclick="ativar('{$id}', '{$nome}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>
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



	function editar(id, nome, cidade){
		$('#id').val(id);
		$('#nome').val(nome);
		$('#cidade').val(cidade).change();			
			
		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');
		$('#cidade').val('');
	}

</script>



