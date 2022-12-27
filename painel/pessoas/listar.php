<?php 
require_once("../../conexao.php");
$data_atual = date('Y-m-d');
echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM pessoas WHERE titular = 1 ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				
				<th>Nome</th>
				<th class="esc">CPF</th> 
				<th class="esc">Data Nasc</th>
				<th class="esc">Telefone</th> 
				<th class="esc">Bairro</th>						
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$nomesocial = $res[$i]['nomesocial'];
$sexo = $res[$i]['sexo'];
$racacor = $res[$i]['racacor'];
$etnia = $res[$i]['etnia'];
$titular = $res[$i]['titular'];
$codfam = $res[$i]['codfam'];
$cpf = $res[$i]['cpf'];
$tipodoc = $res[$i]['tipodoc'];
$docnum = $res[$i]['docnum'];
$docorgao = $res[$i]['docorgao'];
$docexpedicao = $res[$i]['docexpedicao'];
$religiao = $res[$i]['religiao'];
$pai = $res[$i]['pai'];
$mae = $res[$i]['mae'];
$datanasc = $res[$i]['datanasc'];
$reservista = $res[$i]['reservista'];
$clt = $res[$i]['clt'];
$cartaosus = $res[$i]['cartaosus'];
$cartaovacina = $res[$i]['cartaovacina'];
$telefone = $res[$i]['telefone'];
$cidade = $res[$i]['cidade'];
$bairro = $res[$i]['bairro'];
$endereco = $res[$i]['endereco'];
$parentesco = $res[$i]['parentesco'];
$data_cad = $res[$i]['data_cad'];
$hora_cad = $res[$i]['hora_cad'];
$id_usr_resp = $res[$i]['id_usr_resp'];
$ativo = $res[$i]['ativo'];

//retirar quebra de texto do obs
//$obs = str_replace(array("\n", "\r"), ' + ', $obs);

$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));
$data_nascF = implode('/', array_reverse(explode('-', $datanasc)));


$query2 = $pdo->query("SELECT * FROM cidades where id = '$cidade'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cidade = $res2[0]['nome'];
}else{
	$nome_cidade = 'Sem Registro';
}

$query2 = $pdo->query("SELECT * FROM bairros where id = '$bairro'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_bairro = $res2[0]['nome'];
}else{
	$nome_bairro = 'Sem Bairro';
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
				<td>{$nome}</td> 
				<td class="esc">{$cpf}</td>
				<td class="esc">{$data_nascF}</td>
				<td class="esc">{$telefone}</td>
				<td class="esc">{$nome_bairro}</td>
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$nome}', '{$nomesocial}', '{$sexo}','{$racacor}','{$etnia}','{$titular}','{$codfam}','{$cpf}','{$tipodoc}','{$docnum}','{$docorgao}','{$docexpedicao}','{$religiao}','{$pai}','{$mae}','{$datanasc}','{$reservista}','{$clt}','{$cartaosus}','{$cartaovacina}','{$telefone}','{$cidade}','{$bairro}','{$endereco}','{$id_usr_resp}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

					<a href="#" onclick="depend('{$id}', '{$nome}')" title="Inserir Dependentes"><i class="fa fa-users" style="color:#22146e"></i></a>

					<a href="#" onclick="arquivo('{$id}', '{$nome}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " style="color:#22146e"></i></a>

					<big><a href="#" onclick="mostrar('{$id}', '{$nome}', '{$nomesocial}', '{$sexo}','{$racacor}','{$etnia}','{$titular}','{$cpf}','{$tipodoc}','{$docnum}','{$docorgao}','{$docexpedicao}','{$religiao}','{$pai}','{$mae}','{$data_nascF}','{$reservista}','{$clt}','{$cartaosus}','{$cartaovacina}','{$telefone}','{$data_cadF}','{$hora_cad}','{$id_usr_resp}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

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



	function editar(id, nome, nomesocial, sexo, racacor, etnia, titular, codfam, cpf, tipodoc, docnum, docorgao, docexpedicao, religiao, pai, mae, datanasc, reservista, clt, cartaosus, cartaovacina, telefone, cidade, bairro, endereco, id_usr_resp){


		$('#id').val(id);
		$('#nome').val(nome);
		$('#nomesocial').val(nomesocial);
		$('#sexo').val(sexo);
		$('#racacor').val(racacor);	
		$('#etnia').val(etnia).change();
		$('#titular').val(titular);// verificar essa situação do titular como vai ficar
		$('#codfam').val(codfam);
		$('#cpf').val(cpf);
		$('#tipodoc').val(tipodoc);
		$('#docnum').val(docnum);
		$('#docorgao').val(docorgao);
		$('#docexpedicao').val(docexpedicao);
		$('#religiao').val(religiao).change();
		$('#pai').val(pai);
		$('#mae').val(mae);
		$('#datanasc').val(datanasc).change();
		$('#reservista').val(reservista);
		$('#clt').val(clt);
		$('#cartaosus').val(cartaosus);		
		$('#cartaovacina').val(cartaovacina);
		$('#telefone').val(telefone);
		$('#cidade').val(cidade).change();
		$('#bairro').val(bairro).change();
		$('#endereco').val(endereco);		
		$('#id_usr_resp').val(id_usr_resp).change();

		

		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
	}



	/*function mostrar(id, nome, pessoa, doc, telefone, email, endereco, data_cad, data_nasc, obs){

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
	}*/

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');
		$('#nomesocial').val('');
		$('#sexo').val('');
		$('#racacor').val('1').change();
		$('#etnia').val('1').change();
		$('#titular').val('');
		$('#cpf').val('');
		$('#tipodoc').val('Registro Geral').change();
		$('#docnum').val('');
		$('#docorgao').val('1').change();
		$('#docexpedicao').val('<?=$data_atual?>');
		$('#religiao').val('2').change();
		$('#pai').val('');
		$('#mae').val('');
		$('#datanasc').val('<?=$data_atual?>');
		$('#reservista').val('');
		$('#clt').val('');
		$('#cartaosus').val('');
		$('#cartaovacina').val('');
		$('#telefone').val('');

		$('#cidade').val('1').change();
		$('#bairro').val('');
		$('#endereco').val('');

		$('#id_usr_resp').val('');	
		
	}

	function arquivo(id, nome){
	    $('#id-arquivo').val(id);    
	    $('#nome-arquivo').text(nome);

	    $('#modalArquivos').modal('show');
	    $('#mensagem-arquivo').text(''); 
	    listarArquivos();   
	}

	
	function depend(id, nome){
	    $('#id-provedor').val(id);    //id-dependente
	    $('#nome-provedor').text(nome); //nome-dependente

	    $('#modalDependentes').modal('show');
	    $('#mensagem-dependente').text(''); 
	    listarDependentes();   
	}


	    

</script>



