<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/libraries/fpdf/fpdf/easyTable.php";
require_once APPPATH . "/libraries/fpdf/fpdf/exfpdf.php";
class ResumenValorado extends CI_Controller
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
		$this->load->view('inicio/cabecera',$dato);
		$this->load->view('inicio/menu', $dato);
		$this->load->view('Reportes/ResumenValoradoReporte'); //cuerpo
		$this->load->view('inicio/pie');
		
	}


	function cargarTablaValorado()
	{
		$gestion = $this->input->post('gestion');
		$fecha_fin = $this->input->post('fecIni');
		$draw = intval($this->input->get("draw"));
		$filas = $this->reportes_model->getResumenValorado($gestion, $fecha_fin);	
		$data = array();
		$num = 1;
		$salgo_total = 0;
		$salgo_total_bs = 0;
	    foreach ($filas as $fila)
	    {
		    
		    $salgo_total = $fila->saldo_inicial + $fila->ingreso_fisico - $fila->salida_fisico;
		    $salgo_total_bs = $fila->saldo_inicial_valorado + $fila->ingreso_fisico_valorado - $fila->salida_fisico_valorado;
		    $data[] = array(
	                $num++,
	                $fila->codigo_material,
	                $fila->codigo_partida,
	                $fila->descripcion_unidad,
	                $fila->descripcion_material,
	                $fila->saldo_inicial,	  
	                $fila->ingreso_fisico,	  
	                $fila->salida_fisico,	  
	                $salgo_total,
	                number_format($fila->saldo_inicial_valorado,2),	  
	                number_format($fila->ingreso_fisico_valorado,2),	  
	                number_format($fila->salida_fisico_valorado,2),	  
	                number_format($salgo_total_bs,2)
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



	function cargarTablaPartidas()
	{
		$gestion = $this->input->post('gestion');
		$fecha_fin = $this->input->post('fecIni');
		$draw = intval($this->input->get("draw"));
		$filas = $this->reportes_model->getResumenValoradoPartida($gestion, $fecha_fin);	
		$data = array();
		$num = 1;
		$salgo_total = 0;
		$salgo_total_bs = 0;
	    foreach ($filas as $fila)
	    {
		    
		    $salgo_total = $fila->saldo_inicial_partida + $fila->ingreso_fisico_partida - $fila->salida_fisico_partida;
		    $salgo_total_bs = $fila->saldo_inicial_valorado_partida + $fila->ingreso_fisico_valorado_partida - $fila->salida_fisico_valorado_partida;
		    $data[] = array(
	                $num++,	                
	                $fila->codigo_partida,
	                descripcionCategoriaValor($fila->codigo_partida),
	                $fila->saldo_inicial_partida,
	                $fila->ingreso_fisico_partida,
	                $fila->salida_fisico_partida,
	                $salgo_total,
	                number_format($fila->saldo_inicial_valorado_partida,2),
	                number_format($fila->ingreso_fisico_valorado_partida,2),
	                number_format($fila->salida_fisico_valorado_partida,2),
	                number_format($salgo_total_bs,2)
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


	function reporteInventarioValorado($gestion,$fechaFin)
	{
		$filas = $this->reportes_model->getResumenValorado($gestion, $fechaFin);

		$this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);		
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera = 'RESUMEN FÍSICO VALORADO DE MATERIALES DE ALMACEN';
		$pdf->subtituloCabecera1 = "FECHA INICIAL: 01/01/2023       FECHA FINAL: ".formato_fecha_slash($fechaFin);  
        $w = array(7,13,11,15,74,17,15,15,17,17,15,15,17);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','C','C','L','L','R','R','R','R','R','R','R','R'));
		$pdf->AddPage('L','Letter');
		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=8;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',6);
        $saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;
        $sumatotal = 0;
        $saldo_total = 0;
		$saldo_total_bs = 0;
		$saldo_inicial = 0;
		$ingreso_fisico = 0;
		$salida_fisico = 0;
		$saldo_total_suma = 0;
		$saldo_inicial_valorado = 0;
		$ingreso_fisico_valorado = 0;
		$salida_fisico_valorado = 0;
		$saldo_total_bs_suma = 0;

        foreach ($filas as $fila)
        {
        	$num++;	
        	$saldo_total = $fila->saldo_inicial + $fila->ingreso_fisico - $fila->salida_fisico;
		    $saldo_total_bs = $fila->saldo_inicial_valorado + $fila->ingreso_fisico_valorado - $fila->salida_fisico_valorado;


		    $saldo_inicial = $saldo_inicial + $fila->saldo_inicial;
			$ingreso_fisico = $ingreso_fisico + $fila->ingreso_fisico;
			$salida_fisico = $salida_fisico + $fila->salida_fisico;
			$saldo_total_suma = $saldo_total_suma + $saldo_total;
			$saldo_inicial_valorado = $saldo_inicial_valorado + $fila->saldo_inicial_valorado;
			$ingreso_fisico_valorado = $ingreso_fisico_valorado + $fila->ingreso_fisico_valorado;
			$salida_fisico_valorado = $salida_fisico_valorado + $fila->salida_fisico_valorado;
			$saldo_total_bs_suma = $saldo_total_bs_suma + $saldo_total_bs;




        	$fila = array(
        		$num,
                $fila->codigo_material,
                $fila->codigo_partida,
                $fila->descripcion_unidad,
                utf8_decode($fila->descripcion_material),
                $fila->saldo_inicial,	  
                $fila->ingreso_fisico,	  
                $fila->salida_fisico,	  
                $saldo_total,
                number_format($fila->saldo_inicial_valorado,2,',','.'),	  
                number_format($fila->ingreso_fisico_valorado,2,',','.'),	  
                number_format($fila->salida_fisico_valorado,2,',','.'),	  
                number_format($saldo_total_bs,2,',','.')             
        	);

	        $pdf->Row_Reportes($fila,true, '', 4);
	    }        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(120,6,utf8_decode('TOTAL'),1,0,'C',1);
        $pdf->Cell(17,6,number_format($saldo_inicial,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($ingreso_fisico,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($salida_fisico,2,',','.'),1,0,'R',1);
        $pdf->Cell(17,6,number_format($saldo_total_suma,2,',','.'),1,0,'R',1);
        $pdf->Cell(17,6,number_format($saldo_inicial_valorado,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($ingreso_fisico_valorado,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($salida_fisico_valorado,2,',','.'),1,0,'R',1);        
        $pdf->Cell(17,6,number_format($saldo_total_bs_suma,2,',','.'),1,1,'R',1);

        $pdf->Output('I','Reporte.pdf'); 
	}


	function reporteInventarioPartidas($gestion,$fechaFin)
	{
		$filas = $this->reportes_model->getResumenValoradoPartida($gestion, $fechaFin);

		$this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);		
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera = 'RESUMEN FÍSICO VALORADO POR PARTIDAS';
		$pdf->subtituloCabecera1 = "FECHA INICIAL: 01/01/2023       FECHA FINAL: ".formato_fecha_slash($fechaFin);   
        $w = array(7,12,101,17,15,15,17,17,15,15,17);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','L','L','R','R','R','R','R','R','R','R'));
		$pdf->AddPage('L','Letter');
		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=9;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',6);
        $saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;
        $sumatotal = 0;
        $saldo_total = 0;
		$saldo_total_bs = 0;
		$saldo_inicial = 0;
		$ingreso_fisico = 0;
		$salida_fisico = 0;
		$saldo_total_suma = 0;
		$saldo_inicial_valorado = 0;
		$ingreso_fisico_valorado = 0;
		$salida_fisico_valorado = 0;
		$saldo_total_bs_suma = 0;

        foreach ($filas as $fila)
        {
        	$num++;	
        	$saldo_total = $fila->saldo_inicial_partida + $fila->ingreso_fisico_partida - $fila->salida_fisico_partida;
		    $saldo_total_bs = $fila->saldo_inicial_valorado_partida + $fila->ingreso_fisico_valorado_partida - $fila->salida_fisico_valorado_partida;


		    $saldo_inicial = $saldo_inicial + $fila->saldo_inicial_partida;
			$ingreso_fisico = $ingreso_fisico + $fila->ingreso_fisico_partida;
			$salida_fisico = $salida_fisico + $fila->salida_fisico_partida;
			$saldo_total_suma = $saldo_total_suma + $saldo_total;
			$saldo_inicial_valorado = $saldo_inicial_valorado + $fila->saldo_inicial_valorado_partida;
			$ingreso_fisico_valorado = $ingreso_fisico_valorado + $fila->ingreso_fisico_valorado_partida;
			$salida_fisico_valorado = $salida_fisico_valorado + $fila->salida_fisico_valorado_partida;
			$saldo_total_bs_suma = $saldo_total_bs_suma + $saldo_total_bs;
        	$fila = array(
        		$num,
                $fila->codigo_partida,
	            utf8_decode(descripcionCategoriaValor($fila->codigo_partida)),
                $fila->saldo_inicial_partida,	  
                $fila->ingreso_fisico_partida,	  
                $fila->salida_fisico_partida,	  
                $saldo_total,
                number_format($fila->saldo_inicial_valorado_partida,2,',','.'),	  
                number_format($fila->ingreso_fisico_valorado_partida,2,',','.'),	  
                number_format($fila->salida_fisico_valorado_partida,2,',','.'),	  
                number_format($saldo_total_bs,2,',','.')             
        	);
	        $pdf->Row_Reportes($fila,true, '', 4);
	    }        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(120,6,utf8_decode('TOTAL'),1,0,'C',1);
        $pdf->Cell(17,6,number_format($saldo_inicial,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($ingreso_fisico,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($salida_fisico,2,',','.'),1,0,'R',1);
        $pdf->Cell(17,6,number_format($saldo_total_suma,2,',','.'),1,0,'R',1);
        $pdf->Cell(17,6,number_format($saldo_inicial_valorado,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($ingreso_fisico_valorado,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($salida_fisico_valorado,2,',','.'),1,0,'R',1);        
        $pdf->Cell(17,6,number_format($saldo_total_bs_suma,2,',','.'),1,1,'R',1);

        $pdf->Output('I','Reporte.pdf'); 
	}




	function actualizar_informacion()
	{
		$filas = $this->reportes_model->getIngresos();
		foreach($filas as $fila)
		{
			$idInventarioInicial = $fila->id;
			$id_material = $fila->id_material;
			$idInventario = $fila->id;
			$con = 1;
			while($con == 1)
			{
				$inve = $this->reportes_model->getSalidasIngresos($idInventario);
				if($inve)
				{
					foreach($inve as $fil)
					{
						$idInventario = $fil->id;
						echo "aqui ".$idInventarioInicial." ".$id_material." ".$idInventario."<br>";
						$data = array(
							'id_inventario_ingresos' => $idInventarioInicial
							);

						$this->ingresos_model->updateInvetarios($idInventario,$data);
					}	
				}
				else
				{
					$con++;
				}				
			}
		}
	}
	
}

