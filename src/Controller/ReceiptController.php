<?php

namespace App\Controller;

use App\Repository\ReceiptRepository;
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
    
}
