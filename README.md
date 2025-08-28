# Green Express - Application de Livraison de Repas

Application Laravel complète pour la gestion de livraison de repas sains avec authentification multi-rôles, génération de factures PDF et intégration WhatsApp.

## 🚀 Fonctionnalités

### 👨‍💼 Administrateur
- Dashboard avec statistiques complètes
- Gestion du menu (plats et prix)
- Gestion des abonnements (Basic, Professionnel, Premium)
- Validation des commandes
- Génération automatique de factures PDF
- Envoi automatique par WhatsApp
- Suivi des livreurs et commandes

### 👤 Client
- Parcours du menu sans abonnement
- Commande de plats à l'unité
- Souscription aux abonnements
- Historique des commandes
- Suivi du statut des commandes
- Réception automatique des factures par WhatsApp

### 🚚 Livreur
- Dashboard dédié
- Consultation des commandes assignées
- Validation par code sécurisé
- Historique des livraisons

## 🛠️ Technologies Utilisées

- **Laravel 12** - Framework PHP
- **Filament** - Interface d'administration
- **DOMPDF** - Génération de factures PDF
- **Meta WhatsApp Cloud API** - Notifications WhatsApp
- **Tailwind CSS** - Interface utilisateur
- **MySQL** - Base de données

## 📋 Prérequis

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (pour les assets)

## 🔧 Installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd greenapp
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données**
Modifiez le fichier `.env` avec vos informations de base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=greenexpressdb
DB_USERNAME=root
DB_PASSWORD=
```

5. **Configurer WhatsApp (optionnel)**
```env
WHATSAPP_TOKEN=your_whatsapp_token
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
WHATSAPP_VERIFY_TOKEN=your_verify_token
```

6. **Exécuter les migrations et seeders**
```bash
php artisan migrate
php artisan db:seed
```

7. **Créer le lien symbolique pour le stockage**
```bash
php artisan storage:link
```

8. **Lancer le serveur**
```bash
php artisan serve
```

## 👥 Comptes de Test

### Administrateur
- Email: `admin@greenexpress.fr`
- Mot de passe: `password`

### Clients
- Email: `jean.dupont@email.com`
- Mot de passe: `password`

- Email: `marie.martin@email.com`
- Mot de passe: `password`

### Livreurs
- Email: `lucas.bernard@greenexpress.fr`
- Mot de passe: `password`

## 📱 Configuration WhatsApp

1. Créez un compte Meta Developer
2. Configurez WhatsApp Business API
3. Obtenez votre token d'accès
4. Ajoutez les variables dans votre `.env`

## 🔐 Sécurité

- Authentification Laravel native
- Middleware de rôles (Admin, Client, Livreur)
- Codes sécurisés uniques pour les livraisons
- Validation des données
- Protection CSRF

## 📊 Structure de la Base de Données

### Tables Principales
- `users` - Utilisateurs avec rôles
- `meals` - Plats du menu
- `subscriptions` - Abonnements clients
- `orders` - Commandes
- `order_items` - Éléments de commande
- `invoices` - Factures avec codes sécurisés
- `deliveries` - Livraisons

## 🎨 Interface Utilisateur

- Design responsive avec Tailwind CSS
- Interface moderne et intuitive
- Navigation adaptée selon le rôle
- Notifications en temps réel

## 📄 Génération de Factures

- Templates PDF personnalisés
- Codes sécurisés uniques
- Envoi automatique par WhatsApp
- Stockage local des PDF

## 🔄 Flux de Travail

1. **Client** passe une commande
2. **Admin** valide la commande
3. **Système** génère facture + code sécurisé
4. **WhatsApp** envoie automatiquement au client
5. **Livreur** reçoit la commande
6. **Client** présente le code au livreur
7. **Livreur** valide avec le code
8. **Système** marque comme livré

## 🚀 Déploiement

1. Configurez votre serveur web (Apache/Nginx)
2. Définissez les variables d'environnement
3. Exécutez les migrations
4. Configurez les tâches cron si nécessaire

## 📝 Licence

Ce projet est sous licence MIT.

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
- Signaler des bugs
- Proposer des améliorations
- Soumettre des pull requests

## 📞 Support

Pour toute question ou problème, contactez-nous à `contact@greenexpress.fr`
