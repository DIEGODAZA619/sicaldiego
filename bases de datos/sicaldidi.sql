-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-04-2023 a las 22:37:27
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sicaldidi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `padre` int(11) DEFAULT NULL,
  `ruta` varchar(30) DEFAULT NULL,
  `hijos` varchar(30) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC',
  `sigla` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_auxiliar`
--

CREATE TABLE `categorias_auxiliar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `padre` int(11) DEFAULT NULL,
  `ruta` varchar(30) DEFAULT NULL,
  `hijos` varchar(30) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC',
  `sigla` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cites_funcionarios`
--

CREATE TABLE `cites_funcionarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  `id_correlativo` int(11) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `cite` varchar(50) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativos`
--

CREATE TABLE `correlativos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_cite` varchar(30) DEFAULT NULL,
  `abreviatura` varchar(3) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativos_gestion`
--

CREATE TABLE `correlativos_gestion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_correlativo` int(11) NOT NULL,
  `gestion` int(11) DEFAULT NULL,
  `correlativo` int(11) DEFAULT 0,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dominios`
--

CREATE TABLE `dominios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `concepto` varchar(30) DEFAULT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `valor1` varchar(30) DEFAULT NULL,
  `valor2` varchar(30) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE `entidad` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_entidad` varchar(120) DEFAULT NULL,
  `sigla` varchar(20) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  `fecha_aniversario` date DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `telefono2` varchar(15) DEFAULT NULL,
  `direccionweb` varchar(100) DEFAULT NULL,
  `nro_nit` varchar(15) DEFAULT NULL,
  `logo` varchar(15) DEFAULT NULL,
  `valor1` varchar(100) DEFAULT NULL,
  `valor2` varchar(100) DEFAULT NULL,
  `valor3` varchar(100) DEFAULT NULL,
  `valor4` varchar(100) DEFAULT NULL,
  `valor5` varchar(100) DEFAULT NULL,
  `valor6` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionario`
--

CREATE TABLE `funcionario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_documento` varchar(2) DEFAULT NULL,
  `numero_documento` int(11) DEFAULT NULL,
  `complemento` varchar(5) DEFAULT NULL,
  `extension` varchar(2) DEFAULT NULL,
  `nombres` varchar(250) DEFAULT NULL,
  `primer_apellido` varchar(50) DEFAULT NULL,
  `segundo_apellido` varchar(50) DEFAULT NULL,
  `estado_civil` varchar(2) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `lugar_nacimiento` varchar(3) DEFAULT NULL,
  `sexo` varchar(2) DEFAULT NULL,
  `numero_celular` int(11) DEFAULT NULL,
  `domicilio` text DEFAULT NULL,
  `zona` text DEFAULT NULL,
  `email_personal` text DEFAULT NULL,
  `profesion` varchar(10) DEFAULT NULL,
  `numero_cuenta` varchar(15) DEFAULT NULL,
  `afp` varchar(2) DEFAULT NULL,
  `nua_cua` varchar(15) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC',
  `foto` tinyint(1) DEFAULT 0,
  `extension_foto` varchar(5) DEFAULT NULL,
  `banco` varchar(4) DEFAULT NULL,
  `libreta_militar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion`
--

CREATE TABLE `gestion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gestion` int(11) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_entidad` int(11) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  `order_compra` varchar(100) DEFAULT NULL,
  `nota_remision` varchar(100) DEFAULT NULL,
  `nro_factura` varchar(50) DEFAULT NULL,
  `fecha_factura` date DEFAULT NULL,
  `monto_total_factura` double DEFAULT 0,
  `id_provedor` int(11) DEFAULT NULL,
  `descripcion_ingreso` text DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `id_funcionario_registro` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `id_funcionario_update` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(3) DEFAULT 'ELB',
  `activo` varchar(3) DEFAULT 'SI',
  `correlativo` int(11) DEFAULT NULL,
  `cite` text DEFAULT NULL,
  `fecha_nota_remision` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos_detalle`
--

CREATE TABLE `ingresos_detalle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_ingreso` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `cantidad_ingreso` double DEFAULT NULL,
  `precio_unitario` double DEFAULT NULL,
  `precio_total` double DEFAULT NULL,
  `id_funcionario_registro` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `id_funcionario_update` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(3) DEFAULT 'ELB',
  `activo` varchar(3) DEFAULT 'SI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_entidad` int(11) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  `id_ingreso` int(11) DEFAULT NULL,
  `id_ingreso_detalle` int(11) DEFAULT NULL,
  `id_salida` int(11) DEFAULT NULL,
  `id_salida_detalle` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `tipo_proceso` text DEFAULT NULL,
  `tipo_ingreso_egreso` text DEFAULT NULL,
  `cantidad_entrada` double DEFAULT NULL,
  `cantidad_salida` double DEFAULT NULL,
  `saldo` double DEFAULT NULL,
  `precio_unitario` double DEFAULT NULL,
  `precio_total` double DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_inventario` int(11) DEFAULT NULL,
  `id_funcionario_solicitante` int(11) DEFAULT NULL,
  `id_funcionario_almacen` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(3) DEFAULT 'AC',
  `id_inventario_inicial_ingreso` int(11) DEFAULT NULL,
  `id_inventario_ingresos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios_resumen`
--

CREATE TABLE `inventarios_resumen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_entidad` int(11) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `cantidad_entrada` double DEFAULT NULL,
  `cantidad_salida` double DEFAULT NULL,
  `saldo` double DEFAULT NULL,
  `cantidad_solicitada` double DEFAULT NULL,
  `cantidad_disponible` double DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(3) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_entidad` int(11) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC',
  `ruta_imagen` text DEFAULT NULL,
  `nombre_imagen` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_aplicacion` int(11) DEFAULT NULL,
  `nombre_modulo` varchar(120) DEFAULT NULL,
  `abreviatura_modulo` varchar(20) DEFAULT NULL,
  `descripcion_modulo` varchar(200) DEFAULT NULL,
  `valor1` varchar(100) DEFAULT NULL,
  `valor2` varchar(100) DEFAULT NULL,
  `valor3` varchar(100) DEFAULT NULL,
  `valor4` varchar(100) DEFAULT NULL,
  `valor5` varchar(100) DEFAULT NULL,
  `valor6` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `codigo_opciones` int(11) DEFAULT NULL,
  `opcion` varchar(100) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC',
  `id_aplicacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_entidad` int(11) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `nombre_proveedor` varchar(150) DEFAULT NULL,
  `legal_proveedor` varchar(150) DEFAULT NULL,
  `nit` varchar(150) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `celular` varchar(150) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `observaciones` varchar(150) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE `puesto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_entidad` int(11) NOT NULL,
  `nombre_puesto` varchar(100) DEFAULT NULL,
  `numero_item` int(11) DEFAULT NULL,
  `id_dependencia` int(11) DEFAULT NULL,
  `id_subdependencia` int(11) DEFAULT NULL,
  `tipo_puesto` varchar(3) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(4) DEFAULT 'ASIG',
  `nivel_dependencia` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto_funcionario`
--

CREATE TABLE `puesto_funcionario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_puesto` int(11) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_dependencia` int(11) DEFAULT NULL,
  `id_subdependencia` int(11) DEFAULT NULL,
  `id_entidad` int(11) DEFAULT NULL,
  `id_confirmacion_direccion` int(11) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `cantidad_solicitada` double DEFAULT NULL,
  `cantidad_autorizada` double DEFAULT NULL,
  `tipo_solicitud` varchar(3) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_autorizacion` datetime DEFAULT NULL,
  `fecha_aprobacion` datetime DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(3) DEFAULT 'PEN',
  `fecha_confirmacion` datetime DEFAULT NULL,
  `id_usuario_rechazo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_direccion`
--

CREATE TABLE `solicitud_direccion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_dependencia` int(11) DEFAULT NULL,
  `id_subdependencia` int(11) DEFAULT NULL,
  `id_entidad` int(11) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `cantidad_materiales` double DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `cite` text DEFAULT NULL,
  `tipo_solicitud` varchar(3) DEFAULT NULL,
  `id_funcionario_solicitante` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_aprobacion` datetime DEFAULT NULL,
  `fecha_autorizacion` datetime DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(3) DEFAULT 'CON',
  `id_funcionario_aprobador` int(11) DEFAULT NULL,
  `id_funcionario_autorizador` int(11) DEFAULT NULL,
  `id_funcionario_entregas` int(11) DEFAULT NULL,
  `motivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_medida`
--

CREATE TABLE `unidades_medida` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `valor1` varchar(30) DEFAULT NULL,
  `valor2` varchar(30) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_opciones`
--

CREATE TABLE `usuarios_opciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_opcion` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo_opcion` varchar(3) DEFAULT 'ROL',
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` varchar(2) DEFAULT 'AC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `categorias_auxiliar`
--
ALTER TABLE `categorias_auxiliar`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `cites_funcionarios`
--
ALTER TABLE `cites_funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `correlativos`
--
ALTER TABLE `correlativos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `correlativos_gestion`
--
ALTER TABLE `correlativos_gestion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `dominios`
--
ALTER TABLE `dominios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `gestion`
--
ALTER TABLE `gestion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `ingresos_detalle`
--
ALTER TABLE `ingresos_detalle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `inventarios_resumen`
--
ALTER TABLE `inventarios_resumen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `inventarios_resumen_id_material_key` (`id_material`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `puesto_funcionario`
--
ALTER TABLE `puesto_funcionario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `solicitud_direccion`
--
ALTER TABLE `solicitud_direccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `usuarios_opciones`
--
ALTER TABLE `usuarios_opciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias_auxiliar`
--
ALTER TABLE `categorias_auxiliar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cites_funcionarios`
--
ALTER TABLE `cites_funcionarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `correlativos`
--
ALTER TABLE `correlativos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `correlativos_gestion`
--
ALTER TABLE `correlativos_gestion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dominios`
--
ALTER TABLE `dominios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entidad`
--
ALTER TABLE `entidad`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gestion`
--
ALTER TABLE `gestion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos_detalle`
--
ALTER TABLE `ingresos_detalle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarios_resumen`
--
ALTER TABLE `inventarios_resumen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puesto_funcionario`
--
ALTER TABLE `puesto_funcionario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_direccion`
--
ALTER TABLE `solicitud_direccion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_opciones`
--
ALTER TABLE `usuarios_opciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
