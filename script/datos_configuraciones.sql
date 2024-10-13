
SHOW FULL TABLES FROM db_sistema_ventas_fac




truncate ad_empresas;
truncate siat_configuracion_empresa;
truncate table ad_configuraciones_empresas;
truncate table ve_categorias;
truncate table siat_factura;
truncate table siat_factura_item;
truncate table siat_numero_factura;
truncate table ve_inventarios_resumen_producto;
truncate table ve_precios_productos;
truncate table ve_productos;




insert into  ad_empresas (empresa) values ('MADIA TU MEDIDA');

insert into siat_configuracion_empresa (id_empresa) values (1);


--CONFIGURACION INVENTARIO
insert into ad_configuraciones_empresas (codad_empresa,concepto,valor1,valor2)values (1, 'CONTROL INVENTARIO POR SUCURSAL', 'NO','1');


--CONFIGURACION CODIFICACION PRODUCTO
insert into ad_configuraciones_empresas (codad_empresa,concepto,valor1) values (1, 'CODIGO PRODUCTO MANUAL', 'SI');