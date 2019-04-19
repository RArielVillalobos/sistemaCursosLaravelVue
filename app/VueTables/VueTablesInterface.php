<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 18/abr/2019
 * Time: 00:14
 */
namespace App\VueTables;
interface VueTablesInterface{
    public function get($model, Array $fields,Array $relations=[]);
}