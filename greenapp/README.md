# GreenApp - Application de Gestion de Livraison de Repas

## Contexte
GreenApp est une application Laravel dédiée à la gestion de la livraison rapide de repas sains. Elle intègre plusieurs technologies, notamment Laravel, DOMPDF, Filament et l'API WhatsApp Cloud de Meta, tout en offrant une authentification simple via Laravel Auth.

## Fonctionnalités Principales

### Pour l'Admin
- Gestion du menu (ajout, modification, suppression de plats et prix).
- Gestion des abonnements (Formules Secumier/Basic, Entreprise/Professionnel, Premium).
- Réception et validation des commandes.
- Génération automatique de factures PDF avec un code unique sécurisé (UUID ou hash).
- Envoi de factures et de codes au client via l'API WhatsApp.
- Suivi de l'état des commandes (En attente, Validée, En livraison, Livrée).
- Dashboard avec statistiques sur les revenus, le nombre de commandes, et les abonnements actifs.

### Pour le Client
- Parcours du menu sans abonnement et possibilité de commander un plat à l'unité.
- Souscription à un abonnement (Basic, Professionnel, Premium).
- Consultation de l'historique des commandes et des abonnements.
- Visualisation du statut d'approbation des commandes.
- Réception automatique de la facture PDF et du code sécurisé par WhatsApp après validation de l'admin.

### Pour le Livreur
- Dashboard dédié avec consultation des commandes attribuées.
- Validation des commandes par un code sécurisé fourni par le client lors de la livraison.
- Historique des livraisons effectuées.

## Fonctionnalités Avancées

### Authentification
- Gestion simple avec Laravel Auth (sans Breeze/Jetstream).
- Séparation des rôles via middleware (Admin, Client, Livreur).

### Factures
- Génération de factures avec Laravel DOMPDF.
- Factures incluant les informations du client, les détails de la commande, le montant payé, et le code sécurisé unique.
- Stockage des factures dans le système et envoi automatique par WhatsApp.

### Intégration WhatsApp
- Utilisation de l'API WhatsApp Cloud de Meta pour l'envoi automatisé de notifications.

### Dashboard
- Statistiques et suivi des commandes pour chaque type d'utilisateur (Admin, Client, Livreur).

## Sécurité
- Les codes fournis aux clients sont générés sous forme d'UUID ou de hash alphanumérique, valables une seule fois et associés à une commande précise.

## Installation
1. Clonez le dépôt.
2. Installez les dépendances avec Composer et npm.
3. Configurez votre environnement (.env).
4. Exécutez les migrations et les seeders.
5. Lancez le serveur Laravel.

## Contribution
Les contributions sont les bienvenues ! Veuillez soumettre une demande de tirage pour toute amélioration ou correction.

## License
Ce projet est sous licence MIT.