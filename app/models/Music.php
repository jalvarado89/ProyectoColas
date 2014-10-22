<?php

class Music extends Eloquent
{
    protected $table      = 'music';
    protected $fillable   = array('url', 'name1', 'parts', 'timeperchunk', 'type1', 'status');
    protected $guarded    = array('id');
    public    $timestamps = false;

 public static function select()
    {
        return DB::select("select * from music");
    }   

}