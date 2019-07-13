<?php
declare(strict_types=1);


namespace App\Photos\File\UI\Photos\ReactRoutes;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class ReactRoutesController extends AbstractController
{
    /**
     * @Route("/{reactRouting}", name="index", defaults={"reactRouting": null})
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }
}