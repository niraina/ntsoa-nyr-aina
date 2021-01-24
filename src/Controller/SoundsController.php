<?php

namespace App\Controller;

use App\Entity\Audios;
use App\Entity\Searchs;
use App\Entity\Sounds;
use App\Form\SearchsType;
use App\Form\SoundsType;
use App\Repository\SoundsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/sounds")
 */
class SoundsController extends AbstractController
{
    /**
     * @Route("/", name="sounds_index")
     */
    public function index(SoundsRepository $soundsRepository, Request $request): Response
    {

        $search = new Searchs();
        $form = $this->createForm(SearchsType::class, $search);
        $form->handleRequest($request);

        return $this->render('sounds/index.html.twig', [
            // 'sounds' => $soundsRepository->findAll(),
            'sounds' => $soundsRepository->searchSound($search),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="sounds_new", methods={"GET","POST"})
     */
    public function new(SoundsRepository $soundsRepository, Request $request): Response
    {
        $sound = new Sounds();
        $form = $this->createForm(SoundsType::class, $sound);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on recuper le fichier
            $audios = $form->get('audios')->getData();

            //on boucle sur les fichiers
            foreach($audios as $audio){
                //on genere un nouveau nom
                $fichier = md5(uniqid()) . '.' . $audio->guessExtension();
                //on copie
                $audio->move(
                  $this->getParameter('audios_directory'),
                  $fichier  
                );
                //on stock son om dans la BDD
                $ads = new Audios();
                $ads->setName($fichier);
                $sound->addAudio($ads);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sound);
            $entityManager->flush();

            return $this->redirectToRoute('sounds_index');
        }

        return $this->render('sounds/new.html.twig', [
            'sounds' => $soundsRepository->findAll(),
            'sound' => $sound,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sounds_show", methods={"GET"})
     */
    public function show(Sounds $sound): Response
    {
        return $this->render('sounds/show.html.twig', [
            'sound' => $sound,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sounds_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sounds $sound): Response
    {
        $form = $this->createForm(SoundsType::class, $sound);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //on recuper le fichier
            $audios = $form->get('audios')->getData();

            //on boucle sur les fichiers
            foreach($audios as $audio){
                //on genere un nouveau nom
                $fichier = md5(uniqid()) . '.' . $audio->guessExtension();
                //on copie
                $audio->move(
                  $this->getParameter('audios_directory'),
                  $fichier  
                );
                //on stock son om dans la BDD
                $ads = new Audios();
                $ads->setName($fichier);
                $sound->addAudio($ads);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sounds_index');
        }

        return $this->render('sounds/edit.html.twig', [
            'sound' => $sound,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sounds_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sounds $sound): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sound->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sound);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sounds_index');
    }
    /**
     * @Route("/supprime/audio/{id}", name="sounds_delete_audio", methods={"DELETE"})
     */

    public function deleteAudio(Audios $audio, Request $request){
        $data = json_decode($request->getContent(), true);
        
        //on verifie si le token est valide

        if($this->isCsrfTokenValid('delete'.$audio->getId(), $data['_token'])){
            $nom = $audio->getName();
            unlink($this->getParameter('audios_directory').'/'.$nom);
            //on suppriime de la base
            $em =$this>getDotrine()->getMaager();
            $em->remove($audio);
            $em->flush();

            //on repond en json
            return new JsonResponse(['success' => 1]);

        }else{
            return new JsonResponse(['error' => 'Token invalid'], 400);
        }
    }
}
