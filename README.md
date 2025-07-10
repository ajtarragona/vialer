# Vialer for Laravel 5.6

Paquet d'accés al Vialer de l'Ajuntament de Tarragona

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Instalació](#instalaci%C3%B3)
- [Configuració](#configuraci%C3%B3)
- [Providers](#providers)
  - [VialerProvider](#vialerprovider)
  - [DistricteSeccioProvider](#districteseccioprovider)
  - [CatastroProvider](#catastroprovider)
- [Component blade](#component-blade)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Instalació

```bash
composer require ajtarragona/vialer:"@dev"
```
Publicar els assets js i css

```bash
php artisan vendor:publish --tag=ajtarragona-vialer-assets
```

> **Important!!** Cada vegada que s'actualitzi el paquet, cal executar aquesta comanda (amb el paràmetre --force) per sobrescriure els assets (js i css)
```bash
php artisan vendor:publish --tag=ajtarragona-vialer-assets --force
```


## Configuració

Pots publicar l'arxiu de configuració del paquet amb la comanda:

```bash
php artisan vendor:publish --tag=ajtarragona-vialer-config
```

Això copiarà l'arxiu a `config/vialer.php`.



## Providers

Es proporcionen 3 Providers:

### VialerProvider
Simplement és una capa sobre el paquet tsystems-client.
Podeu consultar els mètodes i la configuració a la web del paquet [tsystems-client](https://github.com/ajtarragona/tsystems-client). 

Proporciona com a extra que totes les consultes es guarden a cache durant una hora.

Ho podem fer servir:
#### A través d'una `Facade`:

```php
use Vialer;
...
public function test(){
    $paisos=Vialer::paisos();
    ...
}
```

#### Vía Injecció de dependències:

Als teus controlladors, helpers, model:

```php
use Ajtarragona\Vialer\Providers\VialerProvider;
...
public function test(VialerProvider $vialer){
	$vies=$vialer->getAllVies();
	...
}
```

#### Vía funció `helper`:
```php
...
public function test(){
	$tercer=vialer()->getAllVies();
	...
}
```


### DistricteSeccioProvider
Proporciona accés al servei web d'ARCGIS de districtes i seccions.

Funció | Paràmetres | Retorn 
--- | --- | --- 
**getDistricteISeccio** | `lat`: Latitud <br/> `lng`: Longitud | Un objecte amb els atributs `districte`, `seccio` i `districte_administratiu` o bé `null`

La latitud i longitud han d'anar en el sistema de referència indicat a l'atribut `srs` de l'arxiu de configuració `config/vialer.php`. Per defecte és 4326.

Ho podem fer servir:
#### A través d'una `Facade`:

```php
use Districtes;
...
public function test(){
    $dissec=Districtes::getDistricteISeccio(41.111,12.3323);
    ...
}
```

#### Vía Injecció de dependències:

Als teus controlladors, helpers, model:

```php
use Ajtarragona\Vialer\Providers\DistricteSeccioProvider;
...
public function test(DistricteSeccioProvider $disprov){
	$dissec=$disprov->getDistricteISeccio(41.111,12.3323);
	...
}
```

#### Vía funció `helper`:
```php
...
public function test(){
	$dissec=districtes()->getDistricteISeccio(41.111,12.3323);
	...
}
```



### CatastroProvider

Accés al catastre per comnsulta de referències catastrals.

Funció | Paràmetres | Retorn 
--- | --- | --- 
**getVia** | $codigoIneVia, $codigoProvincia=null, $codigoMunicipio=null, $codigoMunicipioIne=null) | 
**consultaViasPorNombre** | $nombreVia, $tipoVia=null  | 
**consultaDomiciliosPorVia** | $codigoVia, $numero, $partes=[], $codigoProvincia=null, $codigoMunicipio=null, $codigoMunicipioIne=null | 
**consultaDomiliciosPorRC** | $rc | 
**consultaDomiciliosPorXY** | $lat, $lng | 
**consultaXYporRC** | $rc, $srs=null, $provincia = null, $municipio=null | 
**consultaRCporXY** | $x, $y, $srs=null | 




```php
use Catastro;
...
public function test(){
    $via=Catastro::getVia(1234);
    ...
}
```

#### Vía Injecció de dependències:

Als teus controlladors, helpers, model:

```php
use Ajtarragona\Vialer\Providers\CatastroProvider;
...
public function test(CatastroProvider $catastro){
	$vies=$catastro->getVia(1234);
	...
}
```

#### Vía funció `helper`:
```php
...
public function test(){
	$via=catastro()->getVia(1234);
	...
}
```




## Component blade
Es disposa d'un component blade que renderitza un camp de formulari funcional. 

Primer cal, a la teva plantilla, afegir els assets js i css:
```html
<link href="{{ asset('vendor/ajtarragona/css/vialer.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/ajtarragona/js/vialer.js')}}" language="JavaScript"></script>
```    

Ús del component

```php
@vialerFormControl([
	'name'=>'vialer1',
	'class' => 'mb-3',
	'color'=>'info',
	'show_map'=>false, 
	'show_refcat'=>true, 
	'show_xy'=>true,  
	"search_xy"=>false, 
	"search_refcat"=>false, 
	"btn_parcela"=>true,
	
	'via_fields'=>['numero','lletra','escala','bloc','planta','porta','codi_postal','provincia','municipi','districte','seccio',
	"value"=> [
		"via"=> [
			"tipus" => "CR",
			"nom" => "DE LA UNIO",
			"codi" => 3120
		],
		"numero" => 12,
		"refcat"=> "3231506CF5533A0016DM",
		"location" =>[
			"lat" => "41.1147391577075",
			"lng" => "1.25146962624948",
		]
	],
	"readonly" =>true
])

```

#### Paràmetres

Nom | Descripció | Valor per defecte 
--- | --- | --- 
class | Classe/s CSS | 
value | Array amb els valors dels diferents subcamps | null
name | Nom del camp | vialer
id | Identificador del camp | 
map_position | left, right, top, bottom | bottom
map_height | | 300px
map_columns | En cas de posicio del mapa left o right, columes que ocuparà (1 a 12) | 6
color | Dels colors bootstrap (primary, secondary, etc.) | null
via_fields | Especifica quins camps del vialer mostrar | numero, lletra, escala, bloc, planta, porta, codi_postal, provincia, municipi, districte, seccio, districte_administratiu
show_map | Mostrar el mapa de google | true
show_refcat | Mostrar la pestanya de referència catastral  | true
show_xy | Mostrar la pestanya de Latitud i longitud   | true
search_refcat | Habilita la cerca per referència catastral  | true
btn_parcela | Habilita el botó per mostrar la parcela al catastre  | true
search_xy | Habilita la cerca per Latitud i longitud  | true
search_via | Habilita la cerca per carrer  | true
btn_add_marker | Habilita el botó d'afegir marcador al mapa | true
btn_clear | Habilita el botó de netejar tot el camp | true
readonly | Només lectura | false

Si fem servir el camp dins d'un formulari, quan fem el submit el que s'enviarà per la request és un sol camp amb el nom del camp i el valor de tots els subcamps per separat.

```php
"vialer1" => array:15 [
    "via" => array:3 [
      "tipus" => "CR"
      "nom" => "DE LA UNIO"
      "codi" => "3120"
    ]
    "numero" => "13"
    "lletra" => null
    "escala" => null
    "bloc" => null
    "planta" => "01"
    "porta" => "01"
    "codi_postal" => "43001"
    "provincia" => "TARRAGONA"
    "municipi" => "TARRAGONA"
    "districte" => "5"
    "seccio" => "2"
    "districte_administratiu" => "CENTRE"
    "refcat" => "3332212CF5533A0002FS"
    "location" => array:2 [
      "lat" => "41.1151162899822"
      "lng" => "1.25189613335773"
    ]
  ]

```
