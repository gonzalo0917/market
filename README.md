market
======

Prueba técnica : Symfony + Backbone + HTML


1. hacer clone del repositorio

2. Hacer checkout 
  $ git fetch origin
3. Instalar las dependencias del proyecto
  $ curl -s https://getcomposer.org/installer | php

  $ php composer.phar update

4. Configurar el archivo parameters.yml 
  usuario, BD, etc.

5. Inicializar la base de datos
  $ php app/console doctrine:database:create
  $ php app/console doctrine:schema:create

6. Asignar permisos al cache y logs de symfony
$ chmod -R 777 app/cache/
$ chmod -R 777 app/logs/
$ chmod -R 777 app/logs/
$ chmod -R 777 src/Acme/marketBundle/Resources/public/tmp/

7. Finalmente navegar app_dev.php/home/

en mi caso es http://market.proof.code/app_dev.php/home/

el http://market.proof.code lo puedes cambiar por donde tengas tu repositorio.

