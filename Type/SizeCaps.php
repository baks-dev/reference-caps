<?php
/*
 *  Copyright 2022.  Baks.dev <admin@baks.dev>
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *   limitations under the License.
 *
 */

declare(strict_types=1);

namespace BaksDev\Reference\Caps\Type;

use BaksDev\Reference\Caps\Type\Sizes\Collection\SizeCapsInterface;

/** Размер одежды (2XS ... 4XL) */
final class SizeCaps
{

    public const string TYPE = 'size_caps_type';

    private ?SizeCapsInterface $size = null;


    public function __construct(self|string|SizeCapsInterface $size)
    {
        if($size instanceof SizeCapsInterface)
        {
            $this->size = $size;
        }

        if($size instanceof $this)
        {
            $this->size = $size->getSize();
        }

        if(is_string($size))
        {
            /** @var SizeCapsInterface $class */
            foreach(self::getDeclaredSizes() as $class)
            {
                if($class::equals($size))
                {
                    $this->size = new $class;
                    break;
                }
            }
        }

    }


    public function __toString(): string
    {
        return $this->size ? $this->size->getvalue() : '';
    }


    /** Возвращает значение ColorsInterface */
    public function getSize(): SizeCapsInterface
    {
        return $this->size;
    }


    /** Возвращает значение ColorsInterface */
    public function getSizeValue(): string
    {
        return $this->size?->getValue() ?: '';
    }


    public static function cases(): array
    {
        $case = [];

        foreach(self::getDeclaredSizes() as $key => $size)
        {
            /** @var SizeCapsInterface $size */
            $sizes = new $size;
            $case[$sizes::sort().$key] = new self($sizes);
        }

        ksort($case);

        return $case;
    }


    public static function getDeclaredSizes(): array
    {
        return array_filter(
            get_declared_classes(),
            static function($className) {
                return in_array(SizeCapsInterface::class, class_implements($className), true);
            },
        );
    }

}