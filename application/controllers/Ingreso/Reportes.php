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
		$this->load->view('Ingreso/formReporte'); //cuerpo
		$this->load->view('inicio/pie');
	}

	function cargarTablaIngresos()
	{
		$draw = intval($this->input->get("draw"));
		$id_entidad = 1;
		$estado = 'AC';
		$filas = $this->ingresos_model->getIngresos($id_entidad,$estado);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Agregar Materiales'>
						<button class='btn btn-success btn-circle' onclick='listarMateriales(".$fila->id.", this)'><i class='mdi mdi-check'></i></button>
					</span>";
			$botonReporte ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Reporte a Detalle'>
						<button class='btn btn-primary btn-circle' onclick='reporteMaterialIngresado(".$fila->id.")'><i class='mdi mdi-printer'></i></button>
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
	               // descripcion_estados($fila->estado),
	                $boton.$botonReporte
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
		$estado = 'AC';
		$filas = $this->ingresos_model->getIngresosDetallesId($id_ingreso,$estado);
		$data = array();
		$num = 1;
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
		    $data[] = array(
	                $num++,
	                $fila->codigo,
	                $fila->descripcion,
	                $fila->cantidad_ingreso,
	                number_format($fila->precio_unitario,2),
	                number_format($fila->precio_total,2),
	                formato_fecha_hora($fila->fecha_registro),
	               // descripcion_estados($fila->estado),
	               // $boton
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

	/////////////////////////////
	//////// REPORTES ///////////
	function reporteMaterialEntregado_OLD($id_ingreso)
	{
		$id_funcionario             = $this->session->userdata('id_funcionario');
		$idDependencia 				= $this->session->userdata('id_dependencia_principal');
		$idSubDependencia 			= $this->session->userdata('id_subdependencia_principal');
		$idDependenciaSecundario 	= $this->session->userdata('id_dependencia_secundario');
		$idSubdependenciaSecundario = $this->session->userdata('id_subdependencia_secundario');
		$tipoSolicitud =  "NOR";
		$estado = 'AC';

		//$usuario = $this->reportes_model->confirmaSolicitudDireccion($id_ingreso);

		//$filas = $this->solicitudes_model->solicitudConfirmadasDireccion($idDependencia,$tipoSolicitud,$estado);
		
	    $this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);
        
		$solicitante = "XXX"; //datos_persona_nombre($usuario[0]->id_funcionario_solicitante);
		$filas = $this->ingresos_model->getIngresosDetallesId($id_ingreso,$estado);
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera = 'LISTA DE MATERIALES INGRESADOS';
        $pdf->subtituloCabecera1 = "PROVEEDOR: ".$filas[0]->proveedor;
        //$pdf->subtituloCabecera2 =  "CITE : ";//.$usuario[0]->cite;
        $pdf->subtituloCabecera2 ="";
		
        $w = array(10,20,20,40,20,20,20,20);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','C','L','C','L','C','C','C'));

		$pdf->AddPage('P','Letter');
		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=4;

		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',5);
        $saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;

        foreach ($filas as $fila){
	        	$num++;
	        	$saldoSumCE += $fila->cantidad_ingreso;
	        	$fila = array(
	        		$num,
	        		$fila->partida,
	                $fila->codigo,
	                $fila->descripcion,
	                number_format($fila->precio_unitario,2),
	                number_format($fila->precio_total,2),
	                formato_fecha_hora($fila->fecha_registro),
	                $fila->cantidad_ingreso
	        	);
	        $pdf->Row_Entidad($fila,true, '', 5);
	    }
           
        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',8);
                  
        if($num==1){ $registro=' Registro';}
        else{ $registro=' Registros';}
        $pdf->Cell(130,6,utf8_decode('TOTAL'),1,0,'C',1);
        $pdf->Cell(20,6,utf8_decode($saldoSumCE),1,0,'C',1);
       // $pdf->Cell(25,6,utf8_decode($saldoSumCS),1,0,'C',1);
       // $pdf->Cell(25,6,utf8_decode($saldoSum ),1,0,'R',1);

        $pdf->Output('I','Reporte.pdf'); 

	}

	function reporteMaterialEntregado($id_ingreso)
	{

		$pdf=new exFPDF('P','mm','Letter');
		$pdf->AliasNbPages(); 
		$pdf->AddPage(); 
		
		$pdf->SetFont('helvetica','',10);
		$pdf->AddFont('FontUTF8','','Arimo-Regular.php'); 
		$pdf->Header();

		//$table=new easyTable($pdf, '%{50,50}','align:{LR};width:190; border:1');
		//$table->easyCell('', 'img:resources/images/logos/logo_senape_reporte.png, h14, w70;align:L;');
		//$table->easyCell('', 'img:resources/images/logos/chakana.png, w58, h18 ;align:R');
		//$table->printRow(true);
	    //$table->endTable(2);
	    //$pdf->SetMargins(-10,15,-10);
		
		$estado = 'AC';
		$filas = $this->ingresos_model->getIngresosDetallesId($id_ingreso,$estado);
		$table=new easyTable($pdf, 1, 'width:180; paddingX:10; ;align:B'); //border-color:#ffff00; font-size:10; border:1; paddingY:2;');
		//$table->rowStyle('align:{LRCC}; bgcolor:#00ace6;font-style:B');
		$table->easyCell("ALMACEN CENTRAL",'align:C;font-style:B');
		$table->printRow();
		$table->easyCell("INGRESO DE ITEMS",'align:C;font-style:B');
		$table->printRow();
		$table->endTable();
		$table=new easyTable($pdf,'%{15,40,25,20}', 'width:190;align:{RCLL};  font-size:8;');
		$table->easyCell("PROVEEDOR: " ,'width:40;align:R;font-style:B');
		$table->easyCell($filas[0]->proveedor,'align:L;width:90;');
		$table->easyCell(utf8_decode("N° DE DOCUMENTO: "),'align:C;font-style:B');
		$table->easyCell($id_ingreso);
		$table->printRow();
		$table->easyCell("NIT: ",'align:R;font-style:B');
		$table->easyCell($filas[0]->nit,'align:L;');
		$table->easyCell("FECHA  DE INGRESO: ",'align:C;font-style:B');
		$table->easyCell($filas[0]->fecha_ingreso,'align:L;');
		$table->printRow(true);
		$table->endTable(2);


		$table=new easyTable($pdf, '{10,10,15,101,12,12,15,15}', 'width:190; border-color:#ccc00; font-size:5; border:1; paddingY:1;');
		$table->rowStyle('align:{LCCCCCCC}; bgcolor:#ccc;font-style:B');
        $table->easyCell(utf8_decode('NRO'));
        $table->easyCell(utf8_decode('PARTIDA'));
        $table->easyCell(utf8_decode('CODIGO'));
        $table->easyCell(utf8_decode('DESCRIPCION'));
        $table->easyCell(utf8_decode('UNIDAD'));
        $table->easyCell(utf8_decode('CANTIDAD'));
        $table->easyCell(utf8_decode('PRECIO UNIT.'));
        $table->easyCell(utf8_decode('PRECIO TOTAL'));
        $table->printRow(true);
		$saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;

        foreach ($filas as $fila){
        		$bgcolor='';
			    if($num%2)
			    {
			       $bgcolor='bgcolor:#f4f4f4;';
			    }
	        	$num++;
	        	$saldoSumCE += $fila->precio_total;
	        	$table->rowStyle('valign:M;align:{CCCLCC};border:LTRB;paddingY:1;' . $bgcolor);
			    $table->easyCell($num,'align:C');
			    $table->easyCell(substr($fila->partida,0,5));
			    $table->easyCell($fila->codigo);
			    $table->easyCell(utf8_decode($fila->descripcion));
			    $table->easyCell($fila->unidad);
			    $table->easyCell($fila->cantidad_ingreso,'align:C');
			    $table->easyCell(number_format($fila->precio_unitario,2),'align:R');
			    $table->easyCell(number_format($fila->precio_total,2),'align:R');

	       $table->printRow();
	    }

	    $table->easyCell(' ','colspan:6;border:0;');
	    $table->easyCell('TOTAL (Bs.)','align:C;font-style:B;border:0;');
	     $table->easyCell( number_format($saldoSumCE,2),'align:R;border:0;font-style:B;');
	    $table->printRow();
	    $table->endTable(10);
		$table=new easyTable($pdf, '{24,166}', 'border:T; border-color:#000; width:190;align:C{RL};font-size:8; '); 
		$table->easyCell("DESCRIPCION: " ,'align:L;font-style:B');
		$table->easyCell(utf8_decode($filas[0]->descripcion_ingreso) ,'align:L;');
		$table->printRow();
		$table->endTable(10);

		$table=new easyTable($pdf, '{15,175}', ' width:190;align:C{RL};font-size:6;   '); 
		$table->easyCell($filas[0]->estado.": " ,'align:L;font-style:B');
		$table->easyCell(utf8_decode(datos_persona_nombre($filas[0]->id_funcionario_registro) ) ,'align:L;');
		$table->printRow();
		$table->endTable(10);
		
		$pdf->Output('I','Reporte.pdf'); 

	}
 function Header()
 {
 	$table=new easyTable($pdf, '%{50,50}','align:{LR};width:190; border:1');
	//$table->easyCell('', 'img:resources/images/logos/logo_senape_reporte.png, h14, w70;align:L;');
	//$table->easyCell('', 'img:resources/images/logos/chakana.png, w58, h18 ;align:R');
	$table->printRow(true);
	$table->endTable(2);
	$pdf->SetMargins(-10,15,-10);
 }

	
}

