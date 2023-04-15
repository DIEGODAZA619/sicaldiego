--ALMACENES

CREATE SCHEMA administracion;
create table administracion.dominios
(
  id serial,
  concepto character varying(30),
  descripcion character varying(60),
  valor1 character varying(30),
  valor2 character varying(30),
  orden int,
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT dominios_pkey PRIMARY KEY (id)
);

CREATE SCHEMA configuraciones;

create table configuraciones.configuraciones
(
  id serial,
  gestion int,
  id_modulo int,
  concepto character varying(50),
  descripcion character varying(250),
  fecha_alta timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT dias_no_habiles_pkey PRIMARY KEY (id)
);

create table configuraciones.configuracion_detalles
(
  id serial,
  id_configuracion int,
  gestion int,
  concepto character varying(50),
  descripcion character varying(250),
  valor1 character varying(50),
  valor2 character varying(50),
  valor3 character varying(50),
  valor4 character varying(50),
  valor5 character varying(50),
  valor6 character varying(50),
  valor7 character varying(50),
  respaldo character varying(250),
  fecha_alta timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT configuracion_detalles_pkey PRIMARY KEY (id),
  CONSTRAINT configuracion_detalles_id_configuracion_fkey FOREIGN KEY (id_configuracion)
  REFERENCES configuraciones.configuraciones (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);


create table configuraciones.valor_configuracion
(
  id serial,
  id_configuracion int,
  campo character varying(15),
  descripcion character varying(250),
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT valor_configuracion_pkey PRIMARY KEY (id),
  CONSTRAINT valor_configuracion_id_configuracion_fkey FOREIGN KEY (id_configuracion)
  REFERENCES configuraciones.configuraciones (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

create table configuraciones.gestion
(
  id serial,
  gestion int,
  fecha_alta timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT gestion_pkey PRIMARY KEY (id)
);

insert into configuraciones.gestion(gestion)values(2022);

/** TABLAS DE ALMACEN **/
CREATE SCHEMA clasificacion;
--drop table clasificacion.unidades_medida
create table clasificacion.unidades_medida
(
  id serial,
  codigo character varying(10),
  descripcion character varying(250),
  valor1 character varying(30),
  valor2 character varying(30),
  fecha_registro timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT unidades_medida_pkey PRIMARY KEY (id)
);


--insert into clasificacion.unidades_medida (codigo,descripcion)values('CJA','CAJA');


--drop table clasificacion.categorias;
create table clasificacion.categorias
(
  id serial,
  codigo character varying(10),
  descripcion character varying(250),
  nivel int,
  padre int,
  ruta character varying(30),
  hijos character varying(30),
  fecha_registro timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT categorias_pkey PRIMARY KEY (id)
);

--insert into clasificacion.categorias (codigo,descripcion,nivel,padre,ruta,hijos)values();
--insert into clasificacion.categorias (codigo,descripcion,nivel,padre,ruta,hijos)values('31000'
--insert into clasificacion.categorias (codigo,descripcion,nivel,padre,ruta,hijos)values('31000','ALIMENTOS Y PRODUCTOS AGROFORESTALES',1,0,0,1);





CREATE SCHEMA material;
create table material.materiales
(
  id serial,
  id_entidad int,
  codigo character varying(10),
  descripcion character varying(500),
  id_unidad int,
  id_categoria int,
  fecha_registro timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT materiales_pkey PRIMARY KEY (id)
);

create table material.proveedores
(
  id serial,
  id_entidad int,
  codigo character varying(10),
  nombre_proveedor character varying(150),
  legal_proveedor character varying(150),
  nit character varying(150),
  correo character varying(150),
  celular character varying(150),
  direccion character varying(150),
  observaciones character varying(150),  
  fecha_registro timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(2) DEFAULT 'AC',
  CONSTRAINT proveedores_pkey PRIMARY KEY (id)
);

CREATE SCHEMA inventario;

--drop table inventario.ingresos;
create table inventario.ingresos
(
  id serial,
  id_entidad int,
  gestion int,
  order_compra character varying(100),
  nota_remision character varying(100),
  nro_factura character varying(20),  
  fecha_factura date,
  monto_total_factura float DEFAULT 0,
  id_provedor int,
  descripcion_ingreso text,  
  fecha_ingreso date, 
  id_funcionario_registro int,
  fecha_registro timestamp DEFAULT now(),
  id_funcionario_update int,
  fecha_modificacion timestamp,
  estado character varying(3) DEFAULT 'ELB',
  activo character varying(3) DEFAULT 'SI',
  CONSTRAINT ingresos_pkey PRIMARY KEY (id)
);

--drop table inventario.ingresos_detalle;
create table inventario.ingresos_detalle
(
  id serial,
  id_ingreso int,
  id_material int, 
  cantidad_ingreso float,
  precio_unitario  float,
  precio_total     float,
  id_funcionario_registro int,
  fecha_registro timestamp DEFAULT now(),
  id_funcionario_update int,
  fecha_modificacion timestamp,
  estado character varying(3) DEFAULT 'ELB',
  activo character varying(3) DEFAULT 'SI',
  CONSTRAINT ingresos_detalle_pkey PRIMARY KEY (id)
);


--drop table inventario.inventarios;
create table inventario.inventarios
(
  id serial,
  id_entidad int,  
  gestion int,
  id_ingreso int,
  id_ingreso_detalle int,
  id_salida int,
  id_salida_detalle int,
  id_material int,
  tipo_proceso text,
  tipo_ingreso_egreso text,
  cantidad_entrada int, 
  cantidad_salida  int,
  saldo            int,
  precio_unitario  numeric(8,2),
  precio_total     numeric(8,2),
  fecha            date,
  id_inventario    int,
  id_inventario_inicial_ingreso  int,
  id_funcionario_solicitante int,  
  id_funcionario_almacen int,  
  fecha_registro timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(3) DEFAULT 'AC',  
  CONSTRAINT inventarios_pkey PRIMARY KEY (id)
);



create table inventario.inventarios_resumen
(
  id serial,
  id_entidad int, 
  gestion    int,
  id_material int unique,
  cantidad_entrada int, 
  cantidad_salida  int,
  saldo            int,
  cantidad_solicitada int,
  cantidad_disponible int,
  fecha_registro timestamp DEFAULT now(),
  fecha_modificacion timestamp,
  estado character varying(3) DEFAULT 'AC',  
  CONSTRAINT inventarios_resumen_pkey PRIMARY KEY (id)
);


create table inventario.solicitudes
(
  id serial,
  id_funcionario int,
  id_dependencia int,
  id_subdependencia int,
  id_entidad int,
  id_confirmación_direccion int,
  gestion    int,
  id_material int,
  cantidad_solicitada int, 
  cantidad_autorizada int,
  tipo_solicitud      character varying(3),-- NOR NORMAL -- EME EMERGENCIA --- SGE SERVICIOS GENERALES   COM --- COMBUSTIBLE
  fecha_registro      timestamp DEFAULT now(),
  fecha_confirmacion  timestamp,
  fecha_aprobación    timestamp,
  fecha_autorizacion  timestamp,
  fecha_entrega       timestamp,
  fecha_modificacion  timestamp,
  estado character varying(3) DEFAULT 'PEN',  
  CONSTRAINT solicitudes_pkey PRIMARY KEY (id)
);



drop table inventario.solicitud_direccion;
create table inventario.solicitud_direccion
(
  id serial,  
  id_dependencia int,
  id_subdependencia int,
  id_entidad  int, 
  gestion     int,
  cantidad    int,
  cantidad_materiales int,
  correlativo int,
  cite text,  
  tipo_solicitud      character varying(3),-- NOR NORMAL -- EME EMERGENCIA --- SGE SERVICIOS GENERALES   COM --- COMBUSTIBLE
  id_funcionario_solicitante int,
  fecha_registro     timestamp DEFAULT now(),  
  fecha_aprobación   timestamp,
  fecha_autorizacion timestamp,
  fecha_entrega      timestamp,
  fecha_modificacion timestamp,
  estado character varying(3) DEFAULT 'CON',  
  CONSTRAINT solicitud_direccion_pkey PRIMARY KEY (id)
);









CREATE TRIGGER insertar_inventario_material 
 AFTER INSERT 
 ON material.materiales
 FOR EACH STATEMENT
 EXECUTE PROCEDURE insertar_inventario_material();

 CREATE OR REPLACE FUNCTION inventario.insertar_inventario_material()
 RETURNS TRIGGER AS $insertar_inventario_material$
  DECLARE  
    id_material_new integer; 
    id_entidad_new  integer; 

  BEGIN 
    id_material_new = NEW.id;
    id_entidad_new = NEW.id_entidad;
    insert into inventario.inventarios_resumen(id_entidad,id_material,cantidad_entrada,cantidad_salida,saldo,cantidad_solicitada,cantidad_disponible)
               values(id_entidad_new,id_material_new,0,0,0,0,0);
    RETURN NEW;
  END
$insertar_inventario_material$ LANGUAGE plpgsql;




insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','AC','ACTIVO',1);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','HI','HISTORICO',2);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','AN','ANULADO',3);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','BA','BAJA',4);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','CON','CONFIRMADO',5);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','PEN','PENDIENTE',6);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','REV','REVISADO',7);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','VER','VERIFICADO',8);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','IN','INICIADO',9);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','CS','CONSOLIDADO',10);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','RC','RECHAZADO',11);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','ELB','ELABORADO',12);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('ESTADO REGISTRO','TIPOS DE ESTADO DE LOS REGISTROS','APB','APROBADO',13);


insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO SOLICITUD','TIPOS DE SOLICITUD DE LOS MATERIALES','NOR','NORMAL',1);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO SOLICITUD','TIPOS DE SOLICITUD DE LOS MATERIALES','EME','EMERGENCIA',2);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO SOLICITUD','TIPOS DE SOLICITUD DE LOS MATERIALES','SGE','SERVICIOS GENERALES',3);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO SOLICITUD','TIPOS DE SOLICITUD DE LOS MATERIALES','COM','COMBUSTIBLE',4);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('TIPO SOLICITUD','TIPOS DE SOLICITUD DE LOS MATERIALES','AML','ALMACEN',5);

----NOR NORMAL -- EME EMERGENCIA --- SGE SERVICIOS GENERALES   COM --- COMBUSTIBLE
  fecha_registro timestamp DEFAULT now(),




insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','LP','LA PAZ',1);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','CB','COCHABAMBA',2);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','CH','CHUQUISACA',3);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','OR','ORURO',4);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','PT','POTOSI',5);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','TJ','TARIJA',6);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','SC','SANTA CRUZ',7);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','BE','BENI',8);
insert into administracion.dominios (concepto,descripcion,valor1,valor2,orden)values('DEPARTAMENTO','DEPARTAMENTO DE REGISTRO','PD','PANDO',9);

--- Nuevo FOTOGRAFIA - MATERIAL
CREATE TABLE material.fotografia
(
  id serial NOT NULL,
  id_material integer NOT NULL,
  descripcion_fotografia character varying(70),
  orden_fotos integer,
  ruta character varying(80),
  fecha_registro timestamp without time zone NOT NULL DEFAULT now(),
  estado character varying(2) DEFAULT 'AC'::character varying,
  CONSTRAINT fotografia_pkey PRIMARY KEY (id),
  CONSTRAINT fotografia_idmaterial_fkey FOREIGN KEY (id_material)
      REFERENCES material.materiales (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)




ALTER TABLE material.materiales ADD COLUMN ruta_imagen text;
ALTER TABLE material.materiales ADD COLUMN nombre_imagen text;


update inventario.inventarios_resumen set cantidad_entrada  = 0, cantidad_salida  = 0, saldo  = 0, cantidad_solicitada  = 0, cantidad_disponible = 0;
truncate table inventario.inventarios;

truncate table inventario.ingresos;

truncate table inventario.ingresos_detalle;

truncate table inventario.solicitudes;
truncate table inventario.solicitud_direccion;



create table administracion.correlativos
(
    id serial,    
    nombre_cite character varying(30), --completo - medio dia
    abreviatura character varying(3), --manhana tarde
    descripcion character varying(100), --manhana tarde    
    estado character varying(2) DEFAULT 'AC',    
    CONSTRAINT correlativos_pkey PRIMARY KEY (id)
);


create table administracion.correlativos_gestion
(
    id serial,    
    id_correlativo serial,
    gestion int,    
    correlativo int DEFAULT 0,
    fecha_registro timestamp DEFAULT now(),
    fecha_modificacion timestamp,   
    estado character varying(2) DEFAULT 'AC',    
    CONSTRAINT correlativos_gestion_pkey PRIMARY KEY (id),
    CONSTRAINT correlativos_gestion_id_correlativo_fkey FOREIGN KEY (id_correlativo)
    REFERENCES administracion.correlativos (id) MATCH SIMPLE
    ON UPDATE NO ACTION ON DELETE NO ACTION
);


create table administracion.cites_funcionarios
(
    id serial,        
    id_funcionario int,
    gestion int,     
    id_correlativo int,    
    correlativo int,   
    cite character varying(50),   
    fecha_registro timestamp DEFAULT now(),
    fecha_modificacion timestamp,    
    estado character varying(2) DEFAULT 'AC',    
    CONSTRAINT cites_funcionarios_pkey PRIMARY KEY (id)
    
);


/****** 02/03/2023 ********/
/* INSERTAR COLUMNA DE MOTIVO EN SOLICITUD */
ALTER TABLE inventario.solicitud_direccion  ADD COLUMN motivo text;