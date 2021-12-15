<?php

namespace Bamboo\ImportData\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait GetLoadedTrait
{
    /**
     * @param $name
     * @return Model|null
     */
    public function getLoadedRelation($name)
    {
        return $this->relationLoaded($name) ? $this->{$name} : null;
    }
}
