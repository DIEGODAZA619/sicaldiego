<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entrega_solicitud extends CI_Controller
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
		$this->load->view('Solicitudes/entregaSolicitud'); //cuerpo
		$this->load->view('inicio/pie');
	}

	
	function cargartablaSolicitudesConfirmadas()
	{
		$draw = intval($this->input->get("draw"));
		$estado = 'AUT';
		$filas = $this->solicitudes_model->getSolicitudesConfirmadasPorDireccion($estado);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";	
		    $boton2 = "";	
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Solicitud'>
						<button type='button' class='btn btn-warning btn-circle' onclick='cargarTablasolicitudesIdConfirmacion(".$fila->id.")'><i class='mdi mdi-eye'></i></button>
					 </span>";
			$boton2 ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Revertir Autorización'>
						<button type='button' class='btn btn-success btn-circle' onclick='revertirSolicitud(".$fila->id.")'><i class='mdi mdi-update'></i></button>
					 </span>";
			$botonReporte ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Imprimir Reporte a Detalle'>
						<button class='btn btn-primary btn-circle' onclick='reporteMaterialEntregado(".$fila->id.")'><i class='mdi mdi-printer'></i></button>
					 </span>";  
			$botonResumen ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Imprimir Resumen'>
						<button class='btn btn-info btn-circle' onclick='imprimirPedidoResumen(".$fila->id.")'><i class='mdi mdi-printer'></i></button>
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
	                $boton.$boton2.$botonReporte.$botonResumen
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
		$estado = 'AUT';	
		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmados($idConfirmacion,$estado);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";		
		    //$boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Editar Cantidad'><button class='btn btn-secondary' onclick='editarCantidadSolicitud(".$fila->id_solicitud.")'><i class='mdi mdi-printer'></i></button></span>";  
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
		$estado = 'AUT';	
		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmados($idConfirmacion,$estado);		
		$fechaActual   = getFechaHoraActual();
		$data = array(	    				
	    				'fecha_entrega' => $fechaActual,	    				
	    				'estado' => 'ENT'
		    		 );	

		$dataSol = array(	    				
	    				'fecha_entrega' => $fechaActual,
	    				'id_funcionario_entregas' => $id_funcionario,
	    				'estado' => 'ENT'
		    		 );	
		foreach ($filas as $fila)
	    {			    	
	    	$id_confirmacion_direccion = $fila->id_confirmacion_direccion;	    		    	
	    	$id_solicitud 		= $fila->id_solicitud;	    	
	    	$idMaterial 		= $fila->id_material;
	    	$idFuncionarioSol	= $fila->id_funcionario;	    	
	    	$idMaterial 		= $fila->id_material;
	    	$cantidadAutorizada = $fila->cantidad_autorizada;

	    	$registroInvetario = $this->registroMaterialInventario($id_solicitud,$id_confirmacion_direccion,$idMaterial,$cantidadAutorizada,$idFuncionarioSol);	    	
	    	$update 			= $this->solicitudes_model->editarSolicitudMaterialDetalles($id_solicitud,$data);
	    }
	    $update = $this->solicitudes_model->editarConfirmaciónSolicitudMaterialDetalles($idConfirmacion,$dataSol);
	    $resul = 1;
		$mensaje = "SOLICITUD ENTREGADA CORRECTAMENTE";
		$resultado ='[{
					"resultado":"'.$resul.'",
					"mensaje":"'.$mensaje.'"
					}]';
		echo $resultado;
	}


	function revertirPedidoDireccion()
	{
		$idConfirmacion = $this->input->post('id_conf');
		$id_funcionario = $this->session->userdata('id_funcionario');
		$estado = 'AUT';
		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmados($idConfirmacion,$estado);
		$fechaActual   = getFechaHoraActual();
		$data = array(
	    				//'fecha_aprobacion' => $fechaActual,	    				
	    				'estado' => 'APB',
	    				
		    		 );
		$dataSol = array(
	    				//'fecha_aprobacion' => $fechaActual,
	    				//'id_funcionario_aprobador' => $id_funcionario,
	    				'estado' => 'APB',	    				
		    		 );

		foreach ($filas as $fila)
	    {
	    	$id_solicitud = $fila->id_solicitud;
	    	$update = $this->solicitudes_model->editarSolicitudMaterialDetalles($id_solicitud,$data);
	    }
	    $update = $this->solicitudes_model->editarConfirmaciónSolicitudMaterialDetalles($idConfirmacion,$dataSol);
	    $resul = 1;
		$mensaje = "LA SOLICITUD FUE REVERTIDA CORRECTAMENTE";
		$resultado ='[{
					"resultado":"'.$resul.'",
					"mensaje":"'.$mensaje.'"
					}]';
		echo $resultado;
	}

	function registroMaterialInventario($id_solicitud,$id_confirmacion_direccion,$idMaterial,$cantidad,$idFuncionarioSolicitante)
	//function registroMaterialInventario()
	{
		/*$id_solicitud 			   = 1;
		$id_confirmacion_direccion = 2;
		$idMaterial = 176;
		$cantidad   = 9;		
		$idFuncionarioSolicitante   = 44;*/
		$inventario = $this->solicitudes_model->getMaterialInventarioPeps($idMaterial);
		foreach($inventario as $fila)
		{
			$idInventario = $fila->id;			
			$saldo = $fila->saldo;
			if($cantidad > 0)
			{	
				if($saldo <= $cantidad)
				{
					$cantidad = $cantidad - $saldo;
					$guardar = $this->guardarMaterialesInventarioActualizado($id_confirmacion_direccion,$id_solicitud,$idInventario, $saldo,$idFuncionarioSolicitante);				
					$saldo    = 0;
				}
				else
				{					
					$guardar = $this->guardarMaterialesInventarioActualizado($id_confirmacion_direccion,$id_solicitud,$idInventario, $cantidad,$idFuncionarioSolicitante);										
					$cantidad = 0;
				}
			}
			else
			{
				break;
			}			
		}
		return true;
	}
	function guardarMaterialesInventarioActualizado($id_confirmacion_direccion,$id_solicitud,$idInventario, $cantidad,$idFuncionarioSolicitante)
	{
		$datosInventario = $this->solicitudes_model->getIdMaterialInventario($idInventario);
		$id_funcionario = $this->session->userdata('id_funcionario');
		$id_entidad 					= $datosInventario[0]->id_entidad;
		$gestion 						= $datosInventario[0]->gestion;
		$id_ingreso 					= $datosInventario[0]->id_ingreso;
		$id_ingreso_detalle 			= $datosInventario[0]->id_ingreso_detalle;
		$id_salida 						= $datosInventario[0]->id_salida;
		$id_salida_detalle 				= $datosInventario[0]->id_salida_detalle;
		$id_material 					= $datosInventario[0]->id_material;
		$tipo_proceso 					= $datosInventario[0]->tipo_proceso;
		$tipo_ingreso_egreso 			= $datosInventario[0]->tipo_ingreso_egreso;
		$cantidad_entrada 				= $datosInventario[0]->cantidad_entrada;
		$cantidad_salida 				= $datosInventario[0]->cantidad_salida;
		$saldo 							= $datosInventario[0]->saldo;
		$precio_unitario				= $datosInventario[0]->precio_unitario;
		$precio_total 					= $datosInventario[0]->precio_total;
		$fecha 							= $datosInventario[0]->fecha;
		$id_inventario 					= $datosInventario[0]->id_inventario;
		$id_funcionario_solicitante 	= $datosInventario[0]->id_funcionario_solicitante;
		$id_funcionario_almacen 		= $datosInventario[0]->id_funcionario_almacen;
		$fecha_registro 				= $datosInventario[0]->fecha_registro;
		$fecha_modificacion 			= $datosInventario[0]->fecha_modificacion;
		$estado 						= $datosInventario[0]->estado;
		$id_inventario_inicial_ingreso  = $datosInventario[0]->id_inventario_inicial_ingreso;
		$id_inventario_ingresos         = $datosInventario[0]->id_inventario_ingresos;

		if(is_null($id_inventario_ingresos))
		{
			$id_inventario_ingresos = $idInventario;
		}

		$tabla = "inventario.inventarios";
    	$cantidad_salida = $cantidad_salida + $cantidad;
    	$saldo = $cantidad_entrada - $cantidad_salida;    	
		$precio_total = $precio_unitario * $saldo;
		$tipo_proceso = 'INGS';

		$id_inventario = idMaximoTabla($tabla);
    	$dataIngreso = array(	    		
				
				'id_entidad' => $id_entidad,
				'gestion'    => $gestion,
				'id_ingreso' => $id_ingreso,
				'id_ingreso_detalle' => $id_ingreso_detalle,				
				'id_material' => $id_material,
				'tipo_proceso' => $tipo_proceso,
				'tipo_ingreso_egreso' => $tipo_ingreso_egreso,
				'cantidad_entrada' => $cantidad_entrada,
				'cantidad_salida' => $cantidad_salida,
				'saldo' => $saldo,
				'precio_unitario' => $precio_unitario,
				'precio_total' => $precio_total,
				'fecha' => $fecha,
				'id_inventario' => $idInventario,
				'id_funcionario_solicitante' => $idFuncionarioSolicitante,
				'id_funcionario_almacen' => $id_funcionario,				
				'id_inventario_inicial_ingreso' => $id_inventario_inicial_ingreso,
				'id_inventario_ingresos'  => $id_inventario_ingresos,
				'estado' => 'AC',				
    	);
    	
    	$cantidad_salida = $cantidad;
    	$precio_total = $precio_unitario * $cantidad;
    	$tipo_ingreso_egreso = 'SOLM';
    	$id_inventario = idMaximoTabla($tabla);

    	$dataSalida = array(	    		
				
				'id_entidad' => $id_entidad,
				'gestion'    => $gestion,				
				'id_salida' => $id_confirmacion_direccion,
				'id_salida_detalle' => $id_solicitud,
				'id_material' => $id_material,				
				'tipo_ingreso_egreso' => $tipo_ingreso_egreso,				
				'cantidad_salida' => $cantidad_salida,				
				'precio_unitario' => $precio_unitario,
				'precio_total' => $precio_total,				
				'id_inventario' => $idInventario,
				'id_funcionario_solicitante' => $idFuncionarioSolicitante,
				'id_funcionario_almacen' => $id_funcionario,				
				'id_inventario_inicial_ingreso' => $id_inventario_inicial_ingreso,
				'id_inventario_ingresos'  => $id_inventario_ingresos,
				'estado' => 'AC',				
    	);
    	
    	$dataUpdate = array(	    						
				'estado' => 'HI',	
    	);
		$idEgreso  = $this->ingresos_model->registrarIngresosInvetarios($dataSalida);
		$idIngreso = $this->ingresos_model->registrarIngresosInvetarios($dataIngreso);    	
		$update    = $this->solicitudes_model->editarInventarioMaterial($idInventario,$dataUpdate);
		$tipoProceso = "SALIDA";
		$actualizarInvetario = actualizarInventarioResumen($id_material,$cantidad,$tipoProceso);
		
		return true;

	}





	
}


