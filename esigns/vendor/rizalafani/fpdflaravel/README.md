# laravel 5 fpdf

Laravel 5 FPDF

#Usage

```js
"require": {
    "rizalafani/fpdflaravel": "dev-master"
}
```

Kemudian, jalankan `composer update`.

Tambahkan service provider ke `config/app.php`, pada array `providers`.

```php
'providers' => [
	// ...

	rizalafani\fpdflaravel\FpdfServiceProvider::class,
]
```

Selanjutnya, tambahkan alias ke `config/app.php`, pada array `aliases`.

```php
'aliases' => [
	// ...

	'FPDF' => rizalafani\fpdflaravel\FpdfFacade::class,
]
```

##Contoh

```php
Route::get('pdf', function(){

        Fpdf::AddPage();
        Fpdf::SetFont('Arial','B',16);
        Fpdf::Cell(40,10,'Hello World!');
        Fpdf::Output();
        exit;

});
```
