<?php

function processInput($input)
{
    if (is_array($input)) {
        return implode(', ', $input);  // Convert array to a string if necessary
    }

    return htmlspecialchars($input);  // Ensure $input is a string here
}

if (!function_exists('decodeHtmlEntities')) {
    function decodeHtmlEntities($content)
    {
        // Remove extra backslashes and decode HTML entities
        $content = stripslashes($content);
        return html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
