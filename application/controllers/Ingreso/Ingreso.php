<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ingreso extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('materiales_model');
		$this->load->model('ingresos_model');
		$this->load->model('materiales_model');
		$this->load->model('proveedores_model');
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
		$this->load->view('inicio/cabecera',$dato);
		$this->load->view('inicio/menu', $dato);
		$this->load->view('Ingreso/formIngreso'); //cuerpo
		$this->load->view('inicio/pie');
	}
	function cargarProveedores()
	{
		$id_entidad = $this->session->userdata('id_entidad');
		
		$filas = $this->ingresos_model->getProveedores($id_entidad);
		$options = "<option value = '0'>---</option>";
		foreach ($filas as $fila) {
			$options .= "<option value=".$fila->id."> NIT: ".$fila->nit." - Proveedor: ".$fila->nombre_proveedor." - Representante Legal: ".$fila->legal_proveedor."</option>";
		}
		echo $options;
	}

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
						<button class='btn btn-success btn-circle boton' onclick='agregarMateriales(".$fila->id.", this)'><i class='mdi mdi-check'></i></button>
					</span>";
		    $data[] = array(
	                $num++,
	                $fila->order_compra ."- <b>[ ".$fila->id." ]</b>",
	                $fila->nota_remision,
	                $fila->nro_factura,
	                $fila->fecha_factura,	               
	                descripcionProveedorValor($fila->id_provedor) ,
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
	function cargartablasMateriales()
	{
		$draw = intval($this->input->get("draw"));
		$filas = $this->materiales_model->getMateriales();
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Seleccionar'>
						<button class='btn btn-success btn-circle' onclick='agregarIngreso(".$fila->id.")'><i class='mdi mdi-check'></i></button>
					</span>";
			$totalCantidad = $fila->saldo -$fila->cantidad_solicitada; 		
		    $data[] = array(
	                $num++,
	                substr($fila->codigo_categoria,0,5),
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                $fila->descripcion_categoria,
	                $totalCantidad,
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
	function cargartablasMaterialesAcumulados()
	{
		$draw = intval($this->input->get("draw"));
		$id_ingreso  = $this->input->post('id_ing');
		$estado = 'ELB';
		$filas = $this->ingresos_model->getIngresosDetallesId($id_ingreso,$estado);
		$data = array();
		$num = 1;

		$totalCantidad= 0;
		$totalPrecio  = 0;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Editar'>
						<button class='btn btn-warning btn-circle' onclick='editarIngresoDetalles(".$fila->id.")'><i class='mdi mdi-pencil'></i></button>
					 </span>
					 <span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Eliminar'>
						<button class='btn btn-danger btn-circle' onclick='eliminarIngresoDetalles(".$fila->id.")'><i class='mdi mdi-delete'></i></button>
					</span>
					";
			$totalCantidad += $fila->cantidad_ingreso;
			$totalPrecio  +=  $fila->precio_total;

		    $data[] = array(
	                $num++,
	                substr($fila->partida,0,5),
	                $fila->codigo,
	                $fila->descripcion,
	                $fila->cantidad_ingreso,
	                $fila->precio_unitario,
	                $fila->precio_total,
	                formato_fecha_hora($fila->fecha_registro),
	                descripcion_estados($fila->estado),
	                $boton
	           );
	    }
	    $data[] = array(
	                 $num++,
	                 '',
	                "<b> TOTAL </b>",
	                '',
	                $totalCantidad,
	                '',
	               "<b>".$totalPrecio." (Bs)</b>",
	                "",
	                "",
	                ""
	           );
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
		$fechaNota      = $this->input->post('txtfecha_nota_remision');
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

		$tipoCite      = 'INM';		
		$fechaActual   = getFechaHoraActual();
		$valorcites   = json_decode(obtenerCiteGestion($id_funcionario,$gestion,$tipoCite));
		//$correIndividual  = 1;//$valorcites[0]->correIndividual;
		$correGestion     = $valorcites[0]->correGestion;
		$cite             = $valorcites[0]->cites;
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
				'id_funcionario_registro' 	=> $id_funcionario,
				'correlativo' 			    => $correGestion,
				'cite'	           		 	=> $cite,
				'fecha_nota_remision'		=> $fechaNota,
			);
			if($this->ingresos_model->guardarRegistroIngreso($data))
			{
				$citeGuardar = guardarCite($id_funcionario,$tipoCite,$correGestion,$cite,$gestion,$fechaActual);
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
		$id_ingreso  = $this->input->post('id_ingreso');
		$id_material = $this->input->post('id_material');
		$cantidad    = $this->input->post('txtCantidad');
		$precio      = $this->input->post('txtPrecio');
		$id_registro      = $this->input->post('id_registro');
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
							"mensaje":"'.$mensaje.'"
						 }]';
		echo $resultado;
	}
	function getMaterialesId()
	{
		$id_material = $this->input->post('id_mat');
		$material = $this->materiales_model->getMaterialesId($id_material);
		$descripcion = $saldo = $cantidad_solicitada = "";
		$resul = 0;
		$mensaje = "No se identificó ningún registro";
		if($material)
		{
			$descripcion = $material[0]->descripcion;
			$saldo = $material[0]->saldo;
			$cantidad_solicitada = $material[0]->cantidad_solicitada;
			$resul = 1;
			$mensaje = "OK";
		}
		$resultado ='[{
						"descripcion":"'.$descripcion.'",
						"saldo":"'.$saldo.'",
						"cantidad_solicitada":"'.$cantidad_solicitada.'",
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;
	}
	function eliminarIngresoDetalles()
	{
		$id_ingreso = $this->input->post('id_ing');
		$fechaActual = getFechaHoraActual();
		$id_funcionario = $this->session->userdata('id_funcionario');
		$data = array(
			'id_funcionario_update' => $id_funcionario,
			'fecha_modificacion' => $fechaActual,
			'estado' => 'AN'
		);
		$actualizar = $this->ingresos_model->editarIngresoMaterialDetalles($id_ingreso,$data);
		$resul = 1;
		$mensaje = "Se eliminó correctamente el registro";
		$resultado ='[{
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;
	}
	function getIngresoDetalleEditarId()
	{
		$id_ingreso = $this->input->post('id_ing');
		$ingreso = $this->ingresos_model->getIngresoDetId($id_ingreso);
		$descripcion = "";
		$resul = 0;
		$mensaje = "No se identificó ningún registro";
		if($ingreso)
		{
			$id_material = $ingreso[0]->id_material;
			$cantidad 	 = $ingreso[0]->cantidad_ingreso;
			$precio 	 = $ingreso[0]->precio_unitario;
			$resul = 1;
			$mensaje = "OK";
		}
		$resultado ='[{
						"id_material":"'.$id_material.'",
						"cantidad":"'.$cantidad.'",
						"precio":"'.$precio.'",
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;
	}
	function verificarMaterialSeleccionado()
	{
		$id_ingreso = $this->input->post('id_ing');
		$id_material = $this->input->post('id_mat');
		$ingreso = $this->ingresos_model->checkMaterialesIngreso($id_ingreso,$id_material);
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
}

