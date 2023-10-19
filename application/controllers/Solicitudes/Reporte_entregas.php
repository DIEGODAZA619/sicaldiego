<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_entregas extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('materiales_model');
		$this->load->model('ingresos_model');
		$this->load->model('materiales_model');
		$this->load->model('entregados_model');		
		$this->load->model('solicitudes_model');
		$this->load->helper('configuraciones_helper');
		$this->load->helper('funcionarios_helper');		
		$this->load->library('fpdf/pdf2');
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
		$this->load->view('Solicitudes/entregados'); //cuerpo
		$this->load->view('inicio/pie');
	}

	function cargartablaSolicitudesEntregadas()
	{
		$draw = intval($this->input->get("draw"));
		$filas = $this->entregados_model->getEntregados();
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Lista Detalle'>
						<button type='button' class='btn btn-warning btn-circle' onclick='reporteEntregados(".$fila->id.")'><i class='mdi mdi-eye'></i></button>
					 </span>";  
			$botonReporte ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Reporte a Detalle del Material Entregado'>
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
	                $fila->cantidad_autorizada,
	                formato_fecha_hora($fila->fecha_registro),
	                $fila->motivo,
	                descripcion_estados($fila->estado),
	                $boton.$botonReporte.$botonResumen
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
		$estado = 'ENT';
		$filas = $this->entregados_model->getSolicitudDireccionConfirmados($idConfirmacion,$estado);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "-";

		    $data[] = array(
	                $num++,
	                datos_persona_nombre($fila->id_funcionario),
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                $fila->descripcion_categoria,
	                $fila->cantidad_solicitada,
	                $fila->cantidad_autorizada,
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

	/////////////////////////////
	//////// REPORTES ///////////
	function reporteMaterialEntregado($id)
	{
		$id_funcionario = $this->session->userdata('id_funcionario');
		
		$tipoSolicitud =  "NOR";
		$usuario = $this->reportes_model->confirmaSolicitudDireccion($id);
		$idDependencia     = $usuario[0]->id_dependencia;
		$idSubDependencia  = $usuario[0]->id_subdependencia;

		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmadosAutorizados($id);
		
	    $this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);

		$solicitante = datos_persona_nombre($usuario[0]->id_funcionario_solicitante);
		$organizacion = nombre_estructura($idDependencia);
		if($idSubDependencia >0)
		{
			$organizacion = sigla_estrucctura($idDependencia);
			$organizacion = $organizacion." / ".nombre_subestructura($idSubDependencia);
		}
		$organizacion = trim($organizacion);
		//$filas = $this->solicitudes_model->getSolicitudDireccionConfirmados($id);
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera = 'ENTREGA MATERIALES';
        $pdf->subtituloCabecera1 = "ÁREA ORGANIZACIONAL: ".$organizacion;
        $pdf->subtituloCabecera2 = "SOLICITANTE : ".$solicitante;
        $pdf->subtituloCabecera3 = "CORRELATIVO : ".$usuario[0]->cite;

        $w = array(10,35,20,60,20,18,17);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','L','C','J','C','C','C','C'));
		$pdf->AddPage('P','Letter');

		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=3;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',6);
        $saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;

        foreach ($filas as $fila){
	        	$num++;
	        	$saldoSumCE += $fila->cantidad_autorizada;
	        	$fila = array(
	        		$num,
	        		utf8_decode(datos_persona_nombre($fila->id_funcionario)) ,
	                utf8_decode($fila->codigo_material ),
	                utf8_decode($fila->descripcion_material),
	                utf8_decode($fila->descripcion_unidad),
	                utf8_decode(substr($fila->codigo_categoria,0,5)),
	                utf8_decode($fila->cantidad_autorizada)
	        	);
	        $pdf->Row_Entidad($fila,true, '', 5);
	    }
        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',8);
                  
        if($num==1)
        	{ $registro=' Registro';}
        else{ $registro=' Registros';}
        $pdf->Cell(163,6,utf8_decode('TOTAL'),1,0,'C',1);
        $pdf->Cell(17,6,utf8_decode($saldoSumCE),1,1,'C',1);
       // $pdf->Cell(25,6,utf8_decode($saldoSumCS),1,0,'C',1);
       // $pdf->Cell(25,6,utf8_decode($saldoSum ),1,0,'R',1);
        $aprobador = $this->solicitudes_model->getListarDatosSolicitudDireccion($id);
        if(!empty($aprobador)){
        	$funcionario_aprobador=utf8_decode(datos_persona_nombre($aprobador[0]->id_funcionario_aprobador));
        	$funcionario_autorizador=utf8_decode(datos_persona_nombre($aprobador[0]->id_funcionario_autorizador));
        	$funcionario_solicitante=utf8_decode(datos_persona_nombre($aprobador[0]->id_funcionario_solicitante));
        } else {
        	$funcionario_aprobador='';
        }
        /*$pdf->SetFont('Arial','B',6);
        $pdf->Cell(10,4,utf8_decode("MOTIVO:"),'TBL',0,'L',0);*/
        $pdf->SetFont('Arial','',6);
        $pdf->MultiCell(180,4,"MOTIVO: ".utf8_decode($usuario[0]->motivo),1,'J',0);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(90,4,utf8_decode("APROBADO POR: ".$funcionario_aprobador),0,0,'L',0);
        $pdf->Cell(90,4,utf8_decode("AUTORIZADO POR: ".$funcionario_autorizador),0,1,'L',0);
        $pdf->Cell(90,4,utf8_decode("RECIBÍ CONFORME: ".$funcionario_solicitante),0,1,'L',0);
        $pdf->Output('I','Reporte.pdf'); 
	}

	function reporteResumenPedido($id)
	{
		$id_funcionario = $this->session->userdata('id_funcionario');
		
		$tipoSolicitud =  "NOR";
		$usuario = $this->reportes_model->confirmaSolicitudDireccion($id);
		$idDependencia     = $usuario[0]->id_dependencia;
		$idSubDependencia  = $usuario[0]->id_subdependencia;

		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmadosAutorizadosResumen($id);
		
	    $this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);

		$solicitante = datos_persona_nombre($usuario[0]->id_funcionario_solicitante);
		$organizacion = nombre_estructura($idDependencia);
		if($idSubDependencia >0)
		{
			$organizacion = "";//sigla_estrucctura($idDependencia);
			$organizacion = $organizacion." / ".nombre_subestructura($idSubDependencia);
		}
		$organizacion = trim($organizacion);

		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera = 'ENTREGA MATERIALES';
        $pdf->subtituloCabecera1 = "ÁREA ORGANIZACIONAL: ".$organizacion;
        $pdf->subtituloCabecera2 = "SOLICITANTE : ".$solicitante;
        $pdf->subtituloCabecera3 = "CORRELATIVO : ".$usuario[0]->cite;

        $w = array(10,20,95,20,18,17);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','C','J','C','C','C','C'));
		$pdf->AddPage('P','Letter');

		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=5;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',6);
        $saldoSumCE=0;
        $num = 0;

        foreach ($filas as $fila){
	        	$num++;
	        	$saldoSumCE += $fila->cantidad_autorizada;
	        	$fila = array(
	        		$num,
	                utf8_decode($fila->codigo_material ),
	                utf8_decode($fila->descripcion_material),
	                utf8_decode($fila->descripcion_unidad),
	                utf8_decode(substr($fila->codigo_categoria,0,5)),
	                utf8_decode($fila->cantidad_autorizada)
	        	);
	        $pdf->Row_Entidad($fila,true, '', 5);
	    }
        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',8);
                  
        if($num==1)
        	{ $registro=' Registro';}
        else{ $registro=' Registros';}
        $pdf->Cell(163,6,utf8_decode('TOTAL'),1,0,'C',1);
        $pdf->Cell(17,6,utf8_decode($saldoSumCE),1,1,'C',1);

        $aprobador = $this->solicitudes_model->getListarDatosSolicitudDireccion($id);
        if(!empty($aprobador)){
        	$funcionario_aprobador=utf8_decode(datos_persona_nombre($aprobador[0]->id_funcionario_aprobador));
        	$funcionario_autorizador=utf8_decode(datos_persona_nombre($aprobador[0]->id_funcionario_autorizador));
        	$funcionario_solicitante=utf8_decode(datos_persona_nombre($aprobador[0]->id_funcionario_solicitante));
        } else {
        	$funcionario_aprobador='';
        }
        $pdf->SetFont('Arial','',6);
        $pdf->MultiCell(180,4,"MOTIVO: ".utf8_decode($usuario[0]->motivo),1,'J',0);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(90,4,utf8_decode("APROBADO POR: ".$funcionario_aprobador),0,0,'L',0);
        $pdf->Cell(90,4,utf8_decode("AUTORIZADO POR: ".$funcionario_autorizador),0,1,'L',0);
        $pdf->Cell(90,4,utf8_decode("RECIBÍ CONFORME: ".$funcionario_solicitante),0,1,'L',0);
        $pdf->Output('I','Reporte.pdf'); 
	}

}


