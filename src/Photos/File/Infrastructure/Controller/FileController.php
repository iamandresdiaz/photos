<?php
declare(strict_types=1);

namespace App\Photos\File\Infrastructure\Controller;


use App\Photos\File\Application\Add\AddFile;
use App\Photos\File\Application\Apply\ApplyFilters;
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

    public function __construct(AddFile $addFile, ApplyFilters $applyFilters)
    {
        $this->addFile = $addFile;
        $this->applyFilters = $applyFilters;
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
            $requestData = json_decode($request->getContent(), true)['files'];
            $files = $this->addFile->__invoke($requestData);
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

}