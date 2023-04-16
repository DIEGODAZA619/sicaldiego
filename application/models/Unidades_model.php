<?php

class Unidades_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		  $this->db_almacen = $this->load->database('db_almacen', TRUE);

	}

	function getUnidad()
	{
		$query = $this->db_almacen->query("select *
											from unidades_medida um");
        return $query->result();
	}
	function guardarUnidad($data)
    {
        $this->db_almacen->insert('unidades_medida',$data);
        return $this->db_almacen->insert_id();
    }
	function editarUnidad($id_registro,$data)
    {
        $this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('unidades_medida',$data);
    }
	function getUnidadId($id_registro)
	{
		$query = $this->db_almacen->query("select *
											from unidades_medida um
										   where um.id =".$id_registro);
        return $query->result();
	}
}
?>