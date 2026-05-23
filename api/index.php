<?php

// On Vercel, the filesystem is read-only except /tmp.
// We redirect storage writes to /tmp/storage.
$tmpStorage = '/tmp/storage';
if (!is_dir($tmpStorage)) {
    $dirs = [
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/views',
        '/tmp/storage/logs',
        '/tmp/storage/app/public',
    ];
    foreach ($dirs as $dir) {
        mkdir($dir, 0755, true);
    }
}

// Override the storage path before Laravel boots
$_ENV['APP_STORAGE_PATH'] = $tmpStorage;
putenv("APP_STORAGE_PATH=$tmpStorage");

// Point Laravel to the project root
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';

require __DIR__ . '/../public/index.php';
