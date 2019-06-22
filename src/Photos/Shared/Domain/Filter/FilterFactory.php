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

    public function create(SimpleImage $image, array $fileInfo)
    {
        $filter = $fileInfo['filter_to_apply'];
        switch ($filter)
        {
            case self::FILTER_SEPIA:
                $image
                    ->fromFile('public/' . $fileInfo['original_path'])
                    ->sepia()
                    ->toFile('public/' . $fileInfo['new_path']);
                break;

            case self::FILTER_DESATURATE:
                $image
                    ->fromFile('public/' . $fileInfo['original_path'])
                    ->desaturate()
                    ->toFile('public/' . $fileInfo['new_path']);
                break;

            case self::FILTER_INVERT:
                $image
                    ->fromFile('public/' . $fileInfo['original_path'])
                    ->invert()
                    ->toFile('public/' . $fileInfo['new_path']);
                break;

            case self::FILTER_PIXELATE:
                $image
                    ->fromFile('public/' . $fileInfo['original_path'])
                    ->pixelate()
                    ->toFile('public/' . $fileInfo['new_path']);
                break;

            default:
                break;
        }
    }
}