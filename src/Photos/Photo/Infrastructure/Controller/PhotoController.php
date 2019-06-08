<?php
declare(strict_types=1);

namespace App\Photos\Photo\Infrastructure\Controller;


use App\Photos\Photo\Application\Save\SaveFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Symfony\Component\Routing\Annotation\Route;

final class PhotoController extends AbstractController
{
    private $saveFile;

    public function __construct(SaveFile $saveFile)
    {
        $this->saveFile = $saveFile;
    }

    /**
     * @Route("/{reactRouting}", name="index", defaults={"reactRouting": null})
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/api/upload", name="api_photo_upload", methods={"POST"})
     */
    public function upload(Request $request): JsonResponse
    {

        try{

            $this->saveFile->__invoke($request);

            return new JsonResponse(
                [
                    'status' => Response::HTTP_OK,
                    'message' => 'File saved'
                ],
                Response::HTTP_OK
            );
        } catch (Exception $exception)
        {
            return new JsonResponse(
                [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'error' => [
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode()
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

    }

}