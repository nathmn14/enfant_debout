# 🌍 Enfant Debout - Site Web de l'ONG

Ce projet est un site web développé en PHP avec une base de données MySQL, destiné à présenter les activités, événements, missions et objectifs de l'ONG **Enfant Debout**.

Il inclut une **interface publique** pour les visiteurs et une **interface d'administration** sécurisée pour gérer les événements et activités.


---

## 📦 Contenu du projet

- Interface publique (`index.php`, `evenement.php`, etc.)
- Interface d'administration (`Admin/`)
- Gestion des événements (ajout, modification, suppression)
- Base de données MySQL
- Upload d'images
- Design moderne avec Tailwind CSS
- Animation avec AOS (Animate On Scroll)

---

## 🔧 Installation locale (XAMPP)

1. **Cloner le projet** ou extraire dans `C:/xampp/htdocs/enfant-debout`
2. **Démarrer XAMPP** (Apache + MySQL)
3. **Importer la base de données** :
   - Aller sur [localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Créer une base nommée `enfant_debout`
   - Importer le fichier `enfant_debout.sql`
4. **Configurer la connexion** dans `Backend/connect_bdd.php` :

   ```php
   $bdd = new PDO("mysql:host=localhost;dbname=enfant_debout;charset=utf8", "root", "");


5. Accéder au site :

    http://localhost/enfant_debout/ (site public)
    
    http://localhost/enfant_debout/Frontend/Admin/ (admin)



📬 Contact
📧 nathmn14@gmail.com
📱 +243 854570512

