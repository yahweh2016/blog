<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table='Article';
    protected $primaryKey='art_id';
    public $timestamps=false;
    protected $guarded=[];//不想被赋值的属性
}
