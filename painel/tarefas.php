<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'tarefas';


?>
<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Nova Tarefa</button>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
</div>




<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal"></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-text">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-5">						
							<div class="form-group"> 
								<label>Título <small>(Máx 40 Caracteres)</small></label> 
								<input maxlength="40" type="text" class="form-control" name="titulo" id="titulo" required> 
							</div>						
						</div>

						<div class="col-md-4" id="nasc">						
							<div class="form-group"> 
								<label>Data </label> 
								<input type="date" class="form-control" name="data" id="data" value="<?php echo date('Y-m-d') ?>"> 
							</div>						
						</div>

						<div class="col-md-3" id="nasc">						
							<div class="form-group"> 
								<label>Hora</label> 
								<input type="time" class="form-control" name="hora" id="hora" value="" required> 
							</div>						
						</div>					


					</div>

					<div class="col-md-12">						
							<div class="form-group"> 
								<label>Descrição <small>(Máx 100 Caracteres)</small></label> 
								<input maxlength="100" type="text" class="form-control" name="descricao" id="descricao">
							</div>						
						</div>


					
					<div class="col-md-12">
						<div class="form-group"> 
							<label>OBS <small>(Max 1000 Caracteres)</small></label> 
							<textarea maxlength="1000" name="area" id="area" class="textarea"> </textarea>
						</div>
					</div>	
					

					<br>
					<input type="hidden" name="id" id="id"> 
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
						<span><b>Data: </b></span>
						<span id="data_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Hora: </b></span>
						<span id="hora_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Usuário: </b></span>
						<span id="usuario_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Status: </b></span>
						<span id="status_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					
					<div class="col-md-12">							
						<span><b>Descrição: </b></span>
						<span id="descricao_mostrar"></span>
					</div>
				</div>


				

				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-12">							
						<span><b>Observações: </b></span>
						<div id="obs_mostrar" style="margin-top: 15px"></div>							
					</div>
				</div>
				


			</div>


		</div>
	</div>
</div>


<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script>
	

$("#form-text").submit(function () {
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


<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
						