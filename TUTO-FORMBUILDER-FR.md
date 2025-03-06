# TUTO-FORMBUILDER-FR

---

# FORMULAIREBUILDER SYMFONY ÉTAPE PAR ÉTAPE ✅

### 1ère Étape : Installer et exécuter la commande pour créer le Type d’Entity :

- Entrer dans le conteneur Symfony PHP pour installer les dépendances :

```bash
docker exec -it symfo_php-fpm /bin/bash
```

```bash
composer require form validator
```

```bash
symfony console make:form
```

Sortie après l’exécution de la commande :

![image0.png](image0.png)

image info 0

---

### 2ème Étape : Créer une méthode dans `QuoteController.php` pour afficher la vue et créer notre formulaire à partir du type généré à la 1ère étape.

- Fichier `QuoteController.php`

```php
   #[Route('/form-quote', name: 'quote.form')]
    public function form(): Response
    {
        $form_builder = $this->createForm(QuoteType::class);
        return $this->render('quote/form.html.twig', [
            'form' => $form_builder
        ]);
    }
```

- Fichier `form.html.twig`

```html
{% extends 'base.html.twig' %}

{% block title %}Détails Quote{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">

    <h1>FormBuilder - Quotes</h1>
    {# snippet twig pour créer le formulaire #}
    {{ form(form) }}

</div>
{% endblock %}
```

- Pour ajouter une touche de beauté, nous pouvons utiliser **Bootstrap** dans notre formulaire. Pour cela, allez dans le fichier `twig.yaml` et ajoutez le `form_themes` comme ci-dessous :

```bash
twig:
    file_name_pattern: '*.twig'
    form_themes: ['bootstrap_5_layout.html.twig']

when@test:
    twig:
        strict_variables: true
```

Sortie actuelle dans le navigateur :

![image1.png](image1.png)

image info 1

---

### 3ème Étape : Modifier le CSS et le format du layout du formulaire et ajouter le bouton Submit.

- Fichier `form.html.twig` (Ajout de CSS pour styliser et modifier le layout)

```php
{% extends 'base.html.twig' %}

{% block title %}Détails Quote{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">

    <h1>FormBuilder - Quotes</h1>
    <br>
    
    {# snippet twig pour créer le formulaire direct avec flex-column #}
    {# {{ form(form) }} #}

    <div class="border p-3">
        {# snippet twig pour créer le formulaire avec la possibilité d'ajouter du CSS #}
        {{form_start(form)}}
            <h4>Formulaire Quotes</h4>
            <div class="d-flex gap-3">
                {{form_row(form.historian)}}
                {{form_row(form.year)}}
            </div>
    
        {{form_rest(form)}}
        {{form_end(form)}}
    </div>

</div>
{% endblock %}
```

- Fichier `QuoteType.php` (Ajouter le bouton Submit)

```php
<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quote')
            ->add('historian')
            ->add('year')
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
```

- Ajouter Bootstrap pour le formulaire dans `twig.yaml` :

```yaml
twig:
    file_name_pattern: '*.twig'
    form_themes: ['bootstrap_5_layout.html.twig']

when@test:
    twig:
        strict_variables: true
```

Sortie actuelle dans le navigateur :

![image2.png](image2.png)

image info 2

---

### 4ème Étape : Capturer la Request dans `QuoteController` et valider le formulaire.

- Fichier `QuoteController.php` (Capture de la requête + vérification de la soumission et validation)

```php
    #[Route('/form-quote', name: 'quote.form')]
    public function form(Request $request): Response
    {
        $form_builder = $this->createForm(QuoteType::class);
        $form_builder->handleRequest($request);

        if ($form_builder->isSubmitted() && $form_builder->isValid()) {

            // $form_builder->getData() contient les valeurs soumises
            $quote_submit = $form_builder->getData();
            dd($quote_submit);
            // ... effectuer une action, comme enregistrer la tâche en base de données

            //return $this->redirectToRoute('task_success');
        }
        
        return $this->render('quote/form.html.twig', [
            'form' => $form_builder
        ]);
    }
```

Sortie actuelle dans le navigateur après avoir cliqué sur “Sauvegarder” :

![image3.png](image3.png)

image info 3

### 5ème Étape : Ajouter les constraints au fichier QuoteType.php e modifier le fichier form.html.twig pour afficher

- Fichier QuoteType.php (Attention avec les use pour import correctement les modules des libraries)

```php
<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quote', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ "quote" ne peut pas être vide.']),
                    new Length(['min' => 10, 'minMessage' => 'La citation doit comporter au moins {{ limit }} caractères.'])
                ],
            ])
            ->add('historian', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ "historian" ne peut pas être vide.'])
                ],
            ])
            ->add('year', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ "year" ne peut pas être vide.']),
                    new Length([
                        'min' => 4, 
                        'max' => 4,
                        'exactMessage' => 'L\'année doit comporter exactement {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}

```

Fichier form.html.twig ( afficher les errors)

```html
{% extends 'base.html.twig' %}

{% block title %}Details Quote{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">
    <h1>FormBuilder - Quotes</h1>
    <br>
    <div class="mb-3">
        <a href="{{ path('quote.index') }}" class="btn btn-primary">Retour</a>
    </div>

    <div class="border p-3">
        {{ form_start(form) }}
            <h4>Formulaire Quotes</h4>
            
            {# Renderiza o campo Quote com erros #}
            <div class="mb-3">
                {{ form_label(form.quote) }}
                {{ form_widget(form.quote, {'attr': {'class': 'form-control'}}) }}
                {{ form_errors(form.quote) }}
            </div>

            {# Renderiza o campo Historian com erros #}
            <div class="mb-3">
                {{ form_label(form.historian) }}
                {{ form_widget(form.historian, {'attr': {'class': 'form-control'}}) }}
                {{ form_errors(form.historian) }}
            </div>

            {# Renderiza o campo Year com erros #}
            <div class="mb-3">
                {{ form_label(form.year) }}
                {{ form_widget(form.year, {'attr': {'class': 'form-control'}}) }}
                {{ form_errors(form.year) }}
            </div>
        {{ form_end(form) }}
    </div>
</div>
{% endblock %}

```

Sortie dans le navigateur : 

![image.png](image.png)

---