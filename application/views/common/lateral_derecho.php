<div id='search'>
    <div class="input-append">
        <input type="text" id="search-input" class="span4">
        <button id='search-button' type="button" class="btn"><i class='icon-search'></i></button>
    </div>
    
</div>
<div id='carro'>
    <?php $this->load->view('carro/pequenio');?>
</div>


<!-- AQUI VAN LAS IMAGENES ZURI -->


<br />
<div id='topten'>
    
    <ul class="topten">
    <?php
    foreach($global_config['top_ten']->result() as $topten){
            ?>
            <?php $idProducto = $topten->idProducto;?>
            <li id="toptenli"><a href="<?php echo site_url("tienda/producto/$idProducto/");?>"><?php echo $topten->nombre;?>(<?php echo $topten->estado_fisico;?>)</a></li>
            <?php
    }
    ?>
    </ul>
    
</div>
