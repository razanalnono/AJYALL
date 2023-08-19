<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectPartner extends Pivot
{
    use HasFactory;
    protected $table = 'project_partner';
    protected $fillable = ['project_id','partner_id'];

}
