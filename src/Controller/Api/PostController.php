<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/article", methods="GET")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(PostRepository $repository)
    {
        $articles = $repository->findAll();

        return $this->json($articles);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function show(int $id, PostRepository $repository, Request $request)
    {
        $displayMode = $request->query->get('format', 'full');

        $post = $repository->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Article '.$id.' not found.');
        }

        return $this->json($post);
    }

    /**
     * @Route("/{id}/show", requirements={"id": "\d+"})
     */
    public function show2(Post $post)
    {
        return $this->json($post);
    }
}
