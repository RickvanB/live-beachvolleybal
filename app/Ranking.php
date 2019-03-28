<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stand';
    protected $guarded = ['id'];
	protected $fillable = ['poule', 'teams', 'saldo', 'punten', 'plaats', 'dag', 'created_at', 'updated_at'];    
}
