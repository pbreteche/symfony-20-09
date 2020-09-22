<?php

namespace App\Controller\Portal;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $newPost = new Post();
        $newPost->setPublishedAt(new \DateTime());

        $createForm = $this->createFormBuilder($newPost)
            ->add('title')
            ->add('author')
            ->getForm();

        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $manager->persist($newPost);
            $manager->flush();

            $this->addFlash('Success', 'Votre post a bien été créé.');

            return $this->redirectToRoute('app_portal_post_show', [
                'id' => $newPost->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/create.html.twig', [
            'create_form' => $createForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "PUT"})
     */
    public function update(Post $post, Request $request, EntityManagerInterface $manager)
    {
        $editForm = $this->createFormBuilder($post, [
            'method' => 'PUT'
        ])
            ->add('title')
            ->add('author')
            ->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $manager->flush();

            $this->addFlash('Success', 'Votre post a bien été modifié.');

            return $this->redirectToRoute('app_portal_post_show', [
                'id' => $post->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/update.html.twig', [
            'post' => $post,
            'edit_form' => $editForm->createView(),
        ]);
    }
}
