<!DOCTYPE html>

<html lang="es">

    <head>

        <meta charset="utf-8">

        <title>Shop | Some</title>

        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url(); ?>css/screen.css" rel="stylesheet" type="text/css" />

        

        <style>

            td {

                vertical-align: top;

            }

        </style>    

            

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.js"></script>
        
        <script type=”text/javascript” >
			$(document).ready(function(){
			$(".dropdown-toggle").dropdown();

			});

		</script>


        

        

        

        

    </head>

    <body>

        <div class='container' style='margin-top:15px; width:85%; min-width: 1100px'>

            

                <div id="lang_changer" class='pull-right'>

                    <select class="lang_checker">

                        <optgroup label="Escoge un idioma">

                            <option value="es">Español</option>

                            <option value="en">English</option>

                        </optgroup>

                    </select>
				
                </div>

                <div class='clearfix'></div>

                <div id='imagenes'  style='height:200px; background-image:url(../../../img/headerback.jpg);' >
                <img style="float:left; margin-top:20px; margin-left:10px" src="/img/logo-tecno.gif" /><a href="http://www.expoas.com.mx" target="_blank" ><img style="float:right; margin-top:20px; margin-right:20px;" src="/img/banner-expo-agosto.jpg" width="197" height="162" alt="expoalternativas"></a>
				<a href="http://www.exposiempresaludable.com.mx" target="_blank"><img  style="float:right; margin-top:20px; margin-right:25px;" src="/img/banner-expo-guadalajara.jpg" width="197" height="162" alt="exposiempresaludable"></a>
                </div>
             
    <div class='clearfix'></div>

                <div id='menu' class="navbar">

                    <div class="navbar-inner">

                        <ul class="nav">

                            <li><a href="#">Catalogo Virtual</a></li>

                            <li><a href="<?php echo site_url('tienda');?>">Productos Nuevos</a></li>

                            <li><a href="<?php echo site_url('cuenta');?>">Mi Cuenta</a></li>

                            <li class="dropdown"><a href="#" class="dropdown-toggle" role="menu" data-toggle="dropdown">Contáctenos</a>
<ul class="dropdown-menu">
                                <li> <a role="presentation" tabindex="-1" href="#">Ventas e Informes</a></li>
                                <li><a role="menuitem" tabindex="-1" href="#">Quejas y Sugerencias</a></li>
                                <li><a role="menuitem" tabindex="-1" href="#">Asesoría de producto</a></li>
                              
                            </ul>

</li>

                        </ul>

                    </div>

                </div>

                

                <div id="error_ajax" class='alert alert-error' style='display:none;'>ERROR GENÉRICO</div> 

                

                <?php 

                $tmp = $this->phpsession->flashget('acierto');

                if(!empty($tmp)){?>

                  <div class="alert alert-success">

                    <a href="#" class="close" data-dismiss="alert">×</a>

                    <?php echo ($tmp); ?>

                  </div>

                <?php

                }

                ?>



                <?php 

                $tmp = $this->phpsession->flashget('error');

                if(!empty($tmp)){?>

                  <div class="alert alert-error">

                    <a href="#" class="close" data-dismiss="alert">×</a>

                    <?php echo ($tmp); ?>

                  </div>

                <?php

                }

                ?>



                <?php 

                $tmp = validation_errors();

                if(!empty($tmp)){?>

                  <div class="alert alert-error">

                    <a href="#" class="close" data-dismiss="alert">×</a>

                    <?php echo (validation_errors()); ?>

                  </div>

                <?php

                }

                ?>

                

                <?php 

                if($lateral_izquierdo!=0){?>

                <div class='pull-left' style='width:20%'>

                    <?php $this->load->view('common/lateral_izquierdo');?>

                </div>    

                <?php

                }

                ?>

                

                

                

