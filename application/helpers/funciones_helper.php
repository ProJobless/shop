<?php

function configuraMail2(){
	$config = Array(
	  'protocol' => 'smtp',
	  'smtp_host' => 'mail.smadesarrollo.com',
	  'smtp_port' => 26,
	  'smtp_user' => 'noresponder@smadesarrollo.com', // change it to yours
	  'smtp_pass' => '$letmein2u$', // change it to yours
	  'mailtype' => 'html',
	  'charset' => 'utf8',
	  'wordwrap' => TRUE
	);
	return $config;
}

function config_paginacion() {
    $config['full_tag_open'] = '<div class="pagination"><ul>';
    $config['full_tag_close'] = '</ul></div>';
    $config['first_link'] = '<i class="icon icon-double-angle-left"></i>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = '<i class="icon icon-double-angle-right"></i>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['prev_link'] = '<i class="icon icon-angle-left"></i>';
    $config['prev_tag_open'] = '<li class="prev">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '<i class="icon icon-angle-right"></i>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    return $config;
}
