<?php
/**
 * Dona Art Gallery - Setup Script
 * Visit this file once after uploading to create the storage symlink.
 * DELETE THIS FILE after setup is complete!
 */

echo '<html><head><meta charset="utf-8"><title>Dona Art Gallery - Setup</title>';
echo '<style>body{font-family:sans-serif;max-width:600px;margin:50px auto;padding:20px;background:#1a1a2e;color:#e0e0e0}';
echo 'h1{color:#c9a84c}.ok{color:#4caf50;font-weight:bold}.fail{color:#f44336;font-weight:bold}';
echo '.warn{color:#ff9800;font-weight:bold}pre{background:#0d0d1a;padding:15px;border-radius:8px;overflow-x:auto}';
echo 'a{color:#c9a84c}</style></head><body>';
echo '<h1>🎨 Dona Art Gallery - Setup</h1>';

$checks = [];

// Check 1: PHP Version
$phpOk = version_compare(PHP_VERSION, '8.1.0', '>=');
$checks[] = ($phpOk ? '<span class="ok">✓</span>' : '<span class="fail">✗</span>') . ' PHP Version: ' . PHP_VERSION . ($phpOk ? '' : ' (потребна е 8.1+)');

// Check 2: Required extensions
$extensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'json', 'fileinfo'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $checks[] = ($loaded ? '<span class="ok">✓</span>' : '<span class="fail">✗</span>') . " Екстензија: $ext";
}

// Check 3: .env file exists
$envPath = __DIR__ . '/../.env';
$envExists = file_exists($envPath);
$checks[] = ($envExists ? '<span class="ok">✓</span>' : '<span class="fail">✗</span>') . ' .env фајл постои';

// Check 4: vendor directory exists
$vendorExists = file_exists(__DIR__ . '/../vendor/autoload.php');
$checks[] = ($vendorExists ? '<span class="ok">✓</span>' : '<span class="fail">✗</span>') . ' vendor/ директориум постои';

// Check 5: Storage directories writable
$storageDirs = [
    __DIR__ . '/../storage',
    __DIR__ . '/../storage/app/public',
    __DIR__ . '/../storage/app/public/paintings',
    __DIR__ . '/../storage/framework/cache',
    __DIR__ . '/../storage/framework/sessions',
    __DIR__ . '/../storage/framework/views',
    __DIR__ . '/../storage/logs',
    __DIR__ . '/../bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (!file_exists($dir)) {
        @mkdir($dir, 0755, true);
    }
}

$storageWritable = is_writable(__DIR__ . '/../storage');
$checks[] = ($storageWritable ? '<span class="ok">✓</span>' : '<span class="fail">✗</span>') . ' storage/ е запислив';

$bootstrapWritable = is_writable(__DIR__ . '/../bootstrap/cache');
$checks[] = ($bootstrapWritable ? '<span class="ok">✓</span>' : '<span class="fail">✗</span>') . ' bootstrap/cache/ е запислив';

// Check 6: Create storage symlink
$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';
$symlinkStatus = '';

if (file_exists($link) || is_link($link)) {
    $symlinkStatus = '<span class="ok">✓</span> Storage symlink веќе постои';
} else {
    // Try to create symlink
    $symlinkCreated = false;
    if (function_exists('symlink')) {
        @$symlinkCreated = symlink($target, $link);
    }
    
    if ($symlinkCreated) {
        $symlinkStatus = '<span class="ok">✓</span> Storage symlink успешно креиран!';
    } else {
        $symlinkStatus = '<span class="warn">⚠</span> Не може да се креира symlink (нормално за shared hosting). Сликите ќе се сервираат преку PHP route.';
    }
}
$checks[] = $symlinkStatus;

// Check 7: Database connection
$dbStatus = '';
if ($envExists) {
    $envContent = file_get_contents($envPath);
    preg_match('/DB_HOST=(.*)/', $envContent, $host);
    preg_match('/DB_DATABASE=(.*)/', $envContent, $db);
    preg_match('/DB_USERNAME=(.*)/', $envContent, $user);
    preg_match('/DB_PASSWORD=(.*)/', $envContent, $pass);
    
    $dbHost = trim($host[1] ?? '');
    $dbName = trim($db[1] ?? '');
    $dbUser = trim($user[1] ?? '');
    $dbPass = trim($pass[1] ?? '');
    
    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbStatus = '<span class="ok">✓</span> Конекција со база: успешна (' . $dbName . '@' . $dbHost . ')';
        
        // Check tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $requiredTables = ['paintings', 'orders', 'order_items', 'users', 'sessions'];
        $missingTables = array_diff($requiredTables, $tables);
        
        if (empty($missingTables)) {
            $checks[] = '<span class="ok">✓</span> Сите потребни табели постојат (' . count($tables) . ' табели)';
        } else {
            $checks[] = '<span class="fail">✗</span> Недостасуваат табели: ' . implode(', ', $missingTables);
        }
        
        // Check admin user
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        $userCount = $stmt->fetchColumn();
        if ($userCount > 0) {
            $checks[] = '<span class="ok">✓</span> Админ корисник постои';
        } else {
            $checks[] = '<span class="warn">⚠</span> Нема админ корисник - потребно е да се додаде рачно';
        }
        
    } catch (PDOException $e) {
        $dbStatus = '<span class="fail">✗</span> Конекција со база: НЕУСПЕШНА - ' . $e->getMessage();
    }
} else {
    $dbStatus = '<span class="fail">✗</span> .env фајл не постои - не може да се тестира базата';
}
$checks[] = $dbStatus;

// Output results
echo '<h2>Проверка на системот:</h2>';
echo '<pre>';
foreach ($checks as $check) {
    echo $check . "\n";
}
echo '</pre>';

// Summary
$hasErrors = false;
foreach ($checks as $check) {
    if (strpos($check, 'fail') !== false) {
        $hasErrors = true;
        break;
    }
}

if (!$hasErrors) {
    echo '<h2 style="color:#4caf50">✓ Сè е во ред! Страницата е спремна.</h2>';
    echo '<p>👉 <a href="/">Отвори ја страницата</a></p>';
    echo '<p>👉 <a href="/admin/login">Отвори го Admin панелот</a></p>';
    echo '<p style="color:#f44336;margin-top:30px"><strong>⚠ ВАЖНО: Избриши го овој фајл (setup.php) по завршување на setup!</strong></p>';
} else {
    echo '<h2 style="color:#f44336">✗ Има проблеми кои треба да се решат.</h2>';
}

echo '</body></html>';
