<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Shop | Some</title>
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        
        <style>
            td {
                vertical-align: top;
            }
        </style>    
            
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        
        
        
        
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
                <div id='imagenes' style='height:200px;'>
                    
                </div>
                <div id='menu' class="navbar">
                    <div class="navbar-inner">
                        <ul class="nav">
                            <li class="active"><a href="#">Catalogo Virtual</a></li>
                            <li><a href="#">Productos Nuevos</a></li>
                            <li><a href="<?php echo site_url('cuenta');?>">Mi Cuenta</a></li>
                            <li><a href="#">Contáctenos</a></li>
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
                <div class='pull-left' style='width:25%'>
                    <?php $this->load->view('common/lateral_izquierdo');?>
                </div>    
                <?php
                }
                ?>
                
                
                
