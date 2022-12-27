<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'usuarios';

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
				<h4 class="modal-title" id="tituloModal"><span id="nome_mostrar"> </span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
				<div class="modal-body">			
					


					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-6">							
							<span><b>CPF: </b></span>
							<span id="cpf_mostrar"></span>							
						</div>

						<div class="col-md-6">							
							<span><b>Nível: </b></span>
							<span id="cargo_mostrar"></span>
						</div>
						
					</div>


					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-6">							
							<span><b>Email: </b></span>
							<span id="email_mostrar"></span>							
						</div>
						<div class="col-md-6">							
							<span><b>Senha: </b></span>
							<span id="senha_mostrar"></span>
						</div>
					</div>



					<div class="row">
						<div class="col-md-12" align="center">		
							<img  width="200px" id="target_mostrar">	
						</div>
					</div>
					
								

				</div>


		</div>
	</div>
</div>

<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


