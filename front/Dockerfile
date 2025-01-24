# Étape 1 : Construction de l'application (builder)
FROM node:18 AS builder

# Crée un répertoire de travail
WORKDIR /app

# Copie les dépendances (package.json et package-lock.json)
COPY package*.json ./

# Installe les dépendances (peut être adapté selon npm ou yarn)
RUN npm install

# Copie le reste du code
COPY . .

# Compile le projet Next.js
RUN npm run build

# Étape 2 : Exécution de l'application (runner)
FROM node:18-alpine AS runner

# Répertoire de travail dans l'image finale
WORKDIR /app

# Copie le package.json et package-lock.json depuis le builder
COPY --from=builder /app/package*.json ./

# Installe uniquement les dépendances nécessaires en production
RUN npm install --omit=dev

# Copie le répertoire .next et le dossier public
COPY --from=builder /app/.next ./.next
COPY --from=builder /app/public ./public

# (Optionnel) Copie le fichier next.config.js et tout autre fichier nécessaire
COPY --from=builder /app/next.config.ts ./

# Expose le port 3000
EXPOSE 3000

# Démarre l'application Next.js
CMD ["npm", "start"]
