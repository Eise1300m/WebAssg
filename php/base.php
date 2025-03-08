<?php
function redirect(string $url = '/'): void {
    header("Location: $url");
    exit();
}

function temp(string $key, ?string $value = null): ?string {
    if (!session_id()) session_start();
    
    if ($value !== null) {
        $_SESSION["temp_$key"] = $value;
        return null;
    }
    
    $value = $_SESSION["temp_$key"] ?? null;
    unset($_SESSION["temp_$key"]);
    return $value;
}