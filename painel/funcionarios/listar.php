<?php 
require_once("../../conexao.php");
$data_atual = date('Y-m-d');
echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM funcionarios ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				
				<th>Nome</th>
				<th class="esc">Telefone</th> 
				<th class="esc">CPF</th> 
				<th class="esc">Email</th>
				<th class="esc">Cargo</th>				
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$telefone = $res[$i]['telefone'];
$cpf = $res[$i]['cpf'];
$email = $res[$i]['email'];
$endereco = $res[$i]['endereco'];
$cargo = $res[$i]['cargo'];
$data_cad = $res[$i]['data_cad'];
$data_nasc = $res[$i]['data_nasc'];
$obs = $res[$i]['obs'];
$foto = $res[$i]['foto'];
$ativo = $res[$i]['ativo'];

//retirar quebra de texto do obs
$obs = str_replace(array("\n", "\r"), ' + ', $obs);

$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));
$data_nascF = implode('/', array_reverse(explode('-', $data_nasc)));
//$salarioF = number_format($salario, 2, ',', '.');
//$valor_horaF = number_format($valor_hora, 2, ',', '.');

$query2 = $pdo->query("SELECT * FROM cargos where id = '$cargo'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cargo = $res2[0]['nome'];
}else{
	$nome_cargo = 'Sem Cargo';
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
				<td>
				<img src="images/perfil/{$foto}" width="27px" class="mr-2">
				{$nome}
				</td> 
				<td class="esc">{$telefone}</td>
				<td class="esc">{$cpf}</td>
				<td class="esc">{$email}</td>
				<td class="esc">{$nome_cargo}</td>
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$nome}', '{$cpf}','{$telefone}','{$email}','{$endereco}','{$cargo}','{$data_nasc}','{$obs}','{$foto}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

					<big><a href="#" onclick="mostrar('{$id}', '{$nome}', '{$cpf}','{$telefone}','{$email}','{$endereco}','{$nome_cargo}','{$data_cadF}','{$data_nascF}','{$obs}','{$foto}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

					<big><a href="#" onclick="excluir('{$id}', '{$nome}')" title="Excluir Item"><i class="fa fa-trash-o text-danger"></i></a></big>

					<big><a href="#" onclick="arquivo('{$id}', '{$nome}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " style="color:#22146e"></i></a></big>

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



	function editar(id, nome, cpf, telefone, email, endereco, cargo, data_nasc, obs, foto){

		for (let letra of obs){  				
					if (letra === '+'){
						obs = obs.replace(' +  + ', '\n')
					}			
				}


		$('#id').val(id);
		$('#nome').val(nome);
		$('#cpf').val(cpf);
		$('#telefone').val(telefone);
		$('#email').val(email);
		$('#endereco').val(endereco);
		$('#cargo').val(cargo).change();		
		$('#data_nasc').val(data_nasc);	
		$('#obs').val(obs);		

		$('#foto').val('');
		$('#target').attr('src','images/perfil/' + foto);	

		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
	}



	function mostrar(id, nome, cpf, telefone, email, endereco, cargo, data_cad, data_nasc, obs, foto){

		for (let letra of obs){  				
					if (letra === '+'){
						obs = obs.replace(' +  + ', '\n')
					}			
				}
		
		$('#nome_mostrar').text(nome);
		$('#cpf_mostrar').text(cpf);
		$('#telefone_mostrar').text(telefone);
		$('#email_mostrar').text(email);
		$('#endereco_mostrar').text(endereco);
		$('#cargo_mostrar').text(cargo);		
		$('#data_nasc_mostrar').text(data_nasc);	
		$('#data_cad_mostrar').text(data_cad);	
		$('#obs_mostrar').text(obs);		
		
		$('#target_mostrar').attr('src','images/perfil/' + foto);	

		$('#modalMostrar').modal('show');		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');		
		$('#cpf').val('');
		$('#telefone').val('');
		$('#email').val('');
		$('#endereco').val('');			
		$('#data_nasc').val('<?=$data_atual?>');	
		$('#obs').val('');		
		$('#foto').val('');
		$('#target').attr('src','images/perfil/sem-perfil.jpg');
	}


	function arquivo(id, nome){
    $('#id-arquivo').val(id);    
    $('#nome-arquivo').text(nome);
    $('#modalArquivos').modal('show');
    $('#mensagem-arquivo').text(''); 
    listarArquivos();   
}

</script>



