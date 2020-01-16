<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {

        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * @Route("/ads/new", name="ads_create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $ad = new Ad();

        $image = new Image();
        $image->setUrl('http://placehold.it/400x200')
            ->setCaption('Titre 1');
        $image2 = new Image();
        $image2->setUrl('http://placehold.it/400x200')
            ->setCaption('Titre 2');

        $ad->addImage($image)
            ->addImage($image2);

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> à bien été enregistrée ! "
            );

            return $this->redirectToRoute("ads_show", [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ads/{slug}", name="ads_show")
     */
    public function show(Ad $ad)
    {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
