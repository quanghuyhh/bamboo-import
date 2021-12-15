<?php

if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('public_path'))
{
    /**
     * Get the public path.
     *
     * @param  string $path
     * @return string
     */
    function public_path($path = '')
    {
        return app()->basePath() . '/public' . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('get_account_holder_id'))
{
    /**
     * Get account holder id.
     *
     * @return string
     */
    function get_account_holder_id()
    {
        return config('import.account_holder_id');
    }
}
