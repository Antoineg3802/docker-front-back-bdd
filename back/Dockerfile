# Utilisation de l'image Node.js officielle
FROM node:18-alpine

# Création d'un répertoire de travail
WORKDIR /app

# Copie des fichiers package.json et package-lock.json
COPY package*.json ./

# Installation des dépendances
RUN npm install

# Copie du reste du code
COPY . .

# Exposition du port 5000
EXPOSE 5000

# Démarrage de l'application
CMD ["npm", "start"]
