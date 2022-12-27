<?php 
require_once("../../conexao.php");
@session_start();
$id_usu = @$_SESSION['id_usuario'];
$data_atual = date('Y-m-d');
echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM tarefas ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				
				<th>Título</th>
				<th>Hora</th> 
				<th class="esc">Data</th>
				<th class="esc">Usuário</th>
				<th class="esc">Lançado Por</th>
				<th class="esc">Status</th>									
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$titulo = $res[$i]['titulo'];
$descricao = $res[$i]['descricao'];
$hora = $res[$i]['hora'];
$data = $res[$i]['data'];
$usuario = $res[$i]['usuario'];
$usuario_lanc = $res[$i]['usuario_lanc'];
$status = $res[$i]['status'];
$obs = $res[$i]['obs'];


$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", strtotime($hora));


if($status == 'Concluída'){
	$icone = 'fa-check-square';
	$titulo_link = 'Cancelar Conclusão';
	$acao = 'Agendada';
	$classe_linha = '';
}else{
	$icone = 'fa-square-o';
	$titulo_link = 'Concluir Tarefa';
	$acao = 'Concluída';
	$classe_linha = 'text-muted';
}



if($status == 'Agendada'){
	$icone_square = 'text-danger';	
}else{
	$icone_square = 'verde';
}

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu = $res2[0]['nome'];
}else{
	$nome_usu = 'Sem Usuário';
}


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_lanc = $res2[0]['nome'];
}else{
	$nome_usu_lanc = 'Sem Usuário';
}


//retirar aspas do texto do obs
$obs = str_replace('"', "**", $obs);

echo <<<HTML
			<tr> 
				<td><i class="fa fa-square {$icone_square} mr-1"></i> {$titulo}</td> 
				<td >{$horaF}</td>
				<td class="esc">{$dataF}</td>
				<td class="esc">{$nome_usu}</td>
				<td class="esc">{$nome_usu_lanc}</td>
				<td class="esc">{$status}</td>
				
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$titulo}', '{$descricao}','{$hora}','{$data}','{$obs}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

					<big><a href="#" onclick="mostrar('{$id}', '{$titulo}', '{$descricao}','{$horaF}','{$dataF}','{$nome_usu}', '{$nome_usu_lanc}', '{$status}','{$obs}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

					<big><a href="#" onclick="excluir('{$id}', '{$titulo}')" title="Excluir Item"><i class="fa fa-trash-o text-danger"></i></a></big>


					<big><a href="#" onclick="ativar('{$id}', '{$titulo}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>
					
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



	function editar(id, titulo, descricao, hora, data, obs){

		for (let letra of obs){  				
			if (letra === '*'){
				obs = obs.replace('**', '"');
			}			
		}


		$('#id').val(id);
		$('#titulo').val(titulo);
		$('#descricao').val(descricao);
		$('#hora').val(hora);
		$('#data').val(data);
		nicEditors.findEditor("area").setContent(obs);	
				

		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
	}



	function mostrar(id, titulo, descricao, hora, data, usuario, usuario_lanc, status, obs){

		for (let letra of obs){  				
			if (letra === '*'){
				obs = obs.replace('**', '"');
			}			
		}

				
		$('#nome_mostrar').text(titulo);
		$('#descricao_mostrar').text(descricao);
		$('#hora_mostrar').text(hora);
		$('#data_mostrar').text(data);
		$('#usuario_mostrar').text(usuario);
		$('#usuario_lanc_mostrar').text(usuario_lanc);
		$('#status_mostrar').text(status);		
		
		$("#obs_mostrar").html(obs);
		
		
		$('#modalMostrar').modal('show');		
	}

	function limparCampos(){
		$('#id').val('');
		$('#titulo').val('');		
		$('#descricao').val('');
		$('#hora').val('');				
		$('#data').val('<?=$data_atual?>');	
		nicEditors.findEditor("area").setContent('');	
		
	}

</script>



