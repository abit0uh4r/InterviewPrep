# AI Generation Feature

## Statut

Planifiee - a implementer apres concepts CRUD.

## Contexte

InterviewPrep doit aider l'utilisateur a s'entrainer avec des questions d'entretien techniques realistes. Les questions sont generees avec l'API Groq a partir du titre et de l'explication d'un concept.

Le resultat doit etre sauvegarde en base avant affichage pour garder un historique.

## Objectifs

- Generer 5 questions d'entretien pour un concept.
- Appeler Groq via la facade Laravel `Http::`.
- Sauvegarder chaque lot de questions en base.
- Afficher l'historique des generations sur la page detail du concept.
- Supprimer une generation inutile.
- Afficher un message propre si l'API echoue.

## Non-objectifs

- Pas de streaming de reponse.
- Pas de chat interactif.
- Pas de package externe AI.
- Pas de cle API dans le code.

## User stories couvertes

- US11 - Generer des questions d'entretien
- US12 - Voir l'historique des generations
- US13 - Supprimer une generation

## Modele

`GeneratedQuestion`

Champs prevus :

- `id`
- `concept_id`
- `questions`
- `provider`
- `model`
- `created_at`
- `updated_at`

## Relations Eloquent

- `Concept hasMany GeneratedQuestion`
- `GeneratedQuestion belongsTo Concept`

## Migration prevue

```php
Schema::create('generated_questions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('concept_id')->constrained()->cascadeOnDelete();
    $table->json('questions');
    $table->string('provider')->default('groq');
    $table->string('model')->nullable();
    $table->timestamps();
});
```

## Service

`GroqQuestionGeneratorService`

Responsabilites :

- Construire le prompt.
- Appeler l'API Groq avec `Http::`.
- Lire la reponse.
- Retourner un tableau de 5 questions.
- Lever une exception controlee ou retourner une erreur propre en cas d'echec.

## Configuration

Variables `.env` attendues :

```env
GROQ_API_KEY=
GROQ_MODEL=llama-3.1-8b-instant
```

Configuration possible dans `config/services.php` :

```php
'groq' => [
    'key' => env('GROQ_API_KEY'),
    'model' => env('GROQ_MODEL', 'llama-3.1-8b-instant'),
],
```

## Routes prevues

Routes protegees par `auth`.

```php
Route::post('concepts/{concept}/generated-questions', [GeneratedQuestionController::class, 'store'])->name('concepts.generated-questions.store');
Route::delete('generated-questions/{generatedQuestion}', [GeneratedQuestionController::class, 'destroy'])->name('generated-questions.destroy');
```

## Controleur

`GeneratedQuestionController`

- `store` : verifie l'acces au concept, appelle le service Groq, sauvegarde le resultat, redirige vers le detail du concept.
- `destroy` : verifie l'acces et supprime une generation.

## Validation

Pas de formulaire complexe pour `store`, car le concept fournit deja les donnees necessaires.

Le controleur doit surtout verifier :

- utilisateur connecte,
- concept appartenant a l'utilisateur,
- cle Groq configuree,
- reponse API exploitable.

## Vue concernee

```text
resources/views/concepts/show.blade.php
```

La page detail du concept doit afficher :

- bouton "Generer des questions",
- message de succes ou erreur,
- historique des generations,
- date de generation,
- liste des 5 questions,
- bouton supprimer.

## Gestion des erreurs

Si Groq echoue :

- ne pas afficher de page blanche,
- ne pas sauvegarder de generation vide,
- rediriger vers le concept avec un message clair,
- logger l'erreur si necessaire.

## Commandes Artisan

```bash
php artisan make:model GeneratedQuestion -m
php artisan make:controller GeneratedQuestionController
```

Le service est cree manuellement :

```text
app/Services/GroqQuestionGeneratorService.php
```

## Criteres d'acceptation

- L'utilisateur peut generer 5 questions pour un concept.
- Les questions sont sauvegardees en base.
- L'historique est visible sur la page detail du concept.
- Une generation peut etre supprimee.
- Les erreurs API sont affichees proprement.
- La cle API n'apparait jamais dans Git.

## Verification

```bash
php artisan test
npm run build
```

Verification manuelle :

- Configurer `GROQ_API_KEY`.
- Ouvrir un concept.
- Cliquer sur "Generer des questions".
- Verifier l'affichage et la sauvegarde.
- Supprimer une generation.
- Tester le comportement avec une cle API absente.
