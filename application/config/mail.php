<?php 
	$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.example.com',
    'smtp_port' => 465,
    'smtp_user' => 'user@example.com',
    'smtp_pass' => 'password',
    'mailtype' => 'html',
    'charset' => 'utf-8'
);
$this->email->initialize($config);
