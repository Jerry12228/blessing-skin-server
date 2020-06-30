<?php

(function () {
    function die_with_utf8_encoding($error)
    {
        header('Content-Type: text/html; charset=UTF-8');
        exit($error);
    }

    if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
        die_with_utf8_encoding(
            '[Error] No vendor folder found. Please use the released built package.<br>'.
            '[错误] 根目录下未发现 vendor 文件夹，请使用正式的已构建好的 release 包。'
        );
    }

    $requiredVersion = '7.2.5';
    preg_match('/(\d+\.\d+\.\d+)/', PHP_VERSION, $matches);
    $version = $matches[1];
    if (version_compare($version, $requiredVersion, '<')) {
        die_with_utf8_encoding(
            '[Error] Blessing Skin requires PHP version >= '.$requiredVersion.', you are now using '.$version.'<br>'.
            '[错误] 你的 PHP 版本过低（'.$version.'），Blessing Skin 要求至少为 '.$requiredVersion
        );
    }

    $requirements = [
        'extensions' => [
            'pdo',
            'openssl',
            'gd',
            'mbstring',
            'tokenizer',
            'ctype',
            'xml',
            'json',
            'fileinfo',
        ],
        'write_permission' => [
            'bootstrap/cache',
            'storage',
            'plugins',
            'public',
        ],
    ];

    foreach ($requirements['extensions'] as $extension) {
        if (!extension_loaded($extension)) {
            die_with_utf8_encoding(
                "[Error] You have not installed the $extension extension <br>".
                "[错误] 你尚未安装 $extension 扩展！安装方法请自行搜索。"
            );
        }
    }

    foreach ($requirements['write_permission'] as $dir) {
        $realPath = realpath(__DIR__."/../$dir");

        if (!is_writable($realPath)) {
            die_with_utf8_encoding(
                "[Error] The directory '$dir' is not writable. <br>".
                "[错误] 目录 '$dir' 不可写，请检查该目录的权限。"
            );
        }

        if (!is_writable($realPath)) {
            die_with_utf8_encoding(
                "[Error] The program lacks write permission to directory '$dir' <br>".
                "[错误] 程序缺少对 '$dir' 目录的写权限，请手动授权。"
            );
        }
    }
})();
