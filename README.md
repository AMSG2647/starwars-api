<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://static.wikia.nocookie.net/esstarwars/images/4/42/StarWarsOpeningLogo.svg/revision/latest/scale-to-width-down/1000?cb=20161007015630" width="400" alt="Starwars Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Intrucciones de Instalacion

- Tener Instalado PHP 8.1
- Empezamos clonando el repositorio: ``` git clone https://github.com/AMSG2647/starwars-api.git```
- Abrimos la consola ubicada dentro del proyecto (importante tener instalado [composer](https://getcomposer.org/download/)).
- Agregar .env que enviare por correo.
- Ejecutamos: ```composer install```
- Se instalo Laravel Sail esto permite crear el container en [Docker](https://www.docker.com/)) para que el proyecto se virtualice, es importante ejecutar Docker para que el siguiente comando funcione.
- Este comando permite crear el container en docker y que se ejecute el proyecto: ```sudo ./vendor/bin/sail up -d ```
- **Importante:** En windows puede generar el error de Command not found si no se tiene instalada la consola de UBUNTU, en mi caso en MAC me genero un error de permisos.
- Error command not found: [Solucion Windows](https://www.hostgator.mx/blog/terminal-linux-windows-10/)
- Error permisos MAC en repositorios de Docker: 
- Abrir terminal escribir ```nano ~/Library/Group\ Containers/group.com.docker/settings.json```.
- Bajar y buscar array filesharingDirectories y remplazar por: ```
"filesharingDirectories": [
    "/Users",
    "/Volumes",
    "/private",
    "/tmp",
    "/var",
    "/vendor/sail/docker",
    "/var/tmp",
    "/Applications/XAMPP/xamppfiles/htdocs/starwars-api/vendor/laravel/sail/dat$
    "/Applications/XAMPP/xamppfiles/htdocs/starwars-api"
  ],```, se realizo de esta forma debido a que por la interfaz de Docker en filesharing no me permitio agregar repositorios.
  - Si todo sale bien el comando debe levantar ya el contenedor.
  - Luego ejecutamos las migraciones: ```vendor/bin/sail artisan migrate --seed ``` (Tener internet al ejecutarlo debido a que los seeders traen informacion de la API).
  - (Si genera error por conexion ejecutamos): ```vendor/bin/sail artisan migrate:fresh --seed ```.
  - Ejecutar el comando para generar la documentacion: ```php artisan l5-swagger:generate ```.
  - Todo deberia estar listo para entrar a la documentacion ingresar a [Documentacion](http://localhost/api/documentation#/).
  
  Al ingresar saldria todas las ruta, cosa importante y algo extra que agregue se protegieron las rutas con JWT por lo cual se necesita generar un token para poder ver la informacion en las peticiones para hacerlo los pasos:
  
  - En el collapsible Auth presionarlo se ve el metodo login ejecutarlo con los datos que se muestran en los parametros y genera un token.
  - Luego copiar ese token y en la parte de arriba aparece un boton Authorize se copia en el value y se presiona en login, ahora si se pueden usar los metodos de la API :).
           
## Cosas que fuera agregado por tiempo no se lograron

- Implementar una relacion entre todas las consultas de la API como Films o Pilots.

- Crear un Frontend con React para que tuviera interfaz grafica con los CRUD creado de la API.

- Implementar una manera mas eficaz la informacion traida de la API para registrar en la Base de datos.
    
## Observaciones  
               
- Se hubiera implementado solo el uso de la API sin registros pero queria hacerlo de la segunda forma 
para que se visualizara el CRUD creado y el registro de informacion en la base de datos mediante los seeders
usando HTTP.

- El login le falta mucho por completarse solo se le agrego la parte del token a la API como un plus.

- Falto crear la funcion de generar Token al usuario por cuestion de tiempo no se realizo, el token se genera directamente en el Seeder.

- Las pruebas unitarias no se completaron.
                                
## License

Angels
