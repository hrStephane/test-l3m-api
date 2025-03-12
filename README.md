## Environnement:
- php 8.3
- composer 2.8.4
- Laravel 12
- Postgres 16.8

## Installation: 
- Aller à la racine du projet
- Lancer les commandes 
> composer install
- Créer le fichier .env et compléter les informations de connexion à la base de donnée
- lancer les commandes 
> php artisan key:generate

> php artisan migrate

> php artisan serve

### Peupler les données de transactions:
- Après avoir créé un utilisateur, vous pouvez lancer la commande :
> php artisan db:seed --class=FundTransactionSeeder

** vous pouvez modifier l'id de l'utilisateur dans la classe FundTransactionFactory.
** 
## AUTH:
- Utilisation de laravel Sanctum pour gérer l'authentification des utilisateur et API tokens


## API Doc:
  POST            api/auth/login        : Connection utilisateur. Géneration d'un token JWT.

    email: string required

    password: string required

  POST            api/auth/logout       : Déconnexion utilisateur. 

  POST            api/auth/register     : Inscription d'utilisateur. Génère un token JWT. 

    name: string required

    email: string required

    password: string required

  GET|HEAD        api/transactions               : Liste de toutes des transactions.

    Auth Bearer token : auth:sanctum required

    Params {
        page: integer 
        limit: integer 
    }


  GET|HEAD        api/transactions/{transaction} : Récupérer les détails d'une transaction.

    /api/transactions/:transaction_id

    Auth Bearer token : auth:sanctum required

    transaction_id: integer required

  GET|HEAD        api/user                          : Récupérer les informations de l'utilisateur connecté par token.

    Auth Bearer token : auth:sanctum required

  GET|HEAD        api/user/transactions             : Liste de toutes des transactions de l'utilisateur connecté.

    Auth Bearer token : auth:sanctum required

    Params {
        page: integer 
        limit: integer 
    }


  GET|HEAD        api/users                         : Liste des utilisateurs.

    Auth Bearer token : auth:sanctum required

    Params {
        page: integer 
        limit: integer 
    }


  POST            api/users                         : Créer un nouvel utilisateur.

    Auth Bearer token : auth:sanctum required

    name: string required
    
    email: string required
    
    password: string required

  GET|HEAD        api/users/{id}/transactions       : Liste paginée des transactions d'un utilisateur.

    Auth Bearer token : auth:sanctum required

    id: integer required

    Params {
        page: integer 
        limit: integer 
    }

  POST            api/users/{id}/transactions       : Créer une nouvelle transaction.

    Auth Bearer token : auth:sanctum required

    user_id: integer required

    amount: integer required

    type: string required

    status: string required

    description: string optional


  GET|HEAD        api/users/{user}                  : Récupérer les informations d'un utilisateur.

    Auth Bearer token : auth:sanctum required

    user: id integer required

  PUT|PATCH       api/users/{user}                  : Modifier les informations d'un utilisateur.

    Auth Bearer token : auth:sanctum required

    user: id integer required

    name: string optional

    email: string optional

  DELETE          api/users/{user}                  : Supprimer un utilisateur.

    Auth Bearer token : auth:sanctum required

  GET|HEAD        sanctum/csrf-cookie               : Génerer un token CSRF. Pour l'authentification Sanctum Cookie token.


