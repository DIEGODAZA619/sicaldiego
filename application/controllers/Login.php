<?php
class Login extends CI_Controller
{
	function __construct(){
		parent::__construct();
			$this->load->helper('funcionarios_helper');
			$this->load->helper('configuraciones_helper');
			$this->load->model('usuarios_model');
			$this->load->model('roles_model');
			$this->load->model('puestos_model');
    		$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
	}
	function index($mensaje = "")
	{
		$dato['error'] =$mensaje;
		$this->load->view("Login/logued",$dato);

		/*$this->load->view('autentificacion/estilos');
		$this->load->view('autentificacion/registro'); //cuerpo  */
	}
	function logued()
	{
		
		//4f177090371d97d6620aeae8ed4740ee 
		$IDAPLICACION = $this->config->item('IDAPLICACION');		
		$texto = $this->config->item('TEXTO');
		$username = ($this->input->post('username'));		
		$password =  $texto.$this->input->post('pass');
		$password =  md5($password);

		$ip = $this->obtenerIp();
		//echo $username." - ".$password;
		$login = $this->usuarios_model->loguear($username, $password);
		if($login)
		{
			//echo $login[0]->estado;
			$dataingreso = array (
					'id_usuario' => $login[0]->id,	
					'aplicacion' => $IDAPLICACION,
					'ip' => $ip
				);
			$ingresoUsers = $this->usuarios_model->guardarIngreso($dataingreso);
			if( $login[0]->estado == 'AC' )
			{
				$persona = datos_persona($login[0]->id_persona);
				$id_usuario = $login[0]->id;
				$id_persona = $login[0]->id_persona;
				$id_entidad = $login[0]->id_entidad;
				$rolescero = $this->roles_model->obtener_roles_cero($id_usuario,$IDAPLICACION);
				$roles     = $this->roles_model->obtener_roles($id_usuario,$IDAPLICACION);				
				
				$lista_puestos = $this->puestos_model->listaPuestos($id_persona);

				if($lista_puestos)
				{
					$data = array(
					'is_logued_in'  => TRUE,
					'id_usuario' => $id_usuario,
					'id_funcionario' => $login[0]->id_persona,
					'rolescero' => $rolescero,
					//'sede' => $lista_puestos[0]->sede_trabajo,
					'roles' => $roles,
					'gestion' => gestion_vigente(),
					'nombre_completo' => $persona[0]->nombres." ".$persona[0]->primer_apellido." ".$persona[0]->segundo_apellido,

					'id_puesto_principal' => $lista_puestos[0]->id_puesto,
					'puesto_principal' => $lista_puestos[0]->nombre_puesto,					
					'id_dependencia_principal' => $lista_puestos[0]->id_dependencia,
					'id_subdependencia_principal' => $lista_puestos[0]->id_subdependencia,
					'nombre_dependencia_principal' => $lista_puestos[0]->nombre_dependencia,
					'nombre_subdependencia_principal' => $lista_puestos[0]->nombre_subdependencia,
					'id_apliacion' => $IDAPLICACION,
					'id_entidad' => $id_entidad,
					);
					$this->session->set_userdata($data);
					redirect("inicio");
				} 
				else 
				{
					$mensaje ="El usuario no se encuentra asociado a ningun puesto o cargo institucional";
					$this->index($mensaje);
				}

				
			}
			else
			{
				$mensaje ="El usuario no se encuentra habilitado contactece con el administrador";
				$this->index($mensaje);
			}
		}
		else
		{
			$this->index('EL NOMBRE O CONTRASEÑA INCORRECTO');
		}
	}
	/*//redirect("inicio");
		/*$fecha = date('Y-m-j H:i:s');
		$nuevafecha = strtotime ( '-4 hour' , strtotime ( $fecha ) ) ;
		$fecha = date ( 'Y-m-j' , $nuevafecha );
		$username = $this->input->post('username');
		$password = md5($this->input->post('pass'));
		$login = $this->usuarios_model->loguear($username, $password);
		*/

	function obtenerIp()
	{
		 $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;

	}

	function salir()
	{
		$this->session->sess_destroy();
		redirect('Login');
	}
}

?>