<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'arquivos';

?>


<div class="row">
	<div class="col-md-12">
		
		<div style="float:left; margin-right:35px">
			<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i>Arquivo</button>
		</div>

		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Data de Cadastro Inicial" class="fa fa-calendar-o"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:20px">
			<input type="date" class="form-control " name="data-inicial"  id="data-inicial" value="<?php echo date('Y-m-d') ?>" required>
		</div>

		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Data de Cadastro Final" class="fa fa-calendar-o"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:30px">
			<input type="date" class="form-control " name="data-final"  id="data-final" value="<?php echo date('Y-m-d') ?>" required>
		</div>


		
		<div style="float:left; margin-right:20px">
			<select class="form-control selbusca" name="setor-busca" id="setor-busca" style="width:140px;"> 				
				<?php 
				
				//verificar o nível de acesso do usuário
				if(@$_SESSION['nivel_usuario'] == "Tesoureiro"){
					$buscar_setor = '2';
				}else if (@$_SESSION['nivel_usuario'] == "Secretario"){
					$buscar_setor = '3';
				}else if (@$_SESSION['nivel_usuario'] == "Recepcionista"){
					$buscar_setor = '6';
				}else if (@$_SESSION['nivel_usuario'] == "RH"){
					$buscar_setor = '4';
				}

				$query = $pdo->query("SELECT * FROM setor_arquivos where id = '$buscar_setor' order by id asc");

				if(@$_SESSION['nivel_usuario'] == "Gerente" || @$_SESSION['nivel_usuario'] == "Administrador"){
					$query = $pdo->query("SELECT * FROM setor_arquivos order by id asc");
				}

				$res = $query->fetchAll(PDO::FETCH_ASSOC);
				for($i=0; $i < @count($res); $i++){
					foreach ($res[$i] as $key => $value){}

						?>	
					<option value="<?php echo $res[$i]['id'] ?>">Setor <?php echo $res[$i]['nome'] ?></option>

				<?php } ?>

			</select>
		</div>


		<div class="esc" style="float:left; margin-right:20px">
			<div id="listar-cat"></div>
		</div>

		<div class="esc" style="float:left; margin-right:20px">
			<div id="listar-grupos"></div>
		</div>

		

		
	</div>

	
</div>


<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
</div>




<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal"></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-arq">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Número ou Indentificação</label> 
								<input type="text" class="form-control" name="numero" id="numero"> 
							</div>						
						</div>

						<div class="col-md-5">						
							<div class="form-group"> 
								<label>Nome *</label> 
								<input type="text" class="form-control" name="nome" id="nome" required> 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Vencimento</label> 
								<input type="date" class="form-control" name="vencimento" id="vencimento"> 
							</div>						
						</div>			


					</div>


					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Setor</label> 
								<select class="form-control selbusca" name="setor" id="setor" style="width:100%;"> 				
									<?php 
									$query = $pdo->query("SELECT * FROM setor_arquivos where id = '$buscar_setor' order by id asc");

									if(@$_SESSION['nivel_usuario'] == "Gerente" || @$_SESSION['nivel_usuario'] == "Administrador"){
										$query = $pdo->query("SELECT * FROM setor_arquivos order by id asc");
									}

									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>">Setor <?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>


						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Categoria</label> 
								<div id="categoria-listar"></div>
							</div>						
						</div>


						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Grupo</label> 
								<div id="grupo-listar"></div>
							</div>						
						</div>


					</div>



					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Fornecedor</label> 
								<select class="form-control sel2" name="fornecedor" id="fornecedor" style="width:100%;"> 

									<option value="">Selecionar um Fornecedor</option>

									<?php 
									$query = $pdo->query("SELECT * FROM fornecedores order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>


						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Cliente</label> 
								<select class="form-control sel2" name="cliente" id="cliente" style="width:100%;"> 

									<option value="">Selecionar um Cliente</option>

									<?php 
									$query = $pdo->query("SELECT * FROM clientes order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>



						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Funcionário</label> 
								<select class="form-control sel2" name="funcionario" id="funcionario" style="width:100%;"> 

									<option value="">Selecionar Funcionário</option>

									<?php 
									$query = $pdo->query("SELECT * FROM funcionarios order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>


					</div>


					

					

					<div class="row">

					<div class="col-md-8">
						<div class="form-group"> 
							<label>Descrição <small>(Max 1000 Caracteres)</small></label> 
							<textarea maxlength="1000" name="area" id="area" class="textarea"> </textarea>
						</div>
					</div>


						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Arquivo</label> 
								<input type="file" name="arquivo" onChange="carregarImg();" id="arquivo">
							</div>	

							<div id="divImg">
								<img src="images/arquivos/sem-foto.png"  width="150px" id="target">									
							</div>					
						</div>
						
					</div>				
					

					<br>
					<input type="hidden" name="id" id="id"> 
					<input type="hidden" name="id_cat" id="id_cat"> 
					<input type="hidden" name="id_grupo" id="id_grupo"> 
					<small><div id="mensagem" align="center" class="mt-3"></div></small>					

				</div>


				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>



			</form>

		</div>
	</div>
</div>



<!-- ModalExcluir -->
<div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width:400px; margin:0 auto;">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal">Excluir Registro: <span id="nome-excluido"> </span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-excluir">
				<div class="modal-body">

					<div class="row" align="center">
						<div class="col-md-6">
							<button type="submit" class="btn btn-danger" style="width:100px">Sim</button>
						</div>
						<div class="col-md-6">
							<button type="button" data-dismiss="modal" class="btn btn-success" style="width:100px">Não</button>	
						</div>
					</div>

					<br>
					<input type="hidden" name="id" id="id-excluir"> 
					<input type="hidden" name="nome" id="nome-excluir"> 
					<small><div id="mensagem-excluir" align="center" class="mt-3"></div></small>					

				</div>

				<div class="modal-footer">

				</div>

			</form>

		</div>
	</div>
</div>




<!-- ModalMostrar -->
<div class="modal fade" id="modalMostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal"><span id="nome_mostrar"> </span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">			



				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Número do Arquivo: </b></span>
						<span id="numero_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Setor: </b></span>
						<span id="setor_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Categoria: </b></span>
						<span id="cat_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Grupo: </b></span>
						<span id="grupo_mostrar"></span>
					</div>
				</div>



				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Fornecedor: </b></span>
						<span id="fornecedor_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Cliente: </b></span>
						<span id="cliente_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Funcionário: </b></span>
						<span id="func_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Data Cadastro: </b></span>
						<span id="data_cad_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Data Vencimento: </b></span>
						<span id="data_venc_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Quem Cadastrou: </b></span>
						<span id="usu_cad_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Última Edição: </b></span>
						<span id="usu_edit_mostrar"></span>							
					</div>
					
				</div>


				<div class="row">
					<div class="col-md-12" align="center">		
						<a id="link_arquivo" target="_blank"><img  width="200px" id="target_mostrar"></a>	
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-12">							
						<span><b>Descrição: </b></span>
						<div id="descricao_mostrar" style="margin-top: 15px"></div>							
					</div>
				</div>



			</div>


		</div>
	</div>
</div>












<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		listar()

		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});

		$('.selbusca').select2({

		});


		listarCategorias();
		listarCategoriasForm();
		listarGrupos();
		listarGruposForm();

		$('#setor-busca').change(function(){
			listarCategorias();
			listar();
		});

		$('#setor').change(function(){
			listarCategoriasForm();
		});

			

		$('#data-inicial').change(function(){
			listar();
		});

		$('#data-final').change(function(){
			listar();
		});	


	});
</script>


<script type="text/javascript">
	function listarCategorias(){
		var setor = $('#setor-busca').val();
		$.ajax({
			url: pag + "/listar-cat.php",
			method: 'POST',
			data: {setor},
			dataType: "text",

			success:function(result){
				$("#listar-cat").html(result);
			},

		});
	}

	function listarCategoriasForm(){
		var setor = $('#setor').val();
		var cat = $('#id_cat').val();
		$.ajax({
			url: pag + "/listar-cat-form.php",
			method: 'POST',
			data: {setor, cat},
			dataType: "text",

			success:function(result){
				$("#categoria-listar").html(result);
			},

		});
	}
</script>



<script type="text/javascript">
	function listarGrupos(){
		var cat = $('#cat-busca').val();
		$.ajax({
			url: pag + "/listar-grupos.php",
			method: 'POST',
			data: {cat},
			dataType: "text",

			success:function(result){
				$("#listar-grupos").html(result);
			},

		});
	}

	function listarGruposForm(){		
		var cat = $('#categoria').val();
		var grupo = $('#id_grupo').val();
		console.log(grupo + 'aaa')
		$.ajax({
			url: pag + "/listar-grupos-form.php",
			method: 'POST',
			data: {cat, grupo},
			dataType: "text",

			success:function(result){
				$("#grupo-listar").html(result);
			},

		});
	}
</script>


<script type="text/javascript">
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#arquivo").files[0];

		var arquivo = file['name'];
		resultado = arquivo.split(".", 2);

		if(resultado[1] === 'pdf'){
			$('#target').attr('src', "images/pdf.png");
			return;
		}

		if(resultado[1] === 'rar' || resultado[1] === 'zip'){
			$('#target').attr('src', "images/rar.png");
			return;
		}

		if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
			$('#target').attr('src', "images/word.png");
			return;
		}


		if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
			$('#target').attr('src', "images/excel.png");
			return;
		}


		if(resultado[1] === 'xml'){
			$('#target').attr('src', "images/xml.png");
			return;
		}



		var reader = new FileReader();

		reader.onloadend = function () {
			target.src = reader.result;
		};

		if (file) {
			reader.readAsDataURL(file);

		} else {
			target.src = "";
		}
	}
</script>




<script type="text/javascript">

	function listar(){

		var dataInicial = $("#data-inicial").val();
		var dataFinal = $("#data-final").val();
		var setor = $("#setor-busca").val();
		var categoria = $("#cat-busca").val();
		var grupo = $("#grupo-busca").val();

		$.ajax({
			url: pag + "/listar.php",
			method: 'POST',
			data: {dataInicial, dataFinal, setor, categoria, grupo},
			dataType: "html",

			success:function(result){
				$("#listar").html(result);
			}
		});
	}


</script>



<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
						


<style type="text/css">
	.select2-selection__rendered {
		line-height: 28px !important;
		font-size:13px !important;
		color:#666666 !important;

	}

	.select2-selection {
		height: 28px !important;
		font-size:13px !important;
		color:#666666 !important;

	}
</style>  


<script type="text/javascript">
	
$("#form-arq").submit(function () {
	event.preventDefault();
    nicEditors.findEditor('area').saveContent();
	var formData = new FormData(this);
    	$.ajax({
		url: pag + "/inserir.php",
		type: 'POST',
		data: formData,

		success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {                    
                    $('#btn-fechar').click();
                    listar();
                } else {
                	$('#mensagem').addClass('text-danger')
                    $('#mensagem').text(mensagem)
                }

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

});

</script>