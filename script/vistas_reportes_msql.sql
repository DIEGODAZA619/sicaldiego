CREATE VIEW total_precio_ingreso AS 
 SELECT id_ingreso,
    sum(precio_total) AS total_ingreso
   FROM inventarios
  WHERE 1 = 1 
   AND tipo_proceso IN('INGI','INGP') 
   AND estado IN ('AC''HI')
  GROUP BY id_ingreso;





CREATE VIEW total_precio_salida AS 
 SELECT id_salida,
    sum(precio_total) AS total_salida
   FROM inventarios
  WHERE 1 = 1 
    AND tipo_ingreso_egreso = 'SOLM'
    AND estado = 'AC'
  GROUP BY id_salida;


  CREATE VIEW saldos_iniciales_gestion AS 
 SELECT i.id_material,
    i.gestion,
    i.tipo_proceso,    
    sum(i.cantidad_entrada) AS saldo_inicial,
    sum(i.precio_total) AS saldo_inicial_valorado
   FROM inventarios i
  WHERE 1 = 1 
   AND i.tipo_proceso = 'INGI'
  GROUP BY i.id_material, i.gestion, i.tipo_proceso;



  CREATE OR REPLACE VIEW materiales_inventario AS 
 SELECT m.id AS id_material,
    m.codigo AS codigo_material,
    c.codigo AS codigo_categoria,
    c.descripcion AS descripcion_categoria,
    u.descripcion AS descripcion_unidad,
    m.descripcion AS descripcion_material,
    m.estado,
    i.gestion,
    i.saldo,
    i.cantidad_solicitada,
    i.cantidad_disponible
   FROM materiales m,
    categorias c,
    unidades_medida u,
    inventarios_resumen i
  WHERE m.id_categoria = c.id AND m.id_unidad = u.id AND i.id_material = m.id
  ORDER BY i.saldo DESC;