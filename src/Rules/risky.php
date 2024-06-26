<?php

namespace Major\CS\Rules;

return [
    // Alias
    'array_push' => true,
    'ereg_to_preg' => legacy(),
    'mb_str_functions' => false,
    'modernize_strpos' => true,
    'no_alias_functions' => ['sets' => ['@all']],
    'pow_to_exponentiation' => true,
    // Risky when relying on the seed based generating of the numbers.
    'random_api_migration' => legacy([
        'replacements' => ['mt_rand' => 'random_int', 'rand' => 'random_int'],
    ]),
    // Risky when used as the 2nd or 3rd expression in a for loop.
    'set_type_to_cast' => legacy(),

    // Basic
    'non_printable_character' => true,
    'psr_autoloading' => StaticAnalysis,

    // Cast Notation
    'modernize_types_casting' => true,

    // Class Notation
    'final_class' => StaticAnalysis,
    'final_internal_class' => StaticAnalysis,
    'final_public_method_for_abstract_class' => StaticAnalysis,
    // Risky when old style constructor is overridden or overrides parent one.
    'no_php4_constructor' => legacy(),
    // Risky when child class overrides a private method on PHP < 8.0.
    'no_unneeded_final_method' => true,
    // Risky for implements when specifying both an interface and its parent,
    // because PHP does not break on parent, child but does on child, parent.
    'ordered_interfaces' => true,
    // Risky when depending on order of the imports.
    'ordered_traits' => true,
    'phpdoc_readonly_class_comment_to_keyword' => StaticAnalysis,
    // Risky when using dynamic calls like get_called_class() or late static binding.
    'self_accessor' => true,

    // Class Usage
    'date_time_immutable' => StaticAnalysis,

    // Comment
    'comment_to_phpdoc' => true,

    // Constant Notation
    'native_constant_invocation' => false,

    // Function Notation
    'combine_nested_dirname' => legacy(),
    'date_time_create_from_format_call' => false,
    'fopen_flag_order' => rare(),
    'fopen_flags' => rare(['b_mode' => false]),
    'implode_call' => true,
    'native_function_invocation' => false,
    'no_unreachable_default_argument_value' => legacy(),
    'no_useless_sprintf' => true,
    'phpdoc_to_param_type' => StaticAnalysis,
    'phpdoc_to_property_type' => StaticAnalysis,
    'phpdoc_to_return_type' => StaticAnalysis,
    'regular_callable_call' => true,
    'static_lambda' => false,
    'use_arrow_functions' => false,
    'void_return' => StaticAnalysis,

    // Language Construct
    'class_keyword' => false,
    'dir_constant' => legacy(),
    'error_suppression' => false,
    'function_to_constant' => true,
    'is_null' => true,
    'no_unset_on_property' => false,

    // Naming
    'no_homoglyph_names' => true,

    // Operator
    'logical_operators' => true,
    'long_to_shorthand_operator' => true,
    'ternary_to_elvis_operator' => true,

    // PHPDoc
    'phpdoc_array_type' => true,

    // Strict
    'declare_strict_types' => false,
    'strict_comparison' => StaticAnalysis,
    'strict_param' => StaticAnalysis,

    // String Notation
    'no_trailing_whitespace_in_string' => true,
    // Risky when called using a Stringable object.
    'string_length_to_empty' => StaticAnalysis,
    'string_line_ending' => true,
];
