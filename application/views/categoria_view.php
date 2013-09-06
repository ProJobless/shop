<?php 
$data['lateral_izquierdo'] = 1;
$this->load->view('common/header',$data); ?>
<div class='pull-left' style='width:50%;'>
    
    <div class='pull-right paginacion'>
        <?php echo $this->pagination->create_links();?>
    </div>
    <div class='clearfix'></div>
    
    <table class='table table-bordered'>
        <tr>
    <?php
    $cont = 0;
    foreach($productos as $p){?>
            <td style='width:45%;'>
                <a href="<?php echo site_url('tienda/producto/'.$p['idProducto']);?>">
                    <div class=''>
                        <h5 class="green_text font_130"><?php echo $p['nombre'];?></h5>
                        <center>
                            <img width="176" height="176" alt="<?php echo $p['nombre'];?>" src="<?php echo base_url('productos_img/'.$p['imagen']);?>">
                        </center>
                        <div class="ver_descripcion">
                            Ver descripción y presentaciones del producto
                        </div>
                    </div>
                </a>
            </td>
        
    <?php
    $cont++;
    if($cont == 2){
        $cont = 0;
        echo '</tr>';
        echo '<tr>';
    }
    }
    
    if($cont == 1){ echo '<td>&nbsp;</td>'; }
    ?>
    
        </tr>
    </table>
    <div class='clearfix'></div>
    <div class='pull-right paginacion'>
        <?php echo $this->pagination->create_links();?>
    </div>
    <div class='clearfix'></div>
</div>
<?php 
$data['lateral_derecho'] = 1;
$this->load->view('common/footer',$data); ?>
