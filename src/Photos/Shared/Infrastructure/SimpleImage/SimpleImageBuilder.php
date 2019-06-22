<?php
declare(strict_types=1);


namespace App\Photos\Shared\Infrastructure\SimpleImage;

use \claviska\SimpleImage;

final class SimpleImageBuilder
{
    private $image;

    public function __construct()
    {
        $this->image = new SimpleImage();
    }

    public function image():SimpleImage
    {
        return $this->image;
    }
}