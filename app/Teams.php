<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teams extends Model
{   
    use SoftDeletes;
    
    protected $table = 'teams';
    protected $fillable = ['name'];
    //
    
    public function matchs()
    {
        return $this->belongsToMany('App\Matchs');
    }
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
