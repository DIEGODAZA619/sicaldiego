<?php

class Entregados_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		  $this->db_almacen = $this->load->database('db_almacen', TRUE);

	}

	function getEntregados()
	{
		$query = $this->db_almacen->query("select a.*,
													(select  SUM(b.cantidad_autorizada) from inventario.solicitudes b Where  b.id_confirmacion_direccion = a.id) as cantidad_autorizada
	 									from inventario.solicitud_direccion a 
										Where 	a.estado ='ENT'
										");
        return $query->result();
	}
	function getSolicitudDireccionConfirmados($idConfirmacion,$estado)
	{
		$query = $this->db_almacen->query("select s.id as id_solicitud, 
												  s.id_material,	
			                                      m.codigo as codigo_material,
			                                      m.descripcion as descripcion_material, 
			                                      s.estado,
			                                      c.codigo as codigo_categoria, 
			                                      c.descripcion as descripcion_categoria, 
			                                      u.descripcion as descripcion_unidad,
			                                      s.cantidad_solicitada,
			                                      s.cantidad_autorizada,
			                                      s.fecha_registro,
			                                      s.id_funcionario,
			                                      s.id_confirmacion_direccion			                                      
											 from material.materiales m, 
											      clasificacion.categorias c, 
											      clasificacion.unidades_medida u,
											      inventario.solicitudes s
											where m.id_categoria = c.id
											  and m.id_unidad = u.id
											  and s.id_material = m.id
											  and s.id_confirmacion_direccion = ".$idConfirmacion."
											  and s.estado = '".$estado."'
											order by s.id desc");
        return $query->result(); 
	}


	/*function getMaterialesId($id_material)
	{
		$query = $this->db_almacen->query("select *
											 from material.materiales m
											where m.id =".$id_material
											 );
        return $query->result();
	}
	function getCategoria()
	{
		$query = $this->db_almacen->query("select *
											from clasificacion.categorias c
										  where c.nivel = '1'");
        return $query->result();
	}
	function getSubCategoria($id_padre)
	{
		$query = $this->db_almacen->query("select *
											from clasificacion.categorias c
										  where c.nivel = '2'
										  and c.padre ='".$id_padre."'");
        return $query->result();
	}
	function getMaterial($id_padre)
	{
		$query = $this->db_almacen->query("select *
											from clasificacion.categorias c
										  where c.nivel = '3'
										  and c.padre ='".$id_padre."'");
        return $query->result();
	}
	function getUnidad()
	{
		$query = $this->db_almacen->query("select *
											from clasificacion.unidades_medida um");
        return $query->result();
	}
	function guardarMaterial($data)
    {
        $this->db_almacen->insert('material.materiales',$data);
        return $this->db_almacen->insert_id();
    }
	function editarMaterial($id_registro,$data)
    {
        $this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('material.materiales',$data);
    }
	function getMaterialId($id_registro)
	{
		$query = $this->db_almacen->query("select m.*, c2.id as subcategoria, c3.id as categoria
											from material.materiales m
										   left join clasificacion.categorias c on m.id_categoria = c.id
										   left join clasificacion.categorias c2 on c2.id =c.padre
										   left join clasificacion.categorias c3 on c3.id =c2.padre
										   where m.id =".$id_registro);
        return $query->result();
	}*/
}
?>