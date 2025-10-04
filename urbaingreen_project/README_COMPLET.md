# UrbanGreen - Plateforme de Végétalisation Urbaine

## 🌱 Description

UrbanGreen est une plateforme web complète qui encourage la végétalisation des milieux urbains et permet aux citoyens de participer aux projets et événements écologiques. L'application offre une interface moderne et responsive avec des rôles utilisateurs distincts.

## ✨ Fonctionnalités Principales

### 🏠 Interface Publique (Citoyens)
- **Page d'accueil** avec présentation des projets et événements
- **Liste des projets** avec filtrage par statut
- **Détail des projets** avec événements associés
- **Liste des événements** avec inscription en ligne
- **Système d'inscription** aux événements avec commentaires
- **Gestion des inscriptions** (confirmation, annulation)
- **Pages informatives** (À propos, Contact, FAQ)

### 🔧 Interface d'Administration
- **Tableau de bord** avec statistiques en temps réel
- **Gestion complète des projets** (CRUD)
- **Gestion complète des événements** (CRUD)
- **Gestion des inscriptions** avec modération
- **Interface moderne** avec SB Admin 2

### 👥 Système de Rôles
- **Citoyen** : Consultation et inscription aux événements
- **Chef de Projet** : Gestion des projets et événements
- **Administrateur** : Accès complet à toutes les fonctionnalités

## 🛠️ Technologies Utilisées

- **Backend** : Laravel 10
- **Frontend** : Blade Templates + Bootstrap 5
- **Base de données** : MySQL
- **Templates** : 
  - SB Admin 2 (Interface d'administration)
  - Landify (Interface publique)
- **Authentification** : Laravel Breeze

## 📊 Structure de la Base de Données

### Tables Principales
- `users` : Utilisateurs avec rôles (citoyen, chef_projet, admin)
- `projets` : Projets de végétalisation
- `evenements` : Événements liés aux projets
- `inscriptions` : Inscriptions des utilisateurs aux événements

### Relations
- **Projet → Événements** : One-to-Many (un projet peut avoir plusieurs événements)
- **User ↔ Événements** : Many-to-Many via la table `inscriptions`

## 🚀 Installation et Configuration

### Prérequis
- PHP 8.1+
- Composer
- MySQL
- Node.js (optionnel pour les assets)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone [url-du-repo]
cd urbaingreen_project
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données dans `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=urbaingreen
DB_USERNAME=root
DB_PASSWORD=
```

5. **Créer la base de données et exécuter les migrations**
```bash
php artisan migrate
```

6. **Peupler la base de données avec des données de test**
```bash
php artisan db:seed
```

7. **Lancer le serveur de développement**
```bash
php artisan serve
```

L'application sera accessible à l'adresse : `http://127.0.0.1:8000`

## 👤 Comptes de Test

### Administrateur
- **Email** : admin@urbangreen.fr
- **Mot de passe** : password
- **Accès** : Interface d'administration complète

### Chef de Projet
- **Email** : marie.dubois@urbangreen.fr
- **Mot de passe** : password
- **Accès** : Gestion des projets et événements

### Citoyens
- **Email** : sophie.leroy@example.com
- **Mot de passe** : password
- **Accès** : Interface publique et inscriptions

## 🗂️ Structure des Fichiers

```
urbaingreen_project/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Contrôleurs d'administration
│   │   └── Public/          # Contrôleurs publics
│   ├── Models/              # Modèles Eloquent
│   └── Http/Middleware/     # Middlewares personnalisés
├── database/
│   ├── migrations/          # Migrations de base de données
│   ├── seeders/            # Seeders pour les données de test
│   └── factories/          # Factories pour générer des données
├── resources/views/
│   ├── layouts/            # Layouts (admin, public)
│   ├── admin/              # Vues d'administration
│   └── public/             # Vues publiques
├── public/
│   ├── admin/              # Assets SB Admin 2
│   └── frontend/           # Assets Landify
└── routes/
    └── web.php             # Routes de l'application
```

## 🎯 Utilisation

### Pour les Citoyens
1. Créer un compte ou se connecter
2. Parcourir les projets et événements
3. S'inscrire aux événements qui vous intéressent
4. Gérer ses inscriptions depuis son profil

### Pour les Chefs de Projet
1. Se connecter avec un compte chef de projet
2. Accéder à l'interface d'administration
3. Créer et gérer des projets
4. Organiser des événements
5. Modérer les inscriptions

### Pour les Administrateurs
1. Accès complet à toutes les fonctionnalités
2. Gestion des utilisateurs
3. Supervision de tous les projets et événements
4. Accès aux statistiques détaillées

## 📈 Fonctionnalités Avancées

- **Système de notifications** (en développement)
- **Export des données** (en développement)
- **Statistiques avancées** (en développement)
- **API REST** (en développement)

## 🔒 Sécurité

- Authentification sécurisée avec Laravel Breeze
- Middleware de protection des routes par rôles
- Validation des données côté serveur
- Protection CSRF sur tous les formulaires

## 🎨 Interface Utilisateur

- **Design responsive** compatible mobile/tablette/desktop
- **Interface moderne** avec Bootstrap 5
- **Expérience utilisateur optimisée**
- **Accessibilité** prise en compte

## 📞 Support

Pour toute question ou problème :
- Email : contact@urbangreen.fr
- Documentation : Consultez ce README
- Issues : Utilisez le système d'issues du repository

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
1. Fork le projet
2. Créer une branche pour votre fonctionnalité
3. Commiter vos changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

**UrbanGreen** - Ensemble, végétalisons nos villes ! 🌿
