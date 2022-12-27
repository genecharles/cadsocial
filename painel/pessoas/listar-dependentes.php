<?php 
require_once("../../conexao.php");
$pagina = 'pessoas';
$id = $_POST['id'];


echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM pessoas where codfam = '$id' and id != '$id' order by nome desc"); //
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela_dependentes">
		<thead> 
			<tr> 				
				<th>Nome</th>
				<th>CPF</th>
				<th class="esc">Data Nasc</th>				
				<th class="esc">Gênero</th>				
				<th>Parentesco</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];//
$nome = $res[$i]['nome'];//
$apelido = $res[$i]['nomesocial'];
$sexo = $res[$i]['sexo'];//
$racacor = $res[$i]['racacor'];//
$etnia = $res[$i]['etnia'];//
$titular = $res[$i]['titular'];
$codfam = $res[$i]['codfam'];
$cpf = $res[$i]['cpf'];//
$tipodoc = $res[$i]['tipodoc'];//
$docnum = $res[$i]['docnum'];//
$docorgao = $res[$i]['docorgao'];//
$docexpedicao = $res[$i]['docexpedicao'];//
$religiao = $res[$i]['religiao'];//
$pai = $res[$i]['pai'];//
$mae = $res[$i]['mae'];//
$datanasc = $res[$i]['datanasc'];//
$reservista = $res[$i]['reservista'];
$clt = $res[$i]['clt'];//
$cartaosus = $res[$i]['cartaosus'];//
$cartaovacina = $res[$i]['cartaovacina'];//
$telefone = $res[$i]['telefone'];//
//$cidade = $res[$i]['cidade'];
//$bairro = $res[$i]['bairro'];
//$endereco = $res[$i]['endereco'];
$parentesco = $res[$i]['parentesco'];//
$data_cad = $res[$i]['data_cad'];
$hora_cad = $res[$i]['hora_cad'];
$id_usr_resp = $res[$i]['id_usr_resp'];
$ativo = $res[$i]['ativo'];




$datanascF = implode('/', array_reverse(explode('-', $datanasc)));

$query2 = $pdo->query("SELECT * FROM grauparentesco where id = '$parentesco'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_parentesco = $res2[0]['nome'];
}else{
	$nome_parentesco = 'Não definido';
}

echo <<<HTML
			<tr>					
				<td class="">{$nome}</td>
				<td class="">{$cpf}</td>
				<td class="esc">{$datanascF}</td>
				<td class="esc">{$sexo}</td>
				<td class="">{$nome_parentesco}</td>
				<td class="">


					<li class="dropdown head-dpdn2" style="display: inline-block;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-trash-o text-danger"></i></a>
						<ul class="dropdown-menu">
							<li>
								<div class="notification_desc2">
									<p>Confirmar Exclusão? <a href="#" onclick="excluirDependente('{$id}', '{$nome}')"><span class="text-danger">Sim</span></a></p>
								</div>
							</li>
						</ul>

						<a href="#" onclick="editardependente('{$id}', '{$nome}', '{$apelido}', '{$sexo}','{$racacor}','{$etnia}','{$religiao}','{$datanasc}','{$cpf}','{$cartaovacina}','{$cartaosus}','{$reservista}','{$tipodoc}','{$docnum}','{$docorgao}','{$docexpedicao}','{$clt}','{$telefone}','{$pai}','{$mae}','{$id_usr_resp}')" title="Editar Dependentes"><i class="fa fa-users" style="color:#22146e"></i></a>
					</li>
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
	echo 'Não possui nenhum Dependente cadastrado!';
}

?>


<script type="text/javascript">


	


	function excluirDependente(id, nome){
    
    $.ajax({
        url: "dependentes/excluir-dependentes.php",
        method: 'POST',
        data: {id, nome},
        dataType: "text",

        success: function (mensagem) {
            $('#mensagem-dependente').text('');
            $('#mensagem-dependente').removeClass()
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarDependentes();                
            } else {

                $('#mensagem-dependente').addClass('text-danger')
                $('#mensagem-dependente').text(mensagem)
            }


        },      

    });
}

//'{$id}', '{$nome}', '{$apelido}', '{$sexo}','{$racacor}','{$etnia}','{$religiao}','{$datanasc}','{$cpf}','{$cartaovacina}','{$cartaosus}','{$reservista}','{$tipodoc}','{$docnum}','{$docorgao}','{$docexpedicao}','{$clt}','{$telefone}','{$pai}','{$mae}','{$id_usr_resp}'
function editardependente(id, nome, nomesocial, sexo, racacor, etnia, religiao, datanasc, cpf, cartaovacina, cartaosus, reservista, tipodoc, docnum, docorgao, docexpedicao, clt, telefone, pai, mae, id_usr_resp){


		$('#id-editar-dep').val(id);
		$('#nome-editar-dep').val(nome);//
		$('#nomesocial-editar-dep').val(nomesocial);
		$('#sexo-editar-dep').val(sexo);//
		$('#racacor-editar-dep').val(racacor);	
		$('#etnia-editar-dep').val(etnia).change();
		$('#religiao-editar-dep').val(religiao).change();
		$('#datanasc-editar-dep').val(datanasc).change();//

		//$('#titular-editar-dep').val(titular);// verificar essa situação do titular como vai ficar
		//$('#codfam-editar-dep').val(codfam);
		$('#cpf-editar-dep').val(cpf);//
		$('#cartaovacina-editar-dep').val(cartaovacina);
		$('#cartaosus-editar-dep').val(cartaosus);
		$('#reservista-editar-dep').val(reservista);
		$('#tipodoc-editar-dep').val(tipodoc);
		$('#docnum-editar-dep').val(docnum);
		$('#docorgao-editar-dep').val(docorgao);
		$('#docexpedicao-editar-dep').val(docexpedicao);
		$('#clt-editar-dep').val(clt);
		$('#telefone-editar-dep').val(telefone);
		$('#pai-editar-dep').val(pai);
		$('#mae-editar-dep').val(mae);

		
		
		
		
		
				
		
		
		//$('#cidade-editar-dep').val(cidade).change();
		//$('#bairro-editar-dep').val(bairro).change();
		//$('#endereco-editar-dep').val(endereco);		
		$('#id_usr_resp-editar-dep').val(id_usr_resp).change();

		

		$('#tituloModal').text('Editar Registro');
		$('#modalEditarDependente').modal('show');
		$('#mensagem').text('');
	}


</script>


