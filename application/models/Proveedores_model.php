<?php

class Proveedores_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		  $this->db_almacen = $this->load->database('db_almacen', TRUE);

	}

	function getProveedores()
	{
		$query = $this->db_almacen->query("select *
											from material.proveedores p");
        return $query->result();
	}
	function guardarProveedor($data)
    {
        $this->db_almacen->insert('material.proveedores',$data);
        return $this->db_almacen->insert_id();
    }
	function editarProveedor($id_registro,$data)
    {
        $this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('material.proveedores',$data);
    }
	function getProveedorId($id_registro)
	{
		$query = $this->db_almacen->query("select *
											from material.proveedores p
										   where p.id =".$id_registro);
        return $query->result();
	}
	function getNombreProveedor($id)
	{
		$query = $this->db_almacen->query("select nombre_proveedor as nombre	
										   from material.proveedores p
										   where p.id =".$id);
        return $query->result()[0]->nombre;
	}
}
?>