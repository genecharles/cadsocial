<?php 
require_once("../../conexao.php");
$data_atual = date('Y-m-d');
echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM clientes ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				
				<th>Nome</th>
				<th class="esc">Pessoa</th> 
				<th class="esc">Documento</th>
				<th class="esc">Telefone</th> 
				<th class="esc">Email</th>						
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
$doc = $res[$i]['doc'];
$email = $res[$i]['email'];
$endereco = $res[$i]['endereco'];
$pessoa = $res[$i]['pessoa'];
$data_cad = $res[$i]['data_cad'];
$data_nasc = $res[$i]['data_nasc'];
$obs = $res[$i]['obs'];
$ativo = $res[$i]['ativo'];

//retirar quebra de texto do obs
$obs = str_replace(array("\n", "\r"), ' + ', $obs);

$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));
$data_nascF = implode('/', array_reverse(explode('-', $data_nasc)));


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
				<td>{$nome}</td> 
				<td class="esc">{$pessoa}</td>
				<td class="esc">{$doc}</td>
				<td class="esc">{$telefone}</td>
				<td class="esc">{$email}</td>
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$nome}', '{$pessoa}','{$doc}','{$telefone}','{$email}','{$data_nasc}','{$endereco}','{$obs}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

					<big><a href="#" onclick="mostrar('{$id}', '{$nome}', '{$pessoa}','{$doc}','{$telefone}','{$email}','{$endereco}','{$data_cadF}','{$data_nascF}','{$obs}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

					<big><a href="#" onclick="excluir('{$id}', '{$nome}')" title="Excluir Item"><i class="fa fa-trash-o text-danger"></i></a></big>

					<big><a href="#" onclick="ativar('{$id}', '{$nome}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>

					<big><a href="#" onclick="arquivo('{$id}', '{$nome}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " style="color:#22146e"></i></a></big>
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



	function editar(id, nome, pessoa, doc, telefone, email, data_nasc, endereco, obs){

		for (let letra of obs){  				
					if (letra === '+'){
						obs = obs.replace(' +  + ', '\n')
					}			
				}


		$('#id').val(id);
		$('#nome').val(nome);
		$('#pessoa').val(pessoa).change();
		$('#doc').val(doc);
		$('#telefone').val(telefone);
		$('#email').val(email);
		$('#endereco').val(endereco);				
		$('#data_nasc').val(data_nasc);	
		$('#obs').val(obs);	

		

		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
	}



	function mostrar(id, nome, pessoa, doc, telefone, email, endereco, data_cad, data_nasc, obs){

		for (let letra of obs){  				
					if (letra === '+'){
						obs = obs.replace(' +  + ', '\n')
					}			
				}

		if(data_nasc == '00/00/0000'){
			document.getElementById('div_data_nasc_mostrar').style.display = 'none';
		}else{
			document.getElementById('div_data_nasc_mostrar').style.display = 'block';
		}
		
		$('#nome_mostrar').text(nome);
		$('#pessoa_mostrar').text(pessoa);
		$('#doc_mostrar').text(doc);
		$('#telefone_mostrar').text(telefone);
		$('#email_mostrar').text(email);
		$('#endereco_mostrar').text(endereco);
		$('#data_nasc_mostrar').text(data_nasc);	
		$('#data_cad_mostrar').text(data_cad);	
		$('#obs_mostrar').text(obs);
		
		
		$('#modalMostrar').modal('show');		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');		
		$('#doc').val('');
		$('#telefone').val('');
		$('#email').val('');
		$('#endereco').val('');			
		$('#data_nasc').val('<?=$data_atual?>');	
		$('#obs').val('');	
		
	}

	function arquivo(id, nome){
    $('#id-arquivo').val(id);    
    $('#nome-arquivo').text(nome);
    $('#modalArquivos').modal('show');
    $('#mensagem-arquivo').text(''); 
    listarArquivos();   
}

</script>



