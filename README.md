# docker-front-back-bdd

Projet INSTAAAGRAM Permettant d'ajouter des photos, s'inscrire, se connecter, liker, disliker et visualiser les images des autres utilisateurs

## Installation 

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
