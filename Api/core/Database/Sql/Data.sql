INSERT INTO 
    websites (name, shortcode, tagid)
VALUES
('Test A', 'TA', 001),
('Test B', 'TB', 002),
('Test C', 'TC', 003),
('Test D', 'TD', 004),
('Test E', 'TE', 005);

INSERT INTO condominio (id_website, codigo, nombre)
VALUES
(1, 'COND-001', 'Reserva del Mar'),
(2, 'COND-002', 'Torre de la Costa'),
(3, 'COND-003', 'Parque del Sol');

INSERT INTO tipo_gasto (nombre, descripcion, is_active)
VALUES
('Unico', 'Gasto unico de apartamento', true),
('Agua', 'Gasto por suministro de agua', true),
('Gas', 'Gasto por suministro de gas', true),
('Electricidad', 'Gasto por suministro eléctrico', true),
('Seguridad', 'Servicios de vigilancia y seguridad', true),
('Limpieza común', 'Limpieza de áreas comunes', true),
('Mantenimiento', 'Reparaciones y mantenimiento general', true),
('Estacionamiento', 'Servicios de estacionamiento', true);

INSERT INTO 
    apartamento (id_website, id_condominio, nombre, deuda, alicuota)
VALUES
(1, 1, 'Test1', 15000.00, 450.00),
(2, 1, 'Test2', 20000.00, 600.00),
(3, 1, 'Test3', 25000.00, 750.00),
(1, 1, 'Test4', 18000.00, 540.00),
(2, 1, 'Test5', 22000.00, 660.00),
(3, 1, 'Test6', 28000.00, 840.00),
(1, 1, 'Test7', 16000.00, 480.00),
(2, 1, 'Test8', 21000.00, 630.00),
(3, 1, 'Test9', 26000.00, 780.00),
(1, 1, 'Test10', 19000.00, 570.00);

-- DATOS PERMISOS 
INSERT INTO roles (nombre, descripcion)
VALUES ('user', 'Usuario básico'),
       ('admin', 'Administrador del negocio'),
       ('dev', 'Desarrollador');

INSERT INTO permisos (nombre, descripcion)
VALUES ('ver_pagos', 'Verificar pagos'),
       ('consultar_deudas', 'Consultar deudas'),
       ('pagar_deudas', 'Pagar deudas'),
       ('verificar_pagos', 'Verificar pagos'),
       ('administracion_negocio', 'Administrar el negocio'),
       ('configuracion_web', 'Configurar el sitio web'),
       ('gestion_banco', 'Gestionar bancos'),
       ('gestion_tipos_pago', 'Gestionar tipos de pago'),
       ('gestion_websites', 'Gestionar websites');

-- Clave es Contraseña123@
INSERT INTO `usuarios` (`id`, `id_website`, `id_apartamento`, `id_rol`, `nombre`, `apellido`, `cedula`, `phone`, `email`, `user_password`, `token`, `is_active`, `created_at`, `updated_at`) VALUES
-- Usuario básico
(1, 1, 1, 1, 'Usuario', 'Basico', 11222333, '04161234567', 'UsuarioBasico@gmail.com', 'WEhrSmFIQmVnOVBNVjF2S1NxeUxxQT09', '659234ee791d4194e246a4d3308a179212192b4528fef69a50d887c004287f6dc41aa956f05ff74e3cd10ae164d22f958ff87abddc7d3797db9ee63f6e412b2d', 1, '2024-11-11 21:43:24', '2024-11-11 21:43:24'),
-- Administrador del negocio
(2, 1, 2, 2, 'Usario', 'Administrador', 1222333, '04161234567', 'UsarioAdministrador@gmail.com', 'WEhrSmFIQmVnOVBNVjF2S1NxeUxxQT09', '3302891fd8e917d94261060184c27005f67ce5b4683dd5ae4b9dc9472022cff417e7e26f23c26be76387fb43c4fa416e76b617e40a7783c79410464833aa3456', 1, '2024-11-11 21:48:38', '2024-11-11 21:48:38'),
-- Desarrollador
(3, 1, 3, 3, 'Usuario', 'Desarrollador', 111222333, '04161234567', 'UsuarioDesarrollador@gmail.com', 'WEhrSmFIQmVnOVBNVjF2S1NxeUxxQT09', '40f5417f4d78dfeae785611acf82b874d07169f9540ea1b1c543485b17976f08e252172459534f16755c8a3a128de6daf0be05f10f60e0a536903e54c2902688', 1, '2024-11-11 21:51:53', '2024-11-11 21:51:53');

INSERT INTO usuarios_roles (id_usuario, id_rol)
VALUES
(1, 1),  -- Juan Pérez como Usuario básico
(2, 2),  -- Maria Gomez como Administrador del negocio
(3, 3);  -- Carlos Ramirez como Desarrollador

-- Asignar permisos al rol 'user'
INSERT INTO roles_permisos (id_rol, id_permiso)
VALUES
    (1, 1),  -- ver_pagos
    (1, 2),  -- consultar_deudas
    (1, 3);  -- pagar_deudas

-- Asignar permisos al rol 'admin'
INSERT INTO roles_permisos (id_rol, id_permiso)
VALUES
    (2, 1),  -- ver_pagos
    (2, 2),  -- consultar_deudas
    (2, 3),  -- pagar_deudas
    (2, 4),  -- verificar_pagos
    (2, 5);  -- administracion_negocio
    
-- Asignar permisos al rol 'dev'
INSERT INTO roles_permisos (id_rol, id_permiso)
VALUES
    (3, 1),  -- ver_pagos
    (3, 2),  -- consultar_deudas
    (3, 3),  -- pagar_deudas
    (3, 4),  -- verificar_pagos
    (3, 5),  -- administracion_negocio
    (3, 6),  -- configuracion_web
    (3, 7),  -- gestion_banco
    (3, 8),  -- gestion_tipos_pago
    (3, 9);  -- gestion_websites
