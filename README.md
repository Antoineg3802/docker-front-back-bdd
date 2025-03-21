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

Presentation en détail de l'architecture dun projet, unifiant les environnements de développement grâce à Docker, avec pour stack technologique :
- **Front-End :** Vue.js avec TypeScript et Composition API.
- **Back-End :** Symfony (Doctrine).
- **Base de Données :** MySQL.

---

## 1. Front-End – Vue.js avec TypeScript et Composition API

**Vue.js** est choisi pour sa simplicité et sa réactivité, et l’utilisation de **TypeScript** apporte la sécurité des types et une meilleure maintenabilité du code.  
L’**API Composition** permet de regrouper la logique réutilisable en composables, ce qui facilite l’organisation et la réutilisation du code dans les composants.  
Par ailleurs, grâce à Docker, l’environnement de développement est unifié :  
- Le conteneur front-end contient toutes les dépendances (Node, npm/yarn) et outils de build nécessaires.
- Les développeurs bénéficient du même environnement, évitant ainsi les problèmes liés aux différences de configuration locale.

---

## 2. Back-End – Symfony

**Symfony** est un framework PHP robuste et mature, idéal pour développer des applications web évolutives et sécurisées.  
Les avantages de Symfony dans ce contexte incluent :
- Une architecture modulaire facilitant la création d’API RESTful ou GraphQL.
- L’intégration native avec **Doctrine** pour la gestion de la persistance des données.
- Des outils de développement puissants (console, profiler, etc.) qui accélèrent le cycle de développement.  
L’unification des espaces de développement se fait ici également via Docker, où :
- Le conteneur back-end est préconfiguré avec la version PHP, Composer et les extensions nécessaires.
- L’environnement de développement Symfony est identique pour tous, ce qui réduit les écarts entre les machines.

---

## 3. Base de Données – MySQL

**MySQL** est sélectionné pour sa robustesse et sa capacité à gérer un grand volume de transactions.  
Dans ce projet :
- La configuration se fait via Symfony (avec Doctrine) pour la gestion des entités et des migrations.
- Le conteneur MySQL, déployé via Docker, assure un accès standardisé à la base de données, quel que soit l’environnement (développement, test ou production).
- Les données peuvent être persistées grâce aux volumes Docker, garantissant que les informations ne sont pas perdues lors du redémarrage des conteneurs.

---

## 4. Docker – Unification des Espaces de Développement

L’utilisation de **Docker** permet de standardiser l’ensemble des environnements, assurant que :
- **Chaque composant** (front-end, back-end, base de données) fonctionne dans son propre conteneur isolé.
- **Docker Compose** orchestre ces conteneurs en définissant un réseau interne qui facilite la communication entre les services.
- **Les volumes et configurations** partagées garantissent une synchronisation parfaite entre les environnements de développement, test et production.

Exemple de points clés pour unifier les espaces de développement :
- **Images Docker spécifiques :** Chaque service dispose de son propre Dockerfile, garantissant que tous les développeurs utilisent la même version des outils et dépendances.
- **Fichier docker-compose.yml centralisé :** Il définit l’ensemble des services, leurs configurations, et leurs liens, ce qui simplifie le démarrage du projet avec une seule commande.
- **Gestion des variables d’environnement :** Uniformisées dans le fichier de configuration, elles assurent la cohérence des paramètres (accès à la BDD, configurations API, etc.) sur toutes les machines.

---

Cette architecture permet de bénéficier d’un environnement de développement identique pour tous les membres de l’équipe, tout en tirant parti des atouts de Vue.js, Symfony et MySQL pour construire une application moderne, scalable et maintenable.


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

