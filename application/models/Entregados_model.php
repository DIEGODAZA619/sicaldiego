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
													(select  SUM(b.cantidad_autorizada) from solicitudes b Where  b.id_confirmacion_direccion = a.id) as cantidad_autorizada
	 									from solicitud_direccion a 
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
											 from materiales m, 
											      categorias c, 
											      unidades_medida u,
											      solicitudes s
											where m.id_categoria = c.id
											  and m.id_unidad = u.id
											  and s.id_material = m.id
											  and s.id_confirmacion_direccion = ".$idConfirmacion."
											  and s.estado = '".$estado."'
											order by s.id desc");
        return $query->result(); 
	}

	
}
?>