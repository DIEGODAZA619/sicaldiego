<?php

class Solicitudes_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		  $this->db_almacen = $this->load->database('db_almacen', TRUE);    

	}
		
	// INSERT
	function guardarSolicitudMaterial($data)
	{
		$this->db_almacen->insert('inventario.solicitudes',$data);
		return $this->db_almacen->insert_id();
	}

	function guardarConfirmaciónSolicitudMaterial($data)
	{
		$this->db_almacen->insert('inventario.solicitud_direccion',$data);
		return $this->db_almacen->insert_id();
	}

	//UPDATES	
	function editarSolicitudMaterialDetalles($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('inventario.solicitudes',$data);
	}

	function editarConfirmaciónSolicitudMaterialDetalles($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('inventario.solicitud_direccion',$data);
	}

	function editarInventarioMaterial($id_registro,$data)
	{
		$this->db_almacen->where('id',$id_registro);
        return $this->db_almacen->update('inventario.inventarios',$data);
	}
	

	//GET
	function getMaterialesInventario()
	{
		$query = $this->db_almacen->query("select m.id as id_material, 
			                                      m.codigo as codigo_material,
			                                      m.descripcion as descripcion_material, 
			                                      m.estado,
			                                      c.codigo as codigo_categoria, 
			                                      c.descripcion as descripcion_categoria,    
			                                      u.descripcion as descripcion_unidad,
			                                      i.saldo,
			                                      i.cantidad_solicitada,
			                                      i.cantidad_disponible
											 from material.materiales m, 
											      clasificacion.categorias c, 
											      clasificacion.unidades_medida u,
											      inventario.inventarios_resumen i
											where m.id_categoria = c.id
											  and m.id_unidad = u.id
											  and i.id_material = m.id
											  order by i.saldo desc");
        return $query->result();         	
	}

	function getSolicitudesDetalles($id_funcionario,$estado,$tipo)
	{
		$query = $this->db_almacen->query("select s.id as id_solicitud, 
			                                      m.codigo as codigo_material,
			                                      m.descripcion as descripcion_material, 
			                                      s.estado,
			                                      c.codigo as codigo_categoria, 
			                                      c.descripcion as descripcion_categoria, 
			                                      u.descripcion as descripcion_unidad,
			                                      s.cantidad_solicitada,
			                                      s.fecha_registro			                                      
											 from material.materiales m, 
											      clasificacion.categorias c, 
											      clasificacion.unidades_medida u,
											      inventario.solicitudes s
											where m.id_categoria = c.id
											  and m.id_unidad = u.id
											  and s.id_material = m.id
											  and s.id_funcionario = ".$id_funcionario."
											  and s.tipo_solicitud = '".$tipo."'
											  and s.estado = '".$estado."'
											  order by s.id desc");
        return $query->result(); 
	}
	function checkMaterialesSolicitado($id_material,$id_funcionario,$estado,$tipo)
	{
		$query = $this->db_almacen->query("select 1
											 from inventario.solicitudes s
											where s.id_material = ".$id_material."
											  and s.id_funcionario =".$id_funcionario."
											  and s.tipo_solicitud = '".$tipo."'
											  and s.estado = '".$estado."'"
											 );
        return $query->result();
	}

	function getSolicitudId($idSolicitud)
	{
		$query = $this->db_almacen->query("select *
											 from inventario.solicitudes s
											where s.id =".$idSolicitud);
        return $query->result();   	
	}

	function getcantidadSolicitadaMaterial($idMaterial)
	{
		$query = $this->db_almacen->query("select case when sum(cantidad_autorizada)>0 then  sum(cantidad_autorizada) else 0 end as cantidad_solicitada
											 from inventario.solicitudes 
											where estado not in ('AN','ENT','RC')
											  and id_material =". $idMaterial);
        return $query->result();  

	}




	// CONFIRMAR SOLICITUDES DIRECCION

	function solicitudConfirmadasDireccion($idDependencia,$idsubdependencia,$tipoSolicitud,$estado)
	{
		$query = $this->db_almacen->query("select *
											 from inventario.solicitud_direccion s
											where s.id_dependencia = ".$idDependencia."
											  and s.id_subdependencia = ".$idsubdependencia."
											  and tipo_solicitud = '".$tipoSolicitud."'
											  --and estado =  '".$estado."'
											order by s.id desc");
        return $query->result(); 
	}
	function confirmarSolicitudDireccion($dependencia,$subdependencia,$tipoSolicitud,$estado)
	{
		$query = $this->db_almacen->query("select s.id as id_solicitud, 
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
											  and s.tipo_solicitud = '".$tipoSolicitud."'
											  and s.id_dependencia = ".$dependencia."
											  and s.id_subdependencia = ".$subdependencia."									  
											  and s.estado = '".$estado."'
											  order by s.id desc");
        return $query->result(); 
	}
	function confirmarSolicitudDireccionTotal($dependencia,$tipoSolicitud,$estado)
	{
		$query = $this->db_almacen->query("select s.id as id_solicitud, 
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
											  and s.tipo_solicitud = '".$tipoSolicitud."'
											  and s.id_dependencia = ".$dependencia."											  							  
											  and s.estado = '".$estado."'
											  order by s.id desc");
        return $query->result(); 
	}
	function confirmarSolicitudIndividual($id_funcionario,$gestion)
	{
		$query = $this->db_almacen->query("select s.id as id_solicitud, 
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
											  and s.tipo_solicitud = 'NOR'
											  and s.id_funcionario = '".$id_funcionario."'
											  and s.gestion = ".$gestion."										  
											  and s.estado <> 'AN'
											  order by s.id desc");
        return $query->result(); 
	}

	function historialMaterialFuncionario($id_funcionario,$id_material)
	{
		$query = $this->db_almacen->query("select s.id as id_solicitud, 
			                                      m.codigo as codigo_material,
			                                      m.descripcion as descripcion_material, 
			                                      s.estado,
			                                      c.codigo as codigo_categoria, 
			                                      c.descripcion as descripcion_categoria, 
			                                      u.descripcion as descripcion_unidad,
			                                      s.cantidad_solicitada,
			                                      s.cantidad_autorizada,
			                                      s.fecha_registro,
			                                      s.fecha_entrega,
			                                      s.id_funcionario,
			                                      s.id_confirmacion_direccion			                                      
											 from material.materiales m, 
											      clasificacion.categorias c, 
											      clasificacion.unidades_medida u,
											      inventario.solicitudes s
											where m.id_categoria = c.id
											  and m.id_unidad = u.id
											  and s.id_material = m.id
											  and s.tipo_solicitud = 'NOR'
											  and s.id_funcionario = '".$id_funcionario."'
											  and s.id_material = ".$id_material."										  
											  and s.estado = 'ENT'
											  order by s.id desc");
        return $query->result(); 
	}
	function getSolicitudDireccionConfirmadosVerificar($idConfirmacion)
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
											  and s.estado not in ('AN') 
											order by s.id_funcionario, s.id desc");
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
											order by s.id_funcionario, s.id desc");
        return $query->result(); 
	}

	
	function getSolicitudDireccionConfirmadosAutorizados($idConfirmacion)
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
											  and s.estado in ('AUT','ENT') 
											order by s.id_funcionario, s.id desc");
        return $query->result(); 
	}

	function getSolicitudDireccionConfirmadosAutorizadosResumen($idConfirmacion)
	{
		$query = $this->db_almacen->query("
				select codigo_material, descripcion_material, descripcion_unidad, codigo_categoria, sum(cantidad_autorizada) as cantidad_autorizada
				FROM
				(
					select s.id as id_solicitud, 
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
							and s.estado in ('AUT','ENT') 
					order by m.codigo
				) as tabla
				group by codigo_material,descripcion_material,descripcion_unidad, codigo_categoria
				order by codigo_material");
        return $query->result(); 
	}

	function getSolicitudesConfirmadasPorDireccion($estado)
	{
		$query = $this->db_almacen->query("select *
											 from inventario.solicitud_direccion s
											where estado =  '".$estado."'
											order by s.id desc");
        return $query->result(); 
	}


	function getMaterialInventarioPeps($idMaterial)
	{
		$query = $this->db_almacen->query(" select *
											  from inventario.inventarios
											 where id_material = ".$idMaterial." 
											   and saldo > 0
											   and tipo_proceso IN ('INGI','INGP', 'INGS')  
											   and estado = 'AC'
											 order by id_inventario_inicial_ingreso asc");
        return $query->result(); 
	}

	function getIdMaterialInventario($idInventario)
	{
		$query = $this->db_almacen->query(" select *
											  from inventario.inventarios
											 where id = ".$idInventario);
        return $query->result(); 
	}

	function getListarDatosSolicitudDireccion($idSolicitud)
	{
		$query = $this->db_almacen->query(" select *
											  from inventario.solicitud_direccion
											 where id = ".$idSolicitud);
        return $query->result(); 
	}
}
?>