<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autorizar_solicitud extends CI_Controller
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
		$this->load->view('Solicitudes/autorizarSolicitud'); //cuerpo
		$this->load->view('inicio/pie');
	}


	function cargartablaSolicitudesConfirmadas()
	{
		$draw = intval($this->input->get("draw"));
		$estado = 'APB';
		$id_entidad        = $this->session->userdata('id_entidad');
		$filas = $this->solicitudes_model->getSolicitudesConfirmadasPorDireccion($id_entidad,$estado);
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
		  
		    if($fila->estado == 'APB')
			{
				if($this->solicitudes_model->historialMaterialFuncionario($fila->id_funcionario,$fila->id_material))
				{
					$boton = "<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Historial'>
								<button class='btn btn-primary btn-circle' onclick='cargarTablaHistorialMaterial(".$fila->id_material.",".$fila->id_funcionario.")'><i class='mdi mdi-eye'></i></button>
					 		</span>";
				}	 
				$boton = $boton."<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Editar'>
						<button class='btn btn-warning btn-circle' onclick='editarCantidadSolicitud(".$fila->id_solicitud.")'><i class='mdi mdi-pencil'></i></button>
					 </span>
					 <span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Rechazar'>
						<button class='btn btn-danger btn-circle' onclick='recharSolicitudDetalles(".$fila->id_solicitud.",".$idConfirmacion.")'><i class='mdi mdi-delete'></i></button>
					</span>";	
			}
			else
			{
				$boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Restablecer'>
						<button class='btn btn-success btn-circle' onclick='rehabilitarSolicitudDetalles(".$fila->id_solicitud.",".$idConfirmacion.")'><i class='mdi mdi-update'></i></button>
					</span>";
			}
			

		    $data[] = array(
	                $num++,
	                datos_persona_nombre($fila->id_funcionario),
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                //$fila->descripcion_categoria,
	                substr($fila->codigo_categoria,0,5),
	                $fila->cantidad_solicitada,
	                $fila->cantidad_autorizada,
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


	function autorizarPedidoDireccion()
	{
		$idConfirmacion = $this->input->post('id_conf');
		$id_funcionario = $this->session->userdata('id_funcionario');
		$estado = 'APB';
		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmados($idConfirmacion,$estado);
		$fechaActual   = getFechaHoraActual();
		$data = array(
	    				'fecha_aprobacion' => $fechaActual,	    				
	    				'estado' => 'AUT'
		    		 );
		$dataSol = array(
	    				'fecha_aprobacion' => $fechaActual,
	    				'id_funcionario_autorizador' => $id_funcionario,
	    				'estado' => 'AUT'
		    		 );
		foreach ($filas as $fila)
	    {
	    	$id_solicitud = $fila->id_solicitud;
	    	$update = $this->solicitudes_model->editarSolicitudMaterialDetalles($id_solicitud,$data);
	    }
	    $update = $this->solicitudes_model->editarConfirmaciónSolicitudMaterialDetalles($idConfirmacion,$dataSol);
	    $resul = 1;
		$mensaje = "SOLICITUD AUTORIZADA CORRECTAMENTE";
		$resultado ='[{
					"resultado":"'.$resul.'",
					"mensaje":"'.$mensaje.'"
					}]';
		echo $resultado;
	}
	function editarSolicitudMateriales()
	{
		$id_material    			= $this->input->post('id_material');
		$cantidad       			= $this->input->post('txtCantidadAutorizada');
		$id_registro    			= $this->input->post('txtidRegistroSolicitud');
		$id_funcionario             = $this->session->userdata('id_funcionario');
		$resumen              = $this->ingresos_model->getInventarioResumenId($id_material);
		$cantidad_disponible  = $resumen[0]->cantidad_disponible;

		$solicitud 			= $this->solicitudes_model->getSolicitudId($id_registro);
		$cantidadSolicitada = $solicitud[0]->cantidad_solicitada;
		if($cantidad <= $cantidadSolicitada)
		{
			if($cantidad > 0)
			{
				$data = array(
				'cantidad_autorizada' 	=> $cantidad,
				);
				$actualizar = $this->solicitudes_model->editarSolicitudMaterialDetalles($id_registro,$data);
				if($actualizar)
				{
					$resul = 1;
					$mensaje = "OK";
				}
				else
				{
					$resul = 0;
					$mensaje = "Ocurrio un error al actualizar";
				}
			}
			else
			{
				$resul = 0;
				$mensaje = "La cantidad de autorizada debe ser mayor a cero";
			}
		}
		elseif($cantidad <= ($cantidad_disponible + $cantidadSolicitada))
		{
			$data = array(
				'cantidad_autorizada' 	=> $cantidad,
			);
			$actualizar = $this->solicitudes_model->editarSolicitudMaterialDetalles($id_registro,$data);
			if($actualizar)
			{
				$resul = 1;
				$mensaje = "OK";
			}
			else
			{
				$resul = 0;
				$mensaje = "Ocurrio un error al actualizar";
			}
		}
		else
		{
			$resul = 0;
			$mensaje = "La cantidad solicitada es mayor a la cantidad DISPONIBLE en almacen";
		}
		$actualización = actualizarCantidadInventario($id_material);
		$resultado ='[{
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					}]';
		echo $resultado;
	}


	function cargartablasSolicitudesMaterialesUsuario()
	{
		$draw = intval($this->input->get("draw"));
		$id_material = $this->input->post('id_mat');
		$id_funcionario = $this->input->post('if_fun');
		$gestion = 2023;
		$filas = $this->solicitudes_model->historialMaterialFuncionario($id_funcionario,$id_material);
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
	                $fila->cantidad_autorizada,
	                formato_fecha_slash($fila->fecha_entrega),
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

	function cadena()
	{
		$ambiente = 'ddd    , 11 OFICIANSSD. .DFSDKFSDFS';
		
		$resultado = "";
		$nuevaCadena = trim($ambiente);
		$tam = strlen(trim($nuevaCadena));
		$caracter = substr($nuevaCadena,0,1);
		if($caracter == ',')
		{
			$resultado = substr($nuevaCadena,1,$tam);			
		}
		else
		{
			$resultado = $ambiente;
		}
		echo trim($resultado);
	}
}

