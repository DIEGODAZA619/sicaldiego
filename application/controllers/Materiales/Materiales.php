<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materiales extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->_is_logued_in();
		$this->load->model('materiales_model');
		$this->load->helper('configuraciones_helper');
		$this->load->helper('correlativos_helper');		
		$this->load->library('fpdf/pdf2');
		$this->load->helper('date');		
	}
	function _is_logued_in()
	{
		$is_logued_in = $this->session->userdata('is_logued_in');
		if($is_logued_in != TRUE)
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
		$this->load->view('Materiales/formMateriales'); //cuerpo
		$this->load->view('inicio/pie');
	}
	function cargartablasMateriales()
	{
		$draw = intval($this->input->get("draw"));
		$filas = $this->materiales_model->getListaMateriales();
		$data = array();
		$num = 1;
	    foreach ($filas as $fila)
	    {
		    $boton = " <span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Editar'>
							<button class='btn btn-warning btn-circle' onclick='editarMaterial(".$fila->id.")'><i class='mdi mdi-pencil'></i></button>
						</span>";
			
		    $data[] = array(
	                $num++,
	                $fila->codigo_material,
	                $fila->descripcion_material,
	                $fila->descripcion_unidad,
	                $fila->descripcion_categoria,
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
	function listarCategoria()
	{
		$filas = $this->materiales_model->getCategoria();
		$option = "<option VALUE='-1'>Seleccionar opcion</OPTION>";
		foreach ($filas as $fila)
		{
			$option.="<option value = '".$fila->id."'>".$fila->codigo." - ".$fila->descripcion."</option>";
		}
		echo $option;
	}
	function listarSubCategoria()
	{
		$id_registro = $this->input->post('id');
		$filas = $this->materiales_model->getSubCategoria($id_registro);
		$option = "<option VALUE='-1'>Seleccionar opcion</OPTION>";
		foreach ($filas as $fila)
		{
			$option.="<option value = '".$fila->id."'>".$fila->codigo." - ".$fila->descripcion."</option>";
		}
		echo $option;
	}
	function listarMaterial()
	{
		$id_registro = $this->input->post('id');
		$filas = $this->materiales_model->getMaterial($id_registro);
		$option = "<option VALUE='-1'>Seleccionar opcion</OPTION>";
		foreach ($filas as $fila)
		{
			$option.="<option value = '".$fila->id."'>".$fila->codigo." - ".$fila->descripcion."</option>";
		}
		echo $option;
	}
	function listarUnidad()
	{
		$filas = $this->materiales_model->getUnidad();
		$option = "<option VALUE='-1'>Seleccionar opcion</OPTION>";
		foreach ($filas as $fila)
		{
			$option.="<option value = '".$fila->id."'>".$fila->descripcion."</option>";
		}
		echo $option;
	}
	function guardarMaterial()
	{
		$accion = $this->input->post('texto');
		$gestion = gestion_vigente();
		$id_entidad = $this->session->userdata('id_entidad');
		if($accion== 'Editar')
		{
			$id_registro = $this->input->post('id_material');
			$datos = array (
				
				'codigo' => $this->input->post('txtcodigo'),
				'descripcion' => $this->input->post('txtdescripcion'),
				'id_unidad' => $this->input->post('cbunidad'),
				'id_categoria' => $this->input->post('cbmaterial'),
				'fecha_modificacion' => date('Y-m-d H:i:s')
			);
			$insert = $this->materiales_model->editarMaterial($id_registro,$datos);
			$resul = 1;
			$id_fila = $insert;
			$mensaje = "MODIFICADO CORRECTAMENTE";
		}
		else
		{
			$datos = array (
				'id_entidad' =>$id_entidad,
				'codigo' => $this->input->post('txtcodigo'),
				'descripcion' => $this->input->post('txtdescripcion'),
				'id_unidad' => $this->input->post('cbunidad'),
				'id_categoria' => $this->input->post('cbmaterial'),
				'fecha_registro' => date('Y-m-d H:i:s')
			);

			$insert = $this->materiales_model->guardarMaterial($datos);
			if($insert)
			{
				$datosInventario = array (
					'id_entidad'          => $id_entidad,
					'gestion'             => $gestion,
					'id_material'         => $insert,
					'cantidad_entrada'    => 0,
					'cantidad_salida'     => 0,
					'saldo' 			  => 0,
					'cantidad_solicitada' => 0,
					'cantidad_disponible' => 0
				);
				$insertInventario = $this->materiales_model->guardarInventarioResumen($datosInventario);
			}

			$resul = 1;
			$id_fila = $insert;
			$mensaje = "REGISTRADO CORRECTAMENTE";

		}

	$resultado ='[{
				"resultado":"'.$resul.'",
				"id_fila":"'.$id_fila.'",
				"mensaje":"'.$mensaje.'"
				}]';

	echo $resultado;
	}
	function idRegistroMaterial()
	{
		$id_registro = $this->input->post('id');
		//$id_registro = 1;
		$filas = $this->materiales_model->getMaterialId($id_registro);
		$datos ='[{
			"id" : "'.$filas[0]->id.'",
			"id_entidad" : "'.$filas[0]->id_entidad.'",
			"codigo" : "'.$filas[0]->codigo.'",
			"descripcion" : "'.$filas[0]->descripcion.'",
			"id_unidad" : "'.$filas[0]->id_unidad.'",
			"id_categoria" : "'.$filas[0]->id_categoria.'",
			"categoria" : "'.$filas[0]->categoria.'",
			"subcategoria" : "'.$filas[0]->subcategoria.'",
			"estado" : "'.$filas[0]->estado.'"
		}]';

		echo $datos;
	}

	function generarCodigo()
	{
    	$cat_id = $this->input->post('codigo');
    	
    	$catalogoData = $this->materiales_model->catalogoData($cat_id);
        $catalogoNro  = $this->materiales_model->getNroCodigoCorrelativo($cat_id);
        //print_r($catalogoNro);
        //print_r($catalogoData);
    	if ($catalogoNro[0]->numero != null)
    	{    
    		//$codigo_Array = explode("-",$catalogoData[0]['cat_codigo']);
    		$codigo_Producto = $catalogoData[0]->sigla;
    		$codigo_secuencial =$catalogoNro[0]->numero;    
    	}
    	else
    	{
    		$codigo_Producto = $catalogoData[0]->sigla;
    		$codigo_secuencial ='1';
    	}
    	
    	$codigo       = $codigo_Producto.$codigo_secuencial;
    	$longitud     = strlen($codigo);
    	$cadena_ceros = "";
    	
        for ($i=1;$i<=(8-$longitud);$i++){
        	$cadena_ceros = $cadena_ceros.'0';
        }

        
        $codigo = $codigo_Producto.$cadena_ceros.$codigo_secuencial;
    	
    	$respuesta = array (
    			"respuesta" => true,
    			"codigo" => $codigo,
    	);
    	echo json_encode($respuesta);
    	exit();
    	 
    }
}
