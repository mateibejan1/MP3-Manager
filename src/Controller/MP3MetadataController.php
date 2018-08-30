<?php
/**
 * Created by PhpStorm.
 * User: mateibejan
 * Date: 27.08.2018
 * Time: 10:42
 */

namespace App\Controller;

use App\Entity\MP3Metadata;
use App\Form\MP3MetadataType;
use App\Repository\MP3MetadataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MP3MetadataController
 * @package App\Controller
 *
 * @Route("/mp3meta", name="mp3meta_")
 */

class MP3MetadataController extends Controller {

    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(MP3MetadataRepository $mp3MetadataRepository): Response {

        return $this->render('mp3_metadata/index.html.twig', ['mp3metadatas' => $mp3MetadataRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods="GET|POST")
     */
    public function new(Request $request): Response {

        $mp3Metadata = new MP3Metadata();
        $form = $this->createForm(MP3MetadataType::class, $mp3Metadata);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mp3Metadata);
            $em->flush();

            return $this->redirectToRoute('mp3meta_index');
        }

        return $this->render('mp3_metadata/new.html.twig', [
            '$mp3Metadata' => $mp3Metadata,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", requirements={"id"="\d+"}, name="show", methods="GET")
     */
    public function show(MP3Metadata $mp3Metadata): Response {

        return $this->render('mp3_metadata/show.html.twig', ['$mp3Metadata' => $mp3Metadata]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods="GET|POST")
     */
    public function edit(Request $request, MP3Metadata $mp3Metadata): Response {

        $form = $this->createForm(MP3MetadataType::class, $mp3Metadata);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mp3meta_edit', ['id' => $mp3Metadata->getId()]);
        }

        return $this->render('mp3_metadata/edit.html.twig', [
            '$mp3Metadata' => $mp3Metadata,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="delete", methods="DELETE")
     */
    public function delete(Request $request, MP3Metadata $mp3Metadata): Response {

        if ($this->isCsrfTokenValid('delete'.$mp3Metadata->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mp3Metadata);
            $em->flush();
        }

        return $this->redirectToRoute('mp3meta_index');

    }

}