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

# URL, URN, URI
- URL (Uniform Resource Locator)
    - host onde está o recurso
    - Ex: leonardosantana.com.br

- URN (Uniform Resource Name)
    - Recurso dentro do host
    - Ex: /api/vagas

- URI (Uniform Resource Identifier)
    - Combinação protocolo + url + urn
    - Ex: https://leonardosantana.com.br/api/vagas


# Put, Patch
- Quando tiver form-data
    - Inputs Não são reconhecidos no framework laravel
        - Valores chegam como nulo
