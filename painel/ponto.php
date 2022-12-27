<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'ponto';


if(@$_SESSION['nivel_usuario'] != "Administrador" and @$_SESSION['nivel_usuario'] != "Gerente" and @$_SESSION['nivel_usuario'] != "RH"){
	echo "<script>window.location='../index.php'</script>";
	exit();
}

?>


<div class="row" style="background:white; padding:15px">	
	<form method="post" action="rel/ponto_class.php" target="_blank">
	<div class="col-md-4">
		<div class="form-group"> 								 
								<select class="form-control sel3" name="usuario_filtro" id="usuario_filtro" required style="width:100%;"> 
									<?php 
										$query = $pdo->query("SELECT * FROM funcionarios where cargo != 'Administrador' order by nome asc");									
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}
											$cargo = $res[$i]['cargo'];
											$query2 = $pdo->query("SELECT * FROM cargos where id = '$cargo'");
									$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
									$nome_cargo = $res2[0]['nome'];
											
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome']  ?> - <?php echo $nome_cargo  ?></option>

									<?php  } ?>

								</select>
							</div>		
	</div>

	<div align="right" class="col-md-8">
			<button class="text-primary" type="submit" title="PDF da Folha de Ponto" style="background:transparent; padding:2px">
				<img src="images/pdf.png" width="30px" height="30px"> Gerar Relatório
			</button>
	</div>

	<input type="hidden" name="data_inicio_mes" id="data_inicio_mes">
	<input type="hidden" name="data_final_mes" id="data_final_mes"> 

</form>

	
<input type="hidden" name="dias_busca" id="dias_busca"> 
<input type="hidden" name="dias_busca_anterior" id="dias_busca_anterior">   
	
</div>


<div class="row">
<div class="col-md-5" id="calendario">

</div>

<div class="col-xs-12 col-md-7 bs-example widget-shadow" style="padding:10px 5px; margin-top: 0px;" id="listar">
	
</div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header">
				<h4 class="modal-title">Funcionário: <span id="nome-func"></span>  ->  Data: <span id="data-dia"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-text">
				<div class="modal-body">

					<div class="row" style="margin: -10px;">
						<div class="col-md-2">						
							<div class="form-group"> 
								<label>Entrada</label> 
								<input type="time" class="form-control-sm" name="hora_entrada" id="hora_entrada" value="" required> 
							</div>						
						</div>	


						<div class="col-md-3" style="margin:0px; padding:0px">						
							<div class="form-group"> 
								<div align="center"><label>Almoço</label></div>
								<div class="row" style="margin:0px">
								<div class="col-md-6"> 
								<input type="time" class="form-control-sm" name="entrada_almoco" id="entrada_almoco" value="" required>
								</div>

								<div class="col-md-6"> 
								<input type="time" class="form-control-sm" name="saida_almoco" id="saida_almoco" value="" required>
								</div>
								</div>  
							</div>						
						</div>

										
						<div class="col-md-2">						
							<div class="form-group"> 
								<label>Saída</label> 
								<input type="time" class="form-control-sm" name="hora_saida" id="hora_saida" value="" required> 
							</div>						
						</div>	

						<div class="col-md-1" style="margin-top: 17px">					
							 <div class="checkbox"> <label> <input name="folga" id="folga" type="checkbox" value="Sim"> Folga </label> </div>					
						</div>	

						<div class="col-md-1" style="margin-top: 17px; margin-right: 10px">					
							 <div class="checkbox"> <label class="text-primary"> <input name="feriado" id="feriado" type="checkbox" value="Sim"> Feriado </label> </div>					
						</div>	

						<div class="col-md-1" style="margin-top: 17px">					
							 <div class="checkbox"> <label class="text-danger"> <input name="falta" id="falta" type="checkbox" value="Sim"> Falta </label> </div>					
						</div>	

						<div class="col-md-1" style="margin-top: 20px" align="right">	
						<button type="submit" class="btn btn-primary">Salvar</button>
						</div>


					</div>

					

					<br>
					<input type="hidden" name="id" id="id">
					<input type="hidden" name="usuario" id="usuario">
					<input type="hidden" name="data_agenda" id="data_agenda" value="<?php echo date('Y-m-d') ?>">



					

					<small><div id="mensagem" align="center" class="mt-3"></div></small>					

				</div>




			</form>

		</div>
	</div>
</div>



<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
		$(document).ready(function() {	
			var idFunc = $('#usuario_filtro').val();
			listarFuncionario(idFunc);

			buscarData();
			buscarDataAnterior()
			listarCalendario();


			$("#usuario").val(idFunc);
			listar();
			});


		$('#usuario_filtro').change(function(){
			var idFunc = $('#usuario_filtro').val();
			listarFuncionario(idFunc);
			$("#usuario").val(idFunc);
				listar();
				//listarCalendario();
			});		


			$("#folga").change(function() {
			  if ($(this).prop("checked") == true) {
			    $("#hora_entrada").val('00:00');
				$("#hora_saida").val('00:00');
				$("#entrada_almoco").val('00:00');
				$("#saida_almoco").val('00:00');
			  }
			});


			$("#falta").change(function() {
			  if ($(this).prop("checked") == true) {
			    $("#hora_entrada").val('00:00');
				$("#hora_saida").val('00:00');
				$("#entrada_almoco").val('00:00');
				$("#saida_almoco").val('00:00');
			  }
			});

			$("#feriado").change(function() {
			  if ($(this).prop("checked") == true) {
			   $("#hora_entrada").val('00:00');
				$("#hora_saida").val('00:00');
				$("#entrada_almoco").val('00:00');
				$("#saida_almoco").val('00:00');
			  }
			});
		
			


</script>


<script type="text/javascript">
	function listar(){

	var idFunc = $('#usuario_filtro').val();
	listarFuncionario(idFunc);

	var data = $("#data_agenda").val();
	let data_brasileira = data.split('-').reverse().join('/');
	$("#data-dia").text(data_brasileira);
	var usuario = $("#usuario_filtro").val();
	$("#data-modal").val(data);

	var data_inicio_mes = $("#data_inicio_mes").val();
	var data_final_mes = $("#data_final_mes").val();

	buscarData();
	buscarDataAnterior()

    $.ajax({
        url: pag + "/listar.php",
        method: 'POST',
        data: {data, usuario, data_inicio_mes, data_final_mes},
        dataType: "text",

        success:function(result){
            $("#listar").html(result);
        }
    });
}
</script>


<script type="text/javascript">
	$(document).ready(function() {
		$('.sel3').select2({
			
		});
	});
</script>


<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
	});
</script>


<script>

$("#form-text").submit(function () {
	event.preventDefault();
    
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


<script type="text/javascript">
	
	function listarFuncionario(id){

		document.getElementById('folga').checked = false;
        document.getElementById('feriado').checked = false;
        document.getElementById('falta').checked = false;


	var data = $("#data_agenda").val();	
    $.ajax({
        url: pag + "/listar-funcionarios.php",
        method: 'POST',
        data: {id, data},
        dataType: "text",

        success:function(result){
        	var array = result.split("-/");
            $('#nome-func').text(array[0]);
            $('#hora_entrada').val(array[1]);
            $('#hora_saida').val(array[2]);
            $('#entrada_almoco').val(array[3]);
            $('#saida_almoco').val(array[4]);
            $('#id').val(array[8]);
            
            if(array[5] == 'Sim'){
            	document.getElementById('folga').checked = true;
            }

            if(array[6] == 'Sim'){
            	document.getElementById('feriado').checked = true;
            }

            if(array[7] == 'Sim'){
            	document.getElementById('falta').checked = true;
            }
        }
    });
}

	function limparCampos(){
		$('#id').val('');
		$('#titulo').val('');		
		$('#descricao').val('');
		$('#hora').val('');				
		$('#data').val('<?=$data_atual?>');	
		nicEditors.findEditor("area").setContent('');	
		
	}


	function modalPonto(){	
		
		$('#modalForm').modal('show');
	}

	function editar(id, func, data){
		$("#data_agenda").val(data);
		$("#id").val(id);
		listarFuncionario(func);
		modalPonto();

	}


	function listarCalendario(){
		$.ajax({
        url: "ponto/listar-calendario.php",
        method: 'POST',
        data: $('#form').serialize(),
        dataType: "html",

        success:function(result){
            $("#calendario").html(result);
        }
    });
	}


	function buscarData(){
		var idFunc = $('#usuario_filtro').val();
		var data_inicio_mes = $("#data_inicio_mes").val();
		var data_final_mes = $("#data_final_mes").val();

		$.ajax({
				        url: "ponto/buscar-data.php",
				        method: 'POST',
				        data: {idFunc, data_inicio_mes, data_final_mes},
				        dataType: "text",

				        success:function(result){				        	
				        	$('#dias_busca').val(result)

				        }
				    });
	}


	function buscarDataAnterior(){
		var idFunc = $('#usuario_filtro').val();
		var data_inicio_mes = $("#data_inicio_mes").val();
		var data_final_mes = $("#data_final_mes").val();

		$.ajax({
				        url: "ponto/buscar-data-anterior.php",
				        method: 'POST',
				        data: {idFunc, data_inicio_mes, data_final_mes},
				        dataType: "text",

				        success:function(result){				        	
				        	$('#dias_busca_anterior').val(result)

				        }
				    });
	}

</script>

