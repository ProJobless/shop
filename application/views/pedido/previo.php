<?php 
$data['lateral_izquierdo'] = 1;
$this->load->view('common/header',$data); ?>

<div class='pull-left' style='width:75%;'>
    <div class="indice">
        <img src="http://www.tecnobotanicademexico.com.mx/admin/img/cont_heading_td.gif"> Pedido
    </div>
    <br />
    <div id='carro'>
        <?php $this->load->view('carro/mediano');?>
    </div>

</div>


<?php 
$data['lateral_derecho'] = 0;
$this->load->view('common/footer',$data); ?>		