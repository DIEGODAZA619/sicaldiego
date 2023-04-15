
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inexistencia extends CI_Controller
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
		$this->load->view('Solicitudes/formSolicitud'); //cuerpo
		$this->load->view('inicio/pie');
	}

	function cargartablasMaterialesAlmacen()

	{
		$draw = intval($this->input->get("draw"));
		$filas = $this->solicitudes_model->getMaterialesInventario();
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    if($fila->cantidad_disponible > 0)
		    {
		    	$boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Solicitar'>
						<button type='button' class='btn btn-success btn-circle' onclick='seleccionarMaterial(".$fila->id_material.")'><i class='mdi mdi-check'></i></button>
					</span>";
			}
		    $data[] = array(
	                $num++,
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                substr($fila->codigo_categoria,0,5),
	                //$fila->saldo,
	                //$fila->cantidad_solicitada,
	                $fila->cantidad_disponible,
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

	function cargartablasMaterialesAcumulados()
	{
		$draw = intval($this->input->get("draw"));
		$id_funcionario  = $this->session->userdata('id_funcionario');
		$estado = 'PEN';
		$tipo_solicitud = "NOR";
		$filas = $this->solicitudes_model->getSolicitudesDetalles($id_funcionario,$estado,$tipo_solicitud);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Editar'>
						<button class='btn btn-warning btn-circle' onclick='editarSolicitudMaterial(".$fila->id_solicitud.")'><i class='mdi mdi-pencil'></i></button>
					 </span>
					 <span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Eliminar'>
						<button class='btn btn-danger btn-circle' onclick='eliminarIngresoDetalles(".$fila->id_solicitud.")'><i class='mdi mdi-delete'></i></button>
					</span>";
		    $data[] = array(
	                $num++,
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                substr($fila->codigo_categoria,0,5),
	                $fila->cantidad_solicitada,
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

	function verificarMaterialSeleccionado()
	{
		$id_material     = $this->input->post('id_mat');
		$id_funcionario  = $this->session->userdata('id_funcionario');
		$estado = "PEN";
		$tipo_solicitud = "NOR";
		$ingreso = $this->solicitudes_model->checkMaterialesSolicitado($id_material,$id_funcionario,$estado,$tipo_solicitud);
		if(!$ingreso)
		{			
			$resul = 1;
			$mensaje = "OK";
		}
		else
		{
			$resul = 0;
			$mensaje = "El material seleccionado ya está registrado";
		}
		$resultado ='[{			
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;	
	}


	function guardarSolicitudMateriales()
	{
		$accion         			= $this->input->post('accion');		
		$id_material    			= $this->input->post('id_material');
		$cantidad       			= $this->input->post('txtCantidad');
		$tipoSolicitud  			= $this->input->post('tipo_solicitud');
		$id_registro    			= $this->input->post('id_registro');

		$id_funcionario             = $this->session->userdata('id_funcionario');
		$valorDependencia  = json_decode(dependenciasFuncionario());		
		$idDependencia     = $valorDependencia[0]->dependencia;
		$idSubDependencia  = $valorDependencia[0]->SubDependencia;

		

		$id_entidad                 = $this->session->userdata('id_entidad');
		$gestion                    = $this->session->userdata('gestion');

		$resumen              = $this->ingresos_model->getInventarioResumenId($id_material);
		$cantidad_disponible  = $resumen[0]->cantidad_disponible;

		
			if($accion == 'nuevo')
			{
				if($cantidad <= $cantidad_disponible)
				{
					$data = array(
						'id_funcionario' 		=> $id_funcionario,
						'id_dependencia' 		=> $idDependencia,
						'id_subdependencia'		=> $idSubDependencia,
						'id_entidad' 			=> $id_entidad,
						'gestion'         		=> $gestion,
						'id_material' 			=> $id_material,
						'cantidad_solicitada' 	=> $cantidad,
						'cantidad_autorizada' 	=> $cantidad,
						'tipo_solicitud' 		=> $tipoSolicitud,				
					);
					if($this->solicitudes_model->guardarSolicitudMaterial($data))
					{
						$resul = 1;
						$mensaje = "OK";			
					}
					else
					{
						$resul = 0;
						$mensaje = "Ocurrio un error al guardar la información";			
					}
				}
				else
				{
					$resul = 0;
					$mensaje = "La cantidad solicitada es mayor a la cantidad DISPONIBLE en almacen";
				}
			}
			else
			{
				$solicitud 			= $this->solicitudes_model->getSolicitudId($id_registro);
				$cantidadSolicitada = $solicitud[0]->cantidad_solicitada;

				if($cantidad <= $cantidadSolicitada)
				{
					if($cantidad > 0)
					{
						$data = array(
						'cantidad_solicitada' 	=> $cantidad,
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
						$mensaje = "La cantidad de solicitada debe ser mayor a cero";			
					}
					
				}		
				elseif($cantidad<= ($cantidad_disponible + $cantidadSolicitada))
				{
					$data = array(
						'cantidad_solicitada' 	=> $cantidad,
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

			}
			$actualización = actualizarCantidadInventario($id_material);
		
					
		$resultado ='[{
							"resultado":"'.$resul.'",
							"mensaje":"'.$mensaje.'"
						 }]';
		echo $resultado;
	}


	function getSolicitudMaterialesId()
	{
		$id_solicitud = $this->input->post('id_sol');		
		$solicitud = $this->solicitudes_model->getSolicitudId($id_solicitud);
		$resul = 0;
		$mensaje = "No se identificó ningún registro";
		if($solicitud)
		{
			$id_material 			 = $solicitud[0]->id_material;
			$cantidadSolicitada 	 = $solicitud[0]->cantidad_solicitada;
			$cantidadAutorizada 	 = $solicitud[0]->cantidad_autorizada;			
			$resul = 1;
			$mensaje = "OK";
		}

		$resultado ='[{
						"id_material":"'.$id_material.'",
						"cantidad_solicitada":"'.$cantidadSolicitada.'",
						"cantidad_autorizada":"'.$cantidadAutorizada.'",						
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;		
	}
	/////////////




	

	function cargarTablaIngresos()
	{
		$draw = intval($this->input->get("draw"));
		$id_entidad = 1;
		$estado = 'ELB';
		$filas = $this->ingresos_model->getIngresos($id_entidad,$estado);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Agregar Materiales'>
						<button class='btn btn-secondary' onclick='agregarMateriales(".$fila->id.")'><i class='mdi mdi-printer'></i></button>
					</span>";	
		    $data[] = array(
	                $num++,
	                $fila->order_compra,
	                $fila->nota_remision,
	                $fila->nro_factura,	                
	                $fila->fecha_factura,
	                $fila->monto_total_factura,
	                $fila->id_provedor,
	                $fila->descripcion_ingreso,
	                $fila->fecha_ingreso,
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
	
	
	function guardarRegistroIngreso()
	{
		$accion     	= $this->input->post('txtaccion');
		$id_registro 	= $this->input->post('txtidRegistro');
		$orden 		 	= $this->input->post('txtOrden');
		$nota    		= $this->input->post('txtNotaRemision');
		$nroFactura     = $this->input->post('txtNumeroFactura');
		$fechaFactura   = $this->input->post('txtfecha_factura');
		$proveedor      = $this->input->post('slProveedor');
		$descripcion    = $this->input->post('txtDescripcion');
		$fechaActual    = getFechaActual();
		$id_funcionario = $this->session->userdata('id_funcionario');
		$gestion = gestion_vigente();
		$id_entidad = 1;

		$resul = 1;
		$mensaje = "OK";				
		if($accion == 'nuevo')
		{
			$data = array(
				'id_entidad' 				=> $id_entidad,
				'gestion' 					=> $gestion,
				'order_compra' 				=> $orden,
				'nota_remision' 			=> $nota,
				'nro_factura' 				=> $nroFactura,
				'fecha_factura' 			=> $fechaFactura,
				'monto_total_factura'		=> 0,
				'id_provedor' 				=> $proveedor,
				'descripcion_ingreso'		=> $descripcion,
				'fecha_ingreso'				=> $fechaActual,
				'id_funcionario_registro' 	=> $id_funcionario			
			);
			if($this->ingresos_model->guardarRegistroIngreso($data))
			{
				$resul = 1;
				$mensaje = "OK";			
			}
			else
			{
				$resul = 0;
				$mensaje = "Ocurrio un error al guardar la información";			
			}
		}
		$resultado ='[{
							"resultado":"'.$resul.'",
							"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;
	}
	function guardarIngresoMateriales()
	{
		$accion      = $this->input->post('accion');		
		$id_material = $this->input->post('id_material');
		$cantidad    = $this->input->post('txtCantidad');		
		$id_registro = $this->input->post('id_registro');
		$fechaActual = getFechaHoraActual();
		$id_funcionario = $this->session->userdata('id_funcionario');
		$total = $cantidad * $precio;

		if($accion == 'nuevo')
		{
			$data = array(
				'id_ingreso' => $id_ingreso,
				'id_material' => $id_material,
				'cantidad_ingreso' => $cantidad,
				'precio_unitario' => $precio,
				'precio_total' => $total,
				'id_funcionario_registro'=> $id_funcionario
			);
			if($this->ingresos_model->guardarIngresoMaterial($data))
			{
				
				$resul = 1;
				$mensaje = "OK";			
			}
			else
			{
				$resul = 0;
				$mensaje = "Ocurrio un error al guardar la información";			
			}
		}
		else
		{
			$data = array(
				'cantidad_ingreso' => $cantidad,
				'precio_unitario' => $precio,
				'precio_total' => $total,
				'id_funcionario_update' => $id_funcionario,
				'fecha_modificacion' => $fechaActual,				
			);		
			$actualizar = $this->ingresos_model->editarIngresoMaterialDetalles($id_registro,$data);
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
		
		
		$resultado ='[{
							
							"resultado":"'.$resul.'",
							"mensaje":"'.$id_material.'"
						 }]';
		echo $resultado;
	}
	function pruebas()
	{
		$id_material = 176;
		$actualización = actualizarCantidadInventario($id_material);
	}
	function getMaterialesId()
	{
		$id_material = $this->input->post('id_mat');		
		$material = $this->materiales_model->getMaterialesId($id_material);
		$descripcion = "";
		$resul = 0;
		$mensaje = "No se identificó ningún registro";
		if($material)
		{
			$descripcion = $material[0]->descripcion;
			$resul = 1;
			$mensaje = "OK";
		}
		$resultado ='[{
						"descripcion":"'.$descripcion.'",
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;		
	}
	function eliminarSolicitudMaterial()
	{		
		$id_solicitud   = $this->input->post('id_sol');	
		$fechaActual    = getFechaHoraActual();
		$id_funcionario = $this->session->userdata('id_funcionario');
		$filas = $this->solicitudes_model->getSolicitudId($id_solicitud);
		$id_material = $filas[0]->id_material;
		$data = array(			
			'fecha_modificacion' => $fechaActual,
			'estado' => 'AN'
		);		
		$actualizar = $this->solicitudes_model->editarSolicitudMaterialDetalles($id_solicitud,$data);
		$actualización = actualizarCantidadInventario($id_material);
		$resul = 1;
		$mensaje = "Se eliminó correctamente el registro";
		$resultado ='[{						
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;	
	}

	function verificarDatos()
	{
		$id_funcionario             = $this->session->userdata('id_funcionario');
		$idDependencia 				= $this->session->userdata('id_dependencia_principal');
		$idSubDependencia 			= $this->session->userdata('id_subdependencia_principal');

		$idDependenciaSecundario 	= $this->session->userdata('id_dependencia_secundario');
		$idSubdependenciaSecundario = $this->session->userdata('id_subdependencia_secundario');

		
		$valorDependencia  = json_decode(dependenciasFuncionario());
		//$correIndividual  = 1;//$valorcites[0]->correIndividual;
		$idDependencia     = $valorDependencia[0]->dependencia;
		$idSubDependencia  = $valorDependencia[0]->SubDependencia;

		echo $id_funcionario." - ".$idDependencia." - ".$idSubDependencia;
	}
	
}

