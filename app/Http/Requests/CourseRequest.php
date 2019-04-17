<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Role;
use Illuminate\Validation\Rule;

//cuando queremos usar validaciones contra muchos/todos los campos del formulario nos conviene hacer con un form request
class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //si devuelve true significa que el usuario puede ejecutar las reglas si devuelve false no
        //return false;

        //nos aseguramos que el usuario tenga el rol teacher
        return auth()->user()->role_id===Role::TEACHER;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //podemos hacer peticiones post o put,get,delete
        switch ($this->method()){
            case 'GET':
            case 'DELETE':
                //retornamos un arreglo vacio porque no queremos aplicar ninguna regla
                return [];

            case 'POST':{
                return [
                    'name'=>'required|min:5',
                    'description'=>'required|min:30',
                    'level_id'=>[
                            'required',
                            //que exista en la tabla levels, el campo id de la tabla coincida con nuestro level_id
                            Rule::exists('levels','id')

                    ],
                    'category_id'=>[
                        'required',
                        //que exista en la tabla levels, el campo id de la tabla coincida con nuestro level_id
                        Rule::exists('categories','id')

                    ],
                    'picture'=>'required|image|mimes:jpg,jpeg,png',
                    //va a ser requerido si viene el requerimento 1, sino no
                    //en la vista se mostrara el error el requirement.1 es requerido cuando 0 esta presente debemos cambiar el nombre de atributo del error en resources/lang/es/validation.php al final
                    'requirements.0'=>'required_with:requirements.1',
                    'goals.0'=>'required_with:goals.1',
                ];
            }

            case 'PUT':{

                return [
                    'name'=>'required|min:5',
                    'description'=>'required|min:30',
                    'level_id'=>[
                        'required',
                        //que exista en la tabla levels, el campo id de la tabla coincida con nuestro level_id
                        Rule::exists('levels','id')

                    ],
                    'category_id'=>[
                        'required',
                        //que exista en la tabla levels, el campo id de la tabla coincida con nuestro level_id
                        Rule::exists('categories','id')

                    ],
                    //sometimes aplica esta validacion, osea que sea una imagen(jpg etc) pero solo cuando picture cuando haya sido enviado y este dentro del objeto request
                    //digamos es un campo opcional, pero cuando venga tiene q respetar la validacion
                    'picture'=>'sometimes|image|mimes:jpg,jpeg,png',
                    //va a ser requerido si viene el requerimento 1, sino no
                    //en la vista se mostrara el error el requirement.1 es requerido cuando 0 esta presente debemos cambiar el nombre de atributo del error en resources/lang/es/validation.php al final
                    'requirements.0'=>'required_with:requirements.1',
                    'goals.0'=>'required_with:goals.1',
                ];
            }

        }
    }
}
