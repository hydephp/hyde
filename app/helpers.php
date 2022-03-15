<?php

if (!function_exists('relative_path')) {
    /**
     * Inject the proper number of `../` before the links
     *
     * @param string $destination the route to format
     * @param string $current the current route
     * @return string
     */
    function relative_path(string $destination, string $current = ""): string
    {
        $nestCount = substr_count($current, '/');
        $route = '';
        if ($nestCount > 0) {
            $route .= str_repeat('../', $nestCount);
        }
        $route .= $destination ;
        return $route;
    }
}
