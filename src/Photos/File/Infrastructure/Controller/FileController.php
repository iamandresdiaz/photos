<?php
declare(strict_types=1);

namespace App\Photos\File\Infrastructure\Controller;


use App\Photos\File\Application\Add\AddFile;
use App\Photos\File\Application\Apply\ApplyFilters;
use App\Photos\File\Application\Find\FindFiles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Symfony\Component\Routing\Annotation\Route;

final class FileController extends AbstractController
{
    private $addFile;
    private $applyFilters;
    private $findFiles;

    public function __construct(AddFile $addFile, ApplyFilters $applyFilters, FindFiles $findFiles)
    {
        $this->addFile      = $addFile;
        $this->applyFilters = $applyFilters;
        $this->findFiles    = $findFiles;
    }

    /**
     * @Route("/{reactRouting}", name="index", defaults={"reactRouting": null})
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/api/upload", name="api_file_upload", methods={"POST"})
     */
    public function upload(Request $request): Response
    {
        try{
            $files = $this->addFile->__invoke($request);
            $this->applyFilters->__invoke($files);

            return new Response(
                '',
                Response::HTTP_OK
            );
        } catch (Exception $exception)
        {
            return new Response(
                '',
                $exception->getCode()
            );
        }

    }

    /**
     * @Route("/api/search", name="api_file_search", methods={"POST"})
     */
    public function search(Request $request): Response
    {
        try{
            $response = $this->findFiles->__invoke($request);
            return new JsonResponse(
                $response,
                Response::HTTP_OK
            );
        } catch (Exception $exception)
        {
            return new Response(
                '',
                $exception->getCode()
            );
        }
    }

}