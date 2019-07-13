<?php
declare(strict_types=1);


namespace App\Photos\File\UI\Api\Find;


use App\Photos\File\Application\Find\FindFiles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

final class FindFileController extends AbstractController
{
    private $findFiles;

    public function __construct(FindFiles $findFiles)
    {
        $this->findFiles    = $findFiles;
    }

    /**
     * @Route("/api/search/{text}", name="api_file_search", methods={"GET"})
     */
    public function search(string $text): Response
    {
        try{
            $response = $this->findFiles->__invoke($text);
            return new JsonResponse(
                $response,
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