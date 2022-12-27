<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'estado';


if(@$_SESSION['nivel_usuario'] != "Administrador" and @$_SESSION['nivel_usuario'] != "Gerente"){
echo "<script>window.location='../index.php'</script>";
exit();
}


 ?>
<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Estado</button>

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
			<form method="post" id="form">
			<div class="modal-body">

				<div class="row">
					<div class="col-md-6">						
						<div class="form-group"> 
							<label>Estado</label> 
							<input type="text" class="form-control" name="nome" id="nome" required> 
						</div>						
					</div>

					<div class="col-md-6">						
						<div class="form-group"> 
							<label>UF</label> 
							<input type="text" class="form-control" name="uf" id="uf" required> 
						</div>						
					</div>

					<div class="col-md-4">						
							<div class="form-group"> 
								<label>Cidade</label> 
								<select class="form-control sel2" name="pais" id="pais" required style="width:100%;"> 
									<?php 
									$query = $pdo->query("SELECT * FROM paises order by nome asc");
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
					<div class="col-md-4" style="margin-top:20px">						 
						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
				</div>
				
				<br>
				<input type="hidden" name="id" id="id"> 
				<small><div id="mensagem" align="center" class="mt-3"></div></small>					

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


<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
	});
</script>