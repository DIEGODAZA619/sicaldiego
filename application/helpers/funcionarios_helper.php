<?php
function datos_persona($id)
{
  $fila =& get_instance();
  $fila->load->model('Funcionarios_model');
  $datos = $fila->Funcionarios_model->datosPersonas($id);
  if($datos)
  {
    return $datos;
  }
  else
  {
    return "";
  }
}

function datos_persona_nombre($id)
{
  $fila =& get_instance();
  $fila->load->model('Funcionarios_model');
  $datos = $fila->Funcionarios_model->datosPersonas($id);
  if($datos)
  {
    return $datos[0]->nombres." ".$datos[0]->primer_apellido." ".$datos[0]->segundo_apellido ;
  }
  else
  {
    return "";
  }
}

function nombre_estructura($iddireccion)
  {
    $fila = &get_instance();
    $fila->load->model('funcionarios_model');
    $persona = $fila->funcionarios_model->estructura_id($iddireccion);
    $nombre = $persona[0]->nombre_dependencia;
    return $nombre;
  }
  function sigla_estrucctura($iddireccion)
  {
    $fila = &get_instance();
    $fila->load->model('funcionarios_model');
    $persona = $fila->funcionarios_model->estructura_id($iddireccion);
    $nombre = $persona[0]->sigla_dependencia;
    return $nombre;
  }

function nombre_subestructura($subdireccion)
  {
    $fila = &get_instance();
    $fila->load->model('funcionarios_model');
    $persona = $fila->funcionarios_model->subestructura_id($subdireccion);
    if($persona)
    {
      $nombre = $persona[0]->nombre_subdependencia;  
    }
    else
    {
      $nombre = "";
    }
    
    return $nombre;
  }




function datosDependenciaPersonal($id)
{
  $fila =& get_instance();
  $fila->load->model('Funcionarios_model');
  $datos = $fila->Funcionarios_model->datosPersonalesDependencia($id);
  if($datos)
  {
    return $datos[0]->nombre_dependencia."<br>".$datos[0]->nombres." ".$datos[0]->primer_apellido." ".$datos[0]->segundo_apellido;
  }
  else
  {
    return "";
  }
}


?>