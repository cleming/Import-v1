# Scripts d'import des données de Robert v1 dans Robert2

Ce repo contient des scripts permettant d'importer des données depuis des fichiers
`.php` (exportés via PHPMyAdmin par exemple) contenant un tableau, vers une base
de données Robert2.

Les données actuellement prises en charge sont :

- Le matériel (`matos` => `materials`)
- Les techniciens (`tekos` => `persons`)

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

Une fois fait, exécutez la commande suivante : 

```bash
composer require "robert2/import-v1:dev-master"
```

## Utilisation

Vous pouvez lancer les scripts d'import avec la commande suivante :

```bash
./src/vendor/bin/import-v1 [...]
```

__Note:__ Utilisez `--help` pour obtenir la liste complète des commandes et leurs options.
