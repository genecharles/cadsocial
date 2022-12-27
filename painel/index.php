<?php 
require_once("verificar.php");
require_once("../conexao.php");

$id_usuario = $_SESSION['id_usuario'];
//recuperar os dados do usuário logado
$query = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0){
	$nome_user = $res[0]['nome'];
	$foto_usu = $res[0]['foto'];
	$nivel_usu = $res[0]['nivel'];
	$cpf_usu = $res[0]['cpf'];
	$senha_usu = $res[0]['senha'];
	$email_usu = $res[0]['email'];
	$id_usu = $res[0]['id'];
	
}

if( @$_GET['pagina'] == ""){
	$pagina = 'home';
}else{
	$pagina = @$_GET['pagina'];	
}
 

$esc_gerente = '';
//$esc_rh = '';
$esc_op = '';
$esc_sec = '';
$esc_dig = '';

$classe_widget = '';
//PERMISSÕES DOS USUÁRIOS
if($nivel_usu == "Gerente"){
	$esc_gerente = 'ocultar';
//}else if($nivel_usu == "RH"){
//	$esc_rh = 'ocultar';
//	$classe_widget = 'widget1';
}else if($nivel_usu == "Operador"){
	$esc_op = 'ocultar';
}else if($nivel_usu == "Digitador"){
	$esc_dig = 'ocultar';
}else if($nivel_usu == "Administrador"){
	$esc_admin = 'ocultar';
}

if($nivel_usu != "Gerente" and $nivel_usu != "Administrador"){
	$esc_todos = 'ocultar';
}



$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = $ano_atual."-".$mes_atual."-01";
$data_ano = $ano_atual."-01-01";


?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $nome_sistema; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Sistema para Escritórios desenvolvido no curso do Hugo Vasconcelos do Portal Hugo Cursos" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />

	<!-- font-awesome icons CSS -->
	<link href="css/font-awesome.css" rel="stylesheet"> 
	<!-- //font-awesome icons CSS-->

	<!-- side nav css file -->
	<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
	<!-- //side nav css file -->

	<link rel="stylesheet" href="css/monthly.css">

	<!-- js-->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/modernizr.custom.js"></script>

	<!--webfonts-->
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<!--//webfonts--> 

	<!-- chart -->
	<script src="js/Chart.js"></script>
	<!-- //chart -->

	<!-- Metis Menu -->
	<script src="js/metisMenu.min.js"></script>
	<script src="js/custom.js"></script>
	<link href="css/custom.css" rel="stylesheet">
	<!--//Metis Menu -->

	<link rel="icon" href="../img/<?php echo $favicon ?>" type="image/x-icon">
	<style>
		#chartdiv {
			width: 100%;
			height: 295px;
		}
	</style>
	<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
	<script src="js/pie-chart.js" type="text/javascript"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			$('#demo-pie-1').pieChart({
				barColor: '#2dde98',
				trackColor: '#eee',
				lineCap: 'round',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-2').pieChart({
				barColor: '#8e43e7',
				trackColor: '#eee',
				lineCap: 'butt',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-3').pieChart({
				barColor: '#ffc168',
				trackColor: '#eee',
				lineCap: 'square',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});


		});

	</script>
	<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

	<!-- requried-jsfiles-for owl -->
	<link href="css/owl.carousel.css" rel="stylesheet">
	<script src="js/owl.carousel.js"></script>
	<script>
		$(document).ready(function() {
			$("#owl-demo").owlCarousel({
				items : 3,
				lazyLoad : true,
				autoPlay : true,
				pagination : true,
				nav:true,
			});
		});
	</script>
	<!-- //requried-jsfiles-for owl -->

	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>


	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>






</head> 
<body class="cbp-spmenu-push">

	<div class="main-content">
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<!--left-fixed -navigation-->
			<aside class="sidebar-left" >
				<nav class="navbar navbar-inverse" style="overflow: scroll; height:100%">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<h1><a class="navbar-brand" href="./"><span class="fa fa-area-chart"></span> SETRABES<span class="dashboard_text">Sistema Social</span></a></h1>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="sidebar-menu">
							<li class="header">MENU DE NAVEGAÇÃO</li>
							<li class="treeview">
								<a href="./">
									<i class="fa fa-dashboard"></i> <span>Home</span>
								</a>
							</li>


							<li class="treeview <?php echo $esc_todos ?>">
								<a href="#">
									<i class="fa fa-cog"></i>
									<span>Sistema</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">									

									<li><a href="index.php?pagina=funcionarios"><i class="fa fa-angle-right"></i> Funcionários</a></li>

									<li class="<?php echo $esc_todos ?>"><a href="index.php?pagina=usuarios"><i class="fa fa-angle-right"></i> Usuários</a></li>
<!--
									<li><a href="index.php?pagina=cargos"><i class="fa fa-angle-right"></i> Nivel Acesso</a></li>-->
									
								</ul>
							</li>


							<li class="treeview <?php echo $esc_todos ?>">
								<a href="#">
									<i class="fa fa-plus"></i>
									<span>Cadastros</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">

									<li><a href="index.php?pagina=paises"><i class="fa fa-angle-right"></i> País</a></li>

									<li><a href="index.php?pagina=estado"><i class="fa fa-angle-right"></i> Estado</a></li>

									<li><a href="index.php?pagina=cidades"><i class="fa fa-angle-right"></i> Município</a></li>

									<li><a href="index.php?pagina=bairros"><i class="fa fa-angle-right"></i> Bairro</a></li>

									<li><a href="index.php?pagina=religiao"><i class="fa fa-angle-right"></i> Religião</a></li>

									<li><a href="index.php?pagina=etnia"><i class="fa fa-angle-right"></i> Etnia</a></li>

									<li><a href="index.php?pagina=grauparentesco"><i class="fa fa-angle-right"></i> Grau Parentesco</a></li>
<!--
									<li><a href="index.php?pagina=frequencias"><i class="fa fa-angle-right"></i> Frequências</a></li>

									<li><a href="index.php?pagina=contas_banco"><i class="fa fa-angle-right"></i> Contas Bancárias</a></li>-->
									
								</ul>
							</li>


							<li class="treeview">
								<a href="#">
									<i class="fa fa-user"></i>
									<span>Pessoas</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">								
									
<!--
									<li><a href="index.php?pagina=clientes"><i class="fa fa-angle-right"></i> Clientes</a></li> -->

									<li><a href="index.php?pagina=pessoas"><i class="fa fa-angle-right"></i> Beneficiario</a></li>

									<li class="<?php echo $esc_todos ?>"><a href="index.php?pagina=fornecedores"><i class="fa fa-angle-right"></i> Fornecedores</a></li>

									

								</ul>
							</li>


							<li class="treeview  <?php echo $esc_dig ?>">
								<a href="#">
									<i class="fa fa-usd"></i>
									<span>Movimentações</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">								
									<li><a href="index.php?pagina=pagar"><i class="fa fa-angle-right"></i> Contas à Pagar</a></li>

									<li><a href="index.php?pagina=receber"><i class="fa fa-angle-right"></i> Contas à Receber</a></li>

									<li><a href="index.php?pagina=movimentacoes"><i class="fa fa-angle-right"></i> Extrato Caixa</a></li>

									<li><a href="#" data-toggle="modal" data-target="#RelFin"><i class="fa fa-angle-right"></i> Relatório Financeiro</a></li>

								</ul>
							</li>


							<li class="treeview">
								<a href="#">
									<i class="fa fa-calendar-o"></i>
									<span>Tarefas</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">								
									<li class="<?php echo $esc_todos ?>"><a href="index.php?pagina=tarefas-escritorio"><i class="fa fa-angle-right"></i> Tarefas Escritório</a></li>

									<li><a href="index.php?pagina=tarefas"><i class="fa fa-angle-right"></i> Minhas Tarefas</a></li>

									<li><a href="index.php?pagina=agenda"><i class="fa fa-angle-right"></i> Agenda de Tarefas</a></li>									

								</ul>
							</li>



							<li class="treeview">
								<a href="#">
									<i class="fa fa-file-o"></i>
									<span>GED (Arquivos)</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">								
									<li class="<?php echo $esc_todos ?>"><a href="index.php?pagina=setor_arquivos"><i class="fa fa-angle-right"></i> Setor Arquivo</a></li>

									<li><a href="index.php?pagina=cat_arquivos"><i class="fa fa-angle-right"></i> Categoria Arquivos</a></li>

									<li><a href="index.php?pagina=grupo_arquivos"><i class="fa fa-angle-right"></i> Grupo Arquivos</a></li>

									<li><a href="index.php?pagina=arquivos"><i class="fa fa-angle-right"></i> Cadastro de Arquivos</a></li>									

								</ul>
							</li>



							<li class="treeview <?php echo $esc_op ?> <?php echo $esc_sec ?> <?php echo $esc_dig?> ">
								<a href="#">
									<i class="fa fa-wpforms"></i>
									<span>Gestão RH</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">								
									<li><a href="index.php?pagina=ponto"><i class="fa fa-angle-right"></i> Lançar Ponto</a></li>

																	

								</ul>
							</li>


							<li class="treeview <?php echo $esc_todos ?>">
								<a href="#">
									<i class="fa fa-lock"></i>
									<span>Logs</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li><a href="index.php?pagina=logs"><i class="fa fa-angle-right"></i> Ver Logs</a></li>

									<li><a href="#" data-toggle="modal" data-target="#RelLogs"><i class="fa fa-angle-right"></i> Relatório de Logs</a></li>
									
								</ul>
							</li>



							
								</ul>
							</div>
							<!-- /.navbar-collapse -->
						</nav>
					</aside>
				</div>
				<!--left-fixed -navigation-->

				<!-- header-starts -->
				<div class="sticky-header header-section ">
					<div class="header-left">
						<!--toggle button start-->
						<button id="showLeftPush"><i class="fa fa-bars"></i></button>
						<!--toggle button end-->
						<div class="profile_details_left"><!--notifications of menu start -->
							<ul class="nofitications-dropdown">
								

								<?php 
								$query2 = $pdo->query("SELECT * FROM tarefas where status = 'Agendada' and usuario = '$id_usu' order by data asc, hora asc ");
								$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
								$tarefasPendentes_taref = @count($res2);

								$query = $pdo->query("SELECT * FROM tarefas where status = 'Agendada' and usuario = '$id_usu' order by data asc, hora asc limit 6 ");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$tarefasPendentes_taref_limit = @count($res);
								 ?>
								<li class="dropdown head-dpdn">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue1"><?php echo $tarefasPendentes_taref ?></span></a>
									<ul class="dropdown-menu">
										<li>
											<div class="notification_header">
												<h3>Você possui <?php echo $tarefasPendentes_taref ?> Tarefas Pendentes!</h3>
											</div>
										</li>

										<?php 
											if($tarefasPendentes_taref_limit > 0){
											for($i=0; $i < $tarefasPendentes_taref_limit; $i++){
												foreach ($res[$i] as $key => $value){}
											$id_taref = $res[$i]['id'];
											$titulo_taref = $res[$i]['titulo'];	
											$hora_taref = $res[$i]['hora'];
											$data_taref = $res[$i]['data'];
											
											$dataF_taref = implode('/', array_reverse(explode('-', $data_taref)));
											$horaF_taref = date("H:i", strtotime($hora_taref));
										 ?>
										<li>
											<a href="#">
											<div class="notification_desc">
												<p><i class="fa fa-calendar-o text-danger" style="margin-right: 3px"></i><?php echo $titulo_taref ?></p>
												<p><span><?php echo $dataF_taref ?> às <?php echo $horaF_taref ?></span></p>
											</div>
											<div class="clearfix"></div>	
											</a>
											<hr style="margin:2px">
										</li>
									<?php }} ?>								
									
										
										<li>
											<div class="notification_bottom">
												<a href="index.php?pagina=agenda">Ver toda Agenda</a>
											</div> 
										</li>
									</ul>
								</li>	
								
							</ul>
							<div class="clearfix"> </div>
						</div>
						<!--notification menu end -->
						<div class="clearfix"> </div>
					</div>
					<div class="header-right">




						<div class="profile_details">		
							<ul>
								<li class="dropdown profile_details_drop">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<div class="profile_img">	
											<span class="prfil-img"><img src="images/perfil/<?php echo $foto_usu ?>" alt="" width="50px" height="50px"> </span> 
											<div class="user-name">
												<p><?php echo $nome_user ?></p>
												<span><?php echo $nivel_usu ?></span>
											</div>
											<i class="fa fa-angle-down lnr"></i>
											<i class="fa fa-angle-up lnr"></i>
											<div class="clearfix"></div>	
										</div>	
									</a>
									<ul class="dropdown-menu drp-mnu">

										<li> <a href="#" data-toggle="modal" data-target="#modalPerfil"><i class="fa fa-user"></i> Perfil</a> </li> 

										<li class="<?php echo $esc_todos ?>"> <a href="#" data-toggle="modal" data-target="#modalConfig"><i class="fa fa-cog"></i> Configurações</a> </li> 

										<li> <a href="../logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
									</ul>
								</li>
							</ul>
						</div>
						<div class="clearfix"> </div>				
					</div>
					<div class="clearfix"> </div>	
				</div>
				<!-- //header-ends -->




				<!-- main content start-->
				<div id="page-wrapper">					
					<?php 
					require_once($pagina.'.php');					
					?>
				</div>



			</div>

			<!-- new added graphs chart js-->

			<script src="js/Chart.bundle.js"></script>
			<script src="js/utils.js"></script>

			
    <!-- new added graphs chart js-->

    <!-- Classie --><!-- for toggle left push menu script -->
    <script src="js/classie.js"></script>
    <script>
    	var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
    	showLeftPush = document.getElementById( 'showLeftPush' ),
    	body = document.body;

    	showLeftPush.onclick = function() {
    		classie.toggle( this, 'active' );
    		classie.toggle( body, 'cbp-spmenu-push-toright' );
    		classie.toggle( menuLeft, 'cbp-spmenu-open' );
    		disableOther( 'showLeftPush' );
    	};


    	function disableOther( button ) {
    		if( button !== 'showLeftPush' ) {
    			classie.toggle( showLeftPush, 'disabled' );
    		}
    	}
    </script>
    <!-- //Classie --><!-- //for toggle left push menu script -->

    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->

    <!-- side nav js -->
    <script src='js/SidebarNav.min.js' type='text/javascript'></script>
    <script>
    	$('.sidebar-menu').SidebarNav()
    </script>
    <!-- //side nav js -->

    <!-- for index page weekly sales java script -->
    <script src="js/SimpleChart.js"></script>
   


    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
    <!-- //Bootstrap Core JavaScript -->

    <!-- Mascaras JS -->
    <script type="text/javascript" src="js/mascaras.js"></script>
    <!-- Ajax para funcionar Mascaras JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 

</body>
</html>




<!-- Modal -->
<div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Editar Dados</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-usu">
			<div class="modal-body">

				<div class="row">
					<div class="col-md-6">						
						<div class="form-group"> 
							<label>Nome</label> 
							<input type="text" class="form-control" name="nome_usu" value="<?php echo $nome_user ?>" required> 
						</div>						
					</div>
					<div class="col-md-6">
						<div class="form-group"> 
							<label>CPF</label> 
							<input type="text" class="form-control" id="cpf_usu" name="cpf_usu" value="<?php echo $cpf_usu ?>" required> 
						</div>
					</div>

				</div>


				<div class="row">
					<div class="col-md-6">						
						<div class="form-group"> 
							<label>Email</label> 
							<input type="email" class="form-control" name="email_usu" value="<?php echo $email_usu ?>" required> 
						</div>						
					</div>
					<div class="col-md-6">
						<div class="form-group"> 
							<label>Senha</label> 
							<input type="password" class="form-control" name="senha_usu" value="<?php echo $senha_usu ?>" required> 
						</div>
					</div>

				</div>	


				<div class="row">
					<div class="col-md-8">						
						<div class="form-group"> 
							<label>Foto</label> 
							<input type="file" name="foto" onChange="carregarImg2();" id="foto-usu">
						</div>						
					</div>
					<div class="col-md-4">
						<div id="divImg">
							<img src="images/perfil/<?php echo $foto_usu ?>"  width="100px" id="target-usu">									
						</div>
					</div>

				</div>

				<input type="hidden" name="id_usu" value="<?php echo $id_usuario ?>">
				<input type="hidden" name="foto_usu" value="<?php echo $foto_usu ?>">

				<small><div id="msg-usu" align="center" class="mt-3"></div></small>					

			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Editar Dados</button>
			</div>
			</form>

		</div>
	</div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Configurações do Sistema</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-config">
			<div class="modal-body">

				<div class="row">
					<div class="col-md-3">						
						<div class="form-group"> 
							<label>Nome</label> 
							<input type="text" class="form-control" name="nome_config" value="<?php echo $nome_sistema ?>" required> 
						</div>						
					</div>
					<div class="col-md-3">						
						<div class="form-group"> 
							<label>Telefone</label> 
							<input type="text" class="form-control" name="tel_config" id="tel_config" value="<?php echo $tel_sistema ?>" > 
						</div>						
					</div>
					<div class="col-md-6">
						<div class="form-group"> 
							<label>Endereço</label> 
							<input type="text" class="form-control" name="end_config" value="<?php echo $end_sistema ?>" > 
						</div>
					</div>

				</div>


				<div class="row">
					<div class="col-md-4">						
						<div class="form-group"> 
							<label>Email</label> 
							<input type="email" class="form-control" name="email_config" value="<?php echo $email_adm ?>" required> 
						</div>						
					</div>
					<div class="col-md-2">
						<div class="form-group"> 
							<label>Capturar Logs</label> 
							<select class="form-control" name="logs"  required> 
								<option <?php if($logs == 'Sim'){ ?>selected <?php } ?> value="Sim">Sim</option>
								<option <?php if($logs == 'Não'){ ?>selected <?php } ?> value="Não">Não</option>
							</select>
						</div>
					</div>

					<div class="col-md-3">						
						<div class="form-group"> 
							<label>Dias Limpar Logs</label> 
							<input type="number" class="form-control" name="dias_limpar_logs" value="<?php echo $dias_limpar_logs ?>" required> 
						</div>						
					</div>

					<div class="col-md-3">						
						<div class="form-group"> 
							<label>Relatório PDF / HTML</label> 
							<select class="form-control" name="rel"  required> 
								<option <?php if($relatorio_pdf == 'pdf'){ ?>selected <?php } ?> value="pdf">PDF</option>
								<option <?php if($relatorio_pdf == 'html'){ ?>selected <?php } ?> value="html">HTML</option>
							</select>
						</div>						
					</div>

				</div>	


				<div class="row">
					<div class="col-md-2">						
						<div class="form-group"> 
							<label>Logo</label> 
							<input type="file" name="logo" onChange="carregarImgLogo();" id="foto-logo">
						</div>						
					</div>
					<div class="col-md-4">
						<div id="divImgLogo">
							<img src="../img/<?php echo $logo ?>"  width="100px" id="target-logo">									
						</div>
					</div>



					<div class="col-md-4">						
						<div class="form-group"> 
							<label>Favicon (ico)</label> 
							<input type="file" name="favicon" onChange="carregarImgFavicon();" id="foto-favicon">
						</div>						
					</div>
					<div class="col-md-2">
						<div id="divImgFavicon">
							<img src="../img/<?php echo $favicon ?>"  width="20px" id="target-favicon">									
						</div>
					</div>



					

				</div>


				<div class="row">

					<div class="col-md-3">						
						<div class="form-group"> 
							<label>Img Relatório (*jpg) 200x60</label> 
							<input type="file" name="imgRel" onChange="carregarImgRel();" id="foto-rel">
						</div>						
					</div>
					<div class="col-md-3">
						<div id="divImgRel">
							<img src="../img/<?php echo $logo_rel ?>"  width="100px" id="target-rel">									
						</div>
					</div>

				</div>

				<input type="hidden" name="id_usu" value="<?php echo $id_usuario ?>">
				<input type="hidden" name="foto_usu" value="<?php echo $foto_usu ?>">

				<small><div id="msg-config" align="center" class="mt-3"></div></small>					

			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Editar Dados</button>
			</div>
			</form>

		</div>
	</div>
</div>









<!-- Modal Rel Logs -->
<div class="modal fade" id="RelLogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Logs
					<small>(
										<a href="#" onclick="datas('1980-01-01', 'tudo-Logs', 'Logs')">
											<span style="color:#000" id="tudo-Logs">Tudo</span>
										</a> / 
									<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Logs', 'Logs')">
											<span id="hoje-Logs">Hoje</span>
										</a> /
										<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Logs', 'Logs')">
											<span style="color:#000" id="mes-Logs">Mês</span>
										</a> /
										<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Logs', 'Logs')">
											<span style="color:#000" id="ano-Logs">Ano</span>
										</a> 
									)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="rel/logs_class.php" target="_blank">
			<div class="modal-body">

				<div class="row">
					<div class="col-md-6">						
						<div class="form-group"> 
							<label>Data Inicial</label> 
							<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Logs" value="<?php echo date('Y-m-d') ?>" required> 
						</div>						
					</div>
					<div class="col-md-6">
						<div class="form-group"> 
							<label>Data Final</label> 
							<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Logs" value="<?php echo date('Y-m-d') ?>" required> 
						</div>
					</div>

				</div>


				<div class="row">
					<div class="col-md-4">						
						<div class="form-group"> 
							<label>Ações</label> 
							<select class="form-control" name="acao">
								<option value="">Selecionar Ação</option>
								<option value="login">Login</option>
								<option value="inserção">Inserção</option>
								<option value="exclusão">Exclusão</option>
								<option value="edição">Edição</option>
								<option value="logout">Logout</option>
							</select> 
						</div>						
					</div>
					
					<div class="col-md-4">						
						<div class="form-group"> 
							<label>Usuário</label> 
							<select class="form-control sel2index" name="usuario" style="width:100%;">
								<option value="">Selecionar Usuário</option>
								<?php 
									$query = $pdo->query("SELECT * FROM usuarios order by nome asc");
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
							<label>Tabelas</label> 
							<select class="form-control sel2index" name="tabela" style="width:100%;">
								<option value="">Selecionar Tabela</option>
								<?php 
									$query = $pdo->query("SELECT table_name FROM information_schema.tables where table_schema = '$banco'");							
									$res = $query->fetchAll(PDO::FETCH_ASSOC);

									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['table_name'] ?>"><?php echo $res[$i]['table_name'] ?></option>

									<?php } ?>
							</select> 
						</div>						
					</div>

				</div>	
				

			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Gerar Relatório</button>
			</div>
			</form>

		</div>
	</div>
</div>







<!-- Modal Rel Fin -->
<div class="modal fade" id="RelFin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório Financeiro
					<small>(
										<a href="#" onclick="datas('1980-01-01', 'tudo-Fin', 'Fin')">
											<span style="color:#000" id="tudo-Fin">Tudo</span>
										</a> / 
									<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Fin', 'Fin')">
											<span id="hoje-Fin">Hoje</span>
										</a> /
										<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Fin', 'Fin')">
											<span style="color:#000" id="mes-Fin">Mês</span>
										</a> /
										<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Fin', 'Fin')">
											<span style="color:#000" id="ano-Fin">Ano</span>
										</a> 
									)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="rel/financeiro_class.php" target="_blank">
			<div class="modal-body">

				<div class="row">
					<div class="col-md-6">						
						<div class="form-group"> 
							<label>Data Inicial</label> 
							<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Fin" value="<?php echo date('Y-m-d') ?>" required> 
						</div>						
					</div>
					<div class="col-md-6">
						<div class="form-group"> 
							<label>Data Final</label> 
							<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Fin" value="<?php echo date('Y-m-d') ?>" required> 
						</div>
					</div>

				</div>


				<div class="row">
					<div class="col-md-6">						
						<div class="form-group"> 
							<label>Movimentações em:</label> 
							<select class="form-control " name="local_filtro">
								<option value="">Tudo</option>
								<option value="Caixa">Caixa</option>
									<option value="Cartão de Débito">Cartão de Débito</option>
									<option value="Cartão de Crédito">Cartão de Crédito</option>

									<?php 
									$query = $pdo->query("SELECT * FROM contas_banco order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>
							</select> 
						</div>						
					</div>
					
					<div class="col-md-6">						
						<div class="form-group"> 
							<label>Entrada / Saídas</label> 
							<select class="form-control" name="tipo_mov" style="width:100%;">
								<option value="">Tudo</option>
								<option value="Entrada">Entrada</option>
								<option value="Saída">Saída</option>
							</select> 
						</div>						
					</div>



				</div>	
				

			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Gerar Relatório</button>
			</div>
			</form>

		</div>
	</div>
</div>






<script type="text/javascript">
	function carregarImg2() {
		var target = document.getElementById('target-usu');
		var file = document.querySelector("#foto-usu").files[0];

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
	function carregarImgLogo() {
		var target = document.getElementById('target-logo');
		var file = document.querySelector("#foto-logo").files[0];

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
	function carregarImgFavicon() {
		var target = document.getElementById('target-favicon');
		var file = document.querySelector("#foto-favicon").files[0];

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
	function carregarImgRel() {
		var target = document.getElementById('target-rel');
		var file = document.querySelector("#foto-rel").files[0];

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
	$("#form-usu").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-dados.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-usu').text('');
				$('#msg-usu').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {					
					location.reload();
				} else {

					$('#msg-usu').addClass('text-danger')
					$('#msg-usu').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>





<script type="text/javascript">
	$("#form-config").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-config.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-config').text('');
				$('#msg-config').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {					
					location.reload();
				} else {

					$('#msg-config').addClass('text-danger')
					$('#msg-config').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>




<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2index').select2({
			dropdownParent: $('#RelLogs')
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
	function datas(data, id, campo){
		var data_atual = "<?=$data_atual?>";
		$('#dataInicialRel-'+campo).val(data);
		$('#dataFinalRel-'+campo).val(data_atual);

		document.getElementById('hoje-'+campo).style.color = "#000";
		document.getElementById('mes-'+campo).style.color = "#000";
		document.getElementById(id).style.color = "blue";	
		document.getElementById('tudo-'+campo).style.color = "#000";
		document.getElementById('ano-'+campo).style.color = "#000";
		document.getElementById(id).style.color = "blue";		
	}
</script>