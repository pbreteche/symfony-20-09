<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
