# Gestion de Salles - Project README

## Introduction
Ce projet est une application web pour gérer des salles, des établissements, des événements, des catégories, des animateurs, et des tags. Il permet une gestion centralisée des ressources et événements.

---

## Fonctionnalités principales

1. **Gestion des établissements :**
    - Ajout, modification et suppression des établissements.
    - Visualisation des informations (nom, adresse, description).

2. **Gestion des salles :**
    - Ajout, modification et suppression des salles.
    - Association des salles à un établissement.
    - Classification par catégorie et ajout de tags.

3. **Gestion des animateurs :**
    - Ajout, modification et suppression des animateurs.
    - Gestion des informations personnelles (nom, contact, spécialité).

4. **Gestion des événements :**
    - Ajout, modification et suppression des événements.
    - Association d'une salle et d'un animateur à un événement.
    - Définition des horaires, du titre et de la description.
    - Classification des événements par catégorie.

5. **Recherche et filtrage :**
    - Recherche des salles par catégorie, établissement ou tags.
    - Recherche des événements par animateur, salle ou date.

---

## Modélisation des entités principales

### **1. Establishment**
- **Table :** `establishment`
- Représente un établissement contenant des salles.
- **Champs :**
    - `id` : Identifiant unique.
    - `name` : Nom de l'établissement.
    - `address` : Adresse.
    - `description` : Description.

### **2. Room**
- **Table :** `room`
- Représente une salle associée à un établissement.
- **Champs :**
    - `id` : Identifiant unique.
    - `name` : Nom de la salle.
    - `capacity` : Capacité de la salle.
    - `establishment_id` : Lien vers un établissement.

### **3. Category**
- **Table :** `category`
- Représente une classification pour les événements.
- **Champs :**
    - `id` : Identifiant unique.
    - `name` : Nom de la catégorie.
    - `description` : Description.

### **4. Tag**
- **Table :** `tag`
- Représente des étiquettes pour classifier ou identifier des salles.
- **Champs :**
    - `id` : Identifiant unique.
    - `name` : Nom du tag.

### **5. Event**
- **Table :** `event`
- Représente un événement organisé dans une salle.
- **Champs :**
    - `id` : Identifiant unique.
    - `title` : Titre de l'événement.
    - `description` : Description.
    - `start_time` : Début de l'événement.
    - `end_time` : Fin de l'événement.
    - `room_id` : Lien vers une salle.
    - `animator_id` : Lien vers un animateur.
    - `category_id` : Lien vers une catégorie.

### **6. Animator**
- **Table :** `animator`
- Représente un animateur.
- **Champs :**
    - `id` : Identifiant unique.
    - `lastname` : Nom de l'animateur.
    - `lastname` : Prénom de l'animateur.
    - `phone` : Téléphone de l'animateur.
    - `email` : Email de l'animateur.
