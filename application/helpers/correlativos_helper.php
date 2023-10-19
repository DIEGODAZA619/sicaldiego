<?php
function obtenerCiteGestion($id_funcionario,$gestion,$tipoCorrelativo)
{
  	$fila =& get_instance();
  	$fila->load->model('Cites_model');
  	$corre = $fila->Cites_model->getCorrelativoAbreviatura($tipoCorrelativo);
  	$id_correlativo = $corre[0]->id;

  	//$correindi = $fila->Cites_model->getcorrelativociteindividualVacaciones($id_funcionario,$tipoCorrelativo2);

  	$corregeneral = $fila->Cites_model->getcorrelativocite($gestion,$id_correlativo);  	
	$correGestion = $corregeneral[0]->correlativo + 1;
	$cites        = "SNPE/ALM/".$tipoCorrelativo."-".$correGestion."/".$gestion;
  	$resul = 1;
	$mensaje = "OK";
  	$resultado ='[{					
					"correGestion":"'.$correGestion.'",
					"cites":"'.$cites.'",
					"resultado":"'.$resul.'",
					"mensaje":"'.$mensaje.'"
					}]';
	return $resultado;
}

function guardarCite($id_funcionario,$tipo,$correGestion,$cite,$gestion,$fecha)
{
	$fila =& get_instance();
  	$fila->load->model('Cites_model');
	$corre = $fila->Cites_model->getCorrelativoAbreviatura($tipo);
	$id_correlativo = $corre[0]->id;	
	$dataUpdate = array(   					
   					'correlativo' 	  	    => $correGestion,
   					'fecha_modificacion'    => $fecha,
					);

	$data = array(
   					'id_funcionario'    => $id_funcionario,
   					'gestion' 	  	    => $gestion,
   					'id_correlativo'    => $id_correlativo,
   					'correlativo'    	=> $correGestion,
   					'cite'    			=> $cite
					);

	$fila->Cites_model->updateCorrelativosGestion($id_correlativo,$gestion,$dataUpdate);
	$fila->Cites_model->guardarCitesFuncionarios($data);

	return $tipo;
}


function obtenerCiteBoletas($id_funcionario,$gestion,$tipoCorrelativo,$tipoCorrelativo2)
{
  	$fila =& get_instance();
  	$fila->load->model('Cites_model');
  	$corre = $fila->Cites_model->getCorrelativoAbreviatura($tipoCorrelativo);
  	$id_correlativo = $corre[0]->id;

  	$correindi = $fila->Cites_model->getcorrelativociteindividualBoleta($id_funcionario,$tipoCorrelativo2);

  	$corregeneral = $fila->Cites_model->getcorrelativocite($gestion,$id_correlativo);
  	$correIndividual= $correindi[0]->correlativo + 1;
	$correGestion 	= $corregeneral[0]->correlativo + 1;
	$cites 			= "SNPE/RRHH/".$tipoCorrelativo."-".$correGestion."/".$tipoCorrelativo2."-".$correIndividual."/".$gestion;
  	$resul = 1;
	$mensaje = "OK";
  	$resultado ='[{
					"correIndividual":"'.$correIndividual.'",
					"correGestion":"'.$correGestion.'",
					"cites":"'.$cites.'",
					"resultado":"'.$resul.'",
					"mensaje":"'.$mensaje.'"
					}]';
	return $resultado;
}


function obtenerCitePermisos($id_funcionario,$gestion,$tipoCorrelativo,$tipoCorrelativo2)
{
  	$fila =& get_instance();
  	$fila->load->model('Cites_model');
  	$corre = $fila->Cites_model->getCorrelativoAbreviatura($tipoCorrelativo);
  	$id_correlativo = $corre[0]->id;

  	$correindi = $fila->Cites_model->getcorrelativociteindividualPermisos($id_funcionario,$tipoCorrelativo2);

  	$corregeneral = $fila->Cites_model->getcorrelativocite($gestion,$id_correlativo);
  	$correIndividual= $correindi[0]->correlativo + 1;
	$correGestion 	= $corregeneral[0]->correlativo + 1;
	$cites 			= "SNPE/RRHH/".$tipoCorrelativo."-".$correGestion."/".$tipoCorrelativo2."-".$correIndividual."/".$gestion;
  	$resul = 1;
	$mensaje = "OK";
  	$resultado ='[{
					"correIndividual":"'.$correIndividual.'",
					"correGestion":"'.$correGestion.'",
					"cites":"'.$cites.'",
					"resultado":"'.$resul.'",
					"mensaje":"'.$mensaje.'"
					}]';
	return $resultado;
}



?>