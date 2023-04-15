<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aprobacion extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('materiales_model');
		$this->load->model('ingresos_model');		
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
		$this->load->view('Ingreso/formAprobacion'); //cuerpo
		$this->load->view('inicio/pie');
	}
	function cargarTablaAprobacion()
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
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Verificar Materiales'>
						<button class='btn btn-success btn-circle' onclick='cargarMaterialesAcumulado(".$fila->id.", \"".$fila->order_compra." - [ ".$fila->id." ]"." \")'><i class='mdi mdi-check'></i></button>
					</span>";
		    $data[] = array(
	                $num++,
	                $fila->order_compra ."- <b>[ ".$fila->id." ]</b>",
	                $fila->nota_remision,
	                $fila->nro_factura,
	                $fila->fecha_factura,
	               
	                $fila->id_provedor,
	                $fila->descripcion_ingreso,
	                $fila->fecha_ingreso,
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

	
	function cargartablasMaterialesAcumulados()
	{
		$draw = intval($this->input->get("draw"));
		$id_ingreso  = $this->input->post('id_ing');
		$estado = 'ELB';
		$filas = $this->ingresos_model->getIngresosDetallesId($id_ingreso,$estado);
		$data = array();
		$num = 1;
		$totalCantidad = 0;
		$totalPrecio  =  0;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		   /* $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Eliminar'>
						<button class='btn btn-danger btn-circle' onclick='eliminarIngresoDetalles(".$fila->id.")'><i class='mdi mdi-delete'></i></button>
					</span>
					";*/
			$totalCantidad += $fila->cantidad_ingreso;
			$totalPrecio  +=  $fila->precio_total;		
		    $data[] = array(
	                $num++,
	                $fila->partida,
	                $fila->codigo,
	                $fila->descripcion,
	                $fila->cantidad_ingreso,
	                number_format($fila->precio_unitario,2),
	                number_format($fila->precio_total,2),
	                formato_fecha_hora($fila->fecha_registro),
	                descripcion_estados($fila->estado),
	                $boton
	           );
	    }
	     $data[] = array(
	                 $num++,
	                 "",
	                "<b> TOTAL </b>",
	                '',
	                "<b>".$totalCantidad."</b>",
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
	function aprobarIngresoMateriales()
	{
		$id_ingreso  = $this->input->post('id_ing');
		$estado = 'ELB';
		$tipoProceso = 'INGP';
		$id_funcionario = $this->session->userdata('id_funcionario');		
		$entidad = $this->session->userdata('id_entidad');
		$gestion = gestion_vigente();
		$filas = $this->ingresos_model->getIngresosDetallesId($id_ingreso,$estado);	
		$dataUpdate = array(	    		
				'estado' => 'AC',
    	);	
		$tabla = "inventario.inventarios";
	    foreach ($filas as $fila)
	    {	
	    	
	    	$invetariosProductos = $this->ingresos_model->cantidadInventarioProducto($fila->id_material);
	    	$id_inventario_inicial_ingreso = $invetariosProductos[0]->correlativo + 1;
	    	$data = array(	    		  				  				
  				'id_entidad' => $entidad,
  				'gestion' => $gestion,
  				'id_ingreso' => $id_ingreso,
  				'id_ingreso_detalle' => $fila->id,  				
  				'id_material' => $fila->id_material,
  				'tipo_proceso' => $tipoProceso,
  				'cantidad_entrada' => $fila->cantidad_ingreso,
  				'cantidad_salida' => 0,
  				'saldo' => $fila->cantidad_ingreso,
  				'precio_unitario' => $fila->precio_unitario,
  				'precio_total' => $fila->precio_total,  				
  				'id_funcionario_almacen' => $id_funcionario,
  				'id_inventario_inicial_ingreso' => $id_inventario_inicial_ingreso
	    	);
	    	if(!$this->ingresos_model->checkIngresoMaterialInventario($id_ingreso,$fila->id,$fila->id_material))
	    	{
	    		$idIngreso = $this->ingresos_model->registrarIngresosInvetarios($data);
		    	if($idIngreso)
		    	{	    		
			    	$idIngresoUpdate = $this->ingresos_model->editarIngresoMaterialDetalles($fila->id,$dataUpdate);
			    	$actualizacionInventario = actualizarInventarioResumen($fila->id_material,$fila->cantidad_ingreso,'INGRESO');
		    	}	
	    	}
	    	
	    	//echo json_encode($data)."<br>";
	    }
	    $idUpdateIngreso = $this->ingresos_model->updateIngreso($id_ingreso,$dataUpdate);

		$resul = 1;
		$mensaje = "Se realizó el ingreso correctamente ";		
		$resultado ='[{
							"resultado":"'.$resul.'",
							"mensaje":"'.$mensaje.'"
					 }]';		
		echo $resultado;
	}
	function actualizarInventarioResumen($id_material,$cantidad,$tipoProceso)
	{
		$fechaHora = getFechaHoraActual();
		$resumen = $this->ingresos_model->getInventarioResumenId($id_material);
		$id_registro 	     = $resumen[0]->id;
		$cantidad_entrada 	 = $resumen[0]->cantidad_entrada;
		$cantidad_salida 	 = $resumen[0]->cantidad_salida;
		$saldo 				 = $resumen[0]->saldo;
		$cantidad_solicitada = $resumen[0]->cantidad_solicitada;
		$cantidad_disponible = $resumen[0]->cantidad_disponible;
		switch ($tipoProceso)
		{
			case "INGRESO":
				$cantidad_entrada 		= $cantidad_entrada + $cantidad;
				$saldo 					= $cantidad_entrada - $cantidad_salida;
				$cantidad_disponible	= $saldo - $cantidad_solicitada;
				break;

			case "SALIDA":
				$cantidad_salida 		= $cantidad_salida + $cantidad;
				$saldo 					= $cantidad_entrada - $cantidad_salida;
				$cantidad_solicitada	= $cantidad_solicitada - $cantidad;
				$cantidad_disponible	= $saldo - $cantidad_solicitada;
				break;

			case "SOLICITUD":				
				$cantidad_solicitada	= $cantidad_solicitada + $cantidad;
				$cantidad_disponible	= $saldo - $cantidad_solicitada;
				break;
		}
		$dataUpdate = array(	   
				'cantidad_entrada'	=> $cantidad_entrada,
				'cantidad_salida' 	=> $cantidad_salida,
				'saldo' 			=> $saldo,
				'cantidad_solicitada' => $cantidad_solicitada,
				'cantidad_disponible' => $cantidad_disponible
	    	);
		$idUpdateIngreso = $this->ingresos_model->updateInventarioResumen($id_registro,$dataUpdate);

		return true;

	}

	function cargarInventarioInicial()
	{
		$filas = $this->materiales_model->getMateriales();
		$entidad = $this->session->userdata('id_entidad');
		$gestion = gestion_vigente();
	    foreach ($filas as $fila)
	    {
			$data = array(	    		
				'id_entidad' 		=> $entidad,
				'gestion' 		    => $gestion,
				'id_material'		=> $fila->id,
				'cantidad_entrada'	=> 0,
				'cantidad_salida' 	=> 0,
				'saldo' 			=> 0,
				'cantidad_solicitada' => 0,
				'cantidad_disponible' => 0
	    	);
	    	$insertResumen = $this->ingresos_model->insertarInventarioResumen($data);
	    	echo $fila->id."<br>";
	    }

	}
}
