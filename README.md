# Documentation du Projet

Ce document présente une vue d'ensemble du projet, incluant l'architecture choisie, la structure des fichiers et des conteneurs Docker, les étapes pour exécuter le projet, ainsi que les choix technologiques et les configurations Docker.

---

## 1. Architecture du Projet

### 1.1 Vue d'ensemble
Le projet est composé de trois composants principaux :
- **Front-End :** L'interface utilisateur, développée avec une technologie moderne (ex. React, Angular ou Vue).
- **Back-End :** L'API et la logique métier, réalisée par exemple avec Node.js et Express.
- **Base de Données (BDD) :** Le stockage des données, utilisant une solution telle que MySQL, PostgreSQL ou MongoDB.

---

## 2. Structure des Fichiers et des Conteneurs Docker

### 2.1 Structure des fichiers
L'organisation des fichiers dans le dépôt est conçue pour séparer clairement chaque composant du projet frontend et backend.

### 2.2 Conteneurs Docker
Chaque composant est isolé dans son propre conteneur Docker :
- **Front-End Container :** Construit à partir du Dockerfile du répertoire `frontend`. Il peut s'agir d'une image Node pour le développement ou d'une image Nginx pour servir l'application en production.
- **Back-End Container :** Construit à partir du Dockerfile du répertoire `backend`, hébergeant l'API.
- **Database Container :** Contient la base de données avec la configuration nécessaire (ports, volumes pour la persistance des données, etc.).

La communication entre les conteneurs est gérée via Docker Compose, qui configure un réseau interne permettant aux services de communiquer entre eux.

---

## 3. Étapes pour Exécuter le Projet

### 3.1 Prérequis
- Assurez-vous que Docker et Docker Compose sont installés sur votre machine.
- Cloner le dépôt du projet sur votre environnement local.

### 3.2 Instructions d'exécution
Pour exécuter le projet, procédez comme suit :
1. Dans la racine du repository créez un .env à partir de l'exemple et définissez vos port souhaités (Vous pourvez les laisser par défaut)
2. Dans les dossier `backend` et `frontend` faites la même chose que l'étape précédente mais ne modifiez que la ligne en rapport avec la BDD (en fonction de quels Ports vous avez renseignés dans le fichier `.env`)
3. Vérifiez que le fichier `backend/entrypoint.sh` est bien en **LS et non CRLF**
4. Executez la commande suivante qui buildera les containers :
```bash 
docker compose up -d
```
5. Pour éviter d'avoir les erreurs des packages non-installés il ya deux possibilités
    - Utiliser [DevContainers](https://code.visualstudio.com/docs/devcontainers/containers)
    - Effectuer les commmandes :
        - `composer install` dans le dossier `backend`
        - `npm i` dans le dossier `frontend`

6. Une fois ces étapes effectuées vous pouvez coder !!

---

## 4. Choix Technologiques et Configurations Docker

### 4.1 Choix Technologiques
- **Front-End :**  
  Utilisation d’un framework moderne (React, Angular ou Vue) pour construire une interface utilisateur réactive et maintenable.
  
- **Back-End :**  
  Adoption de Node.js et Express pour développer une API scalable et facile à maintenir.

- **Base de Données :**  
  Sélection d’un SGBD robuste (MySQL, PostgreSQL ou MongoDB) en fonction des besoins en termes de transactions, scalabilité et stockage.

- **Docker :**  
  Utilisation de Docker pour isoler les environnements, faciliter le déploiement et assurer une cohérence entre les environnements de développement et de production.

### 4.2 Configurations Docker
- **Dockerfile :**  
  Chaque service dispose d'un Dockerfile dédié pour créer une image optimisée en fonction de son environnement spécifique.

- **Docker Compose :**  
  Le fichier `docker-compose.yml` orchestre la mise en réseau des conteneurs et définit les variables d'environnement, les volumes et les ports pour chaque service.

- **Volumes :**  
  Des volumes sont configurés pour persister les données de la base de données et pour monter le code source dans les conteneurs pendant le développement.

- **Réseaux Internes :**  
  Les conteneurs communiquent via un réseau Docker interne, assurant une isolation et une sécurité accrues.

---

Cette documentation constitue une base pour comprendre et déployer le projet. N’hésitez pas à l’adapter en fonction des évolutions futures ou des besoins spécifiques du projet.

