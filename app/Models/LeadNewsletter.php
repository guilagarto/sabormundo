<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadNewsletter extends Model
{
    use HasFactory;

    // Define qual campo pode ser preenchido via formulário
    protected $fillable = ['email'];
}
