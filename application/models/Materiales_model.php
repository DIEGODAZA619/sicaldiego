<?php

class Materiales_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		  $this->db_almacen = $this->load->database('db_almacen', TRUE);

	}

	function getMateriales()
	{
		$query = $this->db_almacen->query("select m.id,
			                                      m.codigo as codigo_material,
			                                      m.descripcion as descripcion_material,
			                                      m.estado,
			                                      c.codigo as codigo_categoria,
			                                      c.descripcion as descripcion_categoria,
			                                      u.descripcion as descripcion_unidad,
			                                      i.saldo,i.cantidad_solicitada
											 from materiales m,
											      categorias c,
											      unidades_medida u,
											      inventarios_resumen i
											where m.id_categoria = c.id
											  and m.id_unidad = u.id
											  and i.id_material = m.id	
											  order by m.id desc");
        return $query->result();
	}
	function getMaterialesId($id_material)
	{
		$query = $this->db_almacen->query("select * , i.saldo,i.cantidad_solicitada
											 from materiales m,
											 inventarios_resumen i
											where 
											i.id_material = m.id	
											and m.id =".$id_material
											 );
        return $query->result();
	}
	function getMaterialTotal()
	{
		$query = $this->db_almacen->query("select *
											from materiales c
										  where c.estado = 'AC'
										  order by id asc");
        return $query->result();
	}
	function getMaterialDescripcion($descripcion)
	{
		$query = $this->db_almacen->query("select *
											from materiales c
										  where c.descripcion = '".$descripcion."'
										    and c.estado = 'AC'");
        return $query->result();
	}
	function checkMaterial($descripcion,$unidad,$categoriaFamilia)
	{
		$query = $this->db_almacen->query("select *
											from materiales c
										  where c.descripcion = '".$descripcion."'
										    and c.id_unidad = ".$unidad."
										    and c.id_categoria = ".$categoriaFamilia);
        return $query->result();
	}


	function getCategoria()
	{
		$query = $this->db_almacen->query("select *
											from categorias c
										  where c.nivel = '1'");
        return $query->result();
	}
	function getSubCategoria($id_padre)
	{
		$query = $this->db_almacen->query("select *
											from categorias c
										  where c.nivel = '2'
										  and c.padre ='".$id_padre."'");
        return $query->result();
	}
	function getMaterial($id_padre)
	{
		$query = $this->db_almacen->query("select *
											from categorias c
										  where c.nivel = '3'
										  and c.padre ='".$id_padre."'");
        return $query->result();
	}
	function getUnidad()
	{
		$query = $this->db_almacen->query("select *
											from unidades_medida um");
        return $query->result();
	}
	function guardarMaterial($data)
    {
        $this->db_almacen->insert('materiales',$data);
        return $this->db_almacen->insert_id();
    }


	function editarMaterial($id_registro,$data)
    {
        $this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('materiales',$data);
    }

    function guardarInventarioResumen($data)
    {
        $this->db_almacen->insert('inventarios_resumen',$data);
        return $this->db_almacen->insert_id();
    }

	function getMaterialId($id_registro)
	{
		$query = $this->db_almacen->query("select m.*, c2.id as subcategoria, c3.id as categoria
											from materiales m
										   left join categorias c on m.id_categoria = c.id
										   left join categorias c2 on c2.id =c.padre
										   left join categorias c3 on c3.id =c2.padre
										   where m.id =".$id_registro);
        return $query->result();
	}
	function getListaMateriales()
	{
		$query = $this->db_almacen->query("select m.id,
			                                      m.codigo as codigo_material,
			                                      m.descripcion as descripcion_material,
			                                      m.estado,
			                                      c.codigo as codigo_categoria,
			                                      c.descripcion as descripcion_categoria,
			                                      u.descripcion as descripcion_unidad,
			                                      m.ruta_imagen,
			                                      m.nombre_imagen
											 from materiales m,
											      categorias c,
											      unidades_medida u
											where m.id_categoria = c.id
											  and m.id_unidad = u.id
											  order by m.id desc");
        return $query->result();
	}

	function getNroCodigoCorrelativo($cat_id)
	{
        $query = $this->db_almacen->query(" select count(*) + 1 as numero
											   from categorias T0,
											        categorias T1,
											        categorias T2,
											        materiales m
											  where T0.id = T1.padre
											    and T1.id = T2.padre
											    and T2.id = m.id_categoria
											    and T1.id = ".$cat_id);
        return $query->result();
	}
	function catalogoData($cat_id)
	{
        $query = $this->db_almacen->query("select T0.id as id_3 , T0.codigo as codigo_3
			,T1.id as id_2, T1.codigo as codigo_2 , T1.sigla
			,T2.id as id_1 ,T2.codigo as codigo_1
			--, cast(replace(T3.codigo , T1.sigla,'') as integer) + 1 numero
			from categorias T0 
			inner join categorias T1 on T1.id = T0.padre
			inner join categorias T2 on T2.id = T1.padre
			left join  materiales T3 on T3.id_categoria = T0.id
			Where T1.id = ".$cat_id."
			order by T3.codigo desc limit 1
						");
        return $query->result();
	}
}
?>