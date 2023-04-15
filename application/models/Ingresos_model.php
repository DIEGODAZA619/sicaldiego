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
		$this->db_almacen->insert('inventario.ingresos',$data);
		return $this->db_almacen->insert_id();
	}
	function guardarIngresoMaterial($data)
	{
		$this->db_almacen->insert('inventario.ingresos_detalle',$data);
		return $this->db_almacen->insert_id();
	}
	
	function registrarIngresosInvetarios($data)
	{
		$this->db_almacen->insert('inventario.inventarios',$data);
		return $this->db_almacen->insert_id();
	}


	function insertarInventarioResumen($data)
	{
		$this->db_almacen->insert('inventario.inventarios_resumen',$data);
		return $this->db_almacen->insert_id();	
	}

	//UPDATES
	function updateInvetarios($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('inventario.inventarios',$data);
	}

	function editarIngresoMaterialDetalles($id_ingreso,$data)
	{		
		$this->db_almacen->where('id',$id_ingreso);
        return $this->db_almacen->update('inventario.ingresos_detalle',$data);
	}

	function updateIngreso($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('inventario.ingresos',$data);
	}

	function updateInventarioResumen($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('inventario.inventarios_resumen',$data);

	}


	//GET 
	function getInventarioResumenId($id_material)
	{
		$query = $this->db_almacen->query("select *
											 from inventario.inventarios_resumen 
											where id_material = ".$id_material."
											  and estado = 'AC'");
        return $query->result();   
	}
	function getProveedores()
	{
		$query = $this->db_almacen->query("select *
											 from material.proveedores i
											where estado = 'AC'
											order by nombre_proveedor asc"

											 );
        return $query->result();   
	}
	function getIngresos($id_entidad,$estado)
	{
		$query = $this->db_almacen->query("select *
											 from inventario.ingresos i
											where i.id_entidad =".$id_entidad."
											  and estado = '".$estado."' order by id desc"
											 );
        return $query->result();   	
	}

	function getIngresosDetallesId($id_ingreso,$estado)
	{		
		$query = $this->db_almacen->query("select i.*, m.codigo, m.descripcion , c.codigo as partida ,  ii.fecha_ingreso, ii.id as codigo_ingreso , ii.descripcion_ingreso, 
			(select p.nombre_proveedor from material.proveedores p Where p.id=ii.id_provedor ) as proveedor ,
			(select p.nit from material.proveedores p Where p.id=ii.id_provedor ) as nit ,
			(select p.descripcion from  clasificacion.unidades_medida p Where p.id= m.id_unidad ) as unidad
											 from inventario.ingresos_detalle i, 
											      material.materiales m , 
											      clasificacion.categorias c, 
											      inventario.ingresos ii
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
											 from inventario.ingresos_detalle i
											where i.id =".$id_ingreso);
        return $query->result();   	
	}
	function checkMaterialesIngreso($id_ingreso,$id_material)
	{
		$query = $this->db_almacen->query("select 1
											 from inventario.ingresos_detalle i
											where i.id_material = ".$id_material."
											  and i.id_ingreso =".$id_ingreso."
											  and i.estado = 'ELB'"
											 );
        return $query->result();
	}

	function checkIngresoMaterialInventario($idIngreso,$ingresoDetalle,$idMaterial)
	{
		$query = $this->db_almacen->query("select 1
											 from inventario.inventarios i
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
											 from inventario.inventarios 
											where tipo_proceso IN ('INGP','INGI')
											  and id_material = ". $id_material);
        return $query->result();   
	}
}
?>