# AGENTS.md - InterviewPrep

## Mission

InterviewPrep est une application Laravel personnelle pour organiser la préparation aux entretiens techniques.

L'utilisateur classe ses connaissances par domaine, rédige des concepts, suit son niveau de maîtrise et génère des questions d'entretien via l'API Groq.

Le projet doit rester simple, lisible, pédagogique et facilement défendable lors d'une soutenance académique.

---

## Rôle du coding agent

Le coding agent agit comme un assistant de développement senior Laravel.

Il aide à :
- planifier les features,
- proposer une architecture cohérente,
- générer du code,
- vérifier certaines erreurs,
- documenter le travail effectué.

Le développeur garde toujours la responsabilité finale des choix techniques, des tests et des validations.

Avant chaque feature, le coding agent doit travailler en deux étapes :

### 1. PLAN

Analyser la feature avant de coder :
- comprendre le besoin,
- proposer les fichiers à créer ou modifier,
- proposer les routes,
- proposer les commandes Artisan,
- proposer les validations,
- identifier les risques,
- identifier les tests à effectuer.

### 2. BUILD

Coder uniquement après validation du plan.

---

## Contraintes techniques

- Framework : Laravel
- Base de données : MySQL
- Vues : Blade
- CSS : TailwindCSS
- ORM : Eloquent
- Validation : Form Requests
- API AI : Groq API via `Http::` facade Laravel
- Authentification : Laravel Breeze Blade basé sur les sessions Laravel et les middlewares auth/guest
- Packages externes : éviter sauf besoin réellement justifié
- Secrets : aucune clé API dans le code ou dans GitHub

---

## Architecture cible

L’architecture doit rester volontairement simple et pédagogique.

### Structure principale

- `app/Models`
  - modèles Eloquent
  - relations
  - scopes
  - accessors

- `app/Http/Controllers`
  - contrôleurs fins
  - orchestration HTTP uniquement

- `app/Http/Requests`
  - validation des formulaires

- `app/Services`
  - logique métier
  - intégration Groq API

- `app/Enums`
  - statuts et niveaux lisibles

- `app/Policies`
  - autorisations utilisateur si nécessaire

- `resources/views`
  - pages Blade
  - composants réutilisables

- `routes/web.php`
  - routes protégées par middleware `auth`

- `database/migrations`
  - structure SQL versionnée

- `specs`
  - une spec markdown par feature développée avec assistance AI
  - spec concise orientée feature, sans section obligatoire "écart PLAN vs BUILD"

---

## Règles Laravel

- Garder les contrôleurs courts.
- Utiliser des Form Requests pour toutes les validations.
- Utiliser les relations Eloquent plutôt que des requêtes SQL répétées.
- Utiliser l’eager loading (`with`, `load`, `withCount`) pour éviter les problèmes N+1.
- Utiliser des accessors pour afficher les labels lisibles dans Blade.
- Centraliser l’appel Groq API dans un service dédié.
- Afficher des erreurs propres si l’API AI échoue.
- Utiliser les soft deletes pour les concepts (archivage obligatoire).
- Respecter les conventions de nommage Laravel.

---

## Ce que le coding agent ne doit pas faire

- Ne jamais modifier `.env` avec une vraie clé API.
- Ne jamais commiter de secrets.
- Ne jamais changer le MCD ou le MLD sans validation humaine.
- Ne jamais installer un package externe sans justification claire.
- Ne jamais mélanger plusieurs features dans une seule génération.
- Ne jamais contourner l’authentification ou les autorisations.
- Ne jamais mettre la logique Groq directement dans un contrôleur.
- Ne jamais modifier une feature stable sans raison claire.
- Ne jamais créer une architecture inutilement complexe.
- Ne jamais générer du code non demandé.

---

## Workflow Git

Le projet utilise une branche par feature.

### Branches principales

- `feature/authentication`
- `feature/domains-crud`
- `feature/concepts-crud`
- `feature/ai-generation`
- `feature/dashboard`

---

## Convention de commits

Les commits doivent être :
- courts,
- explicites,
- traçables,
- avec mention claire de l’usage AI.

### Exemples

```txt
docs(ai): add project workflow rules
spec(ai): define domains CRUD feature
feat(auth): add Laravel Breeze Blade authentication [AI-assisted]
feat(domains): implement domains CRUD [AI-assisted]
feat(concepts): add quick status update [AI-assisted]
feat(ai-generation): integrate Groq API service [AI-assisted]
fix(ai-generation): handle Groq API failure message [AI-assisted]
refactor(dashboard): simplify statistics queries [manual]
```
