<?php
/**
 * Created by PhpStorm.
 * User: sivar
 * Date: 25/05/2018
 * Time: 18:05.
 */

namespace App\Analysis\Template;

class ParameterManager
{
    private $parameterTypes;

    public function __construct()
    {
        $this->parameterTypes = [new BooleanParameterType(), new ColumnParameterType(), new ColumnValueParameterType(), new NumberParameterType(), new TextParameterType()];
    }

    public function getParameterType($name)
    {
        foreach ($this->parameterTypes as $type) {
            if (strcasecmp($type->getName(), $name) == 0) {
                return $type;
            }
        }

        return null;
    }

    public function getAllTypes()
    {
        return $this->parameterTypes;
    }
}
