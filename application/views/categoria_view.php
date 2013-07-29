<?php 
$data['lateral_izquierdo'] = 1;
$this->load->view('common/header',$data); ?>
<div class='pull-left' style='width:50%;'>
    <?php
    foreach($productos as $p){?>
        <a href="<?php echo site_url('tienda/producto/'.$p['idProducto']);?>">
            <div class='pull-left' style='width:45%;'>
                <h5 class="green_text font_130"><?php echo $p['nombre'];?></h5>
                <center>
                    <img width="176" height="176" alt="<?php echo $p['nombre'];?>" src="<?php echo base_url('img/'.$p['imagen']);?>">
                </center>
                <div class="ver_descripcion">
                    Ver descripción y presentaciones del producto
                </div>
            </div>
        </a>
    <?php
    }
    ?>
    
</div>
<?php 
$data['lateral_derecho'] = 1;
$this->load->view('common/footer',$data); ?>
