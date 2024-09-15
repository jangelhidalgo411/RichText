# RichText

Pasos para el funcionamiento:

* Crear una base de datos
* correr el archivo .sql que se encuentra en la carpeta sql
* colocar los archivos en la carpeta una carpeta local de projectos (htdocs en el caso de usar XAMPP)
	* Tambien puedes clonar el repositorio dentro de la carpeta de project del local 
* Correr los servicios de Apache y MySQL
* Ir al archivo connection.php y cambiar el valor de $DATABASE_NAME al nombre de la base de datos creada
* Abrir en local el project colocando en el url del navegador "localhost/" seguido del nombre de la carpeta donde se encuentrar los archivos