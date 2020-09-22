<?php

namespace App\Controller\Portal;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", methods="GET")
 */
class PostController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index(PostRepository $repository)
    {
        $posts = $repository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"})
     */
    public function create()
    {
        $newPost = new Post();
        $newPost->setPublishedAt(new \DateTime());

        $createForm = $this->createFormBuilder($newPost)
            ->add('title')
            ->add('author')
            ->getForm();

        return $this->render('post/create.html.twig', [
            'create_form' => $createForm->createView(),
        ]);
    }
}
