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
			   							  from correlativos 
										 where abreviatura = '".$valor."'
										   and estado = 'AC'");
        return $query->result();
	}
	function getcorrelativocite($gestion,$id_correlativo)
	{
		$query = $this->db_rrhh->query("select case when max(correlativo) > 0 then max(correlativo) else 0 end as correlativo
			                         	  from cites_funcionarios
			                         	 where 1 = 1
			                         	   and gestion = ". $gestion."
			                         	   and id_correlativo = ".$id_correlativo);
        return $query->result();
	}



	function updateCorrelativosGestion($id_correlativo,$gestion,$data)
    {   
        $this->db_rrhh->where('id_correlativo',$id_correlativo);
        $this->db_rrhh->where('gestion', $gestion);
        return $this->db_rrhh->update('correlativos_gestion',$data);
    }

    function guardarCitesFuncionarios($data)
    {       
        $this->db_rrhh->insert('cites_funcionarios',$data); 
        return $this->db_rrhh->insert_id();
    }

	
}
?>