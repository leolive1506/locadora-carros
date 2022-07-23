# Criar model, migration, controller em um único comando
```sh
art make:model --migration --controller -r Marca
# mais abreviado
art make:model -mcr Marca
# Criar com todos recursos (incluindo seeder, factory)
art make:model --all NameModel
art make:model -a NameModel
```

# Rotas
```php
// nao inclui rotas create e edit
Route::apiResources([
    'cliente' => ClienteController::class
]);
```
