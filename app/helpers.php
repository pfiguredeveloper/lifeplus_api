<?php

if (!function_exists('public_path')) {
    /**
     * Return the path to public dir
     *
     * @param null $path
     *
     * @return string
     */
    function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}

if (!function_exists('get_old_data')) {
    function get_old_data($classname,$old_client_id)
    {
        return $classname::where('old_client_id',$old_client_id)->get()->mapWithKeys(function($item){
            return [$item->old_id=>$item];
        })->toArray();
        //return rtrim(app()->basePath('public/' . $path), '/');
    }
}