<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauType;
use App\core\PaginationModel;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NiveauController extends AbstractController
{
    #[Route('/niveau', name: 'niveau.index')]
    public function index(Request $request, NiveauRepository $niveauRepository, EntityManagerInterface $entityManager): Response
    {
        $niveau = new Niveau();
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niveau);
            $entityManager->flush();
            $this->addFlash('success', 'Niveau créé avec succès');
            return $this->redirectToRoute('niveau.index');
        }
        $currentPage = $request->query->getInt('page', 1);
        $pageSize = 2;
        $queryBuilder = $niveauRepository->createQueryBuilder('e');
        $pagination = PaginationModel::paginate($queryBuilder, $pageSize, $currentPage);
       
        return $this->render('niveau/index.html.twig', [
            'niveaux' => $pagination->getItems(),
            'pagination' => $pagination,
            'route' => 'niveau.index',
            'form' => $form->createView(),
        ]);
    }
}
