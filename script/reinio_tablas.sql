truncate material.proveedores;
truncate material.materiales;
truncate inventario.ingresos;
truncate inventario.ingresos_detalle;
truncate inventario.inventarios;
truncate inventario.inventarios_resumen;
truncate inventario.solicitud_direccion;
truncate inventario.solicitudes;
truncate administracion.cites_funcionarios;


ALTER SEQUENCE inventario.ingresos_id_seq RESTART WITH 1;
ALTER SEQUENCE inventario.ingresos_detalle_id_seq RESTART WITH 1;
ALTER SEQUENCE inventario.inventarios_id_seq RESTART WITH 1;
ALTER SEQUENCE inventario.inventarios_resumen_id_seq RESTART WITH 1;
ALTER SEQUENCE inventario.solicitud_direccion_id_seq RESTART WITH 1;
ALTER SEQUENCE inventario.solicitudes_id_seq RESTART WITH 1;

ALTER SEQUENCE material.materiales_id_seq RESTART WITH 1;
ALTER SEQUENCE material.proveedores_id_seq RESTART WITH 1;
