<?php
// inanna/index.php - Clean front controller (no debug output)
// Serves files from public/ while keeping URL as /inanna/...

// -------- config --------
$publicDir = __DIR__ . '/public';
// -------- end config ----

// ensure public folder exists
if (!is_dir($publicDir)) {
    http_response_code(500);
    echo "Server misconfiguration: public/ folder not found.";
    exit;
}

// normalize request path
$reqUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// compute project URI relative to DOCUMENT_ROOT (best-effort)
$docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
$projectRoot = realpath(__DIR__);
$projectUri = '';
if ($docRoot && $projectRoot && strpos($projectRoot, $docRoot) === 0) {
    $projectUri = '/' . trim(str_replace('\\','/', substr($projectRoot, strlen($docRoot))), '/');
    if ($projectUri === '/') $projectUri = '';
}

// compute relative path inside project
if ($projectUri !== '' && strpos($reqUri, $projectUri) === 0) {
    $relativePath = substr($reqUri, strlen($projectUri));
} else {
    $relativePath = $reqUri;
}
$relativePath = '/' . ltrim($relativePath, '/');
if ($relativePath === '/' || $relativePath === '') {
    $relativePath = '/index.php';
}

// resolve candidate in public/
$publicReal = realpath($publicDir);
$candidate = $publicReal ? realpath($publicDir . $relativePath) : false;

// serve static files directly
if ($candidate && is_file($candidate) && strpos($candidate, $publicReal) === 0) {
    $ext = strtolower(pathinfo($candidate, PATHINFO_EXTENSION));
    if ($ext !== 'php') {
        // MIME type
        $mime = null;
        if (function_exists('finfo_open')) {
            $finfo = @finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $mime = finfo_file($finfo, $candidate);
                finfo_close($finfo);
            }
        }
        if (!$mime) {
            $mimes = [
                'css'=>'text/css', 'js'=>'application/javascript', 'jpg'=>'image/jpeg',
                'jpeg'=>'image/jpeg', 'png'=>'image/png', 'gif'=>'image/gif',
                'svg'=>'image/svg+xml', 'webp'=>'image/webp', 'woff'=>'font/woff',
                'woff2'=>'font/woff2', 'ttf'=>'font/ttf', 'eot'=>'application/vnd.ms-fontobject',
                'json'=>'application/json', 'pdf'=>'application/pdf', 'html'=>'text/html'
            ];
            $mime = $mimes[$ext] ?? 'application/octet-stream';
        }
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($candidate));
        readfile($candidate);
        exit;
    } else {
        // execute PHP in public/
        $scriptName = ($projectUri === '' ? '' : $projectUri) . $relativePath;
        $_SERVER['SCRIPT_FILENAME'] = $candidate;
        $_SERVER['SCRIPT_NAME']     = $scriptName;
        $_SERVER['PHP_SELF']       = $scriptName;
        chdir(dirname($candidate));
        require $candidate;
        exit;
    }
}

// fallback to public/index.php
$fallback = $publicReal ? realpath($publicDir . '/index.php') : false;
if ($fallback && is_file($fallback) && strpos($fallback, $publicReal) === 0) {
    $_SERVER['REQUEST_URI_ORIG'] = $_SERVER['REQUEST_URI'];
    $_SERVER['SCRIPT_FILENAME'] = $fallback;
    $_SERVER['SCRIPT_NAME']     = ($projectUri === '' ? '' : $projectUri) . '/index.php';
    $_SERVER['PHP_SELF']       = ($projectUri === '' ? '' : $projectUri) . '/index.php';
    chdir(dirname($fallback));
    require $fallback;
    exit;
}

// nothing matched
http_response_code(404);
echo "404 Not Found";
exit;
