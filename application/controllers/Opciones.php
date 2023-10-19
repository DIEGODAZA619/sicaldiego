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
	function cargar_opciones_usuarios() //CARGAR ROLES GENERALES
	{
		$filas = $this->roles_model->listaFuncionario();
		$con=0;
		foreach($filas as $fila)
		{
			$usuario = $this->roles_model->usuarioIdPersona($fila->id);
			$id_usuario = $usuario[0]->id;
			$this->cargar_opciones_todos($id_usuario);						
			$con++;		
		}
		echo $con;
	}

	public function cargar_opciones_todos($id_usuario,$rol = 0)
	{		
		$opciones = array(71,75,85,92,96);
		foreach ($opciones as $opcion)
		{
			if(!$this->roles_model->check_opciones($opcion,$id_usuario))
			{
				$data = array(
					'id_opcion' => $opcion,
					'id_usuario' => $id_usuario,
				);
				$insertar = $this->roles_model->guardarOpcionesRol($data);
				echo $opcion." - ".$id_usuario."<br>";
			}
		}
		return true;
	}
	
	function cargarRolesResponsables()
	{
		$usuario = array(31,32,37,38,89,103,9,33,34,60,131,80,92,44,36,53,47,79,17,112,45,64,24,22,39,162,161,82);
		$opciones = array(86);
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
	function cargarRolesAlmacenes()
	{		
		$usuario = array(104,80);
		$opciones = array(72,73,74,77,80,81,82,83,84,88,89,91,95,97,98);	
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

	function cargarRolesUnidadAdministrativaDireccion()
	{
		$usuario = array(60,44,104,80);
		$opciones = array(72,75,76,79,90,93,94,95,97,98);	
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
	function cargarRolesUnidadAdministrativa()
	{
		$usuario = array(60,80);
		$opciones = array(78,87,95,97,98);	
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

	

	function rolesAdministrativos()
	{
		$this->cargar_opciones_usuarios();
		$this->cargarRolesAlmacenes();
		$this->cargarRolesUnidadAdministrativaDireccion();
		$this->cargarRolesUnidadAdministrativa();
	}

	
}
