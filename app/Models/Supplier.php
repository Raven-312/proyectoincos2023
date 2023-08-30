<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'id',
        'ci',
        'name',
        'lastname',
        'phone',
        'email',
        'address',
        'status',
        'created_at',
        'updated_at',
        'user'];
}
