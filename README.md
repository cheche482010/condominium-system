# Sistema de Gestión de Condominios

## Descripción

Este es un sistema de gestión de condominios desarrollado en PHP, utilizando una arquitectura MVC (Modelo-Vista-Controlador). El sistema permite gestionar información de propietarios, mantenimientos, pagos y otras actividades relacionadas con el administración de un condominio.

## Estructura de Carpetas

├── app/
│   ├── Components/
│   │   ├── ButtonComponent.php
│   │   ├── CardComponent.php
│   │   ├── ...
│   │   └── VistaComponent.php
│   ├── Controllers/
│   │   ├── BaseController.php
│   │   └── UserController.php
│   ├── Documentation/
│   │   ├── api.php
│   │   └── index.php
│   ├── Models/
│   │   ├── BaseModel.php
│   │   └── UserModel.php
│   └── Views/
│       ├── error/
│       │   ├── 400.php
│       │   ├── 403.php
│       │   ├── 404.php
│       │   └── 500.php
│       ├── home/
│       │   └── home.php
│       └── user/
│           └── login/
│               └── login.php
├── core/
│   ├── Database/
│   │   ├── Connection.php
│   │   └── Sql/
│   │       └── BD.sql
│   ├── ErrorHandler.php
│   ├── FrontController.php
│   ├── Router.php
│   └── logs/
│       └── error.log
├── public/
│   ├── assets/
│   └── index.php
├── swagger-ui/
└── vendor/
├── .env
├── .htaccess
├── README.md

## Características Principales

- Autenticación de usuarios
- Gestion de propietarios
- Registro de mantenimientos
- Gestión de pagos
- Documentación API (Swagger UI integrada)

## Requisitos

- PHP 7.4+
- MySQL 5.7+
- Composer

## Instalación

1. Clona el repositorio:

git clone https://github.com/cheche482010/condominium-system.git

2. Instala las dependencias:

composer install

3. Configura la conexión a la base de datos en `core/Connection.php`

## Documentación API

La API RESTful está disponible en `/api`. Se puede visualizar y probar utilizando Swagger UI integrada.

## Contribuciones

Contribuciones bienvenidas! Por favor, sigue el formato de commits y el código de conducta.

## Licencia

Este proyecto está licenciado bajo MIT. Ver el archivo LICENSE para más detalles.
