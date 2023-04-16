<?php
/*
*/

class Roles_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();	
		$this->db_almacen = $this->load->database('db_almacen', TRUE);		
		$this->db_rrhh = $this->load->database('db_almacen', TRUE);
	}

	function obtener_roles_cero($id,$aplicacion)
	{
		$query = $this->db_almacen->query(" select o.id, o.codigo_opciones,o.opcion,o.link,o.icono,o.nivel,o.orden
									  from usuarios_opciones u, opciones o
									 where u.id_opcion = o.id   	
									   and u.id_usuario = ".$id."
									   and o.id_aplicacion = ".$aplicacion."
									   and o.nivel = 0
									   and u.estado = 'AC'
									   and o.estado = 'AC'
									 order by o.orden asc" );	
        return $query->result();	
	}
	function obtener_roles($id,$aplicacion)
	{
		$query = $this->db_almacen->query(" select o.id, 
			                               o.codigo_opciones,
			                               o.opcion,
			                               o.link,
			                               o.icono,
			                               o.nivel,
			                               o.orden
									  from usuarios_opciones u, 
									       opciones o
									 where u.id_opcion = o.id
									   and u.id_usuario = ".$id."
									   and o.id_aplicacion = ".$aplicacion."
									   and o.nivel > 0
									   and u.estado = 'AC'
									   and o.estado = 'AC'
									 order by o.codigo_opciones,o.nivel,o.orden asc" );	
        return $query->result();	
	}

	function check_opciones($opcion,$usuario)
	{
		$query = $this->db_almacen->query("select 1 
			                         	     from usuarios_opciones
										    where id_usuario =". $usuario."
										      and id_opcion =".$opcion."
										      and estado = 'AC'");
        return $query->result();
	}
	function guardarOpcionesRol($data)
    {       
        $this->db_almacen->insert('usuarios_opciones',$data); 
        return $this->db_almacen->insert_id();
    }

    function listaFuncionario()
    {
    	$query = $this->db_rrhh->query("select f.id, t.nivel_dependencia,t.numero_item
											  from puesto_funcionario p,
											       funcionario f,
											       entidad.puesto t
											where p.id_funcionario = f.id
											  and p.id_puesto = t.id");
        return $query->result();
    }

    function usuarioIdPersona($id_funcionario)
    {
    	$query = $this->db_almacen->query("select u.id
											  from usuarios u
											where u.id_persona =".$id_funcionario);
        return $query->result();
    }

}
?>