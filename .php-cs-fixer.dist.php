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
        'cast_spaces' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
        'function_typehint_space' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'author',
                'license',
                'package',
                'category',
                'copyright',
            ],
        ],
        'global_namespace_import' => [
            'import_classes' => false,
            'import_constants' => false,
            'import_functions' => false,
        ],
        'increment_style' => true,
        'is_null' => true,
    ]);
