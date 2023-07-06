# Sciences-U - B3 IW - PHP MVC - 2023

## Démarrage

### Composer

Pour récupérer les dépendances déclarées dans `composer.json` et générer l'autoloader PSR-4, exécuter la commande suivante :

```bash
composer install
```

### DB Configuration

La configuration de la base de données doit être inscrite dans un fichier `.env.local`, sur le modèle du fichier `.env`.

### Démarrer l'application

Commande :

```bash
composer start
```

## Cours

Le cours complet se trouve à [cette adresse](https://ld-web.github.io/su-2023-php-mvc-course/).

## Routage par Dossier

Nous avons implémenté le routage par dossier copié tout droit de Next.js, toutefois, nous avons pas implémenté le routage dynamique ainsi que la structure en ``app`` qui va avec. Notre version est clairement meilleure.

### Configuration du Routeur

Avant de pouvoir utiliser le routeur par dossier, il y a une petite configuration à faire.

```php
$router = new Router($serviceContainer);
$router->registerRoutes();
```

Il faut initaliser le Router au sein de l'index.php où tous les services sont initialisées. et appeler la fonction permettant l'initialisation des routes comme ci-dessus.

### Structure des fichiers

Pour que le routage par dossier fonctionne, il faut créer les fichier dans le dossier ``pages``. Le reste du projet peut être organisé à sa guise, il n'influt pas sur le fonctionnement du routage.

```markdown
- app
    - Routing
        - Router.php
- pages
    - accueil.php
    - about.php
    - contact.php
```
Dans cet exemple, nous avons quelques fichiers qui se trouvent dans le dossier pages. Si nous voulions accéder à la page ``about.php``, il faudrait taper sur la route ``/about`` du site.

## Guard

Nous avons implémenté un système de Guard qui permet de protéger les routes, avec des niveaux d'accès différents. Pour ne pas changer à la règle, cette fonctionnalié est inspirée de Angular et bien entendu, la notre est meilleure.

### Configuration du Guard

Pour utiliser le Guard, il faut l'initialiser dans le fichier ``index.php``.

```php
$serviceContainer
    ->// ...
    ->set(Guard::class, new Guard());
```

### Utilisation du Guard
// TODO
