# Vialer for Laravel 5.6

Paquet d'accés al Vialer de l'Ajuntament de Tarragona


## Instalació

```bash
composer require ajtarragona/vialer:"@dev"
```

## Configuració

Pots configurar el paquet a través de l'arxiu `.env` de l'aplicació. Aquests son els parámetres disponibles :
```bash

```
Alternativament, pots publicar l'arxiu de configuració del paquet amb la comanda:

```bash
php artisan vendor:publish --tag=ajtarragona-vialer-config
```

Això copiarà l'arxiu a `config/vialer.php`.



## Ús

Un cop configurat, el paquet està a punt per fer-se servir. 

Ho pots fer de les següents maneres:

### A través d'una `Facade`:

```php
use Vialer;
...
public function test(){
    $paisos=Vialer::paisos();
    ...
}
```

### Vía Injecció de dependències:

Als teus controlladors, helpers, model:

```php
use Ajtarragona\Vialer\Models\VialerProvider;
...
public function test(VialerProvider $vialer){
	$vies=$vialer->getAllVies();
	...
}
```

### Vía funció `helper`:
```php
...
public function test(){
	$tercer=vialer()->getAllVies();
	...
}
```