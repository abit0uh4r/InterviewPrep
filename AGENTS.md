# AGENTS.md - InterviewPrep

## Mission

InterviewPrep est une application Laravel personnelle pour organiser la preparation aux entretiens techniques. L'utilisateur classe ses connaissances par domaine, redige des concepts, suit son niveau de maitrise et genere des questions d'entretien via l'API Groq.

Ce projet doit rester simple, lisible, pedagogique et defendable lors d'une soutenance academique.

## Role du coding agent

Le coding agent agit comme un assistant de developpement senior Laravel. Il aide a planifier, generer, verifier et documenter les features, mais le developpeur garde la responsabilite finale des choix techniques.

Avant chaque feature, le coding agent doit travailler en deux temps :

1. PLAN : analyser le besoin, proposer les fichiers, les routes, les commandes Artisan, les validations, les risques et les tests.
2. BUILD : coder uniquement apres validation du plan.

## Contraintes techniques

- Framework : Laravel
- Base de donnees : MySQL
- Vues : Blade
- CSS : TailwindCSS
- ORM : Eloquent
- Validation : Form Request
- API AI : Groq via `Http::` facade Laravel
- Authentification : auth native Laravel, sans Inertia, Livewire, React ou Vue
- Packages externes : eviter sauf besoin justifie
- Secrets : aucune cle API dans le code ou dans Git

## Architecture cible

L'architecture reste volontairement simple :

- `app/Models` : modeles Eloquent et relations
- `app/Http/Controllers` : controleurs fins, orchestration HTTP uniquement
- `app/Http/Requests` : validation des formulaires
- `app/Services` : logique metier ou integration externe, notamment Groq
- `app/Enums` : statuts et niveaux lisibles
- `app/Policies` : autorisations par utilisateur si necessaire
- `resources/views` : pages Blade et composants reutilisables
- `routes/web.php` : routes web groupees sous `auth`
- `database/migrations` : schema SQL versionne
- `specs` : une spec markdown par feature construite avec assistance AI

## Regles Laravel

- Garder les controleurs courts.
- Mettre les validations dans des Form Requests.
- Utiliser les relations Eloquent au lieu de requetes manuelles repetees.
- Utiliser l'eager loading pour eviter les problemes N+1.
- Utiliser les soft deletes pour l'archivage des concepts.
- Utiliser des accessors pour les labels affiches dans Blade.
- Centraliser l'appel Groq dans un service dedie.
- Afficher des erreurs propres si l'API AI ne repond pas.

## Workflow Git

Le projet doit utiliser des branches par feature :

- `feature/authentication`
- `feature/domains-crud`
- `feature/concepts-crud`
- `feature/ai-generation`
- `feature/dashboard`

Les commits doivent etre explicites et mentionner l'usage AI quand il existe.

Exemples :

- `docs(ai): add project agent workflow`
- `spec(ai): define authentication feature`
- `feat(ai): add native Laravel authentication`
- `feat(ai): implement domains CRUD`
- `fix(ai): handle Groq API failure message`
- `refactor(manual): simplify dashboard query names`

## Specs attendues

Chaque feature assistee par AI doit avoir une spec dans `specs/`.

Structure recommandee :

- Contexte
- Objectifs
- Non-objectifs
- User stories couvertes
- Decisions techniques
- Fichiers a creer ou modifier
- Routes prevues
- Validation
- Criteres d'acceptation
- Tests et verification
- Notes AI vs modifications manuelles

## Commandes utiles

Installation :

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Base de donnees :

```bash
php artisan migrate
php artisan migrate:fresh --seed
```

Developpement :

```bash
composer run dev
```

Qualite :

```bash
vendor/bin/pint
php artisan test
```

Git initial :

```bash
git init
git add AGENTS.md specs/
git commit -m "docs(ai): add AI-assisted workflow and authentication spec"
```

## Definition of Done

Une feature est terminee quand :

- la spec existe dans `specs/`,
- le code suit la spec validee,
- les validations sont dans des Form Requests,
- les routes sont protegees si necessaire,
- les vues sont responsives,
- les erreurs utilisateur sont propres,
- `vendor/bin/pint` passe,
- `php artisan test` passe ou les limites sont documentees,
- le commit Git explique l'usage AI et les ajustements manuels.
