<?php
/**
 * Verificación rápida: todo lo necesario para arrancar el proyecto.
 * Ejecutar: php check-setup.php
 */
$base = __DIR__;
$ok = 0;
$fail = 0;

function check($cond, $msg) {
    global $ok, $fail;
    if ($cond) { echo "  [OK] $msg\n"; $ok++; return true; }
    echo "  [FALTA] $msg\n"; $fail++; return false;
}

echo "=== Requisitos para arrancar el proyecto ===\n\n";

// PHP
check(version_compare(PHP_VERSION, '8.2.0', '>='), "PHP >= 8.2 (tienes " . PHP_VERSION . ")");
$exts = ['bcmath','ctype','curl','dom','fileinfo','json','mbstring','openssl','pdo','pdo_sqlite','tokenizer','xml'];
foreach ($exts as $e) {
    check(extension_loaded($e), "Extensión PHP: $e");
}

// Archivos y directorios
check(file_exists($base . '/.env'), "Archivo .env existe");
if (file_exists($base . '/.env')) {
    $env = file_get_contents($base . '/.env');
    check(strpos($env, 'APP_KEY=base64:') !== false || (strpos($env, 'APP_KEY=') !== false && strlen(trim(explode("\n", explode('APP_KEY=', $env)[1] ?? '')[0] ?? '')) > 10), "APP_KEY está definida en .env");
}
check(is_dir($base . '/vendor'), "Carpeta vendor (ejecuta: composer install)");
check(is_writable($base . '/storage'), "Carpeta storage escribible");
check(is_writable($base . '/bootstrap/cache'), "Carpeta bootstrap/cache escribible");
check(file_exists($base . '/database/database.sqlite') || getenv('DB_CONNECTION') !== 'sqlite', "Base de datos SQLite existe o no usas SQLite");

// Frontend: o existe build o hay que usar npm run dev
$hasBuild = is_dir($base . '/public/build');
$hasNodeModules = is_dir($base . '/node_modules');
check($hasNodeModules, "Carpeta node_modules (ejecuta: npm install)");
if ($hasNodeModules && !$hasBuild) {
    echo "  [AVISO] public/build no existe. Para ver CSS/JS: ejecuta 'npm run dev' (desarrollo) o 'npm run build' (producción).\n";
}

echo "\n--- Resumen: $ok comprobaciones OK";
if ($fail > 0) echo ", $fail pendientes";
echo " ---\n";

if ($fail > 0) {
    echo "\nPasos sugeridos:\n";
    if (!is_dir($base . '/vendor')) echo "  composer install\n";
    if (!file_exists($base . '/.env')) echo "  cp .env.example .env && php artisan key:generate\n";
    if (!is_writable($base . '/bootstrap/cache')) echo "  attrib -r bootstrap\\cache   (Windows)\n";
    if (!is_writable($base . '/storage')) echo "  attrib -r storage   (Windows)\n";
    if (!is_dir($base . '/node_modules')) echo "  npm install\n";
    if (!file_exists($base . '/database/database.sqlite')) echo "  New-Item -ItemType File -Path database\\database.sqlite -Force\n  php artisan migrate\n";
    exit(1);
}
echo "\nListo para arrancar:\n  php artisan serve\n  npm run dev   (en otra terminal)\n  Abre: http://127.0.0.1:8000\n";
exit(0);
