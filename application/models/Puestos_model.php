<?php

class Puestos_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();			
		$this->db_rrhh = $this->load->database('db_almacen', TRUE);
	}

	function listaPuestos($id_persona)
	{

		$query = $this->db_rrhh->query("select f.id_puesto,
										       p.nombre_puesto,
										       p.id_dependencia,
										       p.id_subdependencia,
										       d.nombre_dependencia,       
										       case when (select nombre_subdependencia from subdependencia where id = p.id_subdependencia) is null 
										            then  '' 
										            else (select nombre_subdependencia from subdependencia where id = p.id_subdependencia) end as nombre_subdependencia        
										  from puesto_funcionario f,
										       puesto p,
										       dependencia d
										 where p.id = f.id_puesto
										   and p.id_dependencia = d.id
										   and id_funcionario = ".$id_persona);
		 return $query->result();   
	}

	function listaPuestos_otro($id_persona)
	{
		$query = $this->db_rrhh->query("select pf.id_funcionario,pf.id_puesto,p.nombre_puesto,p.numero_item,dom.valor1 as sede_trabajo, p.id_dependencia,
											case 
												WHEN p.tipo_puesto='PLA' and p.nivel_dependencia is null and dj.tipo_puesto is null then p.id_subdependencia
												WHEN p.tipo_puesto='PLA' and dj.nivel_dependencia is not null and dj.tipo_puesto='PRI' then p.id_subdependencia
												WHEN p.tipo_puesto='PLA' and dj.nivel_dependencia is not null and dj.tipo_puesto='SEC' then dj.id_subdependencia
												WHEN p.tipo_puesto='APO' and p.nivel_dependencia is null and dj.tipo_puesto is null then p.id_subdependencia
												WHEN p.tipo_puesto='APO' and dj.nivel_dependencia is not null and dj.tipo_puesto='PRI' then p.id_subdependencia
												WHEN p.tipo_puesto='APO' and dj.nivel_dependencia is not null and dj.tipo_puesto='SEC' then dj.id_subdependencia
												WHEN p.tipo_puesto='CON' and p.nivel_dependencia is null and dj.tipo_puesto is null then p.id_subdependencia
												WHEN p.tipo_puesto='CON' and dj.nivel_dependencia is not null and dj.tipo_puesto='PRI' then p.id_subdependencia
												WHEN p.tipo_puesto='CON' and dj.nivel_dependencia is not null and dj.tipo_puesto='SEC' then dj.id_subdependencia
											end as id_subdependencia,
											case 
												WHEN p.tipo_puesto='PLA' and p.nivel_dependencia is null and dj.tipo_puesto is null then 'PRI'
												WHEN p.tipo_puesto='PLA' and dj.nivel_dependencia is not null and dj.tipo_puesto='PRI' then 'PRI'
												WHEN p.tipo_puesto='PLA' and dj.nivel_dependencia is not null and dj.tipo_puesto='SEC' then 'SEC'
												WHEN p.tipo_puesto='APO' and p.nivel_dependencia is null and dj.tipo_puesto is null then 'SEC'
												WHEN p.tipo_puesto='APO' and dj.nivel_dependencia is not null and dj.tipo_puesto='PRI' then 'PRI'
												WHEN p.tipo_puesto='APO' and dj.nivel_dependencia is not null and dj.tipo_puesto='SEC' then 'SEC'
											end as nivel_puesto,
											dj.nivel_dependencia,p.tipo_puesto, dj.estado as depjerarquica_estado
										from puesto_funcionario pf join puesto p on (pf.id_puesto=p.id)
												join dependencia dep on (p.id_dependencia=dep.id) 
												join dominios dom on (dom.valor1=dep.sede_trabajo)
												left join dependencia_jerarquica dj on (pf.id_puesto=dj.id_puesto)
										where pf.estado='AC' and dom.concepto ='SEDE TRABAJO' 
												and pf.id_funcionario=".$id_persona."
										order by nivel_puesto"
										);
        return $query->result();   
	}


}

?>