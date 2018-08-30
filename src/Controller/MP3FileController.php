<?php

namespace App\Controller;

use App\Entity\MP3File;
use App\Form\MP3FileType;
use App\Repository\MP3FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MP3FileController
 * @package App\Controller
 *
 * @Route("/mp3file", name="mp3file_")
 */
class MP3FileController extends Controller {

    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index (MP3FileRepository $mp3FileRepository) {

        return $this->render('mp3_file/index.html.twig', ['mp3files' => $mp3FileRepository->getFileData()]);

    }

    /**
     * @Route("/new", name="new", methods="GET|POST")
     */
    public function new (Request $request) {

        $mp3File = new MP3File();
        $form = $this->createForm(MP3FileType::class, $mp3File);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($mp3File);
            $em->flush();

            return $this->redirectToRoute('mp3file_index');
        }

        return $this->render('mp3_file/new.html.twig', [
            'mp3file' => $mp3File,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", requirements={"id"="\d+"}, name="show", methods="GET")
     */
    public function show (MP3File $mp3File): Response {

        return $this->render('mp3_file/show.html.twig', ['mp3file' => $mp3File]);

    }

    /**
     * @Route("/{id}/edit", name="edit", methods="GET|POST")
     */
    public function edit (Request $request, MP3File $mp3File): Response {

        $form = $this->createForm(MP3FileType::class, $mp3File);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mp3file_edit', ['id' => $mp3File->getId()]);
        }

        return $this->render('mp3_file/edit.html.twig', [
            'mp3file' => $mp3File,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="delete", methods="DELETE")
     */
    public function delete(Request $request, MP3File $mp3File): Response {

        if ($this->isCsrfTokenValid('delete'.$mp3File->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mp3File);
            $em->flush();
        }

        return $this->redirectToRoute('mp3file_index');

    }

}
