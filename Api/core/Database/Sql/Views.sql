-- role permisos
CREATE VIEW rol_permisos AS SELECT
    r.nombre AS Rol,
    p.nombre AS Permiso,
    p.descripcion AS Descripción
FROM
    roles r
JOIN roles_permisos rp ON
    r.id = rp.id_rol
JOIN permisos p ON
    rp.id_permiso = p.id
ORDER BY
    r.nombre;

-- usuario condominio
CREATE VIEW usuarios_condominio AS SELECT
    u.nombre,
    u.apellido,
    c.nombre AS condominio_nombre
FROM
    usuarios u
JOIN condominios c ON
    u.id_condominio = c.id;