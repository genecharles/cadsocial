<?php 
require_once("../../conexao.php");
$pagina = 'arquivos';
$data_atual = date('Y-m-d');
$total_valor = 0;
$total_valorF = 0;

$dataInicial = @$_POST['dataInicial'];
$dataFinal = @$_POST['dataFinal'];
$grupo = '%'.@$_POST['grupo'].'%';
$setor = @$_POST['setor'];
$categoria = @$_POST['categoria'];


if($setor == 1 or $setor == ""){
	$setor = '%%';
}

if($categoria == 1 or $categoria == ""){
	$categoria = '%%';
}

echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * from $pagina where (data_cad >= '$dataInicial' and data_cad <= '$dataFinal') and setor LIKE '$setor' and categoria LIKE '$categoria' and  grupo LIKE '$grupo' order by id desc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				
				<th class="ocultar">Número</th>
				<th >Nome</th> 
				<th class="esc">Setor</th> 
				<th class="esc">Categoria</th>
				<th class="esc">Grupo</th>
				<th class="esc">Cadastrado em</th>
				<th>Arquivo</th>				
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$descricao = $res[$i]['descricao'];
$numero = $res[$i]['numero'];
$setor = $res[$i]['setor'];
$data_cad = $res[$i]['data_cad'];
$vencimento = $res[$i]['vencimento'];
$nome = $res[$i]['nome'];
$categoria = $res[$i]['categoria'];
$grupo = $res[$i]['grupo'];
$fornecedor = $res[$i]['fornecedor'];
$cliente = $res[$i]['cliente'];
$funcionario = $res[$i]['funcionario'];
$usuario_cad = $res[$i]['usuario_cad'];
$usuario_editou = $res[$i]['usuario_editou'];
$arquivo = $res[$i]['arquivo'];


//retirar aspas do texto do obs
$descricao = str_replace('"', "**", $descricao);

//extensão do arquivo
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
if($ext == 'pdf'){
	$tumb_arquivo = 'pdf.png';
}else if($ext == 'rar' || $ext == 'zip'){
	$tumb_arquivo = 'rar.png';
}else if($ext == 'doc' || $ext == 'docx' || $ext == 'txt'){
	$tumb_arquivo = 'word.png';
}else if($ext == 'xlsx' || $ext == 'xlsm' || $ext == 'xls'){
	$tumb_arquivo = 'excel.png';
}else if($ext == 'xml'){
	$tumb_arquivo = 'xml.png';
}else{
	$tumb_arquivo = $arquivo;
}

$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));
$data_vencF = implode('/', array_reverse(explode('-', $vencimento)));

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_cad'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_lanc = $res2[0]['nome'];
}else{
	$nome_usu_lanc = 'Sem Usuário';
}

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_editou'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_edit = $res2[0]['nome'];
}else{
	$nome_usu_edit = 'Sem Usuário';
}



$query2 = $pdo->query("SELECT * FROM setor_arquivos where id = '$setor'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_setor = $res2[0]['nome'];
}else{
	$nome_setor = 'Não Definido';
}


$query2 = $pdo->query("SELECT * FROM cat_arquivos where id = '$categoria'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cat = $res2[0]['nome'];
}else{
	$nome_cat = 'Não Definido';
}


$query2 = $pdo->query("SELECT * FROM grupo_arquivos where id = '$grupo'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_grupo = $res2[0]['nome'];
}else{
	$nome_grupo = 'Não Definido';
}


$query2 = $pdo->query("SELECT * FROM fornecedores where id = '$fornecedor'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_forn = $res2[0]['nome'];
}else{
	$nome_forn = 'Não Definido';
}


$query2 = $pdo->query("SELECT * FROM funcionarios where id = '$funcionario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_func = $res2[0]['nome'];
}else{
	$nome_func = 'Não Definido';
}


$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cli = $res2[0]['nome'];
}else{
	$nome_cli = 'Não Definido';
}


if($vencimento != '0000-00-00' and $vencimento < date('Y-m-d')){
	$classe_venc = 'text-danger';	
}else{
	$classe_venc = '';	
}

echo <<<HTML
			<tr class="{$classe_venc}">
			  <td class="ocultar">{$numero}</td>
				<td>{$nome}</td>	
				<td class="esc">{$nome_setor}</td>
				<td class="esc">{$nome_cat}</td>
				<td class="esc">{$nome_grupo}</td>
				<td class="esc">{$data_cadF}</td>
				<td><a href="images/arquivos/{$arquivo}" target="_blank"><img src="images/arquivos/{$tumb_arquivo}" width="30px" height="30px"></a></td>
				<td>
					<big><a href="#" onclick="editar('{$id}', '{$numero}', '{$nome}','{$descricao}','{$setor}','{$categoria}','{$grupo}','{$fornecedor}','{$cliente}','{$funcionario}','{$arquivo}','{$vencimento}')" title="Editar Dados"><i class="fa fa-edit text-primary "></i></a></big>

					<big><a href="#" onclick="mostrar('{$id}', '{$numero}', '{$nome}','{$descricao}','{$nome_setor}','{$nome_cat}','{$nome_grupo}','{$nome_forn}','{$nome_cli}','{$nome_func}','{$arquivo}','{$data_cadF}','{$data_vencF}','{$nome_usu_lanc}','{$nome_usu_edit}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

					<big><a href="#" onclick="excluir('{$id}', '{$nome}')" title="Excluir Item"><i class="fa fa-trash-o text-danger"></i></a></big>
					
				</td>  
			</tr> 
HTML;
}
echo <<<HTML
		</tbody> 
	</table>
	<div align="right" style="margin-top: 10px">
	Total de Arquivos: {$total_reg}
	</div> 
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



	function editar(id, numero, nome, descricao, setor, categoria, grupo, fornecedor, cliente, funcionario, arquivo, vencimento ){

		for (let letra of descricao){  				
			if (letra === '*'){
				descricao = descricao.replace('**', '"');
			}			
		}

		$('#id_cat').val(categoria);
		$('#id_grupo').val(grupo);
		nicEditors.findEditor("area").setContent(descricao);	
		
		$('#id').val(id);
		$('#numero').val(numero);
		$('#nome').val(nome);
		$('#setor').val(setor).change();
		$('#categoria').val(categoria).change();
		$('#grupo').val(grupo).change();		
		
		if(fornecedor != 0){
			$('#fornecedor').val(fornecedor).change();
		}else{
			$('#fornecedor').val('').change();
		}	

		if(cliente != 0){
			$('#cliente').val(cliente).change();
		}else{
			$('#cliente').val('').change();
		}

		if(funcionario != 0){
			$('#funcionario').val(funcionario).change();
		}else{
			$('#funcionario').val('').change();
		}	

		$('#vencimento').val(vencimento);		

		$('#arquivo').val('');
		
		$('#tituloModal').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');


		resultado = arquivo.split(".", 2);

    	 if(resultado[1] === 'pdf'){
            $('#target').attr('src', "images/pdf.png");
            return;
        } else if(resultado[1] === 'rar' || resultado[1] === 'zip'){
            $('#target').attr('src', "images/rar.png");
            return;
        }else if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
            $('#target').attr('src', "images/word.png");
            return;
           
        }else if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
            $('#target').attr('src', "images/excel.png");
            return;

        }else if(resultado[1] === 'xml'){
            $('#target').attr('src', "images/xml.png");
            return;
        }else{
        	$('#target').attr('src','images/arquivos/' + arquivo);			
        }		
	}



	function mostrar(id, numero, nome, descricao, setor, categoria, grupo, fornecedor, cliente, funcionario, arquivo, data_cad, vencimento, usuario_cad, usuario_editou){

		for (let letra of descricao){  				
			if (letra === '*'){
				descricao = descricao.replace('**', '"');
			}			
		}

		
		if(vencimento == "00/00/0000"){
			vencimento = 'Não Possui Data!';
		}


		$('#nome_mostrar').text(nome);
		$('#numero_mostrar').text(numero);
		$("#descricao_mostrar").html(descricao);
		$('#setor_mostrar').text(setor);
		$('#cat_mostrar').text(categoria);
		$('#grupo_mostrar').text(grupo);		
		$('#fornecedor_mostrar').text(fornecedor);	
		$('#cliente_mostrar').text(cliente);	
		$('#func_mostrar').text(funcionario);
		$('#data_cad_mostrar').text(data_cad);
		$('#data_venc_mostrar').text(vencimento);
		$('#usu_cad_mostrar').text(usuario_cad);
		$('#usu_edit_mostrar').text(usuario_editou);
		
		$('#link_arquivo').attr('href','images/arquivos/' + arquivo);
		
		$('#modalMostrar').modal('show');

		resultado = arquivo.split(".", 2);

    	 if(resultado[1] === 'pdf'){
            $('#target_mostrar').attr('src', "images/pdf.png");
            return;
        } else if(resultado[1] === 'rar' || resultado[1] === 'zip'){
            $('#target_mostrar').attr('src', "images/rar.png");
            return;
        }else if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
            $('#target_mostrar').attr('src', "images/word.png");
            return;
           
        }else if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
            $('#target_mostrar').attr('src', "images/excel.png");
            return;

        }else if(resultado[1] === 'xml'){
            $('#target_mostrar').attr('src', "images/xml.png");
            return;
        }else{
        	$('#target_mostrar').attr('src','images/arquivos/' + arquivo);			
        }			
	}

	function limparCampos(){
		$('#id_cat').val('');
		$('#id_grupo').val('');

		$('#id').val('');
		$('#nome').val('');
		$('#numero').val('');
		$('#vencimento').val('');
		
		$('#cliente').val('').change();
		$('#fornecedor').val('').change();
		$('#funcionario').val('').change();
		nicEditors.findEditor("area").setContent('');	
		$('#arquivo').val('');
		$('#target').attr('src','images/arquivos/sem-foto.png');
	}


</script>



