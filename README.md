# App-gestion-de-parking
Étapes pour faire fonctionner cette application correctement :

# Pré-requis :
1. Installez un éditeur de code sur votre ordinateur.
2. Installez un serveur web sur votre ordinateur (ex : XAMPP, ...).
3. Installez Composer sur votre ordinateur.
4. Assurez-vous d'avoir la version 7.4 ou supérieure de PHP.

# Premièrement :
1. Exécutez les commandes suivantes :
2. composer install
3. cp env.example .env

# Deuxièmement :
1. Créez une base de données sur votre ordinateur.
2. Dans le répertoire public/data, vous trouverez un fichier nommé data.sql. Exécutez les scripts de ce fichier dans votre base de données.

# Troisièmement :
1. Dans le répertoire app/Config, ouvrez le fichier nommé Database.php et spécifiez le nom de votre base de données.

# Quatrièmement :
1. Exécutez la commande `php spark serve` pour lancer l'application en local.

# Cinquièmement :
Il y a deux types d'utilisateurs :

Administrateur :
- Nom d'utilisateur : administrateur@gmail.com
- Mot de passe : administrateur@gmail.com

Utilisateur :
- Nom d'utilisateur : rakoto@gmail.com
- Mot de passe : rakoto@gmail.com


