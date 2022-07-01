<?php

namespace App\Controller;

use App\Entity\Receipt;
use App\Form\ReceiptType;
use App\Repository\ReceiptRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReceiptController extends AbstractController
{
    #[Route('/receipt', name: 'view_receipt_list')]
    public function ReceiptIndex(ReceiptRepository $receiptRepository)
    {
        $receipts = $receiptRepository->findAll();
        return $this->render(
            "receipt/index.html.twig",
        [
            'receipts' => $receipts
        ]
        );
    }
    #[Route('/receiptdetail/{id}', name: 'view_receipt_by_id')]
    public function ReceiptDetail(ReceiptRepository $receiptRepository, $id)
    {
        $receipt = $receiptRepository->find($id);
        return $this->render(
            "receipt/detail.html.twig",
        [
            'receipt' => $receipt
        ]
        );
    }
    #[Route('/receiptdelete/{id}', name: 'delete_receipt')]
    public function ReceiptDelete(ReceiptRepository $ReceiptRepository, $id) {
        $receipt = $ReceiptRepository->find($id);
        if ($receipt == null) {
            $this->addFlash("Error","Receipt not found !");        
        } 
        else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($receipt);
            $manager->flush();
            $this->addFlash("Success","Delete receipt succeed  !");
        }
        return $this->redirectToRoute("view_receipt_list");
    }
    #[Route('/receiptadd', name: 'add_receipt')]
    public function ReceiptAdd(Request $request) {
        $receipt = new Receipt;
        $form = $this->createForm(ReceiptType::class,$receipt);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($receipt);
            $manager->flush();
            $this->addFlash("Success","Add receipt succeed !");
            return $this->redirectToRoute("view_receipt_list");
        }
        return $this->render("receipt/add.html.twig",
        [
            'receiptForm' => $form->createView()
        ]);
    }

    #[Route('/receiptedit/{id}', name: 'edit_receipt')]
    public function ReceiptEdit(Request $request, ReceiptRepository $receiptRepository, $id) {
        $receipt = $receiptRepository->find($id);
        if ($receipt == null) {
            $this->addFlash("Error","Receipt not found !");
            return $this->redirectToRoute("view_receipt_list");        
        } else {
            $form = $this->createForm(ReceiptType::class,$receipt);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($receipt);
                $manager->flush();
                $this->addFlash("Success","Edit receipt succeed !");
                return $this->redirectToRoute("view_receipt_list");
            }
            return $this->renderForm("receipt/edit.html.twig",
            [
                'receiptForm' => $form
            ]);
        }   
    }
}
