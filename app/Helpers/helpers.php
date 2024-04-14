<?php
if (! function_exists('updateFileName')) {
    function updateFileName($fileName): string
    {
        return strtolower(str_replace(['#', '/', '\\', ' '], '-', time().trim($fileName)));
    }
}
