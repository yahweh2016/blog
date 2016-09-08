<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    //protected $fillable = []//白名单
    protected $guarded = []; //黑名单

    public function tree()
    {
        $tree = $this->orderBy('cate_order','asc')->get();
        $cate = $this->getTree($tree);
        return $cate;
    }
    public function getTree($cate,$pid=0,$deep=0)
    {
        static $tree = [];
        foreach($cate as $val)
        {
          if($val['cate_pid']==$pid)
          {
              $val['deep'] = $deep;
              $tree[] = $val;
              $this->getTree($cate,$val['cate_id'],$deep+1);
          }
        }
        return $tree;
    }
}
