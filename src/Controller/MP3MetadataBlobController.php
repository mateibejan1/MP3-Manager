<?php
/**
 * Created by PhpStorm.
 * User: mateibejan
 * Date: 27.08.2018
 * Time: 15:30
 */

namespace App\Controller;


use App\Entity\MP3MetadataBlob;
use App\Form\MP3MetadataBlobType;
use App\Repository\MP3MetadataBlobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MP3MetadataBlobController
 * @package App\Controller
 *
 * @Route("/mp3blob", name="mp3blob_")
 */

class MP3MetadataBlobController extends Controller{

    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(MP3MetadataBlobRepository $mp3MetadataBlobRepository): Response {

        return $this->render('mp3_blob/index.html.twig', ['mp3blobs' => $mp3MetadataBlobRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods="GET|POST")
     */
    public function new(Request $request): Response {
        
        $mp3MetadataBlob = new MP3MetadataBlob();
        $form = $this->createForm(MP3MetadataBlobType::class, $mp3MetadataBlob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mp3MetadataBlob);
            $em->flush();

            return $this->redirectToRoute('mp3blob_index');
        }

        return $this->render('mp3_blob/new.html.twig', [
            'mp3_blob' => $mp3MetadataBlob,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id"="\d+"}, name="show", methods="GET")
     */
    public function show(MP3MetadataBlob $mp3MetadataBlob): Response {

        return $this->render('m_p3_blob/show.html.twig', ['mp3blob' => $mp3MetadataBlob]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods="GET|POST")
     */
    public function edit(Request $request, MP3MetadataBlob $mp3MetadataBlob): Response {

        $form = $this->createForm(MP3MetadataBlobType::class, $mp3MetadataBlob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mp3blob_edit', ['id' => $mp3MetadataBlob->getId()]);
        }

        return $this->render('mp3_blob/edit.html.twig', [
            'mp3_blob' => $mp3MetadataBlob,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="delete", methods="DELETE")
     */
    public function delete(Request $request, MP3MetadataBlob $mp3MetadataBlob): Response {

        if ($this->isCsrfTokenValid('delete'.$mp3MetadataBlob->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mp3MetadataBlob);
            $em->flush();
        }

        return $this->redirectToRoute('mp3blob_index');

    }

}