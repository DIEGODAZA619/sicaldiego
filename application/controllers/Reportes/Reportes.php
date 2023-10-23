<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/libraries/fpdf/fpdf/easyTable.php";
require_once APPPATH . "/libraries/fpdf/fpdf/exfpdf.php";
class Reportes extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('materiales_model');
		$this->load->model('ingresos_model');
		$this->load->model('materiales_model');
		$this->load->model('solicitudes_model');
		$this->load->model('reportes_model');
		$this->load->helper('configuraciones_helper');
		$this->load->helper('funcionarios_helper');
		$this->load->helper('correlativos_helper');
		$this->load->library('fpdf/pdf2');
		//$this->load->library('fpdf/fpdf/exfpdf.php');
		$this->load->model('reportes_model');
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
		$this->load->view('Reportes/ReporteInventario'); //cuerpo
		$this->load->view('inicio/pie');
		
	}


	function cargartablasMaterialesAlmacen()

	{
		$draw = intval($this->input->get("draw"));
		$id_entidad = $this->session->userdata('id_entidad');
		$filas = $this->solicitudes_model->getMaterialesInventario($id_entidad);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    
			$boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Kardex'>
						<button type='button' class='btn btn-success btn-circle' onclick='mostrarKardexMaterial(".$fila->id_material.")'><i class='mdi mdi-check'></i></button>
					</span>";
		    $data[] = array(
	                $num++,
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                $fila->descripcion_categoria,
	                $fila->saldo,
	                $fila->cantidad_solicitada,
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

	function cargartablasKardexMaterialesAlmacenGestion()
	{
		$gestion     = $this->input->post('ges');
		$id_material = $this->input->post('id_mat');
		$filas = $this->reportes_model->getKardexMaterialGestion($id_material, $gestion);		
		$con = 1;
		$tabla = "";
		$saldoCantidad = 0;
		$saldoPrecioCantidad = 0;

		$cantidadIngresos = 0;
		$totalIngresos = 0;

		$cantidadSalidas = 0;
		$totalSalidas = 0;
		foreach($filas as $fila)
		{
			$tabla = $tabla."<tr>";
			$tabla = $tabla."<td>".$con++."</td>";
			$tabla = $tabla."<td>".formato_fecha_slash($fila->fecha_registro)."</td>";
			$tabla = $tabla."<td>".$fila->tipo."</td>";
			if($fila->tipo == 'INGRESO')
			{
				$tabla = $tabla."<td>".numeroIngresoAlmacen($fila->id_ingreso)."</td>";
				$tabla = $tabla."<td></td>";
				$tabla = $tabla."<td></td>";
				$tabla = $tabla."<td>".$fila->cantidad_entrada."</td>";
				$tabla = $tabla."<td>".number_format($fila->precio_unitario,2)."</td>";
				$tabla = $tabla."<td>".number_format($fila->precio_total,2)."</td>";
				
				$tabla = $tabla."<td>0</td>";
				$tabla = $tabla."<td>0.00</td>";
				$tabla = $tabla."<td>0.00</td>";

				$saldoCantidad = $saldoCantidad + $fila->cantidad_entrada;
				$saldoPrecioCantidad = $saldoPrecioCantidad + $fila->precio_total;

				$cantidadIngresos = $cantidadIngresos +  $fila->cantidad_entrada;
				$totalIngresos = $totalIngresos +  $fila->precio_total;;

			}
			else
			{
				$dependencia = dependenciaSolicitudAlmacen($fila->id_salida);
				$tabla = $tabla."<td></td>";
				$tabla = $tabla."<td>".numeroSolicitudAlmacen($fila->id_salida)."</td>";				
				$tabla = $tabla."<td>".sigla_estrucctura($dependencia)."</td>";
				//$tabla = $tabla."<td>".$dependencia."</td>";
				$tabla = $tabla."<td>0</td>";
				$tabla = $tabla."<td>0.00</td>";
				$tabla = $tabla."<td>0.00</td>";
				$tabla = $tabla."<td>".$fila->cantidad_salida."</td>";
				$tabla = $tabla."<td>".number_format($fila->precio_unitario,2)."</td>";
				$tabla = $tabla."<td>".number_format($fila->precio_total,2)."</td>";

				$saldoCantidad = $saldoCantidad - $fila->cantidad_salida;
				$saldoPrecioCantidad = $saldoPrecioCantidad - $fila->precio_total;


				$cantidadSalidas = $cantidadSalidas + $fila->cantidad_salida;
				$totalSalidas    = $totalSalidas + $fila->precio_total;
			}
						

			$tabla = $tabla."<td>".$saldoCantidad."</td>";
			$tabla = $tabla."<td>".number_format($saldoPrecioCantidad,2)."</td>";
			$tabla = $tabla."</tr>";
		}
		$tabla = $tabla."<tr >";
		$tabla = $tabla."<td></td>";
		$tabla = $tabla."<td></td>";
		$tabla = $tabla."<td></td>";
		$tabla = $tabla."<td></td>";		
		$tabla = $tabla."<td></td>";
		$tabla = $tabla."<td ><b class='text-primary'>TOTALES</b></td>";
		$tabla = $tabla."<td><b class='text-primary'>".$cantidadIngresos."</b></td>";
		$tabla = $tabla."<td></td>";
		$tabla = $tabla."<td><b class='text-primary'>".$totalIngresos."</b></td>";
		$tabla = $tabla."<td><b class='text-primary'>".$cantidadSalidas."</b></td>";
		$tabla = $tabla."<td></td>";
		$tabla = $tabla."<td><b class='text-primary'>".number_format($totalSalidas,2)."</b></td>";
		$tabla = $tabla."<td><b class='text-primary'>".$saldoCantidad."</b></td>";
		$tabla = $tabla."<td><b class='text-primary'>".number_format($saldoPrecioCantidad,2)."</b></td>";
		$tabla = $tabla."</tr>";
		echo $tabla;



	}
	function cargartablasKardexMaterialesAlmacen()
	{
		$draw = intval($this->input->get("draw"));
		$gestion = gestion_vigente();
		$id_material = $this->input->get('id_mat');
		
		$filas = $this->reportes_model->getKardexMaterial($id_material, $gestion);
		$data = array();
		$num = 1;
		$concepto = "TIPO PROCESO";
		$dirección = "";
	    foreach ($filas as $fila)
	    {
		    $dirección = "";
	    	if($fila->tipo_proceso=="")
	    	{
	    		$tipo_proceso = descripcionDominiosValor($concepto,$fila->tipo_ingreso_egreso);	

	    		$dirección = datosDependenciaPersonal($fila->id_funcionario_solicitante);
	    	}
	    	else
	    	{
	    		$tipo_proceso = descripcionDominiosValor($concepto,$fila->tipo_proceso);
	    		if($fila->tipo_proceso == 'INGI' || $fila->tipo_proceso == 'INGP')
	    		{
	    			$tipo_proceso = "<b class='text-danger'>".$tipo_proceso."</b>";	
	    		}	    		
	    	}
	    	 $data[] = array(
	                $num++,
	                $fila->gestion,
	                $tipo_proceso,
	                $dirección,
	                $fila->cantidad_entrada,
	                $fila->cantidad_salida,
	                $fila->saldo,	                
	                $fila->precio_unitario,
	                $fila->precio_total,
	                formato_fecha_slash($fila->fecha_registro),
	                
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

