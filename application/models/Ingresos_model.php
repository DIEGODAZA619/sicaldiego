<?php

class Ingresos_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		  $this->db_almacen = $this->load->database('db_almacen', TRUE);    

	}
	
	
	// INSERT
	function guardarRegistroIngreso($data)
	{
		$this->db_almacen->insert('ingresos',$data);
		return $this->db_almacen->insert_id();
	}
	function guardarIngresoMaterial($data)
	{
		$this->db_almacen->insert('ingresos_detalle',$data);
		return $this->db_almacen->insert_id();
	}
	
	function registrarIngresosInvetarios($data)
	{
		$this->db_almacen->insert('inventarios',$data);
		return $this->db_almacen->insert_id();
	}


	function insertarInventarioResumen($data)
	{
		$this->db_almacen->insert('inventarios_resumen',$data);
		return $this->db_almacen->insert_id();	
	}

	//UPDATES
	function updateInvetarios($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('inventarios',$data);
	}

	function editarIngresoMaterialDetalles($id_ingreso,$data)
	{		
		$this->db_almacen->where('id',$id_ingreso);
        return $this->db_almacen->update('ingresos_detalle',$data);
	}

	function updateIngreso($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('ingresos',$data);
	}

	function updateInventarioResumen($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('inventarios_resumen',$data);

	}


	//GET 
	function getInventarioResumenId($id_material)
	{
		$query = $this->db_almacen->query("select *
											 from inventarios_resumen 
											where id_material = ".$id_material."
											  and estado = 'AC'");
        return $query->result();   
	}
	function getProveedores($id_entidad)
	{
		$query = $this->db_almacen->query("select *
											 from proveedores i
											where estado = 'AC'
											  and id_entidad = ".$id_entidad."
											order by nombre_proveedor asc"

											 );
        return $query->result();   
	}
	function getIngresos($id_entidad,$estado)
	{
		$query = $this->db_almacen->query("select *
											 from ingresos i
											where i.id_entidad =".$id_entidad."
											  and estado = '".$estado."' order by id desc"
											 );
        return $query->result();   	
	}

	function getIngresosDetallesId($id_ingreso,$estado)
	{		
		$query = $this->db_almacen->query("select i.*, m.codigo, m.descripcion , c.codigo as partida ,  ii.fecha_ingreso, ii.id as codigo_ingreso , ii.descripcion_ingreso, 
			(select p.nombre_proveedor from proveedores p Where p.id=ii.id_provedor ) as proveedor ,
			(select p.nit from proveedores p Where p.id=ii.id_provedor ) as nit ,
			(select p.descripcion from  unidades_medida p Where p.id= m.id_unidad ) as unidad
											 from ingresos_detalle i, 
											      materiales m , 
											      categorias c, 
											      ingresos ii
											where i.id_material = m.id
											  and i.id_ingreso = ii.id 
											  and i.id_ingreso =".$id_ingreso."
											  and m.id_categoria = c.id
											  and i.estado = '".$estado."'
											  ORDER BY m.id, m.id_categoria  asc"

											 );
        return $query->result();   	
	}
	function getIngresoDetId($id_ingreso)
	{
		$query = $this->db_almacen->query("select *
											 from ingresos_detalle i
											where i.id =".$id_ingreso);
        return $query->result();   	
	}
	function checkMaterialesIngreso($id_ingreso,$id_material)
	{
		$query = $this->db_almacen->query("select 1
											 from ingresos_detalle i
											where i.id_material = ".$id_material."
											  and i.id_ingreso =".$id_ingreso."
											  and i.estado = 'ELB'"
											 );
        return $query->result();
	}

	function checkIngresoMaterialInventario($idIngreso,$ingresoDetalle,$idMaterial)
	{
		$query = $this->db_almacen->query("select 1
											 from inventarios i
											where i.id_ingreso = ".$idIngreso."
											  and i.id_ingreso_detalle =".$ingresoDetalle."
											  and i.id_material = ".$idMaterial
											 );
        return $query->result();
	}
	


	function cantidadInventarioProducto($id_material)
	{
		$query = $this->db_almacen->query("select case when max(id_inventario_inicial_ingreso) is null
												  then 0
												  else max(id_inventario_inicial_ingreso)
										          end AS correlativo
											 from inventarios 
											where tipo_proceso IN ('INGP','INGI')
											  and id_material = ". $id_material);
        return $query->result();   
	}
}
?>