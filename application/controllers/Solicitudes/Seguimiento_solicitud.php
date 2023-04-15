<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguimiento_solicitud extends CI_Controller
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
		$this->load->view('Solicitudes/seguimientoSolicitud'); //cuerpo
		$this->load->view('inicio/pie');
	}
	
	function getEstadoSolicitud()
	{
		
		$options = "";
		$options .= "<option value='-1'>SELECCIONE UNA OPCIÓN</option>";
		$options .= "<option value='CON'>CONFIRMADO</option>";
		$options .= "<option value='APB'>APROBADO</option>";
		$options .= "<option value='AUT'>AUTORIZADO</option>";
		$options .= "<option value='ENT'>ENTREGADO</option>";
		echo $options;
	}


	function cargartablaSolicitudesConfirmadas()
	{
		

		$draw = intval($this->input->get("draw"));
		
		$estado = $this->input->post('est');
		$filas = $this->solicitudes_model->getSolicitudesConfirmadasPorDireccion($estado);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Solicitud'>
						<button class='btn btn-warning btn-circle' onclick='cargarTablasolicitudesIdConfirmacion(".$fila->id.")'><i class='mdi mdi-eye'></i></button>
					 </span>";
		    $data[] = array(
	                $num++,
	                datos_persona_nombre($fila->id_funcionario_solicitante),
	                $fila->cite,
	                $fila->cantidad,
	                $fila->cantidad_materiales,
	                formato_fecha_hora($fila->fecha_registro),
	                $fila->motivo,
	                descripcion_estados($fila->estado),
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


	function cargarTablasolicitudesIdConfirmacion()
	{
		$idConfirmacion = $this->input->post('id_conf');
		$draw = intval($this->input->get("draw"));		
		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmadosVerificar($idConfirmacion);
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
	                descripcion_estados($fila->estado),
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

