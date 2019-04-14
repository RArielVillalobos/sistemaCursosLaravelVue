<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 14/abr/2019
 * Time: 11:28
 */
namespace App\Helpers;
Class Helper{

    //la key sera el name picture de formulario
    public static function uploadFile($key,$path){
        //esto subira el archivo y lo guardara
        request()->file($key)->store($path);
            //retornara el nombre del archivo que ha guardado
        return request()->file($key)->hashName();
    }

}