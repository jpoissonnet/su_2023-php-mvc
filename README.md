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

## Utilisation du Routage par Dossier
 
Le Routage par Dossier est un moyen pratique d'organiser les routes d'une application PHP MVC, similaire à Next.js. Cette approche permet d'allouer automatiquement des routes en fonction de la structure des dossiers et fichiers présents dans le répertoire "pages". Voici comment vous pouvez utiliser cette fonctionnalité :
### Structure des fichiers

Assurez-vous d'avoir une structure de fichiers similaire à celle-ci :

```markdown
- app
    - Routing
        - Router.php
- pages
    - accueil.php
    - about.php
    - products
        - index.php
        - details.php
    - contact.php
```

Dans cet exemple, nous avons un répertoire "pages" contenant les fichiers PHP correspondant à chaque page de votre application. Les sous-dossiers peuvent également être utilisés pour organiser les pages liées à un même domaine (par exemple, les pages relatives aux produits).
### Configuration du Routeur

Pour commencer à utiliser le Routage par Dossier, vous devez configurer le Routeur de la manière suivante :

1. Incluez la classe Router dans votre application PHP.

2. Créez une instance du Routeur en lui fournissant l'objet Environment de Twig (ou tout autre moteur de templates que vous utilisez) :

```php
    use App\Routing\Router;
    use Twig\Environment;

    $twig = new Environment(/* Configurer votre moteur de templates Twig ici */);
    $router = new Router($twig);
```

3. Le Routeur chargera automatiquement les routes en analysant les fichiers présents dans le répertoire "pages". Chaque fichier PHP correspondra à une route avec un URL basé sur la structure des dossiers. Par exemple, le fichier about.php sera accessible à l'URL /about.

### Utilisation des routes

Une fois que le Routeur est configuré, vous pouvez utiliser les routes générées :

   - Accédez à une page spécifique : Vous pouvez accéder à une page spécifique en utilisant l'URL correspondante à son fichier dans le répertoire "pages". Par exemple, pour accéder à la page "À propos", vous pouvez visiter l'URL /about.

   - Organisation des sous-dossiers : Si vous avez des sous-dossiers dans le répertoire "pages", ils seront reflétés dans l'URL. Par exemple, le fichier details.php dans le dossier "products" sera accessible à l'URL /products/details.

   - Gestion des méthodes HTTP : Par défaut, les routes sont configurées pour la méthode HTTP GET. Vous pouvez modifier la méthode HTTP en mettant à jour les paramètres lors de l'ajout d'une route avec la méthode addRoute() du Routeur.

```php
    $router->addRoute('route_name', '/path', 'POST', 'ControllerClass', 'methodName');
```

- Paramètres dynamiques : Si vous avez des routes nécessitant des paramètres dynamiques (par exemple, un ID de produit dans l'URL /products/123), vous devrez ajouter ces routes manuellement en utilisant la méthode addRoute() du Routeur.

- Gestion des erreurs : Si une URL demandée ne correspond à aucune route configurée, vous pouvez définir un comportement personnalisé pour gérer cette situation (par exemple, afficher une page d'erreur 404).

- Assurez-vous d'adapter la structure des fichiers et le comportement du Routeur en fonction des besoins spécifiques de votre application.

C'est tout ! Vous pouvez maintenant utiliser le Routage par Dossier dans votre application PHP MVC pour organiser et accéder facilement aux différentes pages.
