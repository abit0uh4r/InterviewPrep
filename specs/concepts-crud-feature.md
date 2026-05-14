# Concepts CRUD Feature

## Statut

Planifiee - a implementer apres validation.

## Contexte

Un concept represente une notion technique a reviser dans un domaine : Eloquent N+1 Problem, Service Container, Index SQL, Dependency Injection, etc.

Chaque concept appartient a un domaine, et donc indirectement a un utilisateur.

## Objectifs

- Lister les concepts d'un domaine.
- Creer un concept avec titre, explication, difficulte et statut.
- Afficher le detail d'un concept.
- Modifier un concept.
- Supprimer un concept via soft delete.
- Filtrer les concepts par statut et difficulte.
- Changer rapidement le statut depuis la liste.

## Non-objectifs

- Pas de generation AI dans cette feature.
- Pas de page d'archives dans cette feature.
- Pas d'editeur riche pour l'explication.

## User stories couvertes

- US5 - Liste des concepts d'un domaine
- US6 - Creer un concept
- US7 - Voir le detail d'un concept
- US8 - Modifier un concept
- US9 - Changer le statut rapidement
- US10 - Supprimer un concept

## Modele

`Concept`

Champs prevus :

- `id`
- `domain_id`
- `title`
- `explanation`
- `difficulty`
- `status`
- `deleted_at`
- `created_at`
- `updated_at`

## Enums

`ConceptDifficulty`

- `junior`
- `mid`
- `senior`

`ConceptStatus`

- `to_review`
- `in_progress`
- `mastered`

## Relations Eloquent

- `Domain hasMany Concept`
- `Concept belongsTo Domain`
- `Concept hasMany GeneratedQuestion`

## Migration prevue

```php
Schema::create('concepts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('domain_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->text('explanation');
    $table->string('difficulty')->default('junior');
    $table->string('status')->default('to_review');
    $table->softDeletes();
    $table->timestamps();
});
```

## Accessors attendus

Dans `Concept` :

- `difficulty_label` : Junior, Mid, Senior
- `status_label` : A revoir, En cours, Maitrise

## Routes prevues

Routes protegees par `auth`.

```php
Route::resource('domains.concepts', ConceptController::class);
Route::patch('concepts/{concept}/status', ConceptStatusController::class)->name('concepts.status.update');
```

## Controleurs

`ConceptController`

- CRUD principal des concepts.
- Verifie que le domaine appartient a l'utilisateur connecte.
- Utilise eager loading pour afficher les generations dans `show`.

`ConceptStatusController`

- Controleur invokable pour le changement rapide de statut.
- Valide uniquement le champ `status`.

## Validation

`StoreConceptRequest`

- `title` : required, string, max:255
- `explanation` : required, string
- `difficulty` : required, in:junior,mid,senior
- `status` : nullable, in:to_review,in_progress,mastered

`UpdateConceptRequest`

- `title` : required, string, max:255
- `explanation` : required, string
- `difficulty` : required, in:junior,mid,senior
- `status` : required, in:to_review,in_progress,mastered

## Vues Blade

```text
resources/views/concepts/index.blade.php
resources/views/concepts/create.blade.php
resources/views/concepts/edit.blade.php
resources/views/concepts/show.blade.php
```

## UI attendue

- Liste de concepts lisible dans le detail d'un domaine.
- Badges pour difficulte et statut.
- Filtres combinables par statut et difficulte.
- Bouton ou select simple pour changer rapidement le statut.
- Detail concept avec explication complete.

## Anti N+1

- Charger le domaine avec ses concepts quand necessaire.
- Charger les generations AI dans la page detail du concept avec eager loading.

## Commandes Artisan

```bash
php artisan make:model Concept -m
php artisan make:controller ConceptController --resource
php artisan make:controller ConceptStatusController --invokable
php artisan make:request StoreConceptRequest
php artisan make:request UpdateConceptRequest
```

## Criteres d'acceptation

- Un utilisateur voit uniquement les concepts de ses domaines.
- Un concept peut etre cree, consulte, modifie et archive.
- Le statut peut etre modifie rapidement depuis la liste.
- Les labels de statut et difficulte sont affiches proprement.
- Les filtres statut + difficulte fonctionnent ensemble.

## Verification

```bash
php artisan migrate
php artisan route:list
npm run build
php artisan test
```

Verification manuelle :

- Creer plusieurs concepts dans un domaine.
- Tester les filtres.
- Modifier un concept.
- Changer rapidement un statut.
- Supprimer un concept et verifier qu'il n'apparait plus dans la liste active.
