<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirmar_direccion extends CI_Controller
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
		$this->load->view('Solicitudes/confirmarDirecciones'); //cuerpo
		$this->load->view('inicio/pie');
	}


	function cargartablaSolicitudesConfirmadas()
	{
		$draw = intval($this->input->get("draw"));
		$id_funcionario             = $this->session->userdata('id_funcionario');
		
		$valorDependencia  = json_decode(dependenciasFuncionario());		
		$idDependencia     = $valorDependencia[0]->dependencia;
		$idSubDependencia  = $valorDependencia[0]->SubDependencia;
			
		$tipoSolicitud =  "NOR";
		$estado = 'CON';
		$filas = $this->solicitudes_model->solicitudConfirmadasDireccion($id_funcionario);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Solicitud'>
						<button class='btn btn-warning btn-circle' onclick='cargarTablasolicitudesIdConfirmacion(".$fila->id.")'><i class='mdi mdi-eye'></i></button>
					 </span>";
			$botonReporte = "";
			if($fila->estado == 'AUT')
			{
				$botonReporte ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Ver Reporte a Detalle del Material Entregado'>
						<button class='btn btn-primary btn-circle' onclick='reporteMaterialEntregado(".$fila->id.")'><i class='mdi mdi-printer'></i></button>
					 </span>";
			}		

		    $data[] = array(
	                $num++,
	                datos_persona_nombre($fila->id_funcionario_solicitante),
	                $fila->cite,
	                $fila->cantidad,
	                $fila->cantidad_materiales,
	                formato_fecha_hora($fila->fecha_registro),
	                $fila->motivo,
	                descripcion_estados($fila->estado),
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

	function cargartablasMaterialesSolicitados()
	{
		$draw = intval($this->input->get("draw"));
		$id_funcionario    = $this->session->userdata('id_funcionario');
		$valorDependencia  = json_decode(dependenciasFuncionario());		
		$idDependencia     = $valorDependencia[0]->dependencia;
		$idSubDependencia  = $valorDependencia[0]->SubDependencia;

		
		$tipoSolicitud =  "NOR";
		$estado = 'PEN';	
		
		
		$filas = $this->solicitudes_model->confirmarSolicitudDireccionTotal($idDependencia,$tipoSolicitud,$estado);	
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";
		    $boton ="<span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Editar'>
						<button class='btn btn-warning btn-circle' onclick='editarSolicitudMaterial(".$fila->id_solicitud.")'><i class='mdi mdi-pencil'></i></button>
					 </span>
					 <span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Rechazar'>
						<button class='btn btn-danger btn-circle' onclick='recharSolicitudDetalles(".$fila->id_solicitud.")'><i class='mdi mdi-delete'></i></button>
					</span>";

		    $data[] = array(
	                $num++,
	                datos_persona_nombre($fila->id_funcionario),
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                $fila->descripcion_categoria,
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
	function cargarTablasolicitudesIdConfirmacion()
	{
		$idConfirmacion = $this->input->post('id_conf');
		$draw = intval($this->input->get("draw"));
		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmadosVerificar($idConfirmacion);
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = "";

		    $data[] = array(
	                $num++,
	                datos_persona_nombre($fila->id_funcionario),
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                $fila->descripcion_categoria,
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


	function confirmarPedidoDireccion()
	{
		$id_funcionario    = $this->session->userdata('id_funcionario');
		$valorDependencia  = json_decode(dependenciasFuncionario());		
		$idDependencia     = $valorDependencia[0]->dependencia;
		$idSubDependencia  = $valorDependencia[0]->SubDependencia;

		$id_entidad    = $this->session->userdata('id_entidad');
		$gestion       = $this->session->userdata('gestion');
		$motivo		   = $this->input->post('motivo');
		$tipoSolicitud = "NOR";
		$estado        = 'PEN';
		$tipoCite      = 'SOL';
		$fechaActual   = getFechaHoraActual();

		$filas = $this->solicitudes_model->confirmarSolicitudDireccionTotal($idDependencia,$tipoSolicitud,$estado);	
		
		$data = array();
		$num = 1;
		$con = 0;
		$sum = 0;
	    if($filas)
	    {
	    	foreach ($filas as $fila)
		    {
		    	$con++;
		    	$sum = $sum + $fila->cantidad_autorizada;
		    }
	    	$valorcites   = json_decode(obtenerCiteGestion($id_funcionario,$gestion,$tipoCite));
			//$correIndividual  = 1;//$valorcites[0]->correIndividual;
			$correGestion     = $valorcites[0]->correGestion;
			$cite             = $valorcites[0]->cites;
	    	$dataConfirmacion = array(
									'id_dependencia' 		=> $idDependencia,
									'id_subdependencia'		=> $idSubDependencia,
									'id_entidad' 			=> $id_entidad,
									'gestion'         		=> $gestion,
									'cantidad'				=> $con,
									'cantidad_materiales' 	=> $sum,
									'correlativo' 			=> $correGestion,
									'cite'				 	=> $cite,
									'tipo_solicitud' 	    => $tipoSolicitud,
									'id_funcionario_solicitante' => $id_funcionario,
									'motivo' => mb_strtoupper($motivo)
	    						);
	    	$id_insert = $this->solicitudes_model->guardarConfirmaciónSolicitudMaterial($dataConfirmacion);
	    	if ($id_insert>0)
	    	{
	    		$resul = 1;
				$mensaje = "SOLICITUD DE MATERIALES CONFIRMADA POR SU DIRECCION EXITOSAMENTE";
				foreach ($filas as $fila)
			    {
			    	$id_solicitud = $fila->id_solicitud;
			    	$data = array(
			    				'id_confirmacion_direccion' => $id_insert,
			    				'fecha_confirmacion' => $fechaActual,
			    				'estado' => 'CON'
			    		);
			    	$update = $this->solicitudes_model->editarSolicitudMaterialDetalles($id_solicitud,$data);
			    	$citeGuardar = guardarCite($id_funcionario,$tipoCite,$correGestion,$cite,$gestion,$fechaActual);
			    }
	    	}
	    	else
	    	{
	    		$resul = 0;
				$mensaje = "OCURRIO UN ERROR AL REGISTRAR LA CONFIRMACIÓN";
	    	}
	    }
	    else
	    {
	    	$resul = 0;
			$mensaje = "NO EXISTEN SOLICITUDES EN ESTADO PENDIENTE PARA CONFIRMAR.";
	    }


		$resultado ='[{
					"resultado":"'.$resul.'",
					"mensaje":"'.$mensaje.'"
					}]';
		echo $resultado;
	}

	function rechazarSolicitudMaterial()
	{		
		$id_solicitud   = $this->input->post('id_sol');	
		$fechaActual    = getFechaHoraActual();
		$id_funcionario = $this->session->userdata('id_funcionario');
		$filas = $this->solicitudes_model->getSolicitudId($id_solicitud);
		$id_material = $filas[0]->id_material;
		$data = array(			
			'fecha_modificacion' => $fechaActual,
			'id_usuario_rechazo' => $id_funcionario,
			'estado' => 'RC'
		);		
		$actualizar = $this->solicitudes_model->editarSolicitudMaterialDetalles($id_solicitud,$data);
		$actualización = actualizarCantidadInventario($id_material);
		$resul = 1;
		$mensaje = "Se rechazo correctamente el registro";
		$resultado ='[{						
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;	
	}
	function restablecerSolicitudMaterial()
	{		
		$id_solicitud   = $this->input->post('id_sol');	
		$fechaActual    = getFechaHoraActual();
		$id_funcionario = $this->session->userdata('id_funcionario');
		$filas = $this->solicitudes_model->getSolicitudId($id_solicitud);
		$id_material = $filas[0]->id_material;
		$data = array(			
			'fecha_modificacion' => $fechaActual,
			'id_usuario_rechazo' => 0,
			'estado' => 'APB'
		);		
		$actualizar = $this->solicitudes_model->editarSolicitudMaterialDetalles($id_solicitud,$data);
		$actualización = actualizarCantidadInventario($id_material);
		$resul = 1;
		$mensaje = "Se rechazo correctamente el registro";
		$resultado ='[{						
						"resultado":"'.$resul.'",
						"mensaje":"'.$mensaje.'"
					 }]';
		echo $resultado;	
	}
	function ajustarSaldoMaterial($id_material)
	{
		$actualización = actualizarCantidadInventario($id_material);
		echo "todo bien";
	}
    /////////////////////////////
	//////// REPORTE  ///////////
	function reporteMaterialConfirmado($id)
	{
		$id_funcionario    = $this->session->userdata('id_funcionario');
		$valorDependencia  = json_decode(dependenciasFuncionario());		
		$idDependencia     = $valorDependencia[0]->dependencia;
		$idSubDependencia  = $valorDependencia[0]->SubDependencia;
		$tipoSolicitud =  "NOR";
		$estado = 'CON';

		$usuario = $this->reportes_model->confirmaSolicitudDireccion($id);

		$filas = $this->solicitudes_model->solicitudConfirmadasDireccion($idDependencia,$idSubDependencia,$tipoSolicitud,$estado);
		
	    $this->load->library('fpdf/pdf2');
        $pdf = new Pdf2();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(20,15,10);

        
		$solicitante = datos_persona_nombre($usuario[0]->id_funcionario_solicitante);
		$filas = $this->solicitudes_model->getSolicitudDireccionConfirmados($id);
		$pdf->SetTitle(utf8_decode("Lista Reporte de Almacen"));
		$pdf->tituloCabecera = 'LISTA CONFIRMADA  DE MATERIALES';
        $pdf->subtituloCabecera1 = "DIRECCION SOLICITANTE: ".$solicitante;
        $pdf->subtituloCabecera2 =  "CITE : ".$usuario[0]->cite;
		//$filas = $this->inicio_model->getListaResumenAlmacen();
		
        $w = array(10,30,20,40,25,25,25);
        $pdf->setWidthsG($w);
        $pdf->SetAligns(array('C','L','C','L','C','C','C'));

		$pdf->AddPage('P','Letter');
		//Paso de valores a la cabecera
		$pdf->opcion_cabecera=2;
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
	        	$saldoSumCE += $fila->cantidad_autorizada;
	        	$fila = array(
	        		$num,
	        		utf8_decode(datos_persona_nombre($fila->id_funcionario)) ,
	                utf8_decode($fila->codigo_material ),
	                utf8_decode($fila->descripcion_material),
	                utf8_decode($fila->descripcion_unidad),
	                utf8_decode($fila->descripcion_categoria),
	                utf8_decode($fila->cantidad_solicitada)
	        	);
	        $pdf->Row_Entidad($fila,true, '', 5);
	    }
           
        
		$pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(55);
        $pdf->SetFont('Arial','B',9);
                  
        if($num==1){ $registro=' Registro';}
        else{ $registro=' Registros';}
        $pdf->Cell(150,6,utf8_decode('TOTAL'),1,0,'C',1);
        $pdf->Cell(25,6,utf8_decode($saldoSumCE),1,0,'C',1);
       // $pdf->Cell(25,6,utf8_decode($saldoSumCS),1,0,'C',1);
       // $pdf->Cell(25,6,utf8_decode($saldoSum ),1,0,'R',1);

        $pdf->Output('I','Reporte.pdf'); 

	}

}

