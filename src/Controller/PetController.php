<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Form\PetType;
use App\Repository\PetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PetController extends AbstractController
{
    #[Route('/', name: 'view_pet_list')]
    public function PetIndex(PetRepository $petRepository)
    {
        $pets = $petRepository->findAll();
        return $this->render(
            "pet/index.html.twig",
        [
            'pets' => $pets
        ]
        );
    }

    #[Route('/detail/{id}', name: 'view_pet_by_id')]
    public function PetDetail(PetRepository $petRepository, $id)
    {
        $pet = $petRepository->find($id);
        return $this->render(
            "pet/detail.html.twig",
        [
            'pet' => $pet
        ]
        );
    }


    #[Route('/delete/{id}', name: 'delete_pet')]
    public function PetDelete(PetRepository $petRepository, $id) {
        $pet = $petRepository->find($id);
        if ($pet == null) {
            $this->addFlash("Error","Pet not found !");        
        } 
        else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($pet);
            $manager->flush();
            $this->addFlash("Success","Delete pet succeed  !");
        }
        return $this->redirectToRoute("view_pet_list");
    }

    #[Route('/add', name: 'add_pet')]
    public function PetAdd(Request $request) {
        $pet = new Pet;
        $form = $this->createForm(PetType::class,$pet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($pet);
            $manager->flush();
            $this->addFlash("Success","Add pet succeed !");
            return $this->redirectToRoute("view_pet_list");
        }
        return $this->render("pet/add.html.twig",
        [
            'petForm' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_pet')]
    public function PetEdit(Request $request, PetRepository $petRepository, $id) {
        $pet = $petRepository->find($id);
        if ($pet == null) {
            $this->addFlash("Error","Pet not found !");
            return $this->redirectToRoute("view_pet_list");        
        } else {
            $form = $this->createForm(PetType::class,$pet);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($pet);
                $manager->flush();
                $this->addFlash("Success","Edit pet succeed !");
                return $this->redirectToRoute("view_pet_list");
            }
            return $this->renderForm("pet/edit.html.twig",
            [
                'petForm' => $form
            ]);
        }   
    }

    #[Route('/searchbyname', name: 'search_pet_name')]
    public function PetSearchByName (PetRepository $petRepository, Request $request) {
        $name = $request->get('keyword');
        $pets = $petRepository->searchByName($name);
        return $this->render(
            "pet/index.html.twig",
            [
                'pets' => $pets
            ]);
    }
}
