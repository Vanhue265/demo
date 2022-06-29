<?php

namespace App\Controller;

use App\Entity\Buyer;
use App\Form\BuyerType;
use App\Repository\BuyerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/buyer')]
class BuyerController extends AbstractController
{
    #[Route('/', name: 'view_buyer_list')]
    public function Buyerindex(BuyerRepository $buyerRepository)
    {
        $buyer = $buyerRepository->findAll();
        return $this->render("buyer/index.html.twig", [
            'buyers' => $buyer,
        ]);
    }
    #[Route('/delete/{id}', name: 'delete_buyer')]
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

    #[Route('/add', name: 'add_buyer')]
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

    #[Route('/edit/{id}', name: 'edit_buyer')]
    public function BuyerEdit(Request $request, BuyerRepository $buyerRepository, $id) {
        $buyer = $buyerRepository->find($id);
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
            return $this->renderForm("buyer/edit.html.twig",
            [
                'buyerForm' => $form
            ]);
        }   
    }

    #[Route('/searchbybuyername', name: 'search_buyer_name')]
    public function BuyerSearchByName (BuyerRepository $buyerRepository, Request $request) {
        $name = $request->get('keyword');
        $buyer = $buyerRepository->searchByName($name);
        return $this->render(
            "buyer/index.html.twig",
            [
                'buyers' => $buyers
            ]);
    }


}
