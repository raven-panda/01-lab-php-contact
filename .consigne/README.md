# Lab PHP : Project 1 - Contact

Ce projet consiste à intégrer une application Web et de réaliser la partie back-end d'une petite application qui permet d'ajouter des contacts.

Réaliser les codes PHP à partir des fichiers fournis (*index.html*, *dashboard.html*, *signup.html*).

## Consigne

### Docker

- Un container de Base de Données

- Un container Apache + PHP

### Nom de domaine

- On pourra atteindre ce projet avec le nom de domaine : **php-dev-1.online**.

### Organiser une Base de Données

- Faire un MCD avec MySQL Workbench pour une app qui **permet aux utilisateurs de s'inscrire**.

- Mettre en oeuvre la BDD à partir d'un **fichier .sql**.
    - Il faut stocker leurs **nom**, **prénom**, **email** qui servira d'identifiant et le **mot de passe**.
    - Cette application permettra aussi aux utilisateurs de **stocker des contacts** avec le **nom**, **prénom** et **email** du contact.
    - Quand l'utilisateur se connectera il ne **verra que ses contacts à lui**.

### Formulaire d'inscription

- Script PHP qui permet de stocker des **utilisateurs de l'app**.

  **/!\ CRYPTER LES MOTS DE PASSES /!\\**

### Formulaire de connexion

- Script PHP qui vérifie si l'utilisateur existe bien et si c'est le cas, rediriger l'utilisateur sur la page du dashboard.

### Formulaire d'ajout de contact

- Script PHP qui permet d'**ajouter dans la BDD un contact**.
    - On ne peut **pas mettre deux fois** le **même email d'un contact** *-> Afficher 'Cette adresse mail existe déjà'*.

- **Rattacher ce contact à l'utilisateur** et ce nouveau contact **devra apparaître dans la liste**.
