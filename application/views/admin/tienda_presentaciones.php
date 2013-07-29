<?php $this->load->view('admin/common/header');?>
	<div class="menu"><?php construyeMenu($rol); ?></div>
	<div id="body">
		<?php 
		if ($accion == "consulta"){
		construyeConsultaPresentaciones($rol);
		}else{
		construyeEdicionPresentaciones($rol);
		}?>
	</div>
<?php $this->load->view('admin/common/footer');?>