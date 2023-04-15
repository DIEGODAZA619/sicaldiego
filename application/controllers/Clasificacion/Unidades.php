<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidades extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('unidades_model');
		$this->load->helper('configuraciones_helper');
		$this->load->helper('correlativos_helper');
		$this->load->library('fpdf/pdf2');
		$this->load->helper('date');

	}
	function _is_logued_in()
	{
		$is_logued_in = $this->session->userdata('is_logued_in');
		if($is_logued_in != TRUE)
		{
			redirect('Login');
		}
	}
	function index()
	{
		$id_usuario = $this->session->userdata('id_usuario');
		$dato['rolescero'] = $this->session->userdata('rolescero');
		$dato['roles']  = $this->session->userdata('roles');
		$dato['gestion']  = $this->session->userdata('gestion');
		$dato['nombre_usuario']  = $this->session->userdata('nombre_completo');
		$this->load->view('inicio/cabecera',$dato);
		$this->load->view('inicio/menu', $dato);
		$this->load->view('Clasificacion/formUnidades'); //cuerpo
		$this->load->view('inicio/pie');
	}
	function cargartablasUnidades()
	{
		$draw = intval($this->input->get("draw"));
		$filas = $this->unidades_model->getUnidad();
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = " <span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Eliminar'>
							<button class='btn btn-warning btn-circle' onclick='editarUnidad(".$fila->id.")'><i class='mdi mdi-pencil'></i></button>
						</span>";
		    $data[] = array(
	                $num++,
	                $fila->codigo,
	                $fila->descripcion,
	                $fila->estado,
	                $boton
	           );
	    }
        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($filas),
            "recordsFiltered" => count($filas),
            "data" => $data
        );
	    echo json_encode($output);
	    exit();
	}

	function guardarUnidad()
	{
		$id_registro = $this->input->post('id_unidad');
		$datos = array (
			'codigo' => $this->input->post('txtcodigo_unidad'),
			'descripcion' => $this->input->post('txtdescripcion_unidad'),
			'fecha_modificacion' => date('Y-m-d H:i:s')
		);
		$insert = $this->unidades_model->editarUnidad($id_registro,$datos);
		$resul = 1;
		$id_fila = $insert;
		$mensaje = "MODIFICADO CORRECTAMENTE";

		$resultado ='[{
					"resultado":"'.$resul.'",
					"id_fila":"'.$id_fila.'",
					"mensaje":"'.$mensaje.'"
					}]';

		echo $resultado;
	}
	function idRegistroUnidad()
	{
		$id_registro = $this->input->post('id');
		//$id_registro = 1;
		$filas = $this->unidades_model->getUnidadId($id_registro);
		$datos ='[{
			"id" : "'.$filas[0]->id.'",
			"codigo" : "'.$filas[0]->codigo.'",
			"descripcion" : "'.$filas[0]->descripcion.'"
		}]';

		echo $datos;
	}
}
