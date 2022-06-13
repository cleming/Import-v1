# Scripts d'import des données de Robert v1 dans Robert2

Ce repo contient des scripts permettant d'importer des données depuis une base de données
de la première version de Robert (v0.6.x), grâce à des fichiers `.php` (exportés via
PHPMyAdmin par exemple) contenant un tableau, vers une base de données Robert2.

Les données actuellement prises en charge sont :

- Le matériel (`matos` => `materials`), avec ses catégories (créées à la volée),
- Les techniciens (`tekos` => `persons` avec le tag "Technicien")
- Les bénéficiaires (`benef_interlocuteurs` => `persons` avec le tag "Bénéficiaire")
- Les organisations (`benef_structure` => `companies`)

## Installation

Dans le fichier `composer.json` de votre Robert2, ajoutez un nouveau repository comme suit :

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:Robert-2/Import-v1.git"
        }
    ]
}
```

Une fois fait, exécutez : 

```bash
composer require "robert2/import-v1:dev-master"
```

Puis, utilisez le namespace `ImportV1Command` dans le fichier `server/src/App/Config/definitions.php`, grâce au `use` suivant :

```php
use ImportScripts\Console\Command as ImportV1Command;
```

Enfin, ajoutez la ligne suivante dans la clé `console.commands` du tableau :

```php
    'console.commands' => DI\add([
        // ...
        DI\get(ImportV1Command\ImportCommand::class),
    ]),
```


## Utilisation

Vous pouvez lancer les scripts d'import depuis le dossier `server` via :

```bash
./bin/console import [entité] [fichier-a-importer.php]
```

__Note:__ Utilisez `-h` (ou `--help`) pour obtenir la liste complète des commandes et leurs options.
