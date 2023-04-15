<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historial extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('materiales_model');
		$this->load->model('ingresos_model');
		$this->load->model('materiales_model');
		$this->load->model('solicitudes_model');
		$this->load->helper('configuraciones_helper');
		$this->load->helper('correlativos_helper');
		$this->load->helper('funcionarios_helper');
		$this->load->library('fpdf/pdf2');
		$this->load->helper('date');
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
	function index()
	{
		$id_usuario = $this->session->userdata('id_usuario');
		$dato['rolescero'] = $this->session->userdata('rolescero');
		$dato['roles']  = $this->session->userdata('roles');
		$dato['gestion']  = $this->session->userdata('gestion');
		$dato['nombre_usuario']  = $this->session->userdata('nombre_completo');
		$dato['tipo_solicitud']  = "NOR";
		$this->load->view('inicio/cabecera',$dato);
		$this->load->view('inicio/menu', $dato);
		$this->load->view('Solicitudes/historialSolicitud'); //cuerpo
		$this->load->view('inicio/pie');
	}

	function cargartablasSolicitudesMaterialesAlmacen()
	{
		$draw = intval($this->input->get("draw"));
		$id_funcionario    = $this->session->userdata('id_funcionario');
		$gestion = 2023;
		$filas = $this->solicitudes_model->confirmarSolicitudIndividual($id_funcionario,$gestion);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";

		    $data[] = array(
	                $num++,
	                datos_persona_nombre($fila->id_funcionario),
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                substr($fila->codigo_categoria,0,5),
	                $fila->cantidad_solicitada,
	                $fila->cantidad_autorizada,
	                formato_fecha_slash($fila->fecha_registro),
	                descripcion_estados($fila->estado)	                
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

	
	
}

