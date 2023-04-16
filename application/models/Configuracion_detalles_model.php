<?php
/*
*/

class Configuracion_detalles_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_almacen = $this->load->database('db_almacen', TRUE);
	}

	function getGestionVigente()
	{
		$query = $this->db_almacen->query("select *
			                              from gestion
			                             where estado = 'AC'");
        return $query->result();
	}


	function getIdMaximoTabla($tabla)
    {
    	$query = $this->db_almacen->query("select max(id)as id_max
   											 from ". $tabla);
        return $query->result();
    }


    function getValoresProveedor($idProveedor)
    {
    	$query = $this->db_almacen->query("select *
			                                 from proveedores
			                                where id =".$idProveedor);
        return $query->result();
    }

    function getnumeroIngresoAlmacen($idIngreso)
    {
    	$query = $this->db_almacen->query("select *
			                                 from ingresos
			                                where id =".$idIngreso);
        return $query->result();
    }

    function getnumeroSolicitudAlmacen($idSolicitud)
    {
    	$query = $this->db_almacen->query("select *
			                                 from solicitud_direccion
			                                where id =".$idSolicitud);
        return $query->result();
    }
	function getValoresDominios($concepto)
	{
		$query = $this->db_almacen->query("select *
			                              from dominios
			                             where concepto ='".$concepto."'
			                               and estado = 'AC'
			                             order by orden asc");
        return $query->result();
	}
	function getValoresDominiosCombos($concepto)
	{
		$query = $this->db_almacen->query("select valor2, valor1
			                              from dominios
			                             where concepto ='".$concepto."'
			                               and estado = 'AC'
										   order by valor2");
        return $query->result();
	}
	function getValoresDominiosConcepto($concepto,$valor)
	{
		$query = $this->db_almacen->query("select *
			                              from dominios
			                             where concepto ='".$concepto."'
			                               and valor1 ='".$valor."'
			                               and estado = 'AC'
			                             order by orden asc");
        return $query->result();
	}
	
	function getConfiguracionDetalles($concepto)
	{
		$query = $this->db_almacen->query("select c.*,
		                                       d.valor2 as estadoregistro
			                              from configuracion_detalles c,
			                                   dominios d
			                             where c.concepto ='".$concepto."'
			                               and d.valor1 = c.estado
			                               and d.concepto = 'ESTADO REGISTRO'     
			                             order by id asc");
        return $query->result();
	}
	function getConfiguracionDetalles_id($concepto)
	{
		$query = $this->db_almacen->query("select *
			                              from configuracion_detalles c
			                             where c.concepto ='".$concepto."'			                               
			                               and c.estado = 'AC'     
			                             order by id asc");
        return $query->result();
	}

	function guardarConfiguracion($data)
    {       
        $this->db_rrhh->insert('configuracion_detalles',$data); 
        return $this->db_rrhh->insert_id();
    }
    
    function getConfiguracionDetallesId($id)
	{
		$query = $this->db_almacen->query("select *		                                       
			                              from configuracion_detalles c
			                             where id = ".$id);
        return $query->result();
	}

	

    
}
?>