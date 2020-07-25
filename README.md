# ⚙️ CRUD API REST LARAVEL 7

Un simple CRUD API usando Laravel 7, donde se podra inicar sesion usando JWT (Json Web Token),
el usuario podra crear tareas, editarlas, eliminarlas y listar sus tareas

## Instalacion 🚀

* git clone https://github.com/DanielVera987/crud_api_laravel/
* Ejecutar `composer install`
* Cambiar el nombre del archivo .env.example por .env
* Crear base de datos y configurar archivo .env
* Generamos nuestra key, `php artisan key:generate`
* Ejecutar `php artisan migrate:fresh --seed`
* `php artisan serve`
* Listo!!!


## Rutas 🧾

### User
| Method | ruta | descripcion |
| ------------- | ------------- | ------------- |
| POST  | api/v1/login  | Inicio de sesion |
| POST  | api/v1/refresh  | Refrescar token |
| POST  | api/v1/me | Muestra datos del usuario logeado |
| POST  | api/v1/register | Registrar nuevo usuario |

### Post
| Method | ruta | descripcion |
| ------------- | ------------- | ------------- |
| GET  | api/v1/post  | Listar post del usuario logeado |
| POST  | api/v1/post  | Crear nuevo post |
| PUT  | api/v1/post/{post} | Editar post |
| DELETE  | api/v1/post/{post} | Eliminar post |

## Licencia 💳

Siéntase libre de usar y reutilizar de la forma que desee.

## Expresiones de Gratitud 🎁

* Comenta a otros sobre este proyecto 📢
* Da las gracias públicamente 🤓.

---
⌨️ con ❤️ por [DanielVera](https://github.com/DanielVera987) 😊
