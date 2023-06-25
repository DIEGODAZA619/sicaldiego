<?php

class Categorias_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		  $this->db_almacen = $this->load->database('db_almacen', TRUE);

	}

	function getCategoria()
	{
		$query = $this->db_almacen->query("select *
											from categorias c 
											order by c.descripcion asc");
        return $query->result();
	}
	function guardarCategoria($data)
    {
        $this->db_almacen->insert('categorias',$data);
        return $this->db_almacen->insert_id();
    }
	function editarCategoria($id_registro,$data)
    {
        $this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('categorias',$data);
    }
	function getCategoriaId($id_registro)
	{
		$query = $this->db_almacen->query("select c.*
											from categorias c
										   where c.id =".$id_registro);
        return $query->result();
	}
	function getCategoriaCodigo($codigo)
	{
		$query = $this->db_almacen->query("select *
											from categorias c
										   where c.codigo ='".$codigo."'");
        return $query->result();
	}
	function getCategoriaCodigoDescripcion($codigo,$descripcion)
	{
		$query = $this->db_almacen->query("select *
											from categorias c
										   where c.codigo ='".$codigo."'
										     and c.descripcion ='".$descripcion."'");
        return $query->result();
	}
	function getUnidadDescripcion($descripcion)
	{
		$query = $this->db_almacen->query("select *
											from unidades_medida c
										   where c.descripcion ='".$descripcion."'");
        return $query->result();
	}
}
?>