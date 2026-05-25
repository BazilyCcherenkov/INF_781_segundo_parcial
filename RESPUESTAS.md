# Parte F — Pregunta teórica

**¿Por qué spatie/laravel-permission cachea los permisos y qué problema de seguridad o de consistencia podría aparecer si olvidas limpiar esa caché tras un cambio de permisos en producción?**

Spatie cachea los permisos para evitar consultas repetitivas a la base de datos en cada
request, mejorando drásticamente el rendimiento. Sin embargo, si en producción se
modifica un rol (se asigna o revoca un permiso) y no se limpia la caché con
`PermissionRegistrar::forgetCachedPermissions()`, los usuarios seguirán viendo los
permisos viejos: podría permitir accesos no autorizados (si se revocó un permiso pero
la caché aún lo concede) o denegar accesos legítimos (si se asignó un permiso nuevo).
Es un problema de consistencia entre el estado real en BD y lo que el sistema
efectivamente aplica, con implicaciones directas de seguridad.

Consultando la pagina guia de Spatie [enlace]("https://spatie.be/docs/laravel-permission/v7/advanced-usage/seeding")se encuentra que si utilizas el rasgo WithoutModelEvents en tus inicializadores, vacíala DESPUÉS de crear cualquier rol o permiso, antes de asignarlos o concederlos.

```php
// reset cached roles and permissions
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```
