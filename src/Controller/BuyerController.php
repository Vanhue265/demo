<?php

namespace App\Controller;

use App\Entity\Buyer;
use App\Form\BuyerType;
use App\Repository\BuyerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/buyer')]
class BuyerController extends AbstractController
{
    #[Route('/', name: 'view_buyer_list')]
    public function Buyerindex(BuyerRepository $buyerRepository)
    {
        $buyers = $buyerRepository->findAll();
        return $this->render("buyer/index.html.twig", [
            'buyers' => $buyers
        ]);
    }
    #[Route('/buyerdetail/{id}', name: 'view_buyer_by_id')]
    public function BuyerDetail(BuyerRepository $buyerRepository, $id)
    {
        $buyer = $buyerRepository->find($id);
        return $this->render(
            "buyer/detail.html.twig",
        [
            'buyer' => $buyer
        ]
        );
    }
    #[Route('/buyerdelete/{id}', name: 'delete_buyer')]
    public function BuyerDelete(BuyerRepository $buyerRepository, $id) {
        $buyer = $buyerRepository->find($id);
        if ($buyer == null) {
            $this->addFlash("Error","Buyer not found !");        
        } 
        else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($buyer);
            $manager->flush();
            $this->addFlash("Success","Delete buyer succeed  !");
        }
        return $this->redirectToRoute("view_buyer_list");
    }

    #[Route('/buyeradd', name: 'add_buyer')]
    public function BuyerAdd(Request $request) {
        $buyer = new Buyer;
        $form = $this->createForm(BuyerType::class,$buyer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($buyer);
            $manager->flush();
            $this->addFlash("Success","Add buyer succeed !");
            return $this->redirectToRoute("view_buyer_list");
        }
        return $this->render("buyer/add.html.twig",
        [
            'buyerForm' => $form->createView()
        ]);
    }

    #[Route('/buyeredit/{id}', name: 'edit_buyer')]
    public function BuyerEdit(Request $request, ManagerRegistry $managerRegistry, $id) {
        $buyer = $managerRegistry->getRepository(Buyer::class)->find($id);
        if ($buyer == null) {
            $this->addFlash("Error","Buyer not found !");
            return $this->redirectToRoute("view_buyer_list");        
        } else {
            $form = $this->createForm(BuyerType::class,$buyer);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($buyer);
                $manager->flush();
                $this->addFlash("Success","Edit buyer succeed !");
                return $this->redirectToRoute("view_buyer_list");
            }
            return $this->render("buyer/edit.html.twig",
            [
                'buyerForm' => $form->createView()
            ]);
        }   
    }
}