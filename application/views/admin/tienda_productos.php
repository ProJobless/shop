<?php $this->load->view('admin/common/header');?>
	<div class="menu"><?php construyeMenu($rol); ?></div>
	<div id="body">
		<?php construyeConsultaProductos($rol);?>
	</div>
<?php $this->load->view('admin/common/footer');?>