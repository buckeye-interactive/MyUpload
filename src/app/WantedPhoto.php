<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WantedPhoto extends Model
{
    /* *
    * Table associated with the model  
    *
    */

    protected $table = 'wanted_photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo_priority_one',
        'photo_priority_two',
        'photo_priority_three',
        'photo_priority_four',
        'photo_priority_five',
    ];
}
