<table class='table table-bordered table-hover'>
    <tr>
        <th>Nombre</th>
        <th>Tipo Cliente</th>
        <th>Clave de Cliente</th>
        <th>Contraseña</th>
        <th>Fecha de Alta</th>
        <th>Información</th>
        <th>Activo</th>
    </tr>

    <?php foreach ($clientes as $c) { ?>
        <tr>
            <td><?php echo $c['nombre_cliente'] . ' ' . $c['apellido']; ?></td>
            <td><?php echo $c['nombre']; ?></td>
            <td><?php echo $c['abreviatura'] . '' . $c['idCliente']; ?></td>
            <td><?php echo $c['contrasena']; ?></td>
            <td><?php echo $c['fecha']; ?></td>
            <td><a href='<?php echo site_url('cliente/editar/' . $c['idCliente']); ?>' >Editar</a></td>
            <td>
        <center>
            <button class="btn btn-link estado" data-accion="<?php echo ($c['activo'] == 'SI') ? 'NO' : 'SI'; ?>" data-id="<?php echo $c['idCliente']; ?>">
                <span class="badge <?php echo ($c['activo'] == 'SI') ? 'badge-success' : 'badge-important'; ?>" id="estado<?php echo $c['idCliente']; ?>">
                    <i class="icon icon-certificate icon-white"></i>
                </span>
            </button>
            <span style="display:none;" id="load<?php echo $c['idCliente']; ?>"><img src="<?php echo base_url('img/load_small.gif'); ?>"></span>
        </center>
    </td>
    </tr>
    <?php
}
?>

</table>
