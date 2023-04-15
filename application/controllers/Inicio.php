<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('inicio_model');
		$this->load->helper('configuraciones_helper');
	}
	function _is_logued_in()
	{
		//colocar esta confirguracion en el archivo config.php,  $config['IDAPLICACION'] = 3;		

		$is_logued_in = $this->session->userdata('is_logued_in');
		$id_apliacion = $this->session->userdata('id_apliacion');
		$aplicacion =   $this->config->item('IDAPLICACION');
		if($is_logued_in != TRUE || $id_apliacion != $aplicacion)
		{
			redirect('Login');
		}
	}
	public function index()
	{

		$id_usuario = $this->session->userdata('id_usuario');
		$dato['rolescero'] = $this->session->userdata('rolescero');
		$dato['roles']  = $this->session->userdata('roles');
		$dato['nombre_usuario']  = $this->session->userdata('nombre_completo');


		$rolescero = $this->session->userdata('rolescero');
		$roles  = $this->session->userdata('roles');
		
		//echo json_encode($rolescero);
		$this->load->view('inicio/cabecera',$dato);
		$this->load->view('inicio/menu',$dato);		
		$this->load->view('inicio/cuerpo'); //cuerpo
		$this->load->view('inicio/pie');
	}
	public function inicio()
	{
		$this->load->view('inicio/cabecera');
		$this->load->view('inicio/menu');
		$this->load->view('inicio/cuerpo'); //cuerpo
		$this->load->view('inicio/pie');
	}

	
	public function cargartablaSolicitudesNoAprobados()
	{
		$draw = intval($this->input->get("draw"));
		$id_entidad = 1;
		$filas = $this->inicio_model->getIngresosNoAprobados($id_entidad);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    /*$boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Agregar Materiales'>
						<button class='btn btn-success btn-circle' onclick='agregarMateriales(".$fila->id.")'><i class='mdi mdi-check'></i></button>
					</span>";
			*/
		    $data[] = array(
	                $num++,
	                $fila->order_compra,
	                $fila->nota_remision,
	              //  $fila->nro_factura,
	              //  $fila->fecha_factura,
	             //   $fila->monto_total_factura,
	                $fila->id_provedor,
	                $fila->descripcion_ingreso,
	                $fila->fecha_ingreso,
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
	function cargartablasMaterialesAcumulados()
	{
		$draw = intval($this->input->get("draw"));
		$id_funcionario  = $this->session->userdata('id_funcionario');
		$filas = $this->inicio_model->getSolicitudesDetalles();
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {

		    $data[] = array(
	                $num++,
	                $fila->codigo_material,
	                $fila->fecha_registro,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                $fila->descripcion_categoria,
	                $fila->cantidad_solicitada,
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




	public function cargarReporteResumenAlmacenPDF(){
        $this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);

		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$filas = $this->inicio_model->getListaResumenAlmacen();
        $w = array(21,65,25,25,25,25);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','L','C','C','C','C'));
        $pdf->tituloCabecera = 'REPORTE ALMACEN';
	

		$nombreEntidad = "ENTIDAD"; // descripcion_nombre_entidad($id_entidad);
		//echo '<pre>'; var_dump($filas); echo '</pre>'; die();
		$pdf->AddPage('P','Letter');

		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=1;
		//$pdf->rubro=$rubro;
		$pdf->Header();
		$pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',8);
        $saldoSum=0;
        $saldoSumCE=0;
        $saldoSumCS=0;
        $num = 0;
        foreach ($filas as $fila){
	        	$num++;
	        	$saldoSum += $fila->saldo;
	        	$saldoSumCE += $fila->cantidad_entrada;
	        	$saldoSumCS += $fila->cantidad_salida;
	        	$fila = array(

	                utf8_decode($fila->partida),
	                utf8_decode($fila->descripcion_del_producto),
	                utf8_decode($fila->unidad),
	                utf8_decode($fila->cantidad_entrada),
	                utf8_decode($fila->cantidad_salida),
	                utf8_decode($fila->saldo)
	        	);
	        $pdf->Row_Entidad($fila,true, '', 5);
	    }
           
        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',9);
                  
        if($num==1){ $registro=' Registro';}
        else{ $registro=' Registros';}
        $pdf->Cell(111,6,utf8_decode(''),1,0,'C',1);
        $pdf->Cell(25,6,utf8_decode($saldoSumCE),1,0,'C',1);
        $pdf->Cell(25,6,utf8_decode($saldoSumCS),1,0,'C',1);
        $pdf->Cell(25,6,utf8_decode($saldoSum ),1,0,'R',1);

        $pdf->Output('I','Reporte.pdf'); 
	}





}
