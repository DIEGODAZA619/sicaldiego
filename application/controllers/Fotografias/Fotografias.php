
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fotografias extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Fotografias_model');
		$this->load->model('materiales_model');
		//$this->load->helper('handler_helper');
		//$this->_is_logued_in();
	}
	function _is_logued_in()
	{
		$is_logued_in = $this->session->userdata('is_logued_in');
		$id_apliacion = $this->session->userdata('id_apliacion');
		if($is_logued_in != TRUE || $id_apliacion != 2)
		{
			redirect('Login');
		}
	}
	public function index()
	{
		$id_usuario = $this->session->userdata('id_usuario');
		$dato['rolescero'] = array();//$this->session->userdata('rolescero');
		$dato['roles']  = array();//$this->session->userdata('roles');
		$dato['nombre_entidad']  = "GOBIERNO AUTONOMO DEPARTAMENTAL DE LA PAZ";//$this->session->userdata('roles');
		$dato['nombre_usuario']  = "JAIME CONTRERAS RAMOS";//$this->session->userdata('nombre_completo');

		$datoRubro['idEntidad']  = 10;
		$datoRubro['rubro']  = "VEH";

		$this->load->view('inicio/cabecera',$dato);
		$this->load->view('inicio/menu',$dato);

		$this->load->view('Bienes/vehiculos/vehiculos',$datoRubro); //cuerpo
		$this->load->view('documentos/nuevoDocumento',$datoRubro); //cuerpo
		$this->load->view('Bienes/vehiculos/datosVehiculo',$datoRubro); //cuerpo

		$this->load->view('ubicacion/nuevaUbicacion',$datoRubro); //cuerpo
		//$this->load->view('fotografias/nuevasFotografias',$datoRubro); //cuerpo
		$this->load->view('Bienes/vehiculos/vehiculosPie',$datoRubro); //cuerpo

		
		$this->load->view('inicio/pie');
	}
	public function nuevasFotografias()
	{
		//$this->load->view('inicio/cabecera',$dato);
		//$this->load->view('inicio/menu',$dato);
		$this->load->view('fotografias/nuevasFotografias');
		$this->load->view('inicio/pie');
	}

	 function galeriafotos()
	{
		$directorio = FCPATH.'upload/images-tmp' ;
		if (is_dir($directorio)){
		        // Abre un gestor de directorios para la ruta indicada
		        $gestor = opendir($directorio);
		        // Recorre todos los archivos del directorio
		        while (($archivo = readdir($gestor)) !== false)  {
		            // Solo buscamos archivos sin entrar en subdirectorios
		            if (is_file($directorio."/".$archivo)) {
		                echo "<div class='cuadro-foto'>
		                <a href=\"javascript: verfoto('".$archivo."')\"><img src='". base_url()."upload/images-tmp/".$archivo."' height='160px' alt='".$archivo."' title='".$archivo."'></a>   
						<div class='botonEliminarImg'><button class='btn btn-danger ' onclick=\"return eliminarFoto('".$archivo."')\" ><i class='mdi mdi-delete'></i></button></div>	
		                </div>";
		            }            
		        }

		        // Cierra el gestor de directorios
		        closedir($gestor);
		    } else {
		        echo "No es una ruta de directorio valida<br/>";
		}
		   
	}
	function verfoto($nombreArchivo)
	{
		$nombreArchivo = rawurldecode($nombreArchivo);
		$directorio = FCPATH.'upload/material' ;
		$gestor = opendir($directorio);
		if (is_dir($directorio))
		{
         // Solo buscamos archivos sin entrar en subdirectorios
		        if (is_file($directorio."/".$nombreArchivo)) {
		                echo "<img src='". base_url()."upload/material/".$nombreArchivo."'  alt='".$nombreArchivo."' title='".$nombreArchivo."'>  
		                ";   
		        }

		        // Cierra el gestor de directorios
		        closedir($gestor);
		    } 
		    else {
		        echo "No es una ruta de directorio valida<br/>";
		}
		   
	}
	function anchoAltoFoto()
	{
		$nombreArchivo = $this->input->post('nombrefoto');
		$directorio = FCPATH.'upload/material' ;
		$gestor = opendir($directorio);
		if (is_dir($directorio))
		{
		        if (is_file($directorio."/".$nombreArchivo)) {
		                 $imagen = getimagesize($directorio."/".$nombreArchivo);    //Sacamos la información
 						echo json_encode( array('ancho'=> $imagen[0],'alto'=> $imagen[1]) );       
		        }
		        closedir($gestor);
		    } 
		    else {
		        echo "0";
		}   
	}
	function altoFoto($nombreArchivo)
	{
		$directorio = FCPATH.'upload/material' ;
		$gestor = opendir($directorio);
		if (is_dir($directorio))
		{
		        if (is_file($directorio."/".$nombreArchivo)) {
		                 $imagen = getimagesize($directorio."/".$nombreArchivo);    //Sacamos la información
 						echo $ancho = $imagen[1];       
		        }
		        closedir($gestor);
		    } 
		    else {
		        echo "0";
		}   
	}



	
	function eliminarArchivosTemporales()
	{
		$directorio = FCPATH.'upload/images-tmp' ;
		// List of name of files inside
		// specified folder
		$files = glob($directorio.'/*'); 
		   
		// Deleting all the files in the list
		foreach($files as $file) {
		   
		    if(is_file($file)) 
		    
		        // Delete the given file
		        unlink($file); 
		}
	}



	function redimensionarImagen($directorio,$rutaFoto,$idBien,$ordenFoto,$rubro)
	{
	    $CI = & get_instance();
	    $CI->load->library('image_lib');

	    $config['image_library'] = 'gd2';
	    $config['source_image'] =  $rutaFoto ;  //'images/'.$idBien.'_'.$ordenFoto.$extension;
	    $config['maintain_ratio'] = TRUE;
	    $config['create_thumb'] = FALSE;
	    $config['width'] = 800;
	    $config['height'] = 600;
	    $config['new_image'] = $directorio;
	    $CI->image_lib->initialize($config);

	    if (!$CI->image_lib->resize()) {
	        echo $this->image_lib->display_errors('', '');
	        return 0;
	    } else {
	        return 1;
	    }
	}

	function verFormularioFoto()
	{	
		$this->load->view('fotografias/formFotografiasupload');

	}

	function galeriaFotosEdit($idBien, $rubro)
	{
		$filas = $this->Fotografias_model->getListarFotografias($idBien );
		foreach ($filas as $key => $fila) {
			echo "<br> -".$fila->ubicacion;
		}
		switch ($rubro) {
			case '3':
				$directorio = FCPATH.'upload/images/vehiculos/'.$idBien ;
				$directorioURL = 'upload/images/vehiculos/'.$idBien."/" ;
				break;
		}
		
		if (is_dir($directorio)){
		        // Abre un gestor de directorios para la ruta indicada
		        $gestor = opendir($directorio);
		        // Recorre todos los archivos del directorio
		        while (($archivo = readdir($gestor)) !== false)  {
		            // Solo buscamos archivos sin entrar en subdirectorios
		            if (is_file($directorio."/".$archivo)) {
		                echo "<div class='cuadro-foto'>
		                <a href=\"javascript: verfoto('".$archivo."')\"><img src='". base_url().$directorioURL.$archivo."' height='160px' alt='".$archivo."' title='".$archivo."'></a>   
						<div class='botonEliminarImg'><button class='btn btn-danger ' onclick=\"return eliminarFotoEdit('".$archivo."')\" ><i class='mdi mdi-delete'></i></button></div>	
		                </div>";
		            }            
		        }
				echo" LISTA FOTOS DE LA BASE ".$idBien ." - ". $rubro;
		        // Cierra el gestor de directorios
		        closedir($gestor);
		    } else {
		        echo "No es una ruta de directorio valida<br/>";
		}
	}



	function guardafo()
	{
		
		$idBien = $this->input->post('idbien');
		$cadenafotos = $this->input->post('cadFotos');
		$idRubro = $this->input->post('rubro');
		$this->load->helper('path');
		switch ($idRubro) {
			case '3':
				$dir = set_realpath('./upload/images/vehiculos/' . $idBien);
				break;
		}

		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		$directorioTmp= FCPATH.'upload/images-tmp';
		$gestor = opendir($directorioTmp);
		$arrayFotos = explode("|", $cadenafotos);
		$files = array_diff(scandir($directorioTmp), array('.', '..')); 
		//while (($archivo = readdir($gestor)) !== false)  {
		foreach($files as $file){
			foreach($arrayFotos  as $nombrefoto)
			{
				if($nombrefoto == $file)
				{
					copy($directorioTmp."/".$file, $dir."/".$file );
					unlink($directorioTmp."/".$nombrefoto ); 
				}	
			}
		}	
		echo json_encode($directorioTmp);
	}


	function endpoint()
	{

		$uploader = new UploadHandler();

		// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$uploader->allowedExtensions = array(); // all files types allowed by default

		// Specify max file size in bytes.
		$uploader->sizeLimit = null;

		// Specify the input name set in the javascript.
		$uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

		// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
		$uploader->chunksFolder = "chunks";

		$method = $_SERVER["REQUEST_METHOD"];
		if ($method == "POST") {
		    header("Content-Type: text/plain");

		    // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
		    // For example: /myserver/handlers/endpoint.php?done
		    if (isset($_GET["done"])) {
		        $result = $uploader->combineChunks("files");
		    }
		    // Handles upload requests
		    else {
		        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
		        $result = $uploader->handleUpload(FCPATH.'upload/images-tmp');
		        //echo "cambia";
//var_dump($result);
		        // To return a name used for uploaded file you can use the following line.
		        $result["uploadName"] = $uploader->getUploadName();
		    }
		   
		    echo json_encode($result);
		}
		// for delete file requests
		else if ($method == "DELETE") {
		    $result = $uploader->handleDelete("files");
		    echo json_encode($result);
		}
		else {
		    header("HTTP/1.0 405 Method Not Allowed");
		}

	}



	





	function guardarDocumentoImg()
	{
		$idMaterial = $this->input->post('idMaterial');

		$material  = $this->materiales_model->getMaterialId($idMaterial);
	

		if($_FILES["fileImg"]["name"]) {
				$filename = $_FILES["fileImg"]["name"];
				$ext = explode(".", $filename);  
        		$extension = $ext[count($ext)-1];  

				$directorio = FCPATH.'upload/material/' ; 
				if(!file_exists($directorio)){
					mkdir($directorio, 0777) or die("No se puede crear el directorio");	
				}
				/*if(file_exists($directorio.$material[0]->nombre_imagen)){
					unlink($directorio.$material[0]->nombre_imagen); 
				}
*/
				$nombreArchivo = $idMaterial."_".strtotime(date('Y-m-d H:i:s'));
				move_uploaded_file ($_FILES ['fileImg']['tmp_name'], $directorio.$nombreArchivo.".".$extension);
				$datosFoto = array (
					'nombre_imagen' => $nombreArchivo.".".$extension,
					'ruta_imagen' => base_url().'upload/material/'
				);
				$this->materiales_model->editarMaterial($idMaterial,$datosFoto);
				$this->redimensionarImagen($directorio, $directorio.$nombreArchivo.".".$extension,0,0,"mue");
				$resul = 1;
				$mensaje = "ARCHIVO CARGADO CORRECTAMENTE";

				$datosFoto = array (
					'id_material' => $idMaterial,
					'nombre' => $nombreArchivo.".".$extension,
					'ruta' => base_url().'upload/material/',
					'fecha_registro' => date('Y-m-d H:i:s')
				);
				$this->Fotografias_model->guardarFotografia($datosFoto);
			}
			else {
			$resul = 0;
			$mensaje = "Ocurrió algún error al subir el fichero. No pudo guardarse.";
		}
		$resultado = array("resultado" => $resul,
				"mensaje" => $mensaje
			);
		echo json_encode($resultado);
	}
	function eliminarfoto()
	{
		$nombreFoto = $this->input->post('nombre');
		$directorio = FCPATH.'upload/material/' ; 

		$foto = $this->Fotografias_model->buscarCampoFotografia('nombre',$nombreFoto);
		if(count($foto )>0 )
		{
			$this->Fotografias_model->eliminarFotografia($foto[0]->id);
			if(file_exists($directorio.$nombreFoto)){
				unlink($directorio.$nombreFoto); 
				$mensaje = "ARCHIVO ELIMINADO CORRECTAMENTE";
				$resp =1;
			}
			else
			{
				$mensaje = "ARCHIVO ELIMINADO CORRECTAMENTE EN LA BASE DE DATOS ";
				$resp =1;
			}
		}
		else
		{
			$resp =0;
			$ensaje = "EL ARCHIVO NO SE  HA ELIMINADO ";
		}

		$resultado = array("resultado" =>$resp,
				"mensaje" => $mensaje
			);
		echo json_encode($resultado);

	}



}
		
	