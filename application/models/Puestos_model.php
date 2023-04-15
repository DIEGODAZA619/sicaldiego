<?php

class Puestos_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();			
		$this->db_rrhh = $this->load->database('db_recursos_humanos', TRUE);
	}

	function listaPuestos($id_persona)
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
										from personal.puesto_funcionario pf join entidad.puesto p on (pf.id_puesto=p.id)
												join entidad.dependencia dep on (p.id_dependencia=dep.id) 
												join administracion.dominios dom on (dom.valor1=dep.sede_trabajo)
												left join entidad.dependencia_jerarquica dj on (pf.id_puesto=dj.id_puesto)
										where pf.estado='AC' and dom.concepto ='SEDE TRABAJO' 
												and pf.id_funcionario=".$id_persona."
										order by nivel_puesto"
										);
        return $query->result();   
	}
}

?>