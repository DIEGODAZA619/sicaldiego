<?php
/*
*/

class Usuarios_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();	
		$this->db_almacen = $this->load->database('db_almacen', TRUE);			
	}

	function loguear($username, $password)
	{
		$query = $this->db_almacen->query("select *
									 from usuarios 
									where login = '".$username."' 
									  and password = '".$password."'");	
        return $query->result();   
	}

	function guardarIngreso($data)
    {       
        $this->db_almacen->insert('control_access',$data); 
        return $this->db_almacen->insert_id();
    }

	function check_usuraio($id_persona, $username)
	{
		$query = $this->db_almacen->query("select *
									         from usuarios 
									        where id_persona = ".$id_persona."
									          and login = '".$username."'");	
        return $query->result();   
	}
	function guardarUsuario($data)
    {       
        $this->db_almacen->insert('usuarios',$data); 
        return $this->db_almacen->insert_id();
    }


    function updateUsuario($id_persona, $data)
    {       
        $this->db_almacen->where('id_persona',$id_persona);
        return $this->db_almacen->update('usuarios',$data);
    }

    function getUsuario()
    {       
        $query = $this->db_almacen->query("select *
									         from usuarios 
									        order by id asc");	
        return $query->result();
    }


	
	
}
?>