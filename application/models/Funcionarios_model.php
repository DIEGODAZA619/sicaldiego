<?php
/*
*/

class Funcionarios_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();			
		$this->db_rrhh = $this->load->database('db_almacen', TRUE);
	}
	function getfuncionarios()
	{
		$query = $this->db_rrhh->query("select *
									      from funcionario 
									     order by id asc");
        return $query->result();   
	}

	function getfuncionariosActivos()
	{
		$query = $this->db_rrhh->query("select *
									      from funcionario 
									      where estado = 'AC'
									     order by id asc");
        return $query->result();   
	}
	function datosPersonas($id_persona)
	{
		$query = $this->db_rrhh->query("select *
									      from funcionario 
									     where id= ".$id_persona);
        return $query->result();   
	}
	function datosPersonalesCompleto($id_persona)
	{
		$query = $this->db_rrhh->query("select *
									      from datos_personales_completo 
									     where id= ".$id_persona);
        return $query->result();   
	}
	function estructura_id($iddireccion)
    {
        $query = $this->db_rrhh->query("select * from dependencia d where d.id =" . $iddireccion);
        return $query->result();
    }

  

    function subestructura_id($subdireccion)
    {
        $query = $this->db_rrhh->query("select * from subdependencia d where d.id =" . $subdireccion);
        return $query->result();
    }

    function datosPersonalesDependencia($id_persona)
	{
		$query = $this->db_rrhh->query("select *
									      from vista_datos_puesto_funcionario 
									     where id= ".$id_persona);
        return $query->result();   
	}
}

?>