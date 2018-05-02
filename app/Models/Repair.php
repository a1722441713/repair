<?php

namespace App\Models;

class Repair extends BaseModel
{
    protected $fillable = [
        'question', 'administrator_id', 'satisfaction','user_id','answer'
    ];

    public function administrator(){
        return $this->belongsTo(Administrators::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
