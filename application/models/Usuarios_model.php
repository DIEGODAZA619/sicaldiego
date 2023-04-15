<?php
/*
*/

class Usuarios_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();	
		$this->db_entorno = $this->load->database('db_entorno', TRUE);			
	}

	function loguear($username, $password)
	{
		$query = $this->db_entorno->query("select *
									 from seguridad.usuarios 
									where login = '".$username."' 
									  and password = '".$password."'");	
        return $query->result();   
	}

	function guardarIngreso($data)
    {       
        $this->db_entorno->insert('accesos.control_access',$data); 
        return $this->db_entorno->insert_id();
    }

	function check_usuraio($id_persona, $username)
	{
		$query = $this->db_entorno->query("select *
									         from seguridad.usuarios 
									        where id_persona = ".$id_persona."
									          and login = '".$username."'");	
        return $query->result();   
	}
	function guardarUsuario($data)
    {       
        $this->db_entorno->insert('seguridad.usuarios',$data); 
        return $this->db_entorno->insert_id();
    }


    function updateUsuario($id_persona, $data)
    {       
        $this->db_entorno->where('id_persona',$id_persona);
        return $this->db_entorno->update('seguridad.usuarios',$data);
    }

    function getUsuario()
    {       
        $query = $this->db_entorno->query("select *
									         from seguridad.usuarios 
									        order by id asc");	
        return $query->result();
    }


	
	
}
?>