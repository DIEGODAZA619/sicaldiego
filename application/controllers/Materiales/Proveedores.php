<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('proveedores_model');
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
		$this->load->view('Materiales/formProveedores'); //cuerpo
		$this->load->view('inicio/pie');
	}
	function cargartablasProveedores()
	{
		$draw = intval($this->input->get("draw"));
		$filas = $this->proveedores_model->getProveedores();
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = " <span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Editar Proveedor'>
							<button class='btn btn-warning btn-circle' onclick='editarProveedor(".$fila->id.")'><i class='mdi mdi-pencil'></i></button>
						</span>";
		    $data[] = array(
	                $num++,
	                $fila->codigo,
	                $fila->nombre_proveedor,
	                $fila->legal_proveedor,
	                $fila->nit,
	                $fila->correo,
					$fila->celular,
					$fila->direccion,
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
	function guardarProveedores()
	{
		$accion = $this->input->post('texto');
		if($accion== 'Editar')
		{
			$id_registro = $this->input->post('id_proveedor');
			$datos = array (
				'codigo' => $this->input->post('txtcodigo_proveedor'),
				'nombre_proveedor' => $this->input->post('txtnombre_proveedor'),
				'legal_proveedor' => $this->input->post('txtlegal_proveedor'),
				'nit' => $this->input->post('nit'),
				'correo' => $this->input->post('correo'),
				'celular' => $this->input->post('celular'),
				'direccion' => $this->input->post('direccion'),
				'observaciones' => $this->input->post('observacion'),
				'fecha_modificacion' => date('Y-m-d H:i:s')
			);
			$insert = $this->proveedores_model->editarProveedor($id_registro,$datos);
			$resul = 1;
			$id_fila = $insert;
			$mensaje = "MODIFICADO CORRECTAMENTE";
		}
		else
		{
			$datos = array (
				'id_entidad' =>1,
				'codigo' => $this->input->post('txtcodigo_proveedor'),
				'nombre_proveedor' => $this->input->post('txtnombre_proveedor'),
				'legal_proveedor' => $this->input->post('txtlegal_proveedor'),
				'nit' => $this->input->post('nit'),
				'correo' => $this->input->post('correo'),
				'celular' => $this->input->post('celular'),
				'direccion' => $this->input->post('direccion'),
				'observaciones' => $this->input->post('observacion'),
				'fecha_registro' => date('Y-m-d H:i:s')
			);
			$insert = $this->proveedores_model->guardarProveedor($datos);
			$resul = 1;
			$id_fila = $insert;
			$mensaje = "REGISTRADO CORRECTAMENTE";
		}
	$resultado ='[{
				"resultado":"'.$resul.'",
				"id_fila":"'.$id_fila.'",
				"mensaje":"'.$mensaje.'"
				}]';

	echo $resultado;
	}
	function idRegistroProveedor()
	{
		$id_registro = $this->input->post('id');
		//$id_registro = 1;
		$filas = $this->proveedores_model->getProveedorId($id_registro);
		$datos ='[{
			"id" : "'.$filas[0]->id.'",
			"id_entidad" : "'.$filas[0]->id_entidad.'",
			"codigo" : "'.$filas[0]->codigo.'",
			"nombre_proveedor" : "'.$filas[0]->nombre_proveedor.'",
			"legal_proveedor" : "'.$filas[0]->legal_proveedor.'",
			"nit" : "'.$filas[0]->nit.'",
			"correo" : "'.$filas[0]->correo.'",
			"celular" : "'.$filas[0]->celular.'",
			"direccion" : "'.$filas[0]->direccion.'",
			"observaciones" : "'.$filas[0]->observaciones.'",
			"estado" : "'.$filas[0]->estado.'"
		}]';

		echo $datos;
	}
	/*public function getNombreProveedor($id)
	{
		 echo  "<br><b>PROVEEDOR : </b>". $this->proveedores_model->getNombreProveedor($id);
		 exit;
	}*/


}
