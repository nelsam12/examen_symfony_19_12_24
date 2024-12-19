<?php

namespace App\Controller;

use App\core\PaginationModel;
use App\Repository\CoursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'cours.index')]
    public function index(Request $request, CoursRepository $coursRepository): Response
    {
        $currentPage = $request->query->getInt('page', 1);
        $pageSize = 2;
        $queryBuilder = $coursRepository->createQueryBuilder('e');
        $pagination = PaginationModel::paginate($queryBuilder, $pageSize, $currentPage);
       
        return $this->render('cours/index.html.twig', [
            'cours' => $pagination->getItems(),
            'pagination' => $pagination,
            'route' => 'niveau.index',
        ]);
    }

    #[Route('/cours/store', name: 'cours.store')]
    public function store(Request $request, CoursRepository $coursRepository): Response
    {
        $currentPage = $request->query->getInt('page', 1);
        $pageSize = 2;
        $queryBuilder = $coursRepository->createQueryBuilder('e');
        $pagination = PaginationModel::paginate($queryBuilder, $pageSize, $currentPage);
       
        return $this->render('cours/form.html.twig', [
            'cours' => $pagination->getItems(),
            'pagination' => $pagination,
            'route' => 'niveau.index',
        ]);
    }
}
