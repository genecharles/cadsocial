<?php 
require_once("../../conexao.php");
@session_start();
$nivel_usu = @$_SESSION['nivel_usuario'];
$data_atual = date('Y-m-d');
echo <<<HTML
<small>
HTML;

if($nivel_usu == 'Gerente'){
	$query = $pdo->query("SELECT * FROM usuarios where nivel != 'Gerente' and nivel != 'Administrador' ORDER BY id desc");
}else if($nivel_usu == 'Administrador'){
	$query = $pdo->query("SELECT * FROM usuarios  ORDER BY id desc");	
}else{
	$query = $pdo->query("SELECT * FROM usuarios where nivel = 'Nenhum'");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				
				<th>Nome</th>
				<th class="esc">CPF</th> 
				<th class="esc">Email</th> 
				<th class="esc">Senha</th>
				<th class="esc">Nível</th>				
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$cpf = $res[$i]['cpf'];
$email = $res[$i]['email'];
$nivel = $res[$i]['nivel'];
$senha = $res[$i]['senha'];
$foto = $res[$i]['foto'];
$ativo = $res[$i]['ativo'];

if($ativo == 'Sim'){			
	$classe_linha = '';
}else{			
	$classe_linha = 'text-muted';
}


echo <<<HTML
			<tr class="{$classe_linha}"> 
				<td>
				<img src="images/perfil/{$foto}" width="27px" class="mr-2">
				{$nome}
				</td> 
				<td class="esc">{$cpf}</td>
				<td class="esc">{$email}</td>
				<td class="esc">{$senha}</td>
				<td class="esc">{$nivel}</td>
				<td>
				
					<big><a href="#" onclick="mostrar('{$id}', '{$nome}', '{$cpf}','{$email}','{$senha}','{$nivel}','{$foto}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

					
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



	
	function mostrar(id, nome, cpf, email, senha, nivel, foto){
		
		
		$('#nome_mostrar').text(nome);
		$('#cpf_mostrar').text(cpf);
		$('#email_mostrar').text(email);
		$('#senha_mostrar').text(senha);
		$('#cargo_mostrar').text(nivel);
		
		$('#target_mostrar').attr('src','images/perfil/' + foto);	

		$('#modalMostrar').modal('show');		
	}

	

</script>



