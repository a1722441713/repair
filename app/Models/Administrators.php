<?php

namespace App\Models;

class Administrators extends BaseModel
{
    public function repair(){
        return $this->hasMany(Repair::class);
    }
}
