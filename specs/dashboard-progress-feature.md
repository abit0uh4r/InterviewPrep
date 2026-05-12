# Dashboard Progress Feature

## Statut

Planifiee - a implementer apres domains CRUD et concepts CRUD.

## Contexte

Le dashboard est la page d'accueil de l'utilisateur connecte. Il doit donner une vue rapide de sa progression globale et l'aider a choisir quoi reviser ensuite.

## Objectifs

- Afficher les statistiques globales de preparation.
- Afficher le nombre de concepts par statut.
- Afficher le domaine le mieux maitrise.
- Afficher le domaine le plus a revoir.
- Proposer des raccourcis vers les domaines et concepts.

## Non-objectifs

- Pas de graphiques complexes dans la premiere version.
- Pas de dashboard admin.
- Pas de statistiques globales entre utilisateurs.

## Donnees affichees

- Nombre total de domaines.
- Nombre total de concepts actifs.
- Nombre de concepts `to_review`.
- Nombre de concepts `in_progress`.
- Nombre de concepts `mastered`.
- Domaine avec le plus de concepts maitrises.
- Domaine avec le plus de concepts a revoir.

## Requetes attendues

Les statistiques doivent etre filtrees par utilisateur connecte.

Exemples de logique :

- `auth()->user()->domains()->count()`
- concepts via `whereHas('domain', fn ($query) => $query->where('user_id', auth()->id()))`
- domaines avec `withCount()` pour eviter N+1.

## Route prevue

La route existe deja avec Breeze :

```php
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
```

Elle pourra etre remplacee par un controleur invokable :

```php
Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');
```

## Controleur

`DashboardController`

Controleur invokable pour preparer les statistiques et retourner la vue.

## Vue Blade

```text
resources/views/dashboard.blade.php
```

## UI attendue

- Style SaaS minimaliste.
- Cartes statistiques lisibles.
- Couleurs sobres pour les statuts.
- Responsive mobile et desktop.
- Liens rapides vers la liste des domaines et les concepts a revoir.

## Commande Artisan

```bash
php artisan make:controller DashboardController --invokable
```

## Criteres d'acceptation

- Le dashboard est accessible uniquement aux utilisateurs connectes.
- Les statistiques ne concernent que l'utilisateur connecte.
- Les compteurs par statut sont corrects.
- Le domaine le mieux maitrise est affiche si disponible.
- Le domaine le plus a revoir est affiche si disponible.
- Un etat vide est affiche si l'utilisateur n'a pas encore de domaines.

## Verification

```bash
php artisan test
npm run build
```

Verification manuelle :

- Creer plusieurs domaines.
- Creer plusieurs concepts avec statuts differents.
- Ouvrir `/dashboard`.
- Verifier les compteurs affiches.
