<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends ApplicationType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Ajouter un titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse web", "Ajouter l'adresse web (Automatique)", [
                'required' => false
            ]))
            ->add('coverImage', UrlType::class, $this->getConfiguration("L'image principale de l'annonce", "Ajouter une image principale de l'annonce"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction de l'annonce", "Ajouter une introduction pour votre annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Contenu de l'annonce", "Ajouter un contenu pour votre annonce"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nomnbre de chambre", "Ajouter le nombre des chambres disponibles"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix d'une chambre par nuit", "Ajouter le prix par nuit de la chambre"))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
