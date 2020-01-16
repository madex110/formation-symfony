<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{
    /**
     * permet de configuer les champs
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder)
    {
        return ([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Ajouter un titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse web", "Ajouter l'adresse web (Automatique)"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("L'image principale de l'annonce", "Ajouter une image principale de l'annonce"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction de l'annonce", "Ajouter une introduction pour votre annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Contenu de l'annonce", "Ajouter un contenu pour votre annonce"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nomnbre de chambre", "Ajouter le nombre des chambres disponibles"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix d'une chambre par nuit", "Ajouter le prix par nuit de la chambre"))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
