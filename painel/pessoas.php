<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'pessoas';

// logado
$id_usuario = $_SESSION['id_usuario'];


?>
<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Beneficiario</button>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
</div>




<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
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
								<label>Nome</label> 
								<input type="text" class="form-control" name="nome" id="nome" required> 
							</div>
						</div>

						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Apelido</label> 
								<input type="text" class="form-control" name="nomesocial" id="nomesocial" required> 
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group"> 
								<label>Gênero</label>								
								<select class="form-control ls-select" name="sexo" id="sexo" required> 
									<option selected value="M">Masculino</option>
									<option value="F">Feminino</option>
								</select>
							</div>
						</div>


					</div>
					<div class="row">
						<div class="col-md-2">
							<div class="form-group"> 
								<label>Raça/Cor</label>								
								<select class="form-control sel2" name="racacor" id="racacor" required style="width:100%;">
									<!--								<option selected disabled hidden>Digite aqui</option>-->
									<?php 
									$query = $pdo->query("SELECT * FROM racacor");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>

										<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group"> 
								<label>ETNIA</label>
								<select class="form-control sel2" name="etnia" id="etnia" required style="width:100%;">
									<!--								<option selected disabled hidden>Digite aqui</option>-->
									<?php 
									$query = $pdo->query("SELECT * FROM etnia");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>

										<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group"> 
								<label>Religião</label>								
								<select class="form-control sel2" name="religiao" id="religiao" required style="width:100%;">
									<!--								<option selected disabled hidden>Digite aqui</option>-->
									<?php 
									$query = $pdo->query("SELECT * FROM religiao");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>

										<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3" id="nasc">
							<div class="form-group"> 
								<label>Data Nascimento</label> 
								<input type="date" class="form-control" name="datanasc" id="datanasc" value="<?php echo date('Y-m-d') ?>"> 
							</div>
						</div>


					</div>

					<div class="row">						



						<div class="col-md-3">						
							<div class="form-group"> 
								<label>CPF</label> 
								<input type="text" class="form-control" name="cpf" id="cpf" required> 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Cartão de Vacina</label> 
								<input maxlength="20" type="text" class="form-control" name="cartaovacina" id="cartaovacina" > 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Cartão SUS</label> 
								<input type="text" maxlength="20" class="form-control" name="cartaosus" id="cartaosus" > 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Reservista</label> 
								<input type="text" maxlength="20" class="form-control" name="reservista" id="reservista"> 
							</div>
						</div>


					</div>

					<div class="row">
						<div class="col-md-3">
							<div class="form-group"> 
								<label>Documento Tipo</label>
								<select class="form-control" name="tipodoc" id="tipodoc"> 
									<option value="Registro Geral">RG</option>
									<option value="Registro Administrativo de Nascimento de Indígena">RANI</option>
									<option value="Registro Nacional Migratório">RNM</option>
									<option value="Registro Nacional do Estrangeiro">RNE</option>
								</select>
							</div>
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Número documento</label> 
								<input type="text" maxlength="20" class="form-control" name="docnum" id="docnum"> 
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group"> 
								<label>ÓRGÃO EMISSOR</label>
								<select class="form-control sel2" name="docorgao" id="docorgao" required style="width:100%;">
									<!--<option selected disabled hidden>Digite aqui</option> -->
									<?php 
									$query = $pdo->query("SELECT * FROM orgaoemissor");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>

										<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['sigla'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group"> 
								<label>Data Emissão</label> 
								<input type="date" class="form-control" name="docexpedicao" id="docexpedicao" value="<?php echo date('Y-m-d') ?>"> 
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-md-6">						
							<div class="form-group"> 
								<label>Endereço</label> 
								<input type="text" maxlength="500" class="form-control" name="endereco" id="endereco" placeholder="Rua e número"> 
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group"> 
								<label>Cidade*</label> 
								<select class="form-control sel2" name="cidade" id="cidade" required style="width:100%;"> 
									<?php 
									$query = $pdo->query("SELECT * FROM cidades");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
									<?php } ?>
								</select>
							</div>						
						</div>


						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Bairro*</label> 
								<div id="listar-bairros"></div>
							</div>						
						</div>

					</div>

					<div class="row">
						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Carteira Trabalho</label> 
								<input type="text" maxlength="20" class="form-control" name="clt" id="clt"> 
							</div>
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Telefone</label> 
								<input type="text" class="form-control" name="telefone" id="telefone"> 
							</div>
						</div>

					</div>				

					<div class="row">
						<div class="col-md-6">						
							<div class="form-group"> 
								<label>Filiação</label> 
								<input type="text" maxlength="150" class="form-control" name="pai" id="pai" placeholder="Nome completo do Pai"> 
							</div>
						</div>
						<div class="col-md-6">						
							<div class="form-group"> 
								<label></label> 
								<input type="text" maxlength="150" class="form-control" name="mae" id="mae" placeholder="Nome completo da Mãe"> 
							</div>
						</div>

						<div class="col-md-4" style="margin-top:20px">						 
							<button type="submit" class="btn btn-primary">Salvar</button>
						</div>

					</div>




					<input type="hidden" name="id" id="id">
					<input type="hidden" name="id_usr_resp" value="<?php echo $id_usuario ?>"> 
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
						<span><b>Pessoa: </b></span>
						<span id="pessoa_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Documento: </b></span>
						<span id="doc_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Email: </b></span>
						<span id="email_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Telefone: </b></span>
						<span id="telefone_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-12">							
						<span><b>Endereço: </b></span>
						<span id="endereco_mostrar"></span>							
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Cadastro: </b></span>
						<span id="data_cad_mostrar"></span>							
					</div>
					<div class="col-md-6" id="div_data_nasc_mostrar">							
						<span><b>Nascimento: </b></span>
						<span id="data_nasc_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-12">							
						<span><b>OBS: </b></span>
						<span id="obs_mostrar"></span>							
					</div>
				</div>
				


			</div>


		</div>
	</div>
</div>





<!-- Modal Arquivos -->
<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal">Gestão de Arquivos - <span id="nome-arquivo"> </span></h4>
				<button id="btn-fechar-arquivos" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-arquivos" method="post">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-8">						
							<div class="form-group"> 
								<label>Arquivo</label> 
								<input type="file" name="arquivo_conta" onChange="carregarImgArquivos();" id="arquivo_conta">
							</div>	
						</div>
						<div class="col-md-4" style="margin-top:-10px">	
							<div id="divImgArquivos">
								<img src="images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">									
							</div>					
						</div>




					</div>

					<div class="row" style="margin-top:-40px">
						<div class="col-md-8">
							<input type="text" class="form-control" name="nome-arq"  id="nome-arq" placeholder="Nome do Arquivo * " required>
						</div>

						<div class="col-md-4">										 
							<button type="submit" class="btn btn-primary">Inserir</button>
						</div>
					</div>

					<hr>

					<small><div id="listar-arquivos"></div></small>

					<br>
					<small><div align="center" id="mensagem-arquivo"></div></small>

					<input type="hidden" class="form-control" name="id-arquivo"  id="id-arquivo">


				</div>
			</form>
		</div>
	</div>
</div>







<!-- Modal Inserir Dependentes -->
<div class="modal fade" id="modalDependentes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal">FICHA DO DEPENDENTE </h4>
				<button id="btn-fechar-dependentes" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-dependentes" method="post">
				<div class="modal-body">


					<div class="panel-group tool-tips widget-shadow" id="accordion" role="tablist" aria-multiselectable="true">
						<h4 class="title2"> Titular Provedor(a): <span id="nome-provedor"> </span></h4>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										DADOS ESSENCIAIS
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">

									<div class="row" style="margin-top:10px">
										<div class="col-md-7">
											<label>Nome</label> 
											<input type="text" class="form-control" name="nome-dep"  id="nome-dep" placeholder="Nome do dependente completo * " required>
										</div>

										<div class="col-md-5">
											<label>CPF</label> 
											<input type="text" class="form-control" name="cpf-dep"  id="cpf-dep">
										</div>

									</div>

									<div class="row" style="margin-top:10px">

										<div class="col-md-4">
											<div class="form-group">
												<label>Data Nasc.</label>
												<input type="date" class="form-control" name="dtnas-dep" id="dtnas-dep" value="<?php echo date('Y-m-d') ?>" required> 
											</div>
										</div>

										<div class="col-md-3">						
											<div class="form-group"> 
												<label>Gênero</label> 
												<select class="form-control sel3" name="sexo-dep" id="sexo-dep" required style="width:100%;">
													<option value="M">Masculino</option>
													<option value="F">Feminino</option>
												</select>
											</div>						
										</div>

										<div class="col-md-5">						
											<div class="form-group"> 
												<label>Parentesco</label> 
												<select class="form-control sel3" name="parentesco-dep" id="parentesco-dep" required style="width:100%;">

													<?php 
													$query = $pdo->query("SELECT * FROM grauparentesco where id != 1");
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









								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										DADOS PESSOAIS
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">










									<div class="row">
										<div class="col-md-2">
											<div class="form-group"> 
												<label>Raça/Cor</label>								
												<select class="form-control sel3" name="racacor-dep" id="racacor-dep" required style="width:100%;">
													<!--								<option selected disabled hidden>Digite aqui</option>-->
													<?php 
													$query = $pdo->query("SELECT * FROM racacor");
													$res = $query->fetchAll(PDO::FETCH_ASSOC);
													for($i=0; $i < @count($res); $i++){
														foreach ($res[$i] as $key => $value){}

															?>

														<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group"> 
												<label>ETNIA</label>
												<select class="form-control sel3" name="etnia-dep" id="etnia-dep" required style="width:100%;">
													<!--								<option selected disabled hidden>Digite aqui</option>-->
													<?php 
													$query = $pdo->query("SELECT * FROM etnia");
													$res = $query->fetchAll(PDO::FETCH_ASSOC);
													for($i=0; $i < @count($res); $i++){
														foreach ($res[$i] as $key => $value){}

															?>

														<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group"> 
												<label>Religião</label>								
												<select class="form-control sel3" name="religiao-dep" id="religiao-dep" required style="width:100%;">
													<!--								<option selected disabled hidden>Digite aqui</option>-->
													<?php 
													$query = $pdo->query("SELECT * FROM religiao");
													$res = $query->fetchAll(PDO::FETCH_ASSOC);
													for($i=0; $i < @count($res); $i++){
														foreach ($res[$i] as $key => $value){}

															?>

														<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-md-3">						
											<div class="form-group"> 
												<label>Telefone</label> 
												<input type="text" maxlength="16" class="form-control" name="telefone-dep" id="telefone-dep"> 
											</div>
										</div>


									</div>
									<div class="row" id="filiacao-dep">
										<div class="col-md-6">						
											<div class="form-group"> 
												<label>Filiação</label> 
												<input type="text" maxlength="150" class="form-control" name="pai-dep" id="pai-dep" placeholder="Nome completo do Pai"> 
											</div>
										</div>
										<div class="col-md-6">						
											<div class="form-group"> 
												<label></label> 
												<input type="text" maxlength="150" class="form-control" name="mae-dep" id="mae-dep" placeholder="Nome completo da Mãe"> 
											</div>
										</div>
									</div>


								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
								<h4 class="panel-title">
									<a class="collapsed"  role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										DOCUMENTOS PESSOAIS
									</a>
								</h4>
							</div>
							<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body">


									<div class="row">
										<div class="col-md-3">
											<div class="form-group"> 
												<label>Documento Tipo</label>
												<select class="form-control" name="tipodoc-dep" id="tipodoc-dep"> 
													<option value="Registro Geral">RG</option>
													<option value="Registro Administrativo de Nascimento de Indígena">RANI</option>
													<option value="Registro Nacional Migratório">RNM</option>
													<option value="Registro Nacional do Estrangeiro">RNE</option>
												</select>
											</div>
										</div>

										<div class="col-md-3">						
											<div class="form-group"> 
												<label>Número documento</label> 
												<input type="text" maxlength="20" class="form-control" name="docnum-dep" id="docnum-dep"> 
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group"> 
												<label>ÓRGÃO EMISSOR</label>
												<select class="form-control sel3" name="docorgao-dep" id="docorgao-dep" style="width:100%;">
													<!--<option selected disabled hidden>Digite aqui</option> -->
													<?php 
													$query = $pdo->query("SELECT * FROM orgaoemissor");
													$res = $query->fetchAll(PDO::FETCH_ASSOC);
													for($i=0; $i < @count($res); $i++){
														foreach ($res[$i] as $key => $value){}

															?>

														<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['sigla'] ?></option>

													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group"> 
												<label>Data Emissão</label> 
												<input type="date" class="form-control" name="docexpedicao-dep" id="docexpedicao-dep" value="<?php echo date('Y-m-d') ?>"> 
											</div>
										</div>

									</div>




									<div class="col-md-3">						
										<div class="form-group"> 
											<label>Cartão de Vacina</label> 
											<input maxlength="20" type="text" class="form-control" name="cartaovacina-dep" id="cartaovacina-dep" > 
										</div>						
									</div>

									<div class="col-md-3">						
										<div class="form-group"> 
											<label>Cartão SUS</label> 
											<input type="text" maxlength="20" class="form-control" name="cartaosus-dep" id="cartaosus-dep" > 
										</div>						
									</div>

									<div class="col-md-3">						
										<div class="form-group"> 
											<label>Reservista</label> 
											<input type="text" maxlength="20" class="form-control" name="reservista-dep" id="reservista-dep"> 
										</div>
									</div>

									<div class="col-md-3">						
										<div class="form-group"> 
											<label>Carteira Trabalho</label> 
											<input type="text" maxlength="20" class="form-control" name="clt-dep" id="clt-dep"> 
										</div>
									</div>


								</div>
							</div>
						</div>
			</div>


			<div class="row" style="margin-top:10px">
				<div class="col-md-4">										 
					<button type="submit" class="btn btn-primary">Inserir</button>
				</div>
			</div>

			<hr>

			<small><div id="listar-dependentes"></div></small>

			<br>
			<small><div align="center" id="mensagem-dependente"></div></small>

			<input type="hidden" class="form-control" name="id-provedor" id="id-provedor">

		</div>
	</form>
</div>
</div>

</div>



<!-- Modal Editar Dependentes -->
<div class="modal fade" id="modalEditarDependente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal">EDITAR DEPENDENTE</h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-editardependente">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">						
							<div class="form-group"> 
								<label>Nome</label> 
								<input type="text" class="form-control" name="nome-editar-dep" id="nome-editar-dep" required> 
							</div>
						</div>

						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Apelido</label> 
								<input type="text" class="form-control" name="nomesocial-editar-dep" id="nomesocial-editar-dep" required> 
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group"> 
								<label>Gênero</label>								
								<select class="form-control ls-select" name="sexo-editar-dep" id="sexo-editar-dep" required> 
									<option selected value="M">Masculino</option>
									<option value="F">Feminino</option>
								</select>
							</div>
						</div>


					</div>
					<div class="row">
						<div class="col-md-2">
							<div class="form-group"> 
								<label>Raça/Cor</label>								
								<select class="form-control sel4" name="racacor-editar-dep" id="racacor-editar-dep" required style="width:100%;">
									<!--								<option selected disabled hidden>Digite aqui</option>-->
									<?php 
									$query = $pdo->query("SELECT * FROM racacor");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>

										<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group"> 
								<label>ETNIA</label>
								<select class="form-control sel4" name="etnia-editar-dep" id="etnia-editar-dep" required style="width:100%;">
									<!--								<option selected disabled hidden>Digite aqui</option>-->
									<?php 
									$query = $pdo->query("SELECT * FROM etnia");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>

										<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group"> 
								<label>Religião</label>								
								<select class="form-control sel4" name="religiao-editar-dep" id="religiao-editar-dep" required style="width:100%;">
									<!--								<option selected disabled hidden>Digite aqui</option>-->
									<?php 
									$query = $pdo->query("SELECT * FROM religiao");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>

										<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['nome'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3" id="nasc">
							<div class="form-group"> 
								<label>Data Nascimento</label> 
								<input type="date" class="form-control" name="datanasc-editar-dep" id="datanasc-editar-dep" value="<?php echo date('Y-m-d') ?>"> 
							</div>
						</div>


					</div>

					<div class="row">						



						<div class="col-md-3">						
							<div class="form-group"> 
								<label>CPF</label> 
								<input type="text" class="form-control" name="cpf-editar-dep" id="cpf-editar-dep" required> 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Cartão de Vacina</label> 
								<input maxlength="20" type="text" class="form-control" name="cartaovacina-editar-dep" id="cartaovacina-editar-dep" > 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Cartão SUS</label> 
								<input type="text" maxlength="20" class="form-control" name="cartaosus-editar-dep" id="cartaosus-editar-dep" > 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Reservista</label> 
								<input type="text" maxlength="20" class="form-control" name="reservista-editar-dep" id="reservista-editar-dep"> 
							</div>
						</div>


					</div>

					<div class="row">
						<div class="col-md-3">
							<div class="form-group"> 
								<label>Documento Tipo</label>
								<select class="form-control" name="tipodoc-editar-dep" id="tipodoc-editar-dep"> 
									<option value="Registro Geral">RG</option>
									<option value="Registro Administrativo de Nascimento de Indígena">RANI</option>
									<option value="Registro Nacional Migratório">RNM</option>
									<option value="Registro Nacional do Estrangeiro">RNE</option>
								</select>
							</div>
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Número documento</label> 
								<input type="text" maxlength="20" class="form-control" name="docnum-editar-dep" id="docnum-editar-dep"> 
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group"> 
								<label>ÓRGÃO EMISSOR</label>
								<select class="form-control sel4" name="docorgao-editar-dep" id="docorgao-editar-dep" required style="width:100%;">
									<!--<option selected disabled hidden>Digite aqui</option> -->
									<?php 
									$query = $pdo->query("SELECT * FROM orgaoemissor");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>

										<option value="<?php echo $res[$i]['id'] ?>"> <?php echo $res[$i]['sigla'] ?></option>

									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group"> 
								<label>Data Emissão</label> 
								<input type="date" class="form-control" name="docexpedicao-editar-dep" id="docexpedicao-editar-dep" value="<?php echo date('Y-m-d') ?>"> 
							</div>
						</div>

					</div>

					

					<div class="row">
						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Carteira Trabalho</label> 
								<input type="text" maxlength="20" class="form-control" name="clt-editar-dep" id="clt-editar-dep"> 
							</div>
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Telefone</label> 
								<input type="text" class="form-control" name="telefone-editar-dep" id="telefone-editar-dep"> 
							</div>
						</div>

					</div>				

					<div class="row">
						<div class="col-md-6">						
							<div class="form-group"> 
								<label>Filiação</label> 
								<input type="text" maxlength="150" class="form-control" name="pai-editar-dep" id="pai-editar-dep" placeholder="Nome completo do Pai"> 
							</div>
						</div>
						<div class="col-md-6">						
							<div class="form-group"> 
								<label></label> 
								<input type="text" maxlength="150" class="form-control" name="mae-editar-dep" id="mae-editar-dep" placeholder="Nome completo da Mãe"> 
							</div>
						</div>

						<div class="col-md-4" style="margin-top:20px">						 
							<button type="submit" class="btn btn-primary">Salvar</button>
						</div>

					</div>




					<input type="hidden" name="id-editar-dep" id="id-editar-dep">
					<input type="hidden" name="id_usr_resp-editar-dep" value="<?php echo $id_usuario ?>"> 
					<small><div id="mensagem" align="center" class="mt-3"></div></small>	



				</div>

			</form>
			

		</div>
	</div>
</div>





<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script>
	$(document).ready(function() {
		$('#cpf-dep').mask('000.000.000-00');
		$('#telefone-dep').mask('(00) 00000-0000');
		//$('#doc').attr('placeholder','CPF');
		document.getElementById('filiacao-dep').style.display = 'block';

		$('#parentesco-dep').change(function(){
			if($(this).val() != '4'){
				//$('#doc').mask('000.000.000-00');
				//$('#doc').attr('placeholder','CPF');
				document.getElementById('filiacao-dep').style.display = 'block';
			}else{
				//$('#doc').mask('00.000.000/0000-00');
				//$('#doc').attr('placeholder','CNPJ');
				document.getElementById('filiacao-dep').style.display = 'none';
				
			}
		});


	});

</script>





<script type="text/javascript">
	function carregarImgArquivos() {
		var target = document.getElementById('target-arquivos');
		var file = document.querySelector("#arquivo_conta").files[0];

		var arquivo = file['name'];
		resultado = arquivo.split(".", 2);

		if(resultado[1] === 'pdf'){
			$('#target-arquivos').attr('src', "images/pdf.png");
			return;
		}

		if(resultado[1] === 'rar' || resultado[1] === 'zip'){
			$('#target-arquivos').attr('src', "images/rar.png");
			return;
		}

		if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
			$('#target-arquivos').attr('src', "images/word.png");
			return;
		}


		if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
			$('#target-arquivos').attr('src', "images/excel.png");
			return;
		}


		if(resultado[1] === 'xml'){
			$('#target-arquivos').attr('src', "images/xml.png");
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
	$("#form-arquivos").submit(function () {
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: pag + "/arquivos.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem-arquivo').text('');
				$('#mensagem-arquivo').removeClass()
				if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-arq').val('');
						$('#arquivo_conta').val('');
						$('#target-arquivos').attr('src','images/arquivos/sem-foto.png');
						listarArquivos();
					} else {
						$('#mensagem-arquivo').addClass('text-danger')
						$('#mensagem-arquivo').text(mensagem)
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

	});
</script>

<script type="text/javascript">
	function listarArquivos(){
		var id = $('#id-arquivo').val();	
		$.ajax({
			url: pag + "/listar-arquivos.php",
			method: 'POST',
			data: {id},
			dataType: "text",

			success:function(result){
				$("#listar-arquivos").html(result);
			}
		});
	}

</script>


<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});


		$('.sel3').select2({
			dropdownParent: $('#modalDependentes')
		});


		$('.sel4').select2({
			dropdownParent: $('#modalEditarDependente')
		});


		listarBairros();

		$('#cidade').change(function(){
			listarBairros();
		});


	});
</script>




<script type="text/javascript">
	function listarBairros(){
		var cidade = $('#cidade').val();
		$.ajax({
			url: pag + "/listar-bairros.php",
			method: 'POST',
			data: {cidade},
			dataType: "text",

			success:function(result){
				$("#listar-bairros").html(result);
			},

		});
	}
</script>


<script type="text/javascript">
	$("#form-dependentes").submit(function () {
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: pag + "/dependentes.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem-dependente').text('');
				$('#mensagem-dependente').removeClass()
				if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-dep').val('');
						$('#cpf-dep').val('');
						$('#dtnas-dep').val('<?=$data_atual?>');
						$('#sexo-dep').val('M').change();
						$('#parentesco-dep').val('');
						$('#racacor-dep').val('1').change();
						$('#etnia-dep').val('1').change();
						$('#religiao-dep').val('2').change();
						$('#telefone-dep').val('');
						$('#pai-dep').val('');
						$('#mae-dep').val('');
						$('#tipodoc-dep').val('Registro Geral').change();
						$('#docnum-dep').val('');
						$('#docorgao-dep').val('1').change();
						$('#docexpedicao-dep').val('<?=$data_atual?>');
						$('#cartaovacina-dep').val('');
						$('#cartaosus-dep').val('');
						$('#reservista-dep').val('');
						$('#clt-dep').val('');




						//$('#arquivo_conta').val('');
						//$('#target-arquivos').attr('src','images/arquivos/sem-foto.png');
						listarDependentes();
					} else {
						$('#mensagem-dependente').addClass('text-danger')
						$('#mensagem-dependente').text(mensagem)
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

	});
</script>



<script type="text/javascript">
	function listarDependentes(){
		var id = $('#id-provedor').val();	
		$.ajax({
			url: pag + "/listar-dependentes.php",
			method: 'POST',
			data: {id},
			dataType: "text",

			success:function(result){
				$("#listar-dependentes").html(result);
			}
		});
	}

</script>


<script type="text/javascript">
	$("#form-editardependentes").submit(function () {
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: pag + "/editar-dependentes.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem-dependente').text('');
				$('#mensagem-dependente').removeClass()
				if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-editar-dep').val('');
						$('#nomesocial-editar-dep').val('');
						$('#sexo-editar-dep').val('');
						$('#racacor-editar-dep').val('');
						$('#etnia-editar-dep').val('');

						$('#religiao-editar-dep').val('');
						$('#datanasc-editar-dep').val('');
						$('#cpf-editar-dep').val('');
						$('#cartaovacina-editar-dep').val('');
						$('#cartaosus-editar-dep').val('');

						$('#reservista-editar-dep').val('');
						$('#tipodoc-editar-dep').val('');
						$('#docnum-editar-dep').val('');
						$('#docorgao-editar-dep').val('');
						$('#docexpedicao-editar-dep').val('');

						$('#clt-editar-dep').val('');
						$('#telefone-editar-dep').val('');
						$('#pai-editar-dep').val('');
						$('#mae-editar-dep').val('');
						

						//$('#arquivo_conta').val('');
						//$('#target-arquivos').attr('src','images/arquivos/sem-foto.png');
						listarDependentes();
					} else {
						$('#mensagem-dependente').addClass('text-danger')
						$('#mensagem-dependente').text(mensagem)
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

	});
</script>