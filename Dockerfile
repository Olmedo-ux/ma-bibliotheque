# Utilise une image de base PHP avec Apache intégré (très simple)
FROM php:8.1-apache

# Rend le dossier "public" accessible directement comme racine web
# Copie tous les fichiers du dépôt dans le dossier web d'Apache
COPY . /var/www/html

# Déplace le contenu du dossier 'public' à la racine du serveur web (la meilleure pratique pour la sécurité)
RUN mv /var/www/html/public/* /var/www/html/

# Supprime le dossier 'public' vide
RUN rm -r /var/www/html/public

# Configure le serveur (optionnel mais propre)
RUN a2enmod rewrite
