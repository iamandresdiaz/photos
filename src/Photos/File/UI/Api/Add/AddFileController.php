<?php
declare(strict_types=1);


namespace App\Photos\File\UI\Api\Add;

use App\Photos\File\Application\Add\AddFile;
use App\Photos\File\Application\Apply\ApplyFilters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

final class AddFileController extends AbstractController
{
    private $addFile;
    private $applyFilters;

    public function __construct(AddFile $addFile, ApplyFilters $applyFilters)
    {
        $this->addFile      = $addFile;
        $this->applyFilters = $applyFilters;
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
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }
}