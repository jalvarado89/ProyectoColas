<?php

class Part extends Eloquent
{
    protected $table      = 'part';
    protected $fillable   = array('url', 'Music_id');
    protected $guarded    = array('id');
    public    $timestamps = false;

 public static function select()
    {
        return DB::select("select * from part");
    }   

}