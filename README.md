# Gestion de pharmacie · Symfony 6

**Franck Nankeng** · Projet académique · [LinkedIn](https://www.linkedin.com/in/franck-nankeng-51b43b297/)

Application web de gestion d'une pharmacie : catalogue des produits classés par type, avec pour chaque produit
le prix, la quantité en stock, la notice, une image et la date de péremption.

## Fonctionnalités
- Gestion des **produits** : création, consultation, modification, suppression ; prix, stock, notice, image et date de péremption.
- Gestion des **types de produits**, reliés aux produits (relation un-à-plusieurs).
- Interface d'administration construite sur un gabarit Twig.

## Stack
PHP 8.1, Symfony 6.2, Doctrine ORM, Twig, base PostgreSQL ou MySQL.

## Lancer le projet en local
```bash
cd Pharma-main
composer install
cp .env .env.local          # renseigner DATABASE_URL et APP_SECRET dans .env.local
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start        # ou : php -S localhost:8000 -t public
```

---
*English — Symfony 6 pharmacy management app: product catalogue with CRUD (price, stock, leaflet, image, expiry date), product types (one-to-many), Twig admin interface.*
