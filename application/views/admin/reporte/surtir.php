<?php $this->load->view('admin/common/header'); ?>
<div class="menu"><?php construyeMenu($rol); ?></div>
<div id="body">

    <?php echo form_open(current_url()); ?>
    Seleccione una persona: <select name="select_persona">
        <option value = 'NONE'> --- </option>
        <?php foreach ($surtidores as $surtidor) { ?>
            <option value="<?php echo $surtidor['nombre']; ?>" ><?php echo $surtidor['nombre']; ?></option>
        <?php } ?>
    </select>
    Fecha de inicio:<input type="text" id="inicio" name="fecha_inicio" />
    Fecha de final:<input type="text" id="final" name="fecha_final" />
    <input type="submit" value="consultar" />
    <?php echo form_close(); ?>

    <p style="color: red;"><?php echo validation_errors(); ?></p>

    <?php if ($mostrar == TRUE) { ?>
        <h2>Pedidos Surtidos de <?php echo $_POST['fecha_inicio']; ?> a <?php echo $_POST['fecha_final']; ?></h2>
        <table class="consulta">
            <tr>
                <th>Nombre de Surtidor</th>
                <th>Número de Pedido</th>
                <th>Importe</th>
                <th>Fecha de Pedido</th>
                <th>Fecha de Surtido</th>
                <th>Tiempo Utilizado</th>
            </tr>
            <?php
            /* echo '<pre>';
              print_r($consulta->result_array()); */

            foreach ($consulta->result() as $resultado) {
                $fecha_sig = NULL;
                foreach ($pedido[$resultado->Pedido_idPedido]['fecha_siguiente']->result() as $fecha) {
                    $fecha_sig = $fecha->fecha_aut;
                    //echo $fecha_sig.'<br />';
                }
                foreach ($pedido[$resultado->Pedido_idPedido]['importe_pedido']->result() as $importe) {
                    $importe_total = $importe->total;
                }
                
                foreach ($pedido[$resultado->Pedido_idPedido]['fecha_recepcion']->result() as $fecha) {
                    $fecha_rec = $fecha->fecha_aut;
                }
                
                if (!empty($fecha_sig) && $fecha_sig != NULL) {
                    $time = $this->pedido->get_diferencia($fecha_sig,$fecha_rec);
                } else {
                    $time = 'No se ha terminado de surtir aún';
                }
                //				echo strtotime($resultado->fecha_aut) - strtotime($fecha_sig);
                ?>
                <tr>
                    <td><?php echo $resultado->persona_dos; ?></td>
                    <td><?php echo $resultado->Pedido_idPedido; ?></td>
                    <td><?php echo '$' . number_format($importe_total, 2); ?></td>
                    <td><?php echo $fecha_rec; ?></td>
                    <td><?php echo $fecha_sig; ?></td>
                    <td><?php echo $time; ?></td>
                </tr>

                <?php
                $sumatoria += $importe_total;
            }
            ?>
            <tr>
                <td colspan="6" style="text-align:right;"><i>Suma de Importes:<?php echo '$' . number_format($sumatoria, 2); ?></i></td>
            </tr>
        </table>
        <?php
        /* echo '<pre>';
          print_r($consulta->result()); */
        ?>

    <?php } ?>
</div>
    <?php $this->load->view('admin/common/footer'); ?>