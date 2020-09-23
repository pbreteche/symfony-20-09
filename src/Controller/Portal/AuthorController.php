<?php

namespace App\Controller\Portal;

use App\Entity\Author;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author/{id}", methods="GET")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/posts")
     */
    public function indexPosts(Author $author, PostRepository $repository)
    {
        $posts = $repository->findBy(['writtenBy' => $author]);

        return $this->render('author/index_posts.html.twig', [
            'author' => $author,
            'posts' => $posts,
        ]);
    }
}