CREATE DATABASE IF NOT EXISTS `condominium-system`;
USE `condominium-system`;

CREATE TABLE usuarios (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    condominio_id BIGINT REFERENCES condominios(id),
    condominio_id_website BIGINT REFERENCES condominios_websites(id),
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    cedula BIGINT NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    rol_id INT,
    permisos_id INT,
    token VARCHAR(255),
    is_active BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE condominios (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    condominio_id_website BIGINT REFERENCES condominios_websites(id),
    nombre VARCHAR(255) NOT NULL,
    deuda DECIMAL(10, 2) DEFAULT 0,
    alicuota DECIMAL(10, 2),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE pagos (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    condominio_id_website BIGINT REFERENCES condominios_websites(id),
    monto DECIMAL(10, 2) NOT NULL,
    fecha DATE NOT NULL,
    banco_id BIGINT REFERENCES bancos(id),
    tipo_pago_id BIGINT REFERENCES tipos_de_pago(id),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE gastos (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    gastos_condominio_id BIGINT REFERENCES gastos_condominios(id),
    concepto VARCHAR(255) NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE bitacora (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    usuario_id BIGINT REFERENCES usuarios(id),
    condominio_id_website BIGINT REFERENCES condominios_websites(id),
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    accion VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE bancos (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(20) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tipos_de_pago (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(20) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE gastos_condominio (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    gastos_id BIGINT REFERENCES gastos(id),
    condominio_id BIGINT REFERENCES condominios(id),
    condominio_id_website BIGINT REFERENCES condominios_websites(id),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE pago_gasto (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    pagos_id BIGINT REFERENCES pagos(id),
    gastos_condominio_id BIGINT REFERENCES gastos_condominio(id),
    condominio_id_website BIGINT REFERENCES condominios_websites(id),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE condominios_websites (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    shortcode VARCHAR(10) NOT NULL,
    tagid BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- AJUSTE NUEVO 

CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE permisos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE usuarios_roles (
    usuario_id BIGINT NOT NULL,
    rol_id INT NOT NULL,
    PRIMARY KEY (usuario_id, rol_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

CREATE TABLE usuarios_permisos (
    usuario_id BIGINT NOT NULL,
    permiso_id INT NOT NULL,
    PRIMARY KEY (usuario_id, permiso_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (permiso_id) REFERENCES permisos(id)
);