<?php
$required = ['config', 'core', 'models', 'controllers', 'views'];
foreach ($required as $dir) {
    if (!is_dir(__DIR__ . '/../' . $dir)) {
        echo "Eksik dizin: {$dir}\n";
        exit(1);
    }
}
echo "Temel dizin yapısı doğrulandı.\n";
