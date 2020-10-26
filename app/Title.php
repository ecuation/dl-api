<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $primaryKey = 'emp_no';
    public $timestamps = false;
    protected $table = 'titles';

    protected $fillable = [
        'title',
        'from_date',
        'to_date',
        'emp_no'
    ];
}
