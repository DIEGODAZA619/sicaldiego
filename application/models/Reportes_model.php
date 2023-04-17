<?php
/*
*/

class Reportes_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_almacen = $this->load->database('db_almacen', TRUE);
	}

	function confirmaSolicitudDireccion($idConfirmacion)
	{
		$query = $this->db_almacen->query("select *
											 from solicitud_direccion
											 where id = ".$idConfirmacion."
											 order by id desc");
        return $query->result(); 
	}

	function getKardexMaterial($idMaterial, $gestion)
	{
		$query = $this->db_almacen->query("select *
											 from inventarios
											where gestion = ".$gestion."
											  and id_material = ".$idMaterial."
											order by id_inventario_inicial_ingreso, id asc");
        return $query->result(); 
	}
	function getKardexMaterialGestion($idMaterial,$gestion)
	{
		$query = $this->db_almacen->query("select *
			                                 from
												( 
												select i.*,'INGRESO' as tipo
												  from inventarios i
												 where i.id_material = ".$idMaterial."
												   and i.gestion = ".$gestion."
												   and tipo_proceso IN ('INGP','INGI')
												  union all
												select s.*,'SALIDA' as tipo
												  from inventarios s
												 where id_material = ".$idMaterial." 
												  and s.gestion = ".$gestion."
												  and tipo_ingreso_egreso = 'SOLM')as tabla
												order by tabla.id asc");
        return $query->result(); 
	}
	

	function getIngresosFechas($fecha_inicio, $fecha_fin)
	{
		
		$query = $this->db_almacen->query("select *
											  from ingresos i, total_precio_ingreso t
											 where i.id = t.id_ingreso
											   and i.estado = 'AC'
											   and fecha_ingreso between '".$fecha_inicio."' and '".$fecha_fin."'
											 order by correlativo asc ");
        return $query->result(); 
	}

	function getSalidasFechas($fecha_inicio, $fecha_fin)
	{
		$query = $this->db_almacen->query("select *
											  from solicitud_direccion s, total_precio_salida t
											 where s.id = t.id_salida
											   and estado = 'ENT'
											   and fecha_entrega between '".$fecha_inicio."' and '".$fecha_fin."'
											 order by correlativo asc");
        return $query->result(); 
	}

	function getResumenValorado($gestion, $fecha_fin)
	{
		$query = $this->db_almacen->query("select  m.id_material,
											       m.codigo_material,
											       m.codigo_categoria,
											       substring(m.codigo_categoria,1,5) as codigo_partida,
											       m.descripcion_unidad,
											       m.descripcion_material,											           
											       case when (select sum(i.cantidad_entrada) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGI'  and i.id_material = m.id_material) is not null 
											            then (select sum(i.cantidad_entrada) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGI'  and i.id_material = m.id_material) else 0 end as saldo_inicial,

											       case when (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGI'  and i.id_material = m.id_material) is not null 
											            then (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGI'  and i.id_material = m.id_material) else 0 end as saldo_inicial_valorado,
											            	
											       case when (select sum(i.cantidad_entrada) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGP' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) is not null 
											            then (select sum(i.cantidad_entrada) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGP' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) else 0 end as ingreso_fisico,

											       case when (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGP' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) is not null 
											            then (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGP' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) else 0 end as ingreso_fisico_valorado,     
											  	
											       case when (select sum(i.cantidad_salida) from inventarios i where i.gestion = m.gestion and i.tipo_ingreso_egreso = 'SOLM' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) is not null 
											            then (select sum(i.cantidad_salida) from inventarios i where i.gestion = m.gestion and i.tipo_ingreso_egreso = 'SOLM' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) else 0 end as salida_fisico,

											       case when (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_ingreso_egreso = 'SOLM' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) is not null 
											            then (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_ingreso_egreso = 'SOLM' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) else 0 end as salida_fisico_valorado
											            
											  from materiales_inventario m
											 where m.gestion = ".$gestion."
											 order by m.id_material");
        return $query->result();
	}


	function getResumenValoradoPartida($gestion, $fecha_fin)
	{
		$query = $this->db_almacen->query("select 
											tabla.codigo_partida,
											sum(tabla.saldo_inicial)as  saldo_inicial_partida,
											sum(tabla.saldo_inicial_valorado)as saldo_inicial_valorado_partida,
											sum(tabla.ingreso_fisico) as ingreso_fisico_partida,
											sum(tabla.ingreso_fisico_valorado)as ingreso_fisico_valorado_partida,
											sum(tabla.salida_fisico)as salida_fisico_partida,
											sum(tabla.salida_fisico_valorado)as  salida_fisico_valorado_partida
											from (
											select m.id_material,
											       m.codigo_material,
											       m.codigo_categoria,
											       substring(m.codigo_categoria,1,5) as codigo_partida,
											       m.descripcion_unidad,
											       m.descripcion_material,
											           
											       case when (select sum(i.cantidad_entrada) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGI'  and i.id_material = m.id_material) is not null 
											            then (select sum(i.cantidad_entrada) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGI'  and i.id_material = m.id_material) else 0 end as saldo_inicial,

											       case when (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGI'  and i.id_material = m.id_material) is not null 
											            then (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGI'  and i.id_material = m.id_material) else 0 end as saldo_inicial_valorado,
											            	
											       case when (select sum(i.cantidad_entrada) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGP' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) is not null 
											            then (select sum(i.cantidad_entrada) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGP' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) else 0 end as ingreso_fisico,

											       case when (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGP' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) is not null 
											            then (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_proceso = 'INGP' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) else 0 end as ingreso_fisico_valorado,     
											  	
											       case when (select sum(i.cantidad_salida) from inventarios i where i.gestion = m.gestion and i.tipo_ingreso_egreso = 'SOLM' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) is not null 
											            then (select sum(i.cantidad_salida) from inventarios i where i.gestion = m.gestion and i.tipo_ingreso_egreso = 'SOLM' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) else 0 end as salida_fisico,

											       case when (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_ingreso_egreso = 'SOLM' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) is not null 
											            then (select sum(i.precio_total) from inventarios i where i.gestion = m.gestion and i.tipo_ingreso_egreso = 'SOLM' and i.fecha_registro <= '".$fecha_fin."' and i.id_material = m.id_material) else 0 end as salida_fisico_valorado
											            
											  from materiales_inventario m
											 where m.gestion = ".$gestion."
											 order by m.id_material)as tabla
											group by tabla.codigo_partida
											order by tabla.codigo_partida asc");
        return $query->result();
	}

	function getDetalleAlmacenes($gestion, $fecha_fin)
	{
				$query = $this->db_almacen->query("select i.id,
															i.id_material,
															m.descripcion_material,
															m.descripcion_unidad,
															i.tipo_proceso,
															i.precio_unitario,
															i.cantidad_entrada,
															i.precio_total,
													       case when (select sum(cantidad_salida) from inventarios inv where inv.tipo_ingreso_egreso = 'SOLM' and inv.id_inventario_ingresos = i.id) is not null 
														    then (select sum(cantidad_salida) from inventarios inv where inv.tipo_ingreso_egreso = 'SOLM' and inv.id_inventario_ingresos = i.id and inv.fecha_registro <= '".$fecha_fin."') else 0 end as cantidadsalida,
													       case when (select sum(precio_total) from inventarios inv where inv.tipo_ingreso_egreso = 'SOLM' and inv.id_inventario_ingresos = i.id) is not null 
														    then (select sum(precio_total) from inventarios inv where inv.tipo_ingreso_egreso = 'SOLM' and inv.id_inventario_ingresos = i.id and inv.fecha_registro <= '".$fecha_fin."') else 0 end as valorsalida
													  from inventarios i,
													       materiales_inventario m
													 where m.id_material = i.id_material
													   and i.gestion = ".$gestion."
													   and i.tipo_proceso IN ('INGP','INGI')													  
													   and i.fecha_registro <= '".$fecha_fin."'													   
													order by i.id_material,i.id asc");
        return $query->result(); 
	}



	function getIngresos()
	{
		$query = $this->db_almacen->query("select *
											  from inventarios
											 where 1 = 1
											   and tipo_proceso IN ('INGP','INGI')
											 order by id asc");
        return $query->result(); 
	}

	function getSalidasIngresos($idInventario)
	{
		$query = $this->db_almacen->query("select *
											  from inventarios
											 where 1 = 1
											   and id_inventario = ".$idMaterial."
											 order by id asc");
        return $query->result(); 
	}
}
?>