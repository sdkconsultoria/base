SDK Consultoría Base
====


Instalación
------------
EL mejor modo de instalar esta extencion es por medio de composer.

Ejecuta el comando

```
composer require sdkconsultoria/base:dev-develop
```

Ejecuta el comando para instalar la libreria

```
php artisan sdk:install
```

Inicia los permisos y crea el primer usuario

```
php artisan sdk:permissions && php artisan sdk:user
```

Para subir archivos es necesario ejecutar

```
php artisan storage:link
```
