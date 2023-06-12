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
        'list_syntax' => [
            'syntax' => 'short',
        ],
        'modernize_types_casting' => true,
        'multiline_comment_opening_closing' => true,
        'new_with_braces' => true,
        'no_alias_functions' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_spaces_around_offset' => true,
        'no_superfluous_elseif' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_trailing_comma_in_singleline' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unneeded_curly_braces' => true,
        'no_unneeded_final_method' => true,
        'no_unreachable_default_argument_value' => true,
        'no_unset_cast' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'non_printable_character' => true,
        'operator_linebreak' => [
            'only_booleans' => true,
            'position' => 'beginning',
        ],
        'ordered_imports' => true,
        'php_unit_construct' => true,
        'php_unit_dedicate_assert' => true,
        'php_unit_dedicate_assert_internal_type' => true,
        'php_unit_expectation' => true,
        'php_unit_fqcn_annotation' => true,
        'php_unit_method_casing' => true,
        'php_unit_mock' => true,
        'php_unit_mock_short_will_return' => true,
        'php_unit_namespaced' => true,
        'php_unit_no_expectation_annotation' => true,
        'php_unit_set_up_tear_down_visibility' => true,
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'self',
        ],
    ]);
