<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/libraries/fpdf/fpdf/easyTable.php";
require_once APPPATH . "/libraries/fpdf/fpdf/exfpdf.php";
class IngresosSalidas extends CI_Controller
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
		$this->load->view('Reportes/ReporteIngresosSalidas'); //cuerpo
		$this->load->view('inicio/pie');
		
	}


	function cargarTablaIngresos()
	{
		$fecha_inicio = $this->input->post('fecIni');
		$fecha_fin 	  = $this->input->post('fecFin');

		$draw = intval($this->input->get("draw"));
		$filas = $this->reportes_model->getIngresosFechas($fecha_inicio, $fecha_fin);	
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $data[] = array(
	                $num++,
	                formato_fecha_slash($fila->fecha_ingreso),
	                $fila->cite,
	                descripcionProveedorValor($fila->id_provedor),
	                number_format($fila->total_ingreso,2)
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



	function cargarTablaSalidas()
	{
		$fecha_inicio = $this->input->post('fecIni');
		$fecha_fin 	  = $this->input->post('fecFin');

		$draw = intval($this->input->get("draw"));
		$filas = $this->reportes_model->getSalidasFechas($fecha_inicio, $fecha_fin);	
		
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";

		    $organizacion = nombre_estructura($fila->id_dependencia);
			if($fila->id_subdependencia >0)
			{
				$organizacion = sigla_estrucctura($fila->id_dependencia);
				$organizacion = $organizacion." / ".nombre_subestructura($fila->id_subdependencia);
			}
			$organizacion = trim($organizacion);
		
		    $data[] = array(
	                $num++,
	                formato_fecha_slash($fila->fecha_entrega),
	                $fila->cite,
	                $organizacion,
	                number_format($fila->total_salida,2)
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


	function reporteMaterialEntregado($fechaInicio,$fechaFin)
	{
		$filas = $this->reportes_model->getSalidasFechas($fechaInicio, $fechaFin);
		$this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);		
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera = 'REPORTE DE SOLICITUDES A ALMACEN';
		$pdf->subtituloCabecera1 = "DEL ".formato_fecha_slash($fechaInicio)." AL ".formato_fecha_slash($fechaFin);   
        $w = array(10,20,30,90,30);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','C','C','L','R'));
		$pdf->AddPage('P','Letter');
		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=6;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',6);
        $saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;
        $sumatotal = 0;
        foreach ($filas as $fila)
        {
        	$organizacion = nombre_estructura($fila->id_dependencia);
			if($fila->id_subdependencia >0)
			{
				$organizacion = sigla_estrucctura($fila->id_dependencia);
				$organizacion = $organizacion." / ".nombre_subestructura($fila->id_subdependencia);
			}
			$sumatotal = $sumatotal + $fila->total_salida;
			$organizacion = trim($organizacion);
	        	$num++;	        	
	        	$fila = array(
	        		$num,
	        		formato_fecha_slash($fila->fecha_entrega),
	                utf8_decode($fila->cite ),
	                utf8_decode($organizacion),
	                number_format($fila->total_salida,2)	               
	        	);
	        $pdf->Row_Entidad($fila,true, '', 5);
	    }        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(150,6,utf8_decode('TOTAL'),1,0,'C',1);
        $pdf->Cell(30,6,number_format($sumatotal,2),1,1,'R',1);      
        $pdf->Output('I','Reporte.pdf'); 
	}
	function reporteMaterialIngresos($fechaInicio,$fechaFin)
	{
		$filas = $this->reportes_model->getIngresosFechas($fechaInicio, $fechaFin);
		$this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);		
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera = 'REPORTE DE INGRESO A ALMACEN';
		$pdf->subtituloCabecera1 = "DEL ".formato_fecha_slash($fechaInicio)." AL ".formato_fecha_slash($fechaFin);   
        $w = array(10,20,30,90,30);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','C','C','J','R'));
		$pdf->AddPage('P','Letter');
		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=7;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',6);
        $saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;
        $sumatotal = 0;
        foreach ($filas as $fila)
        {
        	
	        	$num++;
	        	$sumatotal = $sumatotal + $fila->total_ingreso;      	
	        	$fila = array(
	        		$num,
	        		formato_fecha_slash($fila->fecha_ingreso),
	                utf8_decode($fila->cite ),
	                utf8_decode( descripcionProveedorValor($fila->id_provedor)),
	                number_format($fila->total_ingreso,2)	               
	        	);


	        	 


	        $pdf->Row_Entidad($fila,true, '', 5);
	    }        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(150,6,utf8_decode('TOTAL'),1,0,'C',1);
        $pdf->Cell(30,6,number_format($sumatotal,2),1,1,'R',1);      
        $pdf->Output('I','Reporte.pdf'); 
	}	
}

