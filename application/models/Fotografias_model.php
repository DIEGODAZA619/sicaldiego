<?php

class Fotografias_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_almacen = $this->load->database('db_almacen', TRUE);
	}

	function getListarFotografias($id)
	{
		$query = $this->db_almacen->query("select *
											from material.fotografia
											where id_material=".$id."
											order by orden_fotos");
        return $query->result();
	}

	function guardarFotografia($data)
    {
        $this->db_almacen->insert('material.fotografia',$data);
        return $this->db_almacen->insert_id();
    }

	function editarFotografia($id_registro,$data)
    {
        $this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('material.fotografia',$data);
    }
    function eliminarFotografia($id_registro)
    {
        $this->db_almacen->where('id',$id_registro);
        return( $this->db_almacen->delete('material.fotografia') );
    }
    function getFotografia($idFotografia)
	{
		$query = $this->db_almacen->query("select * from material.fotografia where id =".$idFotografia );
		if(count($query->result()) > 0  ) 
		    return $query->result()[0];
		else 
			return array();
	}


	function buscarCampoFotografia($campo, $valor)
	{
		$query = $this->db_almacen->query("select *
											from material.fotografia
											where ".$campo." ='".$valor."'
											");
        return $query->result();
	}


}

?>