# Domains CRUD Feature

## Statut

Planifiee - a implementer apres validation.

## Contexte

Les domaines techniques permettent a l'utilisateur d'organiser sa preparation par grandes familles de competences : Laravel, PHP OOP, MySQL, API REST, Git, etc.

Chaque domaine appartient a un utilisateur connecte. Un utilisateur ne doit jamais voir, modifier ou supprimer les domaines d'un autre utilisateur.

## Objectifs

- Afficher la liste des domaines de l'utilisateur connecte.
- Creer un domaine avec un nom et une couleur de badge.
- Modifier un domaine existant.
- Supprimer un domaine.
- Afficher pour chaque domaine le nombre total de concepts et le nombre de concepts maitrises.

## Non-objectifs

- Pas de partage de domaine entre utilisateurs.
- Pas d'import/export de domaines.
- Pas de gestion avancee des couleurs.

## User stories couvertes

- US2 - Liste de mes domaines
- US3 - Creer un domaine
- US4 - Modifier / Supprimer un domaine

## Modele

`Domain`

Champs prevus :

- `id`
- `user_id`
- `name`
- `color`
- `created_at`
- `updated_at`

## Relations Eloquent

- `User hasMany Domain`
- `Domain belongsTo User`
- `Domain hasMany Concept`

## Migration prevue

```php
Schema::create('domains', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->string('color')->default('#2563eb');
    $table->timestamps();
});
```

## Routes prevues

Routes protegees par `auth`.

```php
Route::resource('domains', DomainController::class);
```

## Controleur

`DomainController`

Methodes attendues :

- `index` : liste les domaines de l'utilisateur connecte avec `withCount`.
- `create` : affiche le formulaire de creation.
- `store` : valide et cree un domaine pour `auth()->user()`.
- `show` : affiche un domaine et ses statistiques.
- `edit` : affiche le formulaire d'edition.
- `update` : valide et met a jour le domaine.
- `destroy` : supprime le domaine.

## Validation

`StoreDomainRequest`

- `name` : required, string, max:255
- `color` : required, string, format hex simple

`UpdateDomainRequest`

- `name` : required, string, max:255
- `color` : required, string, format hex simple

## Vues Blade

```text
resources/views/domains/index.blade.php
resources/views/domains/create.blade.php
resources/views/domains/edit.blade.php
resources/views/domains/show.blade.php
```

## UI attendue

- Page simple type SaaS.
- Cartes de domaines sobres.
- Badge couleur visible.
- Compteur concepts total.
- Compteur concepts maitrises.
- Boutons create, edit, delete clairement visibles.
- Responsive desktop et mobile.

## Anti N+1

La liste des domaines doit utiliser `withCount()` pour calculer :

- nombre total de concepts,
- nombre de concepts avec statut `mastered`.

## Autorisations

Au minimum, filtrer toutes les requetes par `auth()->id()`.

Une `DomainPolicy` pourra etre ajoutee si la logique d'autorisation devient repetee dans plusieurs methodes.

## Commandes Artisan

```bash
php artisan make:model Domain -m
php artisan make:controller DomainController --resource
php artisan make:request StoreDomainRequest
php artisan make:request UpdateDomainRequest
```

## Criteres d'acceptation

- Un utilisateur connecte voit uniquement ses domaines.
- Un utilisateur peut creer un domaine avec nom et couleur.
- Un utilisateur peut modifier ses domaines.
- Un utilisateur peut supprimer ses domaines.
- Les compteurs concepts sont visibles dans la liste.
- Les validations affichent des messages propres.

## Verification

```bash
php artisan migrate
php artisan route:list
npm run build
php artisan test
```

Verification manuelle :

- Creer un domaine.
- Modifier son nom.
- Modifier sa couleur.
- Supprimer un domaine.
- Verifier qu'un domaine appartient bien a l'utilisateur connecte.
