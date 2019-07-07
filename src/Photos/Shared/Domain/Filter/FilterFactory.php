<?php
declare(strict_types=1);


namespace App\Photos\Shared\Domain\Filter;


use claviska\SimpleImage;

final class FilterFactory
{
    const FILTER_SEPIA      = 'sepia';
    const FILTER_DESATURATE = 'desaturate';
    const FILTER_SKETCH     = 'sketch';
    const FILTER_INVERT     = 'invert';
    const FILTER_PIXELATE   = 'pixelate';
    const PUBLIC_FOLDER     = 'public/';

    public function create(SimpleImage $image, array $fileInfo)
    {
        $filter = $fileInfo['filter_to_apply'];
        switch ($filter)
        {
            case self::FILTER_SEPIA:
                $image
                    ->fromFile(self::PUBLIC_FOLDER . $fileInfo['original_path'])
                    ->sepia()
                    ->toFile(self::PUBLIC_FOLDER . $fileInfo['new_path']);
                break;

            case self::FILTER_DESATURATE:
                $image
                    ->fromFile(self::PUBLIC_FOLDER . $fileInfo['original_path'])
                    ->desaturate()
                    ->toFile(self::PUBLIC_FOLDER . $fileInfo['new_path']);
                break;

            case self::FILTER_INVERT:
                $image
                    ->fromFile(self::PUBLIC_FOLDER . $fileInfo['original_path'])
                    ->invert()
                    ->toFile(self::PUBLIC_FOLDER . $fileInfo['new_path']);
                break;

            case self::FILTER_PIXELATE:
                $image
                    ->fromFile(self::PUBLIC_FOLDER . $fileInfo['original_path'])
                    ->pixelate()
                    ->toFile(self::PUBLIC_FOLDER . $fileInfo['new_path']);
                break;

            case self::FILTER_SKETCH:
                $image
                    ->fromFile(self::PUBLIC_FOLDER . $fileInfo['original_path'])
                    ->sketch()
                    ->toFile(self::PUBLIC_FOLDER . $fileInfo['new_path']);
                break;

            default:
                break;
        }
    }
}