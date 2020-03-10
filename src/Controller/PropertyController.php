<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{


    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/biens", name="property.index")
     */
    public function index()
    {
        /*$property = new Property();
        $property->setTitle('Mon premier bien')
            ->setDescription('petite description')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(1)
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity("Paris")
            ->setAddress("15 rue gambetta")
            ->setPostalCode("94000");

        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();*/
        $property = $this->repository->findAllVisibile();


        $latest = $this->repository->findLatest();
        //$this->em->flush();
        dump($latest);



        return $this->render('pages/index.html.twig', ['current_menu' => 'properties']);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show",requirements={"slug":"[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug): Response
    {

        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('pages/show.html.twig', ['current_menu' => 'properties', 'property' => $property]);
    }
}
