<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Form\StaffType;
use App\Repository\StaffRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/staff')]
class StaffController extends AbstractController
{
    #[Route('/', name: 'view_staff_list')]
    public function Staffindex(ManagerRegistry $managerRegistry)
    {
        $staffs = $managerRegistry->getRepository(Staff::class)->findAll();
        return $this->render('staff/index.html.twig', 
        [
            'staffs' => $staffs,
        ]);
    }
    #[Route('/delete/{id}', name: 'delete_staff')]
    public function StaffDelete($id, ManagerRegistry $managerRegistry) {
        $staff = $managerRegistry->find($id);
        if ($staff == null) {
            $this->addFlash("Error","Staff not found !");        
        } 
        else {
            $manager = $managerRegistry->getManager();
            $manager->remove($staff);
            $manager->flush();
            $this->addFlash("Success","Delete staff succeed  !");
        }
        return $this->redirectToRoute("view_staff_list");
    }

    #[Route('/add', name: 'add_staff')]
    public function StaffAdd(Request $request,ManagerRegistry $managerRegistry) {
        $staff = new Staff;
        $form = $this->createForm(StaffType::class,$staff);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($staff);
            $manager->flush();
            $this->addFlash("Success","Add staff succeed !");
            return $this->redirectToRoute("view_staff_list");
        }
        return $this->render("staff/add.html.twig",
        [
            'staffForm' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_staff')]
    public function StaffEdit(Request $request, StaffRepository $staffRepository, $id) {
        $staff = $staffRepository->find($id);
        if ($staff == null) {
            $this->addFlash("Error","Staff not found !");
            return $this->redirectToRoute("view_staff_list");        
        } else {
            $form = $this->createForm(StaffType::class,$staff);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($staff);
                $manager->flush();
                $this->addFlash("Success","Edit staff succeed !");
                return $this->redirectToRoute("view_staff_list");
            }
            return $this->renderForm("staff/edit.html.twig",
            [
                'staffForm' => $form->createView()
            ]);
        }   
    }

    #[Route('/searchbystaffname', name: 'search_staff_name')]
    public function StaffSearchByName (StaffRepository $staffRepository, Request $request) {
        $name = $request->get('keyword');
        $staff = $staffRepository->searchByName($name);
        return $this->render(
            "staff/index.html.twig",
            [
                'staffs' => $staffs
            ]);
    }

}
