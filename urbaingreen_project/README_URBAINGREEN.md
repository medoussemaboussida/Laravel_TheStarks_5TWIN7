# UrbanGreen - Gestion de Projets et Événements

## Description
Application Laravel pour la gestion de projets urbains écologiques et de leurs événements associés. Chaque projet peut avoir plusieurs événements (relation one-to-many).

## Fonctionnalités Implémentées

### 🌱 Gestion des Projets
- **CRUD complet** : Créer, lire, modifier, supprimer des projets
- **Champs disponibles** :
  - Nom du projet
  - Description
  - Date de début et fin
  - Statut (planifié, en cours, terminé, suspendu)
  - Budget
  - Localisation
- **Pagination** des résultats
- **Validation** des données
- **Affichage des événements** associés à chaque projet

### 📅 Gestion des Événements
- **CRUD complet** : Créer, lire, modifier, supprimer des événements
- **Champs disponibles** :
  - Nom de l'événement
  - Description
  - Date et heure de début/fin
  - Lieu
  - Nombre maximum de participants
  - Statut (planifié, en cours, terminé, annulé)
  - Projet associé (obligatoire)
- **Sélection du projet parent** lors de la création
- **Validation** des données avec contraintes de dates

### 🔗 Relations
- **Un projet peut avoir plusieurs événements**
- **Un événement appartient à un seul projet**
- **Suppression en cascade** : supprimer un projet supprime ses événements
- **Navigation fluide** entre projets et événements

## Structure de la Base de Données

### Table `projets`
```sql
- id (Primary Key)
- nom (VARCHAR)
- description (TEXT)
- date_debut (DATE)
- date_fin (DATE, nullable)
- statut (ENUM: planifie, en_cours, termine, suspendu)
- budget (DECIMAL, nullable)
- localisation (VARCHAR, nullable)
- created_at, updated_at
```

### Table `evenements`
```sql
- id (Primary Key)
- nom (VARCHAR)
- description (TEXT)
- date_debut (DATETIME)
- date_fin (DATETIME)
- lieu (VARCHAR, nullable)
- nombre_participants_max (INTEGER, nullable)
- statut (ENUM: planifie, en_cours, termine, annule)
- projet_id (Foreign Key vers projets)
- created_at, updated_at
```

## Installation et Configuration

### 1. Configuration de la Base de Données
Modifiez le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=urbaingreen
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Exécution des Migrations
```bash
php artisan migrate
```

### 3. Peuplement avec des Données de Test
```bash
php artisan db:seed
```

### 4. Démarrage du Serveur
```bash
php artisan serve
```

L'application sera accessible à : http://127.0.0.1:8000

## Routes Principales

### Projets
- `GET /projets` - Liste des projets
- `GET /projets/create` - Formulaire de création
- `POST /projets` - Enregistrer un nouveau projet
- `GET /projets/{id}` - Afficher un projet
- `GET /projets/{id}/edit` - Formulaire de modification
- `PUT /projets/{id}` - Mettre à jour un projet
- `DELETE /projets/{id}` - Supprimer un projet

### Événements
- `GET /evenements` - Liste des événements
- `GET /evenements/create` - Formulaire de création
- `POST /evenements` - Enregistrer un nouvel événement
- `GET /evenements/{id}` - Afficher un événement
- `GET /evenements/{id}/edit` - Formulaire de modification
- `PUT /evenements/{id}` - Mettre à jour un événement
- `DELETE /evenements/{id}` - Supprimer un événement

## Données de Test Incluses

L'application inclut des données de test avec :
- **13 projets** (10 générés automatiquement + 3 spécifiques à UrbanGreen)
- **Événements associés** à chaque projet
- **Projets spécifiques** :
  - Jardin Communautaire Centre-Ville
  - Toitures Végétalisées Écoles
  - Murs Végétaux Gare

## Interface Utilisateur

- **Design responsive** avec Bootstrap 5
- **Navigation intuitive** entre projets et événements
- **Messages de confirmation** pour les actions
- **Validation en temps réel** des formulaires
- **Badges colorés** pour les statuts
- **Pagination** pour les listes longues

## Technologies Utilisées

- **Laravel 10** - Framework PHP
- **MySQL** - Base de données
- **Bootstrap 5** - Framework CSS
- **Font Awesome** - Icônes
- **Blade** - Moteur de templates

## Prochaines Améliorations Possibles

- Authentification des utilisateurs
- Gestion des participants aux événements
- Upload d'images pour les projets
- Système de notifications
- Export des données en PDF/Excel
- Calendrier interactif pour les événements
- Géolocalisation des projets
