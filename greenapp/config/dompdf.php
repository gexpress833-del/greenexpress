<?php

return [
    'default' => [
        'font_dir' => base_path('storage/fonts/'),
        'font_cache' => base_path('storage/fonts/'),
        'temp_dir' => base_path('storage/temp/'),
        'chroot' => base_path(),
        'log_dir' => base_path('storage/logs/'),
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'application/pdf',
        'default_paper_size' => 'A4',
        'default_paper_orientation' => 'portrait',
        'dpi' => 96,
        'enable_remote' => true,
        'debugPng' => false,
        'debugJpg' => false,
        'debugHtml' => false,
        'debugKeepTemp' => false,
        'debugFontDir' => false,
        'debugFontCache' => false,
        'debugTempDir' => false,
        'debugLogDir' => false,
    ],
];