
insert into aplicaciones.aplicaciones(id_entidad,nombre_aplicacion,abreviatura,descripcion_aplicacion,user_administrador)
values (1,'SISTEMA DE CONTROL DE ALMACENES', 'SICAL','SISTEMA DE GESTION DE ALMACEN','SI');

-----------MODULOS
insert into aplicaciones.modulos(id_aplicacion,nombre_modulo,abreviatura_modulo,descripcion_modulo)
values (3,'INICIO','INI','DESPLIEGA INFORMACION DE INICIO');

insert into aplicaciones.modulos(id_aplicacion,nombre_modulo,abreviatura_modulo,descripcion_modulo)
values (3,'INGRESO MATERIALES','INM','PERMITE EL REGISTRO DE INGRESO A ALMACEN');

insert into aplicaciones.modulos(id_aplicacion,nombre_modulo,abreviatura_modulo,descripcion_modulo)
values (3,'CLASIFICACIONES','CLS','PERMITE EL REGISTRO DE LA CLASIFIACION DE MATERIALES');

insert into aplicaciones.modulos(id_aplicacion,nombre_modulo,abreviatura_modulo,descripcion_modulo)
values (3,'CONTROL DE MATERIALES','INM','PERMITE EL REGISTRO DE CONTROL MATERIALES');

insert into aplicaciones.modulos(id_aplicacion,nombre_modulo,abreviatura_modulo,descripcion_modulo)
values (3,'SOLICITUD DE MATERIALES','SOM','PERMITE EL REGISTRO DE SOLICITUD DE MATERIALES');


insert into aplicaciones.modulos(id_aplicacion,nombre_modulo,abreviatura_modulo,descripcion_modulo)
values (3,'REPORTES','REP','PERMITE GENEREAR REPORTE DE MATERIALES');

---------- ROL


ALTER TABLE aplicaciones.rol  alter COLUMN tipo_rol type character varying(5);

insert into aplicaciones.rol (id_aplicacion,rol,tipo_rol) values (3,'DIRECTOR','DIR');--1
insert into aplicaciones.rol (id_aplicacion,rol,tipo_rol) values (3,'ADMINISTRADOR','ADM');--2
insert into aplicaciones.rol (id_aplicacion,rol,tipo_rol) values (3,'RESPONSABLE ALMACEN','RESP');--3
insert into aplicaciones.rol (id_aplicacion,rol,tipo_rol) values (3,'SOLICITANTE','SOLC');--4




ALTER TABLE aplicaciones.opciones ADD COLUMN id_aplicacion int;
update aplicaciones.opciones set id_aplicacion = 1;

------REGISTRAR OPCIONES RELACIONADAS AL MODULO
--NIVEL 0
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (35,71,'INICIO','Inicio','',0,1,3);

--NIVEL 1
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (36,72,'INGRESO MATERIALES','','',1,0,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (37,73,'CLASIFIACION','','',1,0,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (38,74,'MATERIALES','','',1,0,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'SOLICITUD MATERIALES','','',1,0,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (40,76,'REPORTES','','',1,0,3);
--NIVEL 2
--INGRESOS

--para opciones de nivel 2 primero registrar el del nivel 1 para el campo codigo_opciones
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (36,72,'REGISTRAR INGRESO','Ingreso/Ingreso','',2,1,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (36,72,'APROBACIÓN DE INGRESO','Ingreso/Aprobacion','',2,2,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (36,72,'REPORTES DE INGRESO','Ingreso/Reportes','',2,3,3);

--CLASIFICACION
--para opciones de nivel 2 primero registrar el del nivel 1 para el campo codigo_opciones
--insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (37,73,'NRO. PARTIDAS','Clasificacion/Partidas','',2,1,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (37,73,'CATEGORIAS','Clasificacion/Categorias','',2,1,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (37,73,'UNIDADES DE MEDIDA','Clasificacion/Unidades','',2,2,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (37,73,'CATEGORIAS','Clasificacion/Categorias','',2,3,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (37,73,'MATERIALES','Materiales/Materiales','',2,4,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (37,73,'PROVEEDORES', 'Materiales/Proveedores', '', 2, 5,3);


--SOLICITUD_MATERIALES


insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'SOLICITUD MATERIAL','Solicitudes/Solicitudes','',2,1,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'CONFIRMACIÓN PEDIDO <BR> ÁREA / UNIDAD','Solicitudes/Confirmar_direccion','',2,2,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'APROBAR SOLICITUDES','Solicitudes/Aprobar_solicitud','',2,3,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'AUTORIZAR SOLICITUDES','Solicitudes/Autorizar_solicitud','',2,4,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'ENTREGA SOLICITUDES','Solicitudes/Entrega_solicitud','',2,5,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'REPORTE ENTREGAS','Solicitudes/Reporte_entregas','',2,6,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'RESERVA ALMACEN','Solicitudes/Presolicitud_almacen','',2,7,3);
insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (39,75,'HISTORIAL DE SOLICITUDES','Solicitudes/Historial','',2,8,3);



insert into aplicaciones.opciones(id_modulo,codigo_opciones,opcion,link,icono,nivel,orden,id_aplicacion)values (40,76,'REPORTE INVENTARIO','Reportes/Reportes','',2,1,3);





--insert usuario

insert into seguridad.usuarios (id_persona,login,password)values(1,'diego.daza','e10adc3949ba59abbe56e057f20f883e');


--registrar usuario en aplicacion
insert into seguridad.usuarios_aplicaciones(id_aplicacion,id_usuario)values(3,1);


--registrar usuario en usuarios_roles
insert into seguridad.usuarios_roles(id_aplicacion_usuario,id_usuario,id_rol)values(3,1,2);



insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','AC','ACTIVO',1);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','HI','HISTORICO',2);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','AN','ANULADO',3);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','BA','BAJA',4);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','CO','CONFIRMADO',5);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','PE','PENDIENTE',6);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','RE','REVISADO',7);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','VE','VERIFICADO',8);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','IN','INICIADO',9);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','CS','CONSOLIDADO',10);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','RC','RECHAZADO',11);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','ELB','ELABORADO',12);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','APB','APROBADO',13);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','AUT','AUTORIZADO',14);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','ENT','ENTREGADO',14);






insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','LP','LA PAZ',1);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','CB','COCHABAMBA',2);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','CH','CHUQUISACA',3);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','OR','ORURO',4);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','PT','POTOSI',5);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','TJ','TARIJA',6);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','SC','SANTA CRUZ',7);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','BE','BENI',8);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','PD','PANDO',9);


insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO PROCESO','DESCRIPCION MOVIMIENTOS INVENTARIO','INGI','INGRESO INCIAL',1);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO PROCESO','DESCRIPCION MOVIMIENTOS INVENTARIO','INGP','INGRESO MATERIAL',2);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO PROCESO','DESCRIPCION MOVIMIENTOS INVENTARIO','INGS','ACTUALIZACIÓN SALDOS',3);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO PROCESO','DESCRIPCION MOVIMIENTOS INVENTARIO','SOLM','SOLICITUD MATERIAL',4);



