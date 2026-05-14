# Archived Concepts Feature

## Statut

Planifiee - a implementer apres la feature concepts CRUD.

## Contexte

Supprimer un concept ne doit pas le detruire definitivement. L'application doit archiver les concepts avec soft deletes afin que l'utilisateur puisse les restaurer.

## Objectifs

- Archiver un concept au lieu de le supprimer definitivement.
- Afficher une page des concepts archives.
- Restaurer un concept archive.
- Conserver l'association avec son domaine.

## Non-objectifs

- Pas de suppression definitive dans la premiere version.
- Pas de restauration groupée.
- Pas d'archivage de domaines.

## User stories couvertes

- US10 - Supprimer un concept
- Bonus - Page archives et restauration

## Modele concerne

`Concept`

Le modele doit utiliser :

```php
use Illuminate\Database\Eloquent\SoftDeletes;
```

La migration `concepts` doit contenir :

```php
$table->softDeletes();
```

## Routes prevues

Routes protegees par `auth`.

```php
Route::get('archived-concepts', [ArchivedConceptController::class, 'index'])->name('archived-concepts.index');
Route::patch('archived-concepts/{concept}/restore', [ArchivedConceptController::class, 'restore'])->name('archived-concepts.restore');
```

## Controleur

`ArchivedConceptController`

- `index` : liste les concepts archives appartenant a l'utilisateur connecte.
- `restore` : restaure un concept archive si son domaine appartient a l'utilisateur connecte.

## Requetes Eloquent attendues

- Utiliser `onlyTrashed()` pour afficher les archives.
- Utiliser `restore()` pour restaurer.
- Utiliser `whereHas('domain', ...)` pour filtrer par utilisateur.
- Charger le domaine avec `with('domain')` pour eviter N+1.

## Vue Blade

```text
resources/views/concepts/archived.blade.php
```

## UI attendue

- Tableau simple des concepts archives.
- Titre du concept.
- Nom du domaine.
- Date d'archivage.
- Bouton restaurer.
- Etat vide clair si aucune archive.

## Commandes Artisan

```bash
php artisan make:controller ArchivedConceptController
```

## Criteres d'acceptation

- Un concept supprime n'est plus visible dans la liste active.
- Un concept supprime apparait dans la page archives.
- Un concept archive peut etre restaure.
- Un utilisateur ne peut pas restaurer un concept qui ne lui appartient pas.

## Verification

```bash
php artisan test
npm run build
```

Verification manuelle :

- Archiver un concept.
- Ouvrir la page archives.
- Restaurer le concept.
- Verifier qu'il reapparait dans la liste active.
