<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opciones extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->_is_logued_in();
		$this->load->helper('configuraciones_helper');
		$this->load->model('roles_model');
	}
	function _is_logued_in()
	{
		$is_logued_in = $this->session->userdata('is_logued_in');
		if($is_logued_in != TRUE)
		{
			redirect('Login');
		}
	}

	function index2()
	{
		echo "inicio";
	}
	
	function cargarRolesAlmacenes()
	{		
		$usuario = array(1);
		$opciones = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28);	
		foreach ($usuario as $id_usuario)
		{
			foreach ($opciones as $opcion)
			{
				if(!$this->roles_model->check_opciones($opcion,$id_usuario))
				{
					$data = array(
						'id_opcion' => $opcion,
						'id_usuario' => $id_usuario,
					);
					$insertar = $this->roles_model->guardarOpcionesRol($data);
					echo $opcion."<br>";
				}
			}
		}
		return true;
	}

	

	
}
