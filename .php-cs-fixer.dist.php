<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources/views',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();


return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        "blank_line_after_opening_tag" => false,
        "global_namespace_import" => [
            "import_classes" => true,
            "import_constants" => true,
        ],
        "linebreak_after_opening_tag" => false,
        "native_function_invocation" => false,
        "no_superfluous_phpdoc_tags" => false,
        "not_operator_with_successor_space" => false,
        "php_unit_test_case_static_method_calls" => [
            "call_type" => "this",
        ],
        "phpdoc_add_missing_param_annotation" => true,
        "phpdoc_align" => [
            "align" => "left",
        ],
        "phpdoc_order" => true,
        "phpdoc_single_line_var_spacing" => true,
        "phpdoc_types_order" => [
            "null_adjustment" => "always_last",
            "sort_algorithm" => "none",
        ],
        "single_quote" => true,
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder($finder);
