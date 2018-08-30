<?php
/**
 * Created by PhpStorm.
 * User: mateibejan
 * Date: 28.08.2018
 * Time: 08:21
 */

namespace App\Controller;


use App\Entity\MP3File;
use App\Form\MP3FileType;
use App\Repository\MP3FileRepository;
use App\Service\FileUploader;
use App\Service\PopulateFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile as UploadedFile;

/**
 * Class MP3Controller
 * @package App\Controller
 *
 * @Route("", name="mp3_")
 */

class MP3Controller extends Controller {

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index (MP3FileRepository $mp3FileRepository) {

        return $this->render('mp3/index.html.twig', ['mp3datas' => $mp3FileRepository->getFileData()]);

    }

    /**
     * @Route("/new", name="create", methods={"GET", "POST"})
     */
    public function new (Request $request, FileUploader $fileUploader) : Response {

        $mp3file = new MP3File();
        $form = $this->createForm(MP3FileType::class, $mp3file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $mp3file->getFile();

            $fileName = $fileUploader->upload($file);

            $mp3file->setFile($fileName);

            $populateFile = new PopulateFile($mp3file);
            $populateFile->populate();

            $em = $this->getDoctrine()->getManager();
            $em->persist($mp3file);
            $em->flush();

            return $this->redirectToRoute('mp3_index');

        }

        return $this->render('mp3/new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/{id}/edit", name="edit", methods="GET|POST")
     */
    public function edit (Request $request, MP3File $mp3File): Response {

        $form = $this->createForm(MP3FileType::class, $mp3File);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mp3_index', ['id' => $mp3File->getId()]);
        }

        return $this->render('mp3/edit.html.twig', [
            'mp3file' => $mp3File,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"GET","DELETE"})
     */
    public function delete(Request $request, MP3File $mp3File): Response {

//        if ($this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mp3File);
            $em->remove($mp3File->getMp3Metadata());
            $em->remove($mp3File->getMp3Metadata()->getMp3Blob());
            $em->flush();
//        }

        return $this->redirectToRoute('mp3_index');

    }

}