# Utilise une image de base PHP avec Apache intégré
FROM php:8.1-apache

# --- NOUVELLE COMMANDE CRITIQUE : Installation des pilotes de base de données ---
RUN docker-php-ext-install mysqli pdo_mysql mbstring
# (mbstring est une extension PHP souvent requise pour les fonctions de chaîne)
# -----------------------------------------------------------------------------

# Copie tous les fichiers du dépôt dans le dossier web d'Apache
COPY . /var/www/html

# Déplace le contenu du dossier 'public' à la racine du serveur web 
RUN mv /var/www/html/public/* /var/www/html/
RUN rm -r /var/www/html/public

# Active le module rewrite (si besoin)
RUN a2enmod rewrite
