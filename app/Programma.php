<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programma extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'programma';
    protected $guarded = ['id_programma', 'id'];
	protected $fillable = ['ronde', 'starttijd', 'poule', 'team1', 'team2', 'scheidsrechter', 'uitslagen', 'dag', 'dagdeel', 'created_at', 'updated_at'];    
}
