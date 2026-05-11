# Authentication Feature

## Statut

Implementee (BUILD termine) et verifiee manuellement.

## Contexte

InterviewPrep est une application personnelle. Toutes les donnees metier doivent appartenir a un utilisateur connecte : domaines, concepts et generations AI.

L'authentification est la premiere feature fonctionnelle. Elle a ete implementee avec Laravel Breeze (Blade) pour accelerer la mise en place d'une base auth fiable et standard Laravel.

## Objectifs

- Permettre a un utilisateur de creer un compte.
- Permettre a un utilisateur de se connecter.
- Permettre a un utilisateur de se deconnecter.
- Proteger les pages applicatives via le middleware `auth`.
- Poser une base stable pour les features suivantes.

## Non-objectifs

- Pas de social login.
- Pas de roles administrateur.
- Pas de personnalisation avancee UX auth dans ce lot.
- Pas d'Inertia, Livewire, React ou Vue.

## User stories couvertes

- US1 - Inscription / Connexion / Deconnexion

## Decisions techniques

- Authentification implementee avec Laravel Breeze (stack Blade).
- Breeze fournit routes, controleurs auth, vues auth et gestion de session.
- Protection des pages privees avec middleware `auth`.
- Redirection utilisateur invite vers `/login`.
- Redirection utilisateur connecte vers `/dashboard`.
- Architecture reste simple : Breeze pour la base auth, logique metier custom pour le reste du projet.

## Fichiers principaux generes par Breeze

```text
app/Http/Controllers/Auth/*
app/Http/Requests/Auth/*
resources/views/auth/*
resources/views/layouts/*
resources/views/dashboard.blade.php
routes/auth.php
```

## Fichiers principaux modifies

```text
routes/web.php
resources/js/app.js
resources/js/bootstrap.js
package.json
```

## Routes effectives (resume)

- `GET /register`, `POST /register`
- `GET /login`, `POST /login`
- `POST /logout`
- `GET /dashboard` (protege `auth`)
- Routes profile et reset password Breeze disponibles

## Verification

Verification manuelle effectuee :

- Ouverture de `/register` et creation d'un compte
- Connexion via `/login`
- Acces a `/dashboard` en session connectee
- Redirection vers `/login` en session invitee
- Deconnexion via `POST /logout`

Verification technique :

```bash
php artisan route:list
npm run build
```

## Ecart PLAN vs BUILD

- PLAN initial : auth manuelle native (controleurs et requests crees a la main).
- BUILD retenu : Laravel Breeze (Blade).
- Justification : base auth plus rapide a mettre en place, plus robuste, et totalement compatible avec les contraintes du projet.

## Risques et attention

- Ne pas melanger logique metier InterviewPrep dans les controleurs auth Breeze.
- Garder la personnalisation auth limitee pour eviter les regressions.
- Conserver les secrets AI uniquement dans `.env`.

## Notes AI-assisted

- PLAN assiste pour cadrer la feature.
- BUILD assiste avec ajustements manuels (notamment correction du build Vite avec `resources/js/bootstrap.js` et `axios`).
- Cette spec documente l'etat reel de la feature apres implementation.
