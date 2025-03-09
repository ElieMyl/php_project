# 🎮 Projet PHP - Casino en ligne (Fasael)

## 👥 Membres du Groupe
- **Elie**
- **Fabio**
- **Sami**

## 🛠️ Contributions
| Fonctionnalité | Membres responsables |
|---------------|----------------------|
| 🗄️ Base de données (BDD) | Elie / Fabio / Sami |
| 🔑 Administration | Elie |
| 🎨 Interface utilisateur | Elie / Sami |
| 🏗️ Navbar & Footer | Fabio |
| 💰 Wallet | Fabio / Elie |
| 🎲 Jeu | Elie / Sami / Fabio |
| 📩 Page Contact | Fabio |
| 📜 Historique des jeux et transactions | Elie |
| 💳 Dépôt et Retrait | Elie / Fabio |
| 🎯 Mise dans un jeu | Elie / Sami |

---

## 🚀 Instructions de Lancement

### 📌 Prérequis
- [MAMP](https://www.mamp.info/en/) installé pour exécuter un serveur local
- Navigateur web pour accéder à l'application
- Base de données MySQL (fournie dans le projet)

### 🔧 Installation et Démarrage

1. **Lancer MAMP**
    - Ouvrir et démarrer MAMP

2. **Accéder au projet**
    - Placer le dossier du projet dans le dossier `htdocs` de MAMP
    - Aller dans le dossier `public`
    - Ouvrir un navigateur et accéder au projet via :
      ```
      http://localhost/nom_du_projet/public/
      ```

3. **Connexion à l'interface**
    - Email : `Karl@gmail.com`
    - Mot de passe : `karleemi`

---

## 🗄️ Base de Données

### 📥 Importation du dump SQL
Le fichier de création de la base de données se trouve dans le dossier `bdd/` sous le nom `projet_php.sql`.

#### 📌 Via phpMyAdmin :
1. Ouvrir MAMP et accéder à **phpMyAdmin**
2. Créer une nouvelle base de données nommée `projet_php`
3. Importer le fichier `bdd/projet_php.sql`

#### 📌 Via terminal :
```sh
mysql -u root -p projet_php < bdd/projet_php.sql
