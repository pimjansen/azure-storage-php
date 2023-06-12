<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        '.build/',
        '.github/',
        '.docker/',
        'samples'
    ])
    ->ignoreDotFiles(false)
    ->in(__DIR__);

$config = new PhpCsFixer\Config('AzureOss');

if (!is_dir('.build/php-cs-fixer')) {
    mkdir('.build/php-cs-fixer', 0755, true);
}

return $config
    ->setCacheFile('.build/php-cs-fixer/cache')
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'array_indentation' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'binary_operator_spaces' => true,
        'blank_line_after_opening_tag' => true,
        'braces' => [
            'allow_single_line_anonymous_class_with_empty_body' => true,
        ],
        'cast_spaces' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
    ]);
