INSERT INTO 
    websites (name, shortcode, tagid)
VALUES
('Condominio A', 'CA', 001),
('Condominio B', 'CB', 002),
('Condominio C', 'CC', 003),
('Condominio D', 'CD', 004),
('Condominio E', 'CE', 005);

INSERT INTO
    bancos (codigo, nombre)
VALUES
    ('0102', 'Banco de Venezuela'),
    ('0105', 'Banco Mercantil'),
    ('0106', 'Banco Provincial'),
    ('0107', 'Banco Bicentenario'),
    ('0108', 'Banco Occidental'),
    ('0110', 'Banco Universal'),
    ('0111', 'Banco Plaza'),
    ('0112', 'Banco Venezzuela (Banco Industrial)'),
    ('0113', 'Banco Exterior'),
    ('0114', 'Banco Latino'),
    ('0115', 'Banco Nacional de Crédito Cooperativo'),
    ('0116', 'Banco Agrícola Latino'),
    ('0117', 'Banco Comercial Latino'),
    ('0118', 'Banco Continental'),
    ('0119', 'Banco Caribe');

INSERT INTO 
    tipos_de_pago (codigo, nombre, descripcion)
VALUES
('TPE', 'Efectivo', 'Pago de efectivo en Bolivares'),
('TPM', 'Pago Móvil', 'Pagos móviles en Bolivares.'),
('TED', 'Efectivo Divisas', 'Pagos en efectivo con divisas extranjeras'),
('TZL', 'Zinli', 'Servicio de pagos Zinli'),
('TBZ', 'Zelle', 'Plataforma de pagos Zelle'),
('TBN', 'Binance', 'Pagos criptográficos a través de Binance'),
('TTF', 'Transferencia', 'Transferencias bancarias'),
('TBP', 'Bio Pago', 'Pagos biométricos'),
('TGP', 'Google Pay', 'Servicio de pagos móviles Google Pay'),
('TPI', 'PayPal Instant Transfer', 'Transferencia instantánea desde PayPal'),
('TAT', 'Tarjeta Débito', 'Pagos con tarjeta débito'),
('TCT', 'Tarjeta Crédito', 'Pagos con tarjeta de crédito');

INSERT INTO 
    condominios (id_website, nombre, deuda, alicuota)
VALUES
(1, 'Test1', 15000.00, 450.00),
(2, 'Test2', 20000.00, 600.00),
(3, 'Test3', 25000.00, 750.00),
(1, 'Test4', 18000.00, 540.00),
(2, 'Test5', 22000.00, 660.00),
(3, 'Test6', 28000.00, 840.00),
(1, 'Test7', 16000.00, 480.00),
(2, 'Test8', 21000.00, 630.00),
(3, 'Test9', 26000.00, 780.00),
(1, 'Test10', 19000.00, 570.00);

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

INSERT INTO usuarios (id_condominio, id_website, nombre, apellido, cedula, phone, email, user_password, id_rol, token, is_active)
VALUES
-- Usuario básico
(1, 1, 'Juan Pérez', 'Pérez Gómez', 12345678, '123-456-7890', 'juan.perez@example.com', 'password123', 1, NULL, TRUE),
-- Administrador del negocio
(2, 1, 'María González', 'González López', 87654321, '987-654-3210', 'maria.gonzalez@example.com', 'password123', 2, NULL, FALSE),
-- Desarrollador
(3, 2, 'Carlos Hernández', 'Hernández Martínez', 111222333, '555-666-7777', 'carlos.hernandez@example.com', 'password123', 3, NULL, TRUE);


INSERT INTO usuarios_roles (usuario_id, rol_id)
VALUES
(1, 1),  -- Juan Pérez como Usuario básico
(2, 2),  -- Maria Gomez como Administrador del negocio
(3, 3);  -- Carlos Ramirez como Desarrollador

-- Asignar permisos al rol 'user'
INSERT INTO roles_permisos (rol_id, permiso_id)
VALUES
    (1, 1),  -- ver_pagos
    (1, 2),  -- consultar_deudas
    (1, 3);  -- pagar_deudas

-- Asignar permisos al rol 'admin'
INSERT INTO roles_permisos (rol_id, permiso_id)
VALUES
    (2, 1),  -- ver_pagos
    (2, 2),  -- consultar_deudas
    (2, 3),  -- pagar_deudas
    (2, 4),  -- verificar_pagos
    (2, 5);  -- administracion_negocio
    
-- Asignar permisos al rol 'dev'
INSERT INTO roles_permisos (rol_id, permiso_id)
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

