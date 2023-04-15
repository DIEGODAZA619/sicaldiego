select *
  from inventario.solicitud_direccion s, inventario.total_precio_salida t
 where s.id = t.id_salida
   and estado = 'ENT'
   and fecha_entrega::date between '2023-02-09' and '2023-02-15'
 order by correlativo asc



select *
  from inventario.ingresos i, inventario.total_precio_ingreso t
 where i.id = t.id_ingreso
   and i.estado = 'AC'
   and fecha_ingreso::date between '2023-01-09' and '2023-02-15'
 order by correlativo asc 
  

----SALIDAS
create view inventario.total_precio_salida
as
select id_salida, sum(precio_total)AS total_salida
  from inventario.inventarios
 where 1 = 1  
  and tipo_ingreso_egreso = 'SOLM'
  and estado = 'AC'
 group by id_salida

select *from inventario.total_precio_ingreso
---INGRESOS
create view inventario.total_precio_ingreso
as
select id_ingreso, sum(precio_total)as total_ingreso
  from inventario.inventarios
 where 1 = 1  
  and tipo_proceso in ('INGI','INGP')
  and estado in ('AC','HI')
 group by id_ingreso 




