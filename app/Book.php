<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use UsesUuid;

    protected $guarded = [];

    public function takeImage()
    {
        return "storage/" . $this->picture;
    }
}