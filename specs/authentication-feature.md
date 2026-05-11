# Authentication Feature

## Statut

Planifiee - a construire apres validation du plan.

## Contexte

InterviewPrep est une application personnelle. Toutes les donnees metier doivent appartenir a un utilisateur connecte : domaines, concepts et generations AI.

L'authentification est donc la premiere feature fonctionnelle. Elle doit rester simple, native Laravel, sans starter front-end lourd et sans framework JavaScript.

## Objectifs

- Permettre a un utilisateur de creer un compte.
- Permettre a un utilisateur de se connecter.
- Permettre a un utilisateur de se deconnecter.
- Proteger les futures pages applicatives derriere le middleware `auth`.
- Preparer une base claire pour les relations `User -> Domain -> Concept -> GeneratedQuestion`.

## Non-objectifs

- Pas de verification email dans la premiere version.
- Pas de reset password dans la premiere version.
- Pas de roles administrateur.
- Pas de social login.
- Pas d'Inertia, Livewire, React ou Vue.

## User stories couvertes

- US1 - Inscription / Connexion / Deconnexion

## Decisions techniques

- Utiliser l'auth native Laravel avec `Auth::attempt()`, `auth()->login()` et `auth()->logout()`.
- Creer des controleurs dedies et fins pour separer les responsabilites.
- Creer des Form Requests pour `register` et `login`.
- Utiliser Blade et TailwindCSS pour des pages simples, modernes et responsives.
- Rediriger l'utilisateur connecte vers `/dashboard`.
- Rediriger l'utilisateur invite vers `/login`.
- Ne pas installer Laravel Breeze afin d'eviter une dependance et des fichiers inutiles pour ce projet academique.

## Fichiers a creer

```text
app/Http/Controllers/Auth/RegisteredUserController.php
app/Http/Controllers/Auth/AuthenticatedSessionController.php
app/Http/Requests/Auth/RegisterRequest.php
app/Http/Requests/Auth/LoginRequest.php
resources/views/auth/register.blade.php
resources/views/auth/login.blade.php
resources/views/layouts/guest.blade.php
resources/views/layouts/app.blade.php
resources/views/dashboard.blade.php
```

## Fichiers a modifier

```text
routes/web.php
app/Models/User.php
```

## Routes prevues

```php
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
```

Note : `DashboardController` peut etre cree dans une feature separee si l'on veut garder ce premier lot strictement centre sur l'authentification. Dans ce cas, `/dashboard` peut temporairement retourner une vue simple.

## Validations

### RegisterRequest

- `name` : obligatoire, string, max 255
- `email` : obligatoire, email, unique users
- `password` : obligatoire, confirmation, minimum 8 caracteres

### LoginRequest

- `email` : obligatoire, email
- `password` : obligatoire

## Experience utilisateur

- Design minimaliste, clair, responsive.
- Formulaires centres, champs lisibles, messages d'erreur visibles.
- Boutons Tailwind sobres.
- Navigation simple entre connexion et inscription.
- Apres connexion : redirection vers le dashboard.
- Apres deconnexion : redirection vers la page login.

## Criteres d'acceptation

- Un utilisateur peut creer un compte avec nom, email et mot de passe.
- Le mot de passe est hashe automatiquement par le cast du modele `User`.
- Un utilisateur peut se connecter avec des identifiants valides.
- Une erreur propre est affichee si les identifiants sont invalides.
- Un utilisateur connecte peut se deconnecter.
- Les routes protegees ne sont pas accessibles aux invites.
- Les routes `login` et `register` ne sont pas accessibles aux utilisateurs deja connectes.

## Commandes Artisan proposees

```bash
php artisan make:controller Auth/RegisteredUserController
php artisan make:controller Auth/AuthenticatedSessionController
php artisan make:request Auth/RegisterRequest
php artisan make:request Auth/LoginRequest
php artisan make:controller DashboardController --invokable
```

## Verification

```bash
vendor/bin/pint
php artisan test
```

Verification manuelle :

- Ouvrir `/register`
- Creer un compte
- Verifier la redirection vers `/dashboard`
- Se deconnecter
- Se reconnecter depuis `/login`
- Tester un mauvais mot de passe

## Risques

- Ne pas dupliquer la logique d'authentification entre plusieurs controleurs.
- Ne pas exposer de details sensibles dans les messages d'erreur.
- Ne pas ajouter de package externe inutile.
- Garder le dashboard provisoire simple si la feature dashboard n'est pas encore construite.

## Notes AI-assisted

Ce fichier sert de trace de travail PLAN avant BUILD.

Ce que l'agent doit generer pendant BUILD :

- controleurs auth,
- Form Requests,
- routes auth,
- vues Blade,
- layout minimal.

Ce qui doit etre relu ou ajuste manuellement :

- wording des messages en francais,
- coherence visuelle Tailwind,
- noms de routes,
- compatibilite avec les futures features `domains`, `concepts` et `ai-generation`.
