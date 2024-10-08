CREATE TABLE usuarios (
    id bigint primary key generated always as identity,
    nombre text not null,
    apellido text not null,
    cedula bigint not null unique,
    telefono text not null,
    email text not null unique,
    password text not null,
    rol text not null,
    token text
);

CREATE TABLE condominios (
    id bigint primary key generated always as identity,
    nombre text not null,
    deuda numeric(10, 2) default 0,
    alicuota numeric(10, 2)
);

CREATE TABLE cobranza (
    id bigint primary key generated always as identity,
    usuario_id bigint references usuarios(id),
    condominio_id bigint references condominios(id),
    monto numeric(10, 2) not null,
    fecha date not null,
    estado text not null
);

CREATE TABLE reportes (
    id bigint primary key generated always as identity,
    usuario_id bigint references usuarios(id),
    condominio_id bigint references condominios(id),
    tipo text not null,
    contenido text not null,
    fecha date not null
);

CREATE TABLE pagos (
    id bigint primary key generated always as identity,
    condominio_id bigint references condominios(id),
    cobranza_id bigint references cobranza(id),
    monto numeric(10, 2) not null,
    fecha date not null
);

CREATE TABLE gastos (
    id bigint primary key generated always as identity,
    cobranza_id bigint references cobranza(id),
    concepto text not null,
    monto numeric(10, 2) not null,
    tipo text not null
);