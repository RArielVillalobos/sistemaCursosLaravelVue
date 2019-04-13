<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Student
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUserId($value)
 */
class Student extends Model
{
    //
    protected $fillable=[
        'user_id',
        'title'
    ];
    protected $appends=['courses_formatted'];

    public function courses(){
        return $this->belongsToMany(Course::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->select('id','role_id','name','email');
    }

    //tiene que empezar con get,tiene que terminar con attribute y tiene que ser lowecase
    public function getCoursesFormattedAttribute(){
        //pluck:columnas que queremos devolver
        //separar todos los registros por una coma
        //devolvera algo asi u'curso 1','curso 2','curso 3'
        //pero como tenemos nombres grandes no van a caber en la tabla asi que hacemos un salto de kinea
        return $this->courses->pluck('name')->implode('<br>');


    }
}
