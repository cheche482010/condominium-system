INSERT INTO
    bancos (codigo, nombre, is_active)
VALUES
    ('0102', 'Banco de Venezuela', 1),
    ('0105', 'Banco Mercantil', 1),
    ('0106', 'Banco Provincial', 1),
    ('0107', 'Banco Bicentenario', 1),
    ('0108', 'Banco Occidental', 1),
    ('0110', 'Banco Universal', 1),
    ('0111', 'Banco Plaza', 1),
    ('0112', 'Banco Venezzuela (Banco Industrial)', 1),
    ('0113', 'Banco Exterior', 1),
    ('0114', 'Banco Latino', 1),
    ('0115', 'Banco Nacional de Crédito Cooperativo', 1),
    ('0116', 'Banco Agrícola Latino', 1),
    ('0117', 'Banco Comercial Latino', 1),
    ('0118', 'Banco Continental', 1),
    ('0119', 'Banco Caribe', 1);

-- DATOS PERMISOS 
INSERT INTO roles (nombre, descripcion)
VALUES ('user', 'Usuario básico'),
       ('admin', 'Administrador del negocio'),
       ('dev', 'Desarrollador');

INSERT INTO permisos (nombre, descripcion)
VALUES ('ver_pagos', 'Verificar pagos'),
       ('consultar_deudas', 'Consultar deudas'),
       ('verificar_pagos', 'Verificar pagos'),
       ('administracion_negocio', 'Administrar el negocio'),
       ('configuracion_web', 'Configurar el sitio web'),
       ('gestion_banco', 'Gestionar bancos'),
       ('gestion_tipos_pago', 'Gestionar tipos de pago'),
       ('gestion_condominios_websites', 'Gestionar condominios_websites');
