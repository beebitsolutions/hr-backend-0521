<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

##Descripción de la prueba

El proyecto en cuestión es una API de Laravel para gestionar paseos de perros en parques. Actualmente cuenta con los modelos:

- Dog
- Owner
- Park


Deliberadamente no se ha entregado el diagrama ER, arquitectura del sistema y otros.
La documentación de la API se encuentra en esta **[URL](https://documenter.getpostman.com/view/4081730/TzY1gbjo)**

## Tareas a realizar

1) Creación de relación muchos a muchos entre Dog y Park, completando los métodos ParkController@addOwnerWithDogs y ParkController@listOwnerWithDogs.
2) Terminar el método ParkController@forceOwnersLeave y lanzarlo como una tarea programada cada hora. Ademas crear un comando de CLI para llamar ParkController@forceOwnersLeave con "php artisan owners:leave".
3) Abstraer y encapsular la funcionalidad de creación y listado común en  OwnerController y ParkController en un controlador "BaseController". Implementar en OwnerController.
4) Refactorizar DogController con el patrón de diseño de software Repository.
5) Mejorar la eficiencia de DogFactory.

## Anotaciones
- Fecha y hora de inicio: 09/06/2021 11:00 hasta 13:00 (2 horas), se continua el 10/06/2021 08:00 hasta las 12:00 (4 horas), haciendo una suma total de 6 horas aproximadamente.
- Se realizan los refactors e implementaciones en los archivos solicitados.
- Se inicia de manera premeditada(por esta razón BEE-1 está entre commits al inicio) y para el punto 2 hago un poco de uso de gitflow para una mejor organización del código.
- Las tareas fueron reorganizadas por peticiones asociadas y se simula cada tarea como un ticket. 
