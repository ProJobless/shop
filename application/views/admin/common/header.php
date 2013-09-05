<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Administración - <?php if($seccion != 'inicio_login') { echo $nombre_tienda; }?> </title>
	<link href="<?php echo base_url();?>bootstrap/css/bootstrap.css" rel="stylesheet">
	<!--<link href="<?php echo base_url(); ?>css/ddsmoothmenu2.css" rel="stylesheet" type="text/css"> 
	<link href="<?php echo base_url(); ?>css/smooth/smooth.css" rel="stylesheet" type="text/css"> -->
	<link href="<?php echo base_url(); ?>js/menu/menu.css" rel="stylesheet" type="text/css"> 
	<link href="<?php echo base_url();?>css/smooth/smooth.css" rel="stylesheet" type="text/css" />
	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
		color: #0A0A0A;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}
	
	h2 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 16px;
		font-weight: normal;
		margin: 5px;
		/*padding: 14px 15px 10px 15px;*/
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	#container .menu{
		width: inherit;
		margin: -14px 0 20px 0;
		height: 35px;
		background: #88C322;
	}
	
	.consulta th, .consulta1 th{
		background: none repeat scroll 0 0 #EEE;
		border: 1px solid #000000;
		border-collapse: separate;
		font-family: Arial,Helvetica,sans-serif;
		padding: 2px 6px;
	}
	.consulta td{
		border: 1px solid #000000;
		border-collapse: separate;
		font-family: Arial,Helvetica,sans-serif;
		padding: 2px 6px;
		text-align: center;
	}

	.consulta1 td{
		border: 1px solid #000000;
		border-collapse: separate;
		font-family: Arial,Helvetica,sans-serif;
		padding: 2px 6px;
		text-align: left;
	}

	.left td{
		text-align: left;
	}
	
	.consulta .incompleto td{
		border: 1px solid #FF0000;
		background: #F59395;
		color: #000;
	}
	
	.modificar{
		background: none repeat scroll 0 0 #EEE;
	}

	.red{
		background: none repeat scroll 0 0 #F57A7A;
	}
	
	img{
		border: 0;
	}
	.ddsmoothmenu{
		width: inherit;
	}
	</style>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/autoNumeric-1.8.1.js" ></script>
	<script type="text/javascript">
		function calculaPrecio(base,descuento,excepcion){
			//alert(':)');
			var contid=0;
			var check = isNaN(base);
			if(!check){
			var precio = descuento;
				for(var x in precio){
					contid++;
					if(excepcion == precio[x]){
						var price = (base - (-((base * precio[x])/100)));
						//alert(base + '+' + price + '=' + (base - (-price)));
					}else{
						var price = (base - ((base * precio[x])/100));
						//alert(base + '-' + price + '=' + (base - ((base * precio[x])/100)));
					}
					document.getElementById('ID_'+contid).innerHTML = price;
				}
			}
			
		}
	</script>

	
	<script>
	$(function() {
		$( "#inicio" ).datepicker({ dateFormat: "yy-mm-dd" });
		$( "#final" ).datepicker({ dateFormat: "yy-mm-dd" });
		}); 
	</script>

	<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript">
	tinyMCE.init({
	        theme : "advanced",
	        mode : "textareas"
	});
	</script>

	<script type="text/javascript">
		function mostrar(uno,dos){
			document.getElementById(uno).style.display="none";
			document.getElementById(dos).style.display="block";
		}
	</script>

	<script language="javascript" src="<?php echo base_url();?>js/menu/menu.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			
			$(".numerico").autoNumeric({aSep: '', aDec: '.'});
		});
	</script>
</head>
<body>

<div id="container">
	<?php 

	$logged = (!empty($_SESSION['userdata'])) ? $_SESSION['userdata']['logged'] : FALSE; 
			if($logged){
	?>
	<div style="height: 110px;">
		<div style="float:left; height: 100px;"><img src="<?php echo base_url();?>img/logo-tecno.gif" alt="<?php echo $nombre_tienda;?>" height="100"/></div>
		<div id="logout" style="float:right;"><a href="<?php echo site_url('/admin/dashboard/salir');?>">Salir</a></div>
	</div>
	<?php } ?>
	<h1>Panel de Administración  <?php  if($seccion != 'inicio_login') { echo "de ".$nombre_tienda; }?></h1>
	