<?php

namespace App\Reflection\Interfaces;

interface ReflectionType
{
    /**
     * Get the fields of the reflection type and their default values.
     */
    public function getFields(): array;
}
