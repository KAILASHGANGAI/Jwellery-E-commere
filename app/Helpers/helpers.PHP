<?php

function processInput($input)
{
    if (is_array($input)) {
        return implode(', ', $input);  // Convert array to a string if necessary
    }

    return htmlspecialchars($input);  // Ensure $input is a string here
}