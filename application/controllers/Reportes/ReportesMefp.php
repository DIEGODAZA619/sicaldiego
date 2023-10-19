<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/libraries/fpdf/fpdf/easyTable.php";
require_once APPPATH . "/libraries/fpdf/fpdf/exfpdf.php";
class ReportesMefp extends CI_Controller
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
		$this->load->view('Reportes/ReporteMefp'); //cuerpo
		$this->load->view('inicio/pie');
		
	}

	function cargarTablaDetallado()
	{
		$gestion = $this->input->post('gestion');
		$fecha_fin = $this->input->post('fecIni');
		$draw = intval($this->input->get("draw"));
		$filas = $this->reportes_model->getDetalleAlmacenes($gestion,$fecha_fin);	
		//echo json_encode($filas);
		$data = array();
		$num = 1;
		$saldo_total = 0;
		$salgo_total_bs = 0;
		$saldoInicial = 0;
		$entrada = 0;
		$saldoInicialbs = 0;
		$precio_entrada = 0;
	    foreach ($filas as $fila)
	    {
		    
		    if($fila->tipo_proceso == 'INGI')
		    {
		    	$saldoInicial = $fila->cantidad_entrada;		    	
		    	$entrada = 0;

		    	$saldoInicialbs = $fila->precio_total;
		    	$precio_entrada = 0;
		    }	
		    else
		    {
		    	$saldoInicial = 0;
		    	$entrada = $fila->cantidad_entrada;

		    	$saldoInicialbs = 0;
		    	$precio_entrada = $fila->precio_total;
		    }

		    $saldo_total    = $fila->cantidad_entrada - $fila->cantidadsalida;
		    $salgo_total_bs = $fila->precio_total - $fila->valorsalida;
		    $data[] = array(
	                $num++,	                
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                number_format($fila->precio_unitario,2,',','.'),
	                $saldoInicial,
	                $entrada,
	                $fila->cantidadsalida,
	                $saldo_total,
	                number_format($saldoInicialbs,2,',','.'),
	                number_format($precio_entrada,2,',','.'),
	                number_format($fila->valorsalida,2,',','.'),
	                number_format($salgo_total_bs,2,',','.'),	                          
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
	                $fila->codigo_partida." ".descripcionCategoriaValor($fila->codigo_partida),
	                $fila->saldo_inicial_partida,
	                number_format($fila->saldo_inicial_valorado_partida,2),	                
	                $salgo_total,
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

	function reporteInventarioPartidas($gestion,$fechaFin)
	{
		$filas = $this->reportes_model->getResumenValoradoPartida($gestion, $fechaFin);

		$this->load->library('fpdf/pdf3');
        $pdf = new Pdf3('L','cm','legal');
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(40,15,10);
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera     = 'SERVICIO NACIONAL DE PATRIMONIO DEL ESTADO';
		$pdf->tituloCabeceraDos  = 'RESUMEN DE ALMACENES (BIENES DE CONSUMO)';
		$pdf->subtituloCabecera1 = "AL: ".fechacompleta2($fechaFin);  
		$pdf->subtituloCabecera2 = "(Expresado en Bolivianos)";
		$pdf->fechaReporte = formato_fecha_slash($fechaFin);
        $w = array(10,140,35,35,35,35);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','L','R','R','R','R'));
		$pdf->AddPage('L','legal');
		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=11;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',10);
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
        	$filas = array(
        		$num,
                $fila->codigo_partida."   ".utf8_decode(descripcionCategoriaValor($fila->codigo_partida)),

                number_format($fila->saldo_inicial_partida,0,',','.').'   ',
	            number_format($fila->saldo_inicial_valorado_partida,2,',','.').'   ',
	            number_format($saldo_total,0,',','.').'   ',
	            number_format($saldo_total_bs,2,',','.').'   '
	        );
	        $pdf->Row($filas,true, '', 5);
	    }
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(150,6,utf8_decode('TOTAL'),0,0,'C',0);
        $pdf->Cell(35,6,number_format($saldo_inicial,0,',','.').'   ',1,0,'R',1);
        $pdf->Cell(35,6,number_format($saldo_inicial_valorado,2,',','.').'   ',1,0,'R',1);
        $pdf->Cell(35,6,number_format($saldo_total_suma,0,',','.').'   ',1,0,'R',1);
        $pdf->Cell(35,6,number_format($saldo_total_bs_suma,2,',','.').'   ',1,0,'R',1);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','B',6);
        $pdf->Ln(7);
        $pdf->Cell(6,6,utf8_decode('Nota:'),0,0,'L',0);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(180,6,utf8_decode('La información expuesta en el presente cuadro cuenta con la documentación de soporte correspondiente en el marco de la Normativas Básicas del Sistema de Contabilidad Integrada.'),0,0,'L',1);

        $pdf->Output('I','Reporte.pdf'); 
	}

	function reporteInventarioValorado($gestion, $fechaFin)
	{
		$filas = $this->reportes_model->getDetalleAlmacenes($gestion,$fechaFin);
		$this->load->library('fpdf/pdf3');
        $pdf = new Pdf3('L','cm','legal');
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->SetMargins(35,15,10);		
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera     = 'MINISTERIO DE ECONOMÍA Y FINANZAS PÚBLICAS';
		$pdf->tituloCabeceraDos  = 'D.A 6 - SERVICIO NACIONAL DE PATRIMONIO DEL ESTADO';
		$pdf->tituloCabeceraTres = 'RESUMEN DE ALMACENES (BIENES DE CONSUMO)';
		$pdf->subtituloCabecera1 = "AL: ".fechacompleta2($fechaFin);  
		$pdf->subtituloCabecera2 = "(Expresado en Bolivianos)";  
        $w = array(10,140,15,15,15,15,15,15,15,15,15,15);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','L','C','R','R','R','R','R','R','R','R','R','R'));
		$pdf->AddPage('L','legal');
		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=10;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',6);
        $saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;
        $precio_unitario  = 0;
		$saldo_incial  = 0;
		$entradas1  = 0;
		$salidas1  = 0;
		$saldofinal  = 0;
		$saldo_inicial_valorado  = 0;
		$entrada_valorado  = 0;
		$salida_valorado  = 0;
		$saldo_final_valorado  = 0;

		$saldo_total = 0;
		$salgo_total_bs = 0;
		$saldoInicial = 0;
		$entrada = 0;
		$saldoInicialbs = 0;
		$precio_entrada = 0;
		$id_material_anterior = 0;
		$valnum = '';
        foreach ($filas as $fila)
        {
        	if($fila->tipo_proceso == 'INGI')
		    {
		    	$saldoInicial = $fila->cantidad_entrada;		    	
		    	$entrada = 0;

		    	$saldoInicialbs = $fila->precio_total;
		    	$precio_entrada = 0;
		    }	
		    else
		    {
		    	$saldoInicial = 0;
		    	$entrada = $fila->cantidad_entrada;

		    	$saldoInicialbs = 0;
		    	$precio_entrada = $fila->precio_total;
		    }
		    $saldo_total    = $fila->cantidad_entrada - $fila->cantidadsalida;
		    $salgo_total_bs = $fila->precio_total - $fila->valorsalida;

		    $precio_unitario  		= $precio_unitario + $fila->precio_unitario;
			$saldo_incial  			= $saldo_incial + $saldoInicial;
			$entradas1  			= $entradas1 + $entrada;
			$salidas1  				= $salidas1 + $fila->cantidadsalida;
			$saldofinal  			= $saldofinal + $saldo_total;
			$saldo_inicial_valorado = $saldo_inicial_valorado + $saldoInicialbs;
			$entrada_valorado  		= $entrada_valorado + $precio_entrada;
			$salida_valorado  		= $salida_valorado + $fila->valorsalida;
			$saldo_final_valorado  	= $saldo_final_valorado + $salgo_total_bs;

			if($fila->id_material != $id_material_anterior)
			{
				$id_material_anterior = $fila->id_material;
				$num++;
				$valnum = $num;
			}
			else
			{
				$valnum = '';
			}
        	$fila = array(
        		$valnum,
                utf8_decode($fila->descripcion_material),
                utf8_decode($fila->descripcion_unidad),
                number_format($fila->precio_unitario,2,',','.'),	               
                $saldoInicial,
                $entrada,
                $fila->cantidadsalida,
                $saldo_total,
                number_format($saldoInicialbs,2,',','.'),
                number_format($precio_entrada,2,',','.'),
                number_format($fila->valorsalida,2,',','.'),
                number_format($salgo_total_bs,2,',','.')
        	);        	
	        $pdf->Row_Reportes($fila,true, '', 4);
	    }        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(165,6,utf8_decode('TOTAL'),0,0,'C',0);
        $pdf->Cell(15,6,number_format($precio_unitario,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($saldo_incial,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($entradas1,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($salidas1,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($saldofinal,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($saldo_inicial_valorado,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($entrada_valorado,2,',','.'),1,0,'R',1);        
        $pdf->Cell(15,6,number_format($salida_valorado,2,',','.'),1,0,'R',1);
        $pdf->Cell(15,6,number_format($saldo_final_valorado,2,',','.'),1,1,'R',1);

		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','B',6);
        $pdf->Ln(2);
        $pdf->Cell(6,6,utf8_decode('Nota:'),0,0,'L',0);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(180,6,utf8_decode('La información expuesta en el presente cuadro cuenta con la documentación de soporte correspondiente en el marco de la Normativas Básicas del Sistema de Contabilidad Integrada.'),0,0,'L',1);
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

