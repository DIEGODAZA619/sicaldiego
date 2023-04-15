<?php
/*
*/

class Cites_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_rrhh = $this->load->database('db_almacen', TRUE);
	}

	function getCorrelativoAbreviatura($valor)
	{
		$query = $this->db_rrhh->query("select *
			   							  from administracion.correlativos 
										 where abreviatura = '".$valor."'
										   and estado = 'AC'");
        return $query->result();
	}
	function getcorrelativocite($gestion,$id_correlativo)
	{
		$query = $this->db_rrhh->query("select case when max(correlativo) > 0 then max(correlativo) else 0 end as correlativo
			                         	  from administracion.cites_funcionarios
			                         	 where 1 = 1
			                         	   and gestion = ". $gestion."
			                         	   and id_correlativo = ".$id_correlativo);
        return $query->result();
	}
	function getcorrelativociteindividualVacaciones($id_funcionario,$tipo)
	{
		$query = $this->db_rrhh->query("select case when count(correlativo_individual) > 0 then count(correlativo_individual) else 0 end as correlativo
										  from vacaciones.rango_uso_vacaciones
										 where 1 = 1										   
										   and id_funcionario = ".$id_funcionario);
        return $query->result();
	}
	//----------------------------BOLETAS
	function getcorrelativociteindividualBoleta($id_funcionario,$tipo)
	{
		$query = $this->db_rrhh->query("select case when count(correlativo_boleta) > 0 then count(correlativo_boleta) else 0 end as correlativo
										  from boletas.boleta
										 where 1 = 1
										   and id_funcionario = ".$id_funcionario);
        return $query->result();
	}
	function getcorrelativociteindividualPermisos($id_funcionario,$tipo)
	{
		$query = $this->db_rrhh->query("select case when count(correlativo_permiso) > 0 then count(correlativo_permiso) else 0 end as correlativo
										  from boletas.permiso
										 where 1 = 1
										   and id_funcionario = ".$id_funcionario);
        return $query->result();
	}
	function getcorrelativociteindividualSalida($id_funcionario,$tipo)
	{
		$query = $this->db_rrhh->query("select case when count(correlativo_boleta) > 0 then count(correlativo_boleta) else 0 end as correlativo
										  from boletas.salida_dias
										where 1 = 1
										   and id_funcionario = ".$id_funcionario);
        return $query->result();
	}

	function updateCorrelativosGestion($id_correlativo,$gestion,$data)
    {   
        $this->db_rrhh->where('id_correlativo',$id_correlativo);
        $this->db_rrhh->where('gestion', $gestion);
        return $this->db_rrhh->update('administracion.correlativos_gestion',$data);
    }

    function guardarCitesFuncionarios($data)
    {       
        $this->db_rrhh->insert('administracion.cites_funcionarios',$data); 
        return $this->db_rrhh->insert_id();
    }

	
}
?>