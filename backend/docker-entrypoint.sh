#!/bin/bash

# Wait for MySQL to be available with retries and exponential backoff
echo "Waiting for MySQL to be ready..."
RETRIES=5
WAIT_TIME=3
until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "SELECT 1" &>/dev/null || [ $RETRIES -eq 0 ]; do
  echo "Waiting for MySQL... ($RETRIES retries left)"
  RETRIES=$((RETRIES - 1))
  sleep $WAIT_TIME
  WAIT_TIME=$((WAIT_TIME * 2))  # Exponential backoff
done

if [ $RETRIES -eq 0 ]; then
  echo "MySQL not ready after retries, exiting."
  exit 1
fi

echo "Ensuring vendor dependencies are installed"
composer install --optimize-autoloader --no-dev

# Run the migrations
echo "Running migrations..."
php artisan migrate --force

# Run Laravel Scheduler
echo "Starting Laravel Scheduler..."
php artisan schedule:work &

# Execute the original command (start the server)
exec "$@"
