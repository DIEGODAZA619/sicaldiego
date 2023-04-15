<?php

function gestion_vigente()
{
  $fila =& get_instance();
  $fila->load->model('Configuracion_detalles_model');
  $gestion = $fila->Configuracion_detalles_model->getGestionVigente();
  $valorgestion = $gestion[0]->gestion;
  return $valorgestion;
}

function idMaximoTabla($tabla)
{
  $fila =& get_instance();
  $fila->load->model('Configuracion_detalles_model');  
  $datos = $fila->Configuracion_detalles_model->getIdMaximoTabla($tabla);
  if($datos)
  {
    return $datos[0]->id_max + 1;
  }
  else
  {
    return 1;
  }  
}

function descripcion_estados($valor)
{
  $fila =& get_instance();
  $fila->load->model('Configuracion_detalles_model');
  $concepto = 'ESTADO REGISTRO';
  $datos = $fila->Configuracion_detalles_model->getValoresDominiosConcepto($concepto,$valor);
  if($datos)
  {
    return $datos[0]->valor2;
  }
  else
  {
    return $valor;
  }
}


function descripcionDominiosValor($concepto,$valor)
{
  $fila =& get_instance();
  $fila->load->model('Configuracion_detalles_model');  
  $datos = $fila->Configuracion_detalles_model->getValoresDominiosConcepto($concepto,$valor);
  if($datos)
  {
    return $datos[0]->valor2;
  }
  else
  {
    return $valor;
  }
}


function descripcionProveedorValor($idProveedor)
{
  $fila =& get_instance();
  $fila->load->model('Configuracion_detalles_model');  
  $datos = $fila->Configuracion_detalles_model->getValoresProveedor($idProveedor);
  if($datos)
  {
    return $datos[0]->nombre_proveedor;
  }
  else
  {
    return $valor;
  }
}



function descripcionCategoriaValor($valor)
{
  $fila =& get_instance();
  $fila->load->model('Categorias_model');  
  $datos = $fila->Categorias_model->getCategoriaCodigo($valor);
  if($datos)
  {
    return $datos[0]->descripcion;
  }
  else
  {
    return "";
  }
}




function numeroIngresoAlmacen($id)
{
  $fila =& get_instance();
  $fila->load->model('Configuracion_detalles_model');  
  $datos = $fila->Configuracion_detalles_model->getnumeroIngresoAlmacen($id);
  if($datos)
  {
    return $datos[0]->correlativo;
  }
  else
  {
    return 0;
  }
}
function numeroSolicitudAlmacen($id)
{
  $fila =& get_instance();
  $fila->load->model('Configuracion_detalles_model');  
  $datos = $fila->Configuracion_detalles_model->getnumeroSolicitudAlmacen($id);
  if($datos)
  {
    return $datos[0]->correlativo;
  }
  else
  {
    return 0;
  }
}


function dependenciaSolicitudAlmacen($id)
{
  $fila =& get_instance();
  $fila->load->model('Configuracion_detalles_model');  
  $datos = $fila->Configuracion_detalles_model->getnumeroSolicitudAlmacen($id);
  if($datos)
  {
    return $datos[0]->id_dependencia;
  }
  else
  {
    return 0;
  }
}








function dependenciasFuncionario()
{
    $fila =& get_instance();
    $idDependencia        = $fila->session->userdata('id_dependencia_principal');
    $idSubDependencia       = $fila->session->userdata('id_subdependencia_principal');
    $idDependenciaSecundario  = $fila->session->userdata('id_dependencia_secundario');
    $idSubdependenciaSecundario = $fila->session->userdata('id_subdependencia_secundario');   

    if(strlen($idDependenciaSecundario) > 0)
    {
      
      if($idDependencia != $idDependenciaSecundario)
      {
        $idDependencia    = $idDependenciaSecundario;
        if(strlen($idSubdependenciaSecundario) > 0)
        {
          $idSubDependencia = $idSubdependenciaSecundario;
        }
        else
        {
          $idSubDependencia = 0;
        }  
      }
      else
      {
        if(strlen($idDependencia) > 0)
        {
          $idDependencia = $idDependencia;
          if(strlen($idSubDependencia) > 0)
          {
            $idSubDependencia = $idSubDependencia;
          }
          else
          {
            $idSubDependencia = 0;
          }
        }
      }
    }
    else
    {
      if(strlen($idDependencia) > 0)
      {
        $idDependencia    = $idDependencia;
        if(strlen($idSubDependencia) > 0)
        {
          $idSubDependencia = $idSubDependencia;
        }
        else
        {
          $idSubDependencia = 0;
        }
      }
    }

    $resul = 1;
    $mensaje = "OK";
    $resultado ='[{         
          "dependencia":"'.$idDependencia.'",
          "SubDependencia":"'.$idSubDependencia.'",
          "resultado":"'.$resul.'",
          "mensaje":"'.$mensaje.'"
          }]';
  return $resultado;
}

function actualizarInventarioResumen($id_material,$cantidad,$tipoProceso)
{
  $fila =& get_instance();
  $fila->load->model('ingresos_model');
  $fechaHora = getFechaHoraActual();
  $resumen = $fila->ingresos_model->getInventarioResumenId($id_material);
  $id_registro       = $resumen[0]->id;
  $cantidad_entrada    = $resumen[0]->cantidad_entrada;
  $cantidad_salida   = $resumen[0]->cantidad_salida;
  $saldo         = $resumen[0]->saldo;
  $cantidad_solicitada = $resumen[0]->cantidad_solicitada;
  $cantidad_disponible = $resumen[0]->cantidad_disponible;
  switch ($tipoProceso)
  {
    case "INGRESO":
      $cantidad_entrada     = $cantidad_entrada + $cantidad;
      $saldo          = $cantidad_entrada - $cantidad_salida;
      $cantidad_disponible  = $saldo - $cantidad_solicitada;
      break;

    case "SALIDA":
      $cantidad_salida    = $cantidad_salida + $cantidad;
      $saldo          = $cantidad_entrada - $cantidad_salida;
      $cantidad_solicitada  = $cantidad_solicitada - $cantidad;
      $cantidad_disponible  = $saldo - $cantidad_solicitada;
      break;

    case "SOLICITUD":       
      $cantidad_solicitada  = $cantidad_solicitada + $cantidad;
      $cantidad_disponible  = $saldo - $cantidad_solicitada;
      break;
  }
  $dataUpdate = array(     
      'cantidad_entrada'  => $cantidad_entrada,
      'cantidad_salida'   => $cantidad_salida,
      'saldo'       => $saldo,
      'cantidad_solicitada' => $cantidad_solicitada,
      'cantidad_disponible' => $cantidad_disponible
      );
  $idUpdateIngreso = $fila->ingresos_model->updateInventarioResumen($id_registro,$dataUpdate);

  return $idUpdateIngreso;


}

function actualizarCantidadInventario($id_material)
{
  $fila =& get_instance();
  $fila->load->model('solicitudes_model');
  $fila->load->model('ingresos_model');
  $fechaHora = getFechaHoraActual();
  $resumenSolicitudes          = $fila->solicitudes_model->getcantidadSolicitadaMaterial($id_material);
  $cantidad_solicitada_reserva = $resumenSolicitudes[0]->cantidad_solicitada;


  $resumen              = $fila->ingresos_model->getInventarioResumenId($id_material);
  $id_registro          = $resumen[0]->id;
  $cantidad_entrada     = $resumen[0]->cantidad_entrada;
  $cantidad_salida      = $resumen[0]->cantidad_salida;
  $saldo                = $resumen[0]->saldo;
  $cantidad_solicitada  = $resumen[0]->cantidad_solicitada;
  $cantidad_disponible  = $resumen[0]->cantidad_disponible;

  $cantidad_solicitada  = $cantidad_solicitada_reserva;
  $cantidad_disponible  = $saldo - $cantidad_solicitada;
  
  $dataUpdate = array(     
      'cantidad_entrada'    => $cantidad_entrada,
      'cantidad_salida'     => $cantidad_salida,
      'saldo'               => $saldo,
      'cantidad_solicitada' => $cantidad_solicitada,
      'cantidad_disponible' => $cantidad_disponible
      );
  $idUpdateIngreso = $fila->ingresos_model->updateInventarioResumen($id_registro,$dataUpdate);
  return $idUpdateIngreso;
}










function mdate($datestr = '', $time = '')
{
  if ($datestr === '')
  {
    return '';
  }
  elseif (empty($time))
  {
    $time = now();
  }

  $datestr = str_replace(
    '%\\',
    '',
    preg_replace('/([a-z]+?){1}/i', '\\\\\\1', $datestr)
  );

  return date($datestr, $time);
}



function diferencia_dias($fechaUno, $fechaDos)
{
  $fecha1= new DateTime($fechaUno);
  $fecha2= new DateTime($fechaDos);
  $diff = $fecha1->diff($fecha2);

  // El resultados sera 3 dias
  return $diff->days;
}



function getFechaHoraActual()
{
  $hoy = date("Y-m-d h:m:s"); //fecha de hoy
  return $hoy;
}

function getFechaActual()
{
  $hoy = date("Y-m-d"); //fecha de hoy
  return $hoy;
}

function getHoraActual()
{
  $hoy = date("h:m"); //fecha de hoy
  return $hoy;
}

function formato_fecha($fecha)
{
    if($fecha)
    {
      $timestamp = strtotime($fecha);
      return date('d-m-Y', $timestamp);
    }
    else
    {
      return "";
    }
}
function formato_fecha_slash($fecha)
{
    if($fecha)
    {
      $timestamp = strtotime($fecha);
      return date('d/m/Y', $timestamp);
    }
    else
    {
      return "";
    }
}
function formato_fecha_hora($fecha)
{
    if($fecha)
    {
      $timestamp = strtotime($fecha);
      return date('d-m-Y H:i:s', $timestamp);
    }
    else
    {
      return "";
    }
}

function formato_fecha_dia($fecha)
{
    if($fecha)
    {
      $timestamp = strtotime($fecha);
      //$GetD = getdate();
      $verd = array(
                1=>"Lunes",2=>"Martes",3=>"Miércoles",4=>"Jueves",5=>"Viernes",6=>"Sábado",0=>"Domingo"
      );
      $verm = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",
          8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"
      );

      //return $verd[$GetD['wday']].", ".$GetD['mday']." de ".$verm[$GetD['mon']]." del ".$GetD['year'];
      return " ".$verd[date('w', $timestamp)]." ".date('d', $timestamp)." de ".$verm[(int)date('m', $timestamp)]." de ".date('Y', $timestamp);
    }
    else
    {
      return "";
    }
}

function fechacompleta2($fecha)
{
    if($fecha)
    {
      $timestamp = strtotime($fecha);
      //$GetD = getdate();
      $verd = array(
                1=>"Lunes",2=>"Martes",3=>"Miércoles",4=>"Jueves",5=>"Viernes",6=>"Sábado",0=>"Domingo"
      );
      $verm = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",
          8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"
      );

      //return $verd[$GetD['wday']].", ".$GetD['mday']." de ".$verm[$GetD['mon']]." del ".$GetD['year'];
      return " ".date('d', $timestamp)." de ".$verm[(int)date('m', $timestamp)]." de ".date('Y', $timestamp);
    }
    else
    {
      return "";
    }
}
function formato_fecha_dia_hora($fecha)
{
    if($fecha)
    {
      $timestamp = strtotime($fecha);
      $verd = array(
                1=>"Lunes",2=>"Martes",3=>"Mi&eacute;rcoles",4=>"Jueves",5=>"Viernes",6=>"Sábado",0=>"Domingo"
      );
      $verm = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",
          8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"
      );
      return " ".$verd[date('w', $timestamp)]." ".date('d', $timestamp)." de ".$verm[date('m', $timestamp)]." de ".date('Y', $timestamp)."  Hora:  ".date('H:i:s', $timestamp);
    }
    else
    {
      return "";
    }
}
function formato_fecha_dia_hora_meses_con_cero($fecha)
{
    if($fecha)
    {
      $timestamp = strtotime($fecha);
      $verd = array(
                1=>"Lunes",2=>"Martes",3=>"Mi&eacute;rcoles",4=>"Jueves",5=>"Viernes",6=>"Sábado",0=>"Domingo"
      );
      $verm = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio",
          "08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre"
      );
      return $verd[date('w', $timestamp)]." ".date('d', $timestamp)." de ".$verm[date('m', $timestamp)]." de ".date('Y', $timestamp).", Hora: ".date('H:i:s', $timestamp);
    }
    else
    {
      return "";
    }
}

 ?>