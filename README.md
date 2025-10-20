# UrbanGreen - Gestion Environnementale des Bâtiments

## Fonctionnalités

### Prédiction IA des Émissions CO2

Le système intègre une API d'Intelligence Artificielle (OpenAI) pour prédire automatiquement les émissions de CO2, le pourcentage d'énergie renouvelable et les émissions réelles des bâtiments.

#### Configuration

1. **Obtenir une clé API OpenAI** :
   - Rendez-vous sur [https://platform.openai.com/api-keys](https://platform.openai.com/api-keys)
   - Créez une nouvelle clé API

2. **Configurer l'environnement** :
   ```bash
   # Copier le fichier d'exemple
   cp .env.example .env

   # Ajouter votre clé API
   OPENAI_API_KEY=sk-your-api-key-here
   OPENAI_MODEL=gpt-3.5-turbo
   OPENAI_TIMEOUT=30
   ```

3. **Installation des dépendances** :
   ```bash
   composer install
   npm install
   ```

#### Utilisation

Lors de la création d'un bâtiment dans l'interface admin :

1. Remplissez les informations de base (type, adresse, zone)
2. Cochez les cases pertinentes pour les émissions, énergies renouvelables et recyclage
3. **Activez l'option "Utiliser l'Intelligence Artificielle"** dans la section "Prédiction Intelligente"
4. Soumettez le formulaire

L'IA analysera automatiquement :
- Le type de bâtiment
- Les données d'émissions saisies
- Les installations d'énergies renouvelables
- Les pratiques de recyclage
- Le type d'industrie (pour les usines)

Et prédira :
- **Émissions CO2 théoriques** (en tonnes/an)
- **Pourcentage d'énergie renouvelable** (0-100%)
- **Émissions réelles** (émissions théoriques - réduction due aux renouvelables)

#### Fallback

Si l'API IA n'est pas configurée ou échoue, le système utilise automatiquement les calculs traditionnels basés sur des facteurs prédéfinis.

#### Recommandations IA pour la Protection de la Nature

UrbanGreen intègre également une fonctionnalité d'Intelligence Artificielle avancée pour générer des recommandations personnalisées de protection de l'environnement et d'amélioration de la qualité de vie urbaine.

##### Fonctionnalités

- **Recommandations Personnalisées** : Analyse complète du bâtiment et génération de conseils adaptés
- **Actions Courte et Long Terme** : Plan d'action structuré avec priorisation temporelle
- **Impact et Coûts Estimés** : Évaluation réaliste des bénéfices environnementaux et financiers
- **Actions Rapides** : Impression, partage et création de plans d'action

##### Accès aux Recommandations

1. Depuis la liste des bâtiments, cliquez sur le bouton 🧠 (cerveau) vert
2. La page de détails s'ouvre avec une section dédiée aux recommandations IA
3. Les recommandations sont générées automatiquement lors de l'affichage

##### Types de Recommandations Générées

- **Recommandations Principales** : Actions prioritaires pour l'impact maximal
- **Actions Courte Terme** : Solutions réalisables rapidement (1-6 mois)
- **Actions Long Terme** : Stratégies de transformation durable (6-36 mois)
- **Impact Estimé** : Bénéfices environnementaux quantifiés
- **Coût Estimé** : Budget nécessaire pour l'implémentation
- **Durée d'Implémentation** : Délais réalistes pour la mise en œuvre

##### Exemple de Recommandations

Pour une maison individuelle :
- Installer des panneaux solaires
- Créer un jardin potager
- Système de récupération d'eau de pluie

Pour une usine industrielle :
- Management environnemental ISO 14001
- Optimisation des processus industriels
- Programme de compensation carbone

## Installation

```bash
# Cloner le repository
git clone <repository-url>
cd Laravel_TheStarks_5TWIN7

# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install

# Configurer l'environnement
cp .env.example .env
# Éditer .env avec vos configurations

# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations
php artisan migrate

# Compiler les assets
npm run build

# Démarrer le serveur
php artisan serve
```

## Technologies Utilisées

- **Laravel 12** - Framework PHP
- **MySQL** - Base de données
- **Bootstrap 5** - Interface utilisateur
- **Chart.js** - Graphiques
- **OpenAI API** - Intelligence Artificielle
- **Vite** - Build tool