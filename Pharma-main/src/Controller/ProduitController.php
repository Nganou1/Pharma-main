<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
            
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository, TypeRepository $typeRepository): Response
    {
        $produit = new Produit();

        if(isset($_POST['submit'])){

            $nom = $request->request->get('nom');
            $prix = $request->request->get('prix');
            $qte = $request->request->get('qute');
            $notice = $request->request->get('notice');
            $image = $request->files->get('image');
            $type = $request->request->get('type');


            $produit->setName($nom);
            $produit->setPrice($prix);
            $produit->setQuantity(intval($qte));
            $produit->setNotice($notice);
            $produit->setTypeProduit($typeRepository->findOneBy(['description' => $type]));

            if($image){

                $newImage = uniqid() .'.'. $image->guessExtension();

                try{
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/images',
                        $newImage
                    );
                }catch (FileException $e){
                        return new Response($e->getMessage());                
                }
                    
                $produit->setImage($newImage);
            }
            
            $produitRepository->save($produit, true);
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }


        

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'types' => $typeRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository, TypeRepository $typeRepository): Response
    {
        if(isset($_POST['submit'])){
            $nom = $request->request->get('nom');
            $prix = $request->request->get('prix');
            $qte = $request->request->get('qte');
            $notice = $request->request->get('notice');
            $image = $request->files->get('image');
            $type = $request->request->get('type');

        
            $produit->setName($nom);
            $produit->setPrice($prix);
            $produit->setQuantity($qte);
            $produit->setNotice($notice);
            $produit->setTypeProduit($typeRepository->findOneBy(['description' => $type]));

            if($image){

                $newImage = uniqid() .'.'. $image->guessExtension();

                try{
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/images',
                        $newImage
                    );
                }catch (FileException $e){
                        return new Response($e->getMessage());                
                }
                    
                $produit->setImage($newImage);
            }

            $produitRepository->save($produit, true);
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'types' => $typeRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
