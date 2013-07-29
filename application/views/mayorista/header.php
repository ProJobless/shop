<?php $user = $this->phpsession->get('datos','mayorista');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
  <title>Tecnobotánica de México | Sistema de Mayoristas</title>

    <!-- Le styles -->
    <link href="<?php echo base_url();?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
    <LINK rel=stylesheet href="<?php echo base_url();?>bootstrap/css/bootstrap-responsive.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/cupertino/jquery-ui.css" type="text/css" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style type="text/css">
        table .header-fixed {
            position: fixed;
            top: 40px;
            z-index: 1020; /* 10 less than .navbar-fixed to prevent any overlap */
            border-bottom: 1px solid #d5d5d5;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            -webkit-box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
            -moz-box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
            box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); /* IE6-9 */
        }
        #tag-container{
            height: 100px; 
            background-color: #FFFFFF; 
            border: 1px solid #CCCCCC; 
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset; 
            transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s; 
            padding: 2px 0;
        }

        span.tag-label{
            float:left; 
            margin: 1px 2px;
        }

        .eliminar_tag:hover span.tag-label{
            text-decoration: line-through;
        }


        #input-tag{
            float:left; 
            border:none;
        }
        
    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/autoNumeric-1.7.4.js" ></script>
    <script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tiny_mce/tiny_mce.js"></script>
    <script src="<?php echo base_url();?>js/fixed-table.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            
            $(".numerico").autoNumeric({aSep: '', aDec: '.'});
            $(".sinpunto").autoNumeric({aSep: ''});
            //alert('documento 1');
            
        });
    </script>
</head>
  <body>


    <div class="container-fluid">
        
        <?php 
        if(!empty($user)){?>
        <div class="navbar">
            <div class="navbar-inner">
                <a class="brand" href="#"><?php echo $user['nombre'].' '.$user['apellido'];?></a>
                <ul class="nav">
                    <li class=""><a href="<?php echo base_url('mayorista/panel/pedido');?>">Colocar Pedido</a></li>
                    <li><a href="<?php echo site_url('mayorista/panel/colocados');?>">Pedidos Colocados</a></li>
                </ul>
                <ul class='nav pull-right'>
                    <li><a href="<?php echo site_url('mayorista/login/salir');?>">Salir</a></li>
                </ul>
            </div>
        </div>
        <?php
        }
        ?>
        
        <?php 
          $tmp = $this->phpsession->flashget('acierto');
          if(!empty($tmp)){?>
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert"><i class='icon icon-remove-sign'></i></a>
              <?php echo ($tmp); ?> 
            </div>
          <?php
          }
          ?>

          <?php 
          $tmp = $this->phpsession->flashget('error');
          if(!empty($tmp)){?>
            <div class="alert alert-error">
              <a href="#" class="close" data-dismiss="alert"><i class='icon icon-remove-sign'></i></a>
              <?php echo ($tmp); ?>
            </div>
          <?php
          }
          ?>

          <?php 
          $tmp = validation_errors();
          if(!empty($tmp)){?>
            <div class="alert alert-error">
              <a href="#" class="close" data-dismiss="alert"><i class='icon icon-remove-sign'></i></a>
              <?php echo (validation_errors()); ?>
            </div>
          <?php
          }
          ?>
        
            <div id='error_ajax' class='alert alert-error' style='display: none;'>
                <p>ERROR.</p>
            </div>
      <div class="row-fluid">
          