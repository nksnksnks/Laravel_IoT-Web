<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fanstatus extends Model
{
    public $timestamps = false;
    protected $fillable = ['status', 'time', 'day'];
    protected $primaryKey = 'id';
    protected $table = 'fanstatus';
}
