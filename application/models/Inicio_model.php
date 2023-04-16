<?php

class Inicio_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_almacen = $this->load->database('db_almacen', TRUE); 
	}
	function getIngresosNoAprobados($id_entidad)
	{
		$query = $this->db_almacen->query("select *
											 from ingresos i
											where i.id_entidad =".$id_entidad."
											  and estado not in('AC') "
											 );
        return $query->result();   	
	}
	function getSolicitudesDetalles()
	{
		$query = $this->db_almacen->query("select s.id as id_solicitud, 
			                                      m.codigo as codigo_material,
			                                      m.descripcion as descripcion_material, 
			                                      s.estado,
			                                      s.id_funcionario,
			                                      c.codigo as codigo_categoria, 
			                                      c.descripcion as descripcion_categoria, 
			                                      u.descripcion as descripcion_unidad,
			                                      s.cantidad_solicitada,
			                                      TO_CHAR(s.fecha_registro ,'dd-MM-YYYY' ) as fecha_registro
											 from materiales m, 
											      clasificacion.categorias c, 
											      clasificacion.unidades_medida u,
											      solicitudes s
											where m.id_categoria = c.id
											  and m.id_unidad = u.id
											  and s.id_material = m.id
											  and s.estado not  in ('ENT', 'AN')
											  order by s.id desc");
        return $query->result(); 
	}

	function getListaResumenAlmacen()
	{
		$query = $this->db_almacen->query("
										select 
										(select b.codigo from  clasificacion.categorias b Where  b.id= m.id_categoria ) as partida,
										--(select b.descripcion from  clasificacion.categorias b Where  b.id= m.id_categoria ) as categoria_descripcion,
										m.descripcion  as descripcion_del_producto,
										(select b.descripcion from  clasificacion.unidades_medida b Where  b.id= m.id_unidad ) as unidad, 
										i.cantidad_entrada, i.cantidad_salida, i.saldo

										from inventarios_resumen i
										inner join materiales m on m.id= i.id_material
										where i.estado='AC'
										order  by descripcion_del_producto 
			");
        return $query->result(); 
	}
	

	
	
}

?>