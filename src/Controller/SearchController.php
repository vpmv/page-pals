<?php

namespace App\Controller;

use App\Service\Biblio\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Client $biblio, Request $request): Response {
        $t = $request->query->get('type', 'book');
        $q = $request->query->get('q');

        $books = [];
        $authors = [];

        if ($q) {
            switch ($t) {
                case 'book':
                case 'books':
                    $books = $biblio->searchBooks($q);
                    break;
                case 'author':
                case 'authors':
                    $authors = $biblio->searchAuthors($q);
                    break;
            }
        }

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'books'           => $books,
            'authors'         => $authors,
            'q'               => $q,
        ]);
    }

}
