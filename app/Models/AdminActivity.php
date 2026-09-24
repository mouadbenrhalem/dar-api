<?php namespace App\Models; use Illuminate\Database\Eloquent\Model; class AdminActivity extends Model { protected $fillable=['action','admin_name','subject_type','subject_id','description']; }
