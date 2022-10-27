<?php

return (new PhpCsFixer\Config())
    ->setIndent('    ')
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@DoctrineAnnotation' => false,
        '@PHPUnit48Migration:risky' => true,
        // part of `PHPUnitXYMigration:risky` ruleset, to be enabled when PHPUnit 4.x support will be dropped
        // as we don't want to rewrite exceptions handling twice
        'php_unit_no_expectation_annotation' => false,
        'array_syntax' => ['syntax' => 'short'],
        'strict_param' => true,
        'fopen_flags' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'break',
                'continue',
                'extra',
                'return',
                'throw',
                'use',
                'parenthesis_brace_block',
                'square_brace_block',
                'curly_brace_block',
            ],
        ],
        'ordered_imports' => true,
        'protected_to_private' => false,
        // Part of @Symfony:risky in PHP-CS-Fixer 2.13.0. To be removed from the config file once upgrading
        'native_function_invocation' => [
            'include' => ['@compiler_optimized'],
            'scope' => 'namespaced',
            'strict' => true,
        ],
        // Part of future @Symfony ruleset in PHP-CS-Fixer To be removed from the config file once upgrading
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],
        'array_indentation' => true,
        'indentation_type' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'static_lambda' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->append([__FILE__])
            ->exclude([
                'vendor',
            ])
        // ->notPath('somepath_to_a_file')
    )
;
