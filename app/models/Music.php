<?php

class Music extends Eloquent
{
    protected $table      = 'Music';
    protected $fillable   = array('url', 'parts', 'timeperchunk', 'type1', 'status');
    protected $guarded    = array('id');
    public    $timestamps = false;

 public static function select()
    {
        return DB::select("select * from Music");
    }   

}