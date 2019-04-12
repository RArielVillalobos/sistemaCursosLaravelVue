<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrengthPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // si no viene un valor pasamos la validacion

        if(!$value){
            return true;
        }

        //que haya una mayuscula
        $upperCase=preg_match('@[A-Z]@',$value);
        //queremos una minuscula
        $lowerCase=preg_match('@[a-z]@',$value);
        //queremos que exista un numero
        $number=preg_match('@[0-9]@',$value);
        //minimo de  8 caracteres
        $length=strlen($value)>=8;
        $success=true;
        if(!$upperCase|| !$lowerCase || !$number || !$length){
            $success=false;
        }
        return $success;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('el :attribute debe tener 8 caracteres, un numero,una letra mayuscula y una letra minuscula');
    }
}
