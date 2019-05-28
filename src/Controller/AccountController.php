<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\AccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class AccountController extends AbstractController
{

    public function renderAccountPage(UserInterface $user, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->find($user->getId());

        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Données utilisateur modifiés');
            return $this->redirectToRoute('account');
        }

        return $this->render('account/account.html.twig', [
            'template' => 'account/account',
            'accountInfo' => $form->createView()
        ]);

    }
}