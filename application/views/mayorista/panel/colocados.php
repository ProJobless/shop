<?php $this->load->view('mayorista/header'); ?>
<br />
<div class="container" style="margin:auto;">
    <div class='pull-left'><?php echo $this->pagination->create_links();?></div>
    <div class='clearfix'></div>
    
    <table class=' table table-bordered table-hover'>
        <thead>
            <tr>
                <th>Número de Pedido</th>
                <th>Fecha de Pedido</th>
                <th>Estado</th>
                <!--<th>Exportar a Excel</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($pedidos as $p){?>
            <tr>
                <td><?php echo $p['idPedido'];?></td>
                <td><?php echo $p['fecha_pedido'];?></td>
                <td><?php echo $p['estado'];?></td>
                <!--<td><button onclick="window.open('<?php echo site_url('admin/pedido/excel/'.$p['idPedido']);?>','newwindow','width=400,height=200');">Exportar</button></td>-->
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <script type='text/javascript'>
        
        $(document).ready(function(){
            
            
            
            
        });
    </script>
</div>
<?php $this->load->view('mayorista/footer'); ?>