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
CREATE VIEW usuarios_apartamento AS SELECT
    u.nombre,
    u.apellido,
    a.nombre AS apartamento,
    co.nombre AS condominio
FROM
    usuarios u
JOIN apartamento a ON u.id_apartamento = a.id
JOIN condominio co ON a.id_condominio = co.id;
