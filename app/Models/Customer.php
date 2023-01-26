<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['taxid', 'customertype', 'company', 'firstname', 'lastname', 'telephone', 'mobile', 'dateofbirth'
                        , 'citizenship', 'addressline1', 'addressline2', 'city', 'region', 'postcode'];

}
