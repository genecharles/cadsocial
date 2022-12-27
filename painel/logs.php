<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'logs';


if(@$_SESSION['nivel_usuario'] != "Administrador" and @$_SESSION['nivel_usuario'] != "Gerente"){
echo "<script>window.location='../index.php'</script>";
exit();
}


?>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
</div>




<!-- ModalMostrar -->
<div class="modal fade" id="modalMostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal">Tabela de :<span id="nome_mostrar"> </span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
				<div class="modal-body">			
					


					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-6">							
							<span><b>Ação: </b></span>
							<span id="acao_mostrar"></span>							
						</div>
						<div class="col-md-6">							
							<span><b>Data: </b></span>
							<span id="data_mostrar"></span>
						</div>
					</div>


					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-6">							
							<span><b>Hora: </b></span>
							<span id="hora_mostrar"></span>							
						</div>
						<div class="col-md-6">							
							<span><b>Usuário: </b></span>
							<span id="usuario_mostrar"></span>
						</div>
					</div>


					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-6">							
							<span><b>Id do Registro: </b></span>
							<span id="id_reg_mostrar"></span>							
						</div>
						<div class="col-md-6">							
							<span><b>Descrição: </b></span>
							<span id="descricao_mostrar"></span>
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
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
	});
</script>

<style type="text/css">
	.select2-selection__rendered {
		line-height: 36px !important;
		font-size:16px !important;
		color:#666666 !important;

	}

	.select2-selection {
		height: 36px !important;
		font-size:16px !important;
		color:#666666 !important;

	}
</style>  





<script type="text/javascript">
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#foto").files[0];

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
