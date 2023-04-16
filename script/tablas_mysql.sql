CREATE TABLE cites_funcionarios
(
  id serial NOT NULL,
  id_funcionario integer,
  gestion integer,
  id_correlativo integer,
  correlativo integer,
  cite varchar(50),
  fecha_registro datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT cites_funcionarios_pkey PRIMARY KEY (id)
);

CREATE TABLE correlativos
(
  id serial NOT NULL,
  nombre_cite varchar(30),
  abreviatura varchar(3),
  descripcion varchar(100),
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT correlativos_pkey PRIMARY KEY (id)
)

CREATE TABLE correlativos_gestion
(
  id serial NOT NULL,
  id_correlativo integer NOT NULL,
  gestion integer,
  correlativo integer DEFAULT 0,
  fecha_registro datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT correlativos_gestion_pkey PRIMARY KEY (id)
);



CREATE TABLE dominios
(
  id serial NOT NULL,
  concepto varchar(30),
  descripcion varchar(60),
  valor1 varchar(30),
  valor2 varchar(30),
  orden integer,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT dominios_pkey PRIMARY KEY (id)
);





CREATE TABLE materiales
(
  id serial NOT NULL,
  id_entidad integer,
  codigo varchar(10),
  descripcion varchar(500),
  id_unidad integer,
  id_categoria integer,
  fecha_registro datetime DEFAULT now(),
  fecha_modificacion datetime DEFAULT null,
  estado varchar(2) DEFAULT 'AC',
  ruta_imagen text,
  nombre_imagen text,
  CONSTRAINT materiales_pkey PRIMARY KEY (id)
);


CREATE TABLE categorias
(
  id serial NOT NULL,
  codigo varchar(10),
  descripcion varchar(250),
  nivel integer,
  padre integer,
  ruta varchar(30),
  hijos varchar(30),
  fecha_registro datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(2) DEFAULT 'AC',
  sigla varchar(5),
  CONSTRAINT categorias_pkey PRIMARY KEY (id)
);

CREATE TABLE categorias_auxiliar
(
  id serial NOT NULL,
  codigo varchar(10),
  descripcion varchar(250),
  nivel integer,
  padre integer,
  ruta varchar(30),
  hijos varchar(30),
  fecha_registro datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(2) DEFAULT 'AC',
  sigla varchar(5)
);


CREATE TABLE unidades_medida
(
  id serial NOT NULL,
  codigo varchar(10),
  descripcion varchar(250),
  valor1 varchar(30),
  valor2 varchar(30),
  fecha_registro datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT unidades_medida_pkey PRIMARY KEY (id)
);


CREATE TABLE gestion
(
  id serial NOT NULL,
  gestion integer,
  fecha_alta datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT gestion_pkey PRIMARY KEY (id)
);


CREATE TABLE ingresos
(
  id serial NOT NULL,
  id_entidad integer,
  gestion integer,
  order_compra varchar(100),
  nota_remision varchar(100),
  nro_factura varchar(50),
  fecha_factura date,
  monto_total_factura double precision DEFAULT 0,
  id_provedor integer,
  descripcion_ingreso text,
  fecha_ingreso date,
  id_funcionario_registro integer,
  fecha_registro datetime  DEFAULT now(),
  id_funcionario_update integer,
  fecha_modificacion datetime ,
  estado varchar(3) DEFAULT 'ELB',
  activo varchar(3) DEFAULT 'SI',
  correlativo integer,
  cite text,
  fecha_nota_remision date,
  CONSTRAINT ingresos_pkey PRIMARY KEY (id)
);


CREATE TABLE ingresos_detalle
(
  id serial NOT NULL,
  id_ingreso integer,
  id_material integer,
  cantidad_ingreso double precision,
  precio_unitario double precision,
  precio_total double precision,
  id_funcionario_registro integer,
  fecha_registro datetime  DEFAULT now(),
  id_funcionario_update integer,
  fecha_modificacion datetime ,
  estado varchar(3) DEFAULT 'ELB',
  activo varchar(3) DEFAULT 'SI',
  CONSTRAINT ingresos_detalle_pkey PRIMARY KEY (id)
);

CREATE TABLE inventarios
(
  id serial NOT NULL,
  id_entidad integer,
  gestion integer,
  id_ingreso integer,
  id_ingreso_detalle integer,
  id_salida integer,
  id_salida_detalle integer,
  id_material integer,
  tipo_proceso text,
  tipo_ingreso_egreso text,
  cantidad_entrada double precision,
  cantidad_salida double precision,
  saldo double precision,
  precio_unitario double precision,
  precio_total double precision,
  fecha date,
  id_inventario integer,
  id_funcionario_solicitante integer,
  id_funcionario_almacen integer,
  fecha_registro datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(3) DEFAULT 'AC',
  id_inventario_inicial_ingreso integer,
  id_inventario_ingresos integer,
  CONSTRAINT inventarios_pkey PRIMARY KEY (id)
);




CREATE TABLE inventarios_resumen
(
  id serial NOT NULL,
  id_entidad integer,
  gestion integer,
  id_material integer,
  cantidad_entrada double precision,
  cantidad_salida double precision,
  saldo double precision,
  cantidad_solicitada double precision,
  cantidad_disponible double precision,
  fecha_registro datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(3) DEFAULT 'AC',
  CONSTRAINT inventarios_resumen_pkey PRIMARY KEY (id),
  CONSTRAINT inventarios_resumen_id_material_key UNIQUE (id_material)
);



CREATE TABLE solicitud_direccion
(
  id serial NOT NULL,
  id_dependencia integer,
  id_subdependencia integer,
  id_entidad integer,
  gestion integer,
  cantidad double precision,
  cantidad_materiales double precision,
  correlativo integer,
  cite text,
  tipo_solicitud varchar(3),
  id_funcionario_solicitante integer,
  fecha_registro datetime  DEFAULT now(),
  fecha_aprobacion datetime ,
  fecha_autorizacion datetime ,
  fecha_entrega datetime ,
  fecha_modificacion datetime ,
  estado varchar(3) DEFAULT 'CON',
  id_funcionario_aprobador integer,
  id_funcionario_autorizador integer,
  id_funcionario_entregas integer,
  motivo text,
  CONSTRAINT solicitud_direccion_pkey PRIMARY KEY (id)
);



CREATE TABLE solicitudes
(
  id serial NOT NULL,
  id_funcionario integer,
  id_dependencia integer,
  id_subdependencia integer,
  id_entidad integer,
  id_confirmacion_direccion integer,
  gestion integer,
  id_material integer,
  cantidad_solicitada double precision,
  cantidad_autorizada double precision,
  tipo_solicitud varchar(3),
  fecha_registro datetime  DEFAULT now(),
  fecha_autorizacion datetime ,
  fecha_aprobacion datetime ,
  fecha_entrega datetime ,
  fecha_modificacion datetime ,
  estado varchar(3) DEFAULT 'PEN',
  fecha_confirmacion datetime ,
  id_usuario_rechazo integer,
  CONSTRAINT solicitudes_pkey PRIMARY KEY (id)
);


CREATE TABLE proveedores
(
  id serial NOT NULL,
  id_entidad integer,
  codigo varchar(10),
  nombre_proveedor varchar(150),
  legal_proveedor varchar(150),
  nit varchar(150),
  correo varchar(150),
  celular varchar(150),
  direccion varchar(150),
  observaciones varchar(150),
  fecha_registro datetime  DEFAULT now(),
  fecha_modificacion datetime ,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT proveedores_pkey PRIMARY KEY (id)
);



CREATE TABLE aplicaciones
(
  id serial NOT NULL,
  id_entidad integer,
  nombre_aplicacion varchar(120),
  abreviatura varchar(120),
  descripcion_aplicacion varchar(120),
  user_administrador varchar(4),
  valor1 varchar(100),
  valor2 varchar(100),
  valor3 varchar(100),
  valor4 varchar(100),
  valor5 varchar(100),
  valor6 varchar(100),
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT aplicaciones_pkey PRIMARY KEY (id) 
);


CREATE TABLE modulos
(
  id serial NOT NULL,
  id_aplicacion integer,
  nombre_modulo varchar(120),
  abreviatura_modulo varchar(20),
  descripcion_modulo varchar(200),
  valor1 varchar(100),
  valor2 varchar(100),
  valor3 varchar(100),
  valor4 varchar(100),
  valor5 varchar(100),
  valor6 varchar(100),
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT modulos_pkey PRIMARY KEY (id)
)

CREATE TABLE opciones
(
  id serial NOT NULL,
  id_modulo integer,
  codigo_opciones integer,
  opcion varchar(100),
  link varchar(100),
  icono varchar(50),
  nivel integer,
  orden integer,
  estado varchar(2) DEFAULT 'AC',
  id_aplicacion integer,
  CONSTRAINT opciones_pkey PRIMARY KEY (id)
 
)

CREATE TABLE entidad
(
  id serial NOT NULL,
  nombre_entidad varchar(120),
  sigla varchar(20),
  direccion varchar(120),
  fecha_aniversario date,
  telefono varchar(15),
  telefono2 varchar(15),
  direccionweb varchar(100),
  nro_nit varchar(15),
  logo varchar(15),
  valor1 varchar(100),
  valor2 varchar(100),
  valor3 varchar(100),
  valor4 varchar(100),
  valor5 varchar(100),
  valor6 varchar(100),
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT entidad_pkey PRIMARY KEY (id)
);



CREATE TABLE entidad_aplicacion
(
  id serial NOT NULL,
  id_entidad integer,
  id_aplicacion integer,  
  fecha_alta datetime DEFAULT now(),
  fecha_modificacion datetime,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT entidad_aplicacion_pkey PRIMARY KEY (id)
);

CREATE TABLE usuarios
(
  id serial NOT NULL,
  id_persona integer,
  id_entidad integer,
  login varchar(20),
  password varchar(150),
  tipo_usuario varchar(50),
  fecha_alta datetime DEFAULT now(),
  fecha_modificacion datetime,
  estado varchar(2) DEFAULT 'EX',
  fecha_expiracion date,
  CONSTRAINT usuarios_pkey PRIMARY KEY (id)
);


CREATE TABLE usuarios_opciones
(
  id serial NOT NULL,
  id_opcion integer,
  id_usuario integer,
  tipo_opcion varchar(3) DEFAULT 'ROL',
  fecha_alta datetime DEFAULT now(),
  fecha_modificacion datetime,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT usuarios_opciones_pkey PRIMARY KEY (id),  
);




CREATE TABLE funcionario
(
  id serial NOT NULL,
  id_entidad integer,
  tipo_documento varchar(2),
  numero_documento integer,
  complemento varchar(5),
  extension varchar(2),
  nombres varchar(250),
  primer_apellido varchar(50),
  segundo_apellido varchar(50),
  estado_civil varchar(2),
  fecha_nacimiento date,
  lugar_nacimiento varchar(3),
  sexo varchar(2),
  numero_celular integer,
  domicilio text,
  zona text,
  email_personal text,
  profesion varchar(10),
  numero_cuenta varchar(15),
  afp varchar(2),
  nua_cua varchar(15),
  fecha_registro datetime DEFAULT now(),
  fecha_modificacion datetime,
  estado varchar(2) DEFAULT 'AC',
  foto boolean DEFAULT false,
  extension_foto varchar(5),
  banco varchar(4),
  libreta_militar varchar(50),
  CONSTRAINT funcionario_pkey PRIMARY KEY (id)
)
---------------------------------



CREATE TABLE puesto_funcionario
(
  id serial NOT NULL,
  id_funcionario integer,
  id_puesto integer,
  fecha_alta date,
  fecha_baja date,
  fecha_registro datetime DEFAULT now(),
  fecha_modificacion datetime,
  estado varchar(2) DEFAULT 'AC',
  CONSTRAINT puesto_funcionario_pkey PRIMARY KEY (id)
)


CREATE TABLE puesto
(
  id serial NOT NULL, 
  id_entidad integer, 
  nombre_puesto varchar(100),
  numero_item integer,
  id_dependencia integer,
  id_subdependencia integer,
  tipo_puesto varchar(3),
  fecha_registro datetime DEFAULT now(),
  fecha_modificacion datetime,
  estado varchar(4) DEFAULT 'ASIG',
  nivel_dependencia varchar(3),
  CONSTRAINT puesto_pkey PRIMARY KEY (id)
  
)



CREATE TABLE control_access
(
  id serial NOT NULL,
  id_usuario integer,
  aplicacion integer,
  ip varchar(20),
  fecha_ingreso datetime DEFAULT now(),
  estado varchar(5)
);



CREATE TABLE dependencia
(
  id serial NOT NULL,
  nombre_dependencia text NOT NULL,
  sigla varchar(10),
  orden integer,
  id_ubicacion_dependencia integer,
  sede_trabajo varchar(2),
  fecha_registro datetime DEFAULT now(),
  fecha_modificacion datetime,
  estado varchar(2),
  CONSTRAINT dependencia_pkey PRIMARY KEY (id)
);



CREATE TABLE subdependencia
(
  id serial NOT NULL,
  id_dependencia integer,
  nombre_subdependencia text NOT NULL,
  sigla varchar(10),
  orden integer,
  id_tipo_subdependencia integer,
  fecha_registro datetime DEFAULT now(),
  fecha_modificacion datetime,
  estado varchar(2),
  CONSTRAINT subdependencia_pkey PRIMARY KEY (id)
);

