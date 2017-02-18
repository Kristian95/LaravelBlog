<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model 
{
	protected $guarded = [];

	//user who has commented
    public function posts()
    {
    	return $this->hasMany('App\Posts');
    }
}