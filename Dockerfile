# Utilise une image de base PHP avec Apache intégré
FROM php:8.1-apache

# --- NOUVELLE COMMANDE CRITIQUE : Installation des dépendances système ---
# Installe libonig-dev pour mbstring et nettoie le cache APT
RUN apt-get update && apt-get install -y \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*
# ----------------------------------------------------------------------

# Installation des pilotes et extensions PHP
RUN docker-php-ext-install mysqli pdo_mysql mbstring

# Copie tous les fichiers du dépôt dans le dossier web d'Apache
COPY . /var/www/html

# Déplace le contenu du dossier 'public' à la racine du serveur web 
RUN mv /var/www/html/public/* /var/www/html/
RUN rm -r /var/www/html/public

# Active le module rewrite
RUN a2enmod rewrite
