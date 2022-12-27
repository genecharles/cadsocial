<?php 
require_once("../../conexao.php");
$data_atual = date('Y-m-d');
echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM logs ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 
				<th >Tabela</th> 
				<th >Ação</th>				
				<th class="esc">Data</th>
				<th class="esc">Hora</th>				
				<th class="esc">Usuário</th>
				<th class="esc">ID Reg</th>
				<th class="esc">Descrição</th>				
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$tabela = $res[$i]['tabela'];
$acao = $res[$i]['acao'];
$data = $res[$i]['data'];
$hora = $res[$i]['hora'];
$usuario = $res[$i]['usuario'];
$id_reg = $res[$i]['id_reg'];
$descricao = $res[$i]['descricao'];


$dataF = implode('/', array_reverse(explode('-', $data)));

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu = $res2[0]['nome'];
}else{
	$nome_usu = 'Sem Usuário';
}


echo <<<HTML
			<tr> 
				<td>{$tabela}</td> 
				<td>{$acao}</td>
				<td class="esc">{$dataF}</td>
				<td class="esc">{$hora}</td>
				<td class="esc">{$nome_usu}</td>
				<td class="esc">{$id_reg}</td>
				<td class="esc">{$descricao}</td>
				<td>
					
					<big><a href="#" onclick="mostrar('{$id}', '{$tabela}', '{$acao}','{$dataF}','{$hora}','{$nome_usu}','{$id_reg}','{$descricao}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

					
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



	

	function mostrar(id, tabela, acao, data, hora, usuario, id_reg, descricao){		
		
		$('#nome_mostrar').text(tabela);
		$('#acao_mostrar').text(acao);
		$('#data_mostrar').text(data);
		$('#hora_mostrar').text(hora);
		$('#usuario_mostrar').text(usuario);
		$('#id_reg_mostrar').text(id_reg);		
		$('#descricao_mostrar').text(descricao);			

		$('#modalMostrar').modal('show');		
	}

	

</script>



