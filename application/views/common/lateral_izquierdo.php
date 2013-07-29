<ul id="categorias">
<?php
$barra_lateral = $global_config['barra_lateral'];
foreach($barra_lateral as $b){
    $cat= $b['info'];
    $subcats = $b['subcats'];?>
    <li class="categoria">
        <strong><?php echo $cat['nombre'];?></strong> &nbsp;<a data-show="si" data-subcategoria="<?php echo $cat['idCategoria'];?>" class="optgroup" href="#N">+</a>
        <ul style="display:none;" class="subcategoria some<?php echo $cat['idCategoria'];?>">
            <?php
            foreach($subcats as $sc){?>
            
                <li>
                    <a style="color:#000;" href="<?php echo site_url('tienda/categoria/'.$sc['idSubcategoria']);?>"><?php echo $sc['nombre'];?></a>
                </li>
            
            <?php
            }
            ?>
        </ul>
    </li>
<?php
}
?>

                        
