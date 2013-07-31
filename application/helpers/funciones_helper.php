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
