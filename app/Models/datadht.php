<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datadht extends Model
{
    public $timestamps = false;
    protected $fillable = ['temperature', 'humidity', 'light', 'time', 'day'];
    protected $primaryKey = 'id';
    protected $table = 'datadht';
}
