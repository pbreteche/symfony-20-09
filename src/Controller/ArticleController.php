<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", methods="GET")
     */
    public function index(PostRepository $repository)
    {
        $articles = $repository->findAll();

        return $this->json($articles);
    }

    /**
     * @Route("/article/{id}", requirements={"id": "\d+"})
     */
    public function show(int $id, PostRepository $repository)
    {
        $article = $repository->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Article '.$id.' not found.');
        }

        return $this->json($article);
    }
}
