<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct(){
		parent::__construct();
		//$this->_is_logued_in();
		$this->load->model('usuarios_model');
		$this->load->model('registro_funcionario_model');
		$this->load->model('roles_model');
	}

	function _is_logued_in()
	{
		$is_logued_in = $this->session->userdata('is_logued_in');
		$id_apliacion = $this->session->userdata('id_apliacion');
		$aplicacion =   $this->config->item('IDAPLICACION');
		if($is_logued_in != TRUE || $id_apliacion != $aplicacion)
		{
			redirect('Login');
		}
	}
	public function migradousuarios()
	{
		$filas = $this->registro_funcionario_model->getListaFuncionario();
		$usuario = "";
		$con = 0;
		foreach($filas as $fila)
		{
			$nombre   = $fila->nombres;
			$nombres  = explode(" ", $nombre);
			$apellido   = $fila->primer_apellido;
			$apellidos  = explode(" ", $apellido);
			$username =  strtolower($nombres[0].".".$apellidos[0]);
			$password = md5(123456);
			$data = array(
				'id_persona' => $fila->id,
				'login'    =>  $username,
				'password'    =>  $password,
				'estado'    =>  'AC',
			);
			if(!$this->usuarios_model->check_usuraio($fila->id,$username))
			{
				$insert = $this->usuarios_model->guardarUsuario($data);
				$con++;
			}
		}
		echo $con;
		//echo json_encode($filas);
	}

	public function cargarclaves()
	{
		$filas = $this->registro_funcionario_model->getListaFuncionario();
		$usuario = "";
		$con = 0;
		foreach($filas as $fila)
		{
			$nombre   = $fila->nombres;
			$nombres  = explode(" ", $nombre);
			$apellido   = $fila->primer_apellido;
			$apellidos  = explode(" ", $apellido);
			$username =  strtolower($nombres[0].".".$apellidos[0]);
			$password = md5(123456);
			//$password = md5($fila->numero_documento);
			$data = array(				
				'password'    =>  $password
			);
			
			$insert = $this->usuarios_model->updateUsuario($fila->id,$data);
			$con++;
			
		}
		echo $con;
		//echo json_encode($filas);
	}




	public function lista_usuario()
	{
		$filas = $this->usuarios_model->getUsuario();
		$con = 0;
		foreach($filas as $fila)
		{
			$rol = $this->cargar_opciones($fila->id);
			$con++;
		}
		echo $con;
	}

	public function cargar_opciones($id_usuario,$rol = 0)
	{
		$opciones = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,19,20,21,22,23,24,25,26,27,28,29,30);
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
}
