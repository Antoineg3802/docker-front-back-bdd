#!/bin/bash
set -e

# Exemple de variables d'environnement pour la base de données
DB_HOST=${DATABASE_HOST:-"db"}
DB_PORT=${DATABASE_PORT:-3306}

echo "Attente de la disponibilité de la base de données sur $DB_HOST:$DB_PORT..."

# Boucle d'attente pour vérifier que la base de données est accessible
while ! nc -z "$DB_HOST" "$DB_PORT"; do
  echo "Base de données indisponible, attente..."
  sleep 2
done

echo "Base de données disponible ! Exécution des migrations Symfony..."

# Exécution des migrations
php bin/console doctrine:migrations:migrate --no-interaction

echo "Migrations terminées. Lancement de l'application..."

php bin/console lexik:jwt:generate-keypair --skip-if-exists

# Lancement de l'application avec la commande passée en argument
exec "$@"
