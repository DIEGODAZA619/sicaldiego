<?php
/*
*/

class Funcionarios_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();			
		$this->db_rrhh = $this->load->database('db_recursos_humanos', TRUE);
	}
	function getfuncionarios()
	{
		$query = $this->db_rrhh->query("select *
									      from personal.funcionario 
									     order by id asc");
        return $query->result();   
	}

	function getfuncionariosActivos()
	{
		$query = $this->db_rrhh->query("select *
									      from personal.funcionario 
									      where estado = 'AC'
									     order by id asc");
        return $query->result();   
	}
	function datosPersonas($id_persona)
	{
		$query = $this->db_rrhh->query("select *
									      from personal.funcionario 
									     where id= ".$id_persona);
        return $query->result();   
	}
	function datosPersonalesCompleto($id_persona)
	{
		$query = $this->db_rrhh->query("select *
									      from personal.datos_personales_completo 
									     where id= ".$id_persona);
        return $query->result();   
	}
	function estructura_id($iddireccion)
    {
        $query = $this->db_rrhh->query("select * from personal.vista_puesto_funcionarios_activos d where d.id_dependencia =" . $iddireccion);
        return $query->result();
    }

    function subestructura_id($subdireccion)
    {
        $query = $this->db_rrhh->query("select * from personal.vista_puesto_funcionarios_activos d where d.id_subdependencia =" . $subdireccion);
        return $query->result();
    }

    function datosPersonalesDependencia($id_persona)
	{
		$query = $this->db_rrhh->query("select *
									      from personal.vista_datos_puesto_funcionario 
									     where id= ".$id_persona);
        return $query->result();   
	}
}

?>