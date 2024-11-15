<?php

namespace Major\CS\Rules;

const PhpDocOrder = [
    'internal', 'deprecated',
    'no-named-arguments',
    'type',
    'template', 'template-covariant',
    'extends', 'implements',
    'property', 'property-read', 'property-write',
    'param', 'return', 'throws',
    'var',
];

const PhpDocGroups = [
    ['template', 'template-covariant'],
    ['extends', 'implements'],
    ['property', 'property-read', 'property-write'],
];

return [
    // Alias
    'backtick_to_shell_exec' => true,
    'no_alias_language_construct_call' => true,
    'no_mixed_echo_print' => true,

    // Array Notation
    'array_syntax' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_whitespace_before_comma_in_array' => true,
    'normalize_index_brace' => true,
    'return_to_yield_from' => false,
    'trim_array_spaces' => true,
    'whitespace_after_comma_in_array' => ['ensure_single_space' => true],
    'yield_from_array_to_yields' => false,

    // Attribute Notation
    'attribute_empty_parentheses' => true,
    'ordered_attributes' => [
        'sort_algorithm' => 'custom',
        'order' => [
            \PHPUnit\Framework\Attributes\DataProvider::class,
            \PHPUnit\Framework\Attributes\TestDox::class,
        ],
    ],

    // Basic
    'braces_position' => true,
    'encoding' => true,
    'no_multiple_statements_per_line' => true,
    'no_trailing_comma_in_singleline' => true,
    'numeric_literal_separator' => false,
    'octal_notation' => true,
    'single_line_empty_body' => false,

    // Casing
    'class_reference_name_casing' => true,
    'constant_case' => true,
    'integer_literal_case' => true,
    'lowercase_keywords' => true,
    'lowercase_static_reference' => true,
    'magic_constant_casing' => true,
    'magic_method_casing' => true,
    'native_function_casing' => true,
    'native_type_declaration_casing' => true,

    // Cast Notation
    'cast_spaces' => true,
    'lowercase_cast' => true,
    'no_short_bool_cast' => true,
    'no_unset_cast' => true,
    'short_scalar_cast' => true,

    // Class Notation
    'class_attributes_separation' => true,
    'class_definition' => [
        'single_line' => true,
        'space_before_parenthesis' => true,
        'inline_constructor_arguments' => false,
    ],
    'no_blank_lines_after_class_opening' => true,
    'no_null_property_initialization' => true,
    'ordered_class_elements' => [
        'order' => [
            'use_trait', 'case', 'constant', 'property',
            'method_abstract', 'construct', 'method', 'magic',
        ],
    ],
    'ordered_types' => false,
    'protected_to_private' => true,
    'self_static_accessor' => true,
    'single_class_element_per_statement' => true,
    'single_trait_insert_per_statement' => true,
    'visibility_required' => true,

    // Comment
    'header_comment' => false,
    'multiline_comment_opening_closing' => true,
    'no_empty_comment' => true,
    'no_trailing_whitespace_in_comment' => true,
    'single_line_comment_spacing' => true,
    'single_line_comment_style' => true,

    // Control Structure
    'control_structure_braces' => true,
    'control_structure_continuation_position' => true,
    'elseif' => true,
    'empty_loop_body' => true,
    'empty_loop_condition' => true,
    'include' => true,
    'no_alternative_syntax' => ['fix_non_monolithic_code' => false],
    'no_break_comment' => true,
    'no_superfluous_elseif' => true,
    'no_unneeded_control_parentheses' => [
        'statements' => [
            'break', 'clone', 'continue', 'echo_print', 'negative_instanceof',
            'others', 'return', 'switch_case', 'yield', 'yield_from',
        ],
    ],
    'no_unneeded_braces' => true,
    // 'no_useless_else' => true,
    // 'simplified_if_return' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'switch_continue_to_break' => true,
    'trailing_comma_in_multiline' => [
        'after_heredoc' => true,
        'elements' => ['arguments', 'array_destructuring', 'arrays', 'match', 'parameters'],
    ],
    'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],

    // Function Notation
    'function_declaration' => true,
    'lambda_not_used_import' => true,
    'method_argument_space' => ['on_multiline' => 'ignore', 'attribute_placement' => 'ignore'],
    'no_spaces_after_function_name' => true,
    'nullable_type_declaration_for_default_null_value' => true,
    'return_type_declaration' => true,
    'single_line_throw' => false,

    // Import
    'fully_qualified_strict_types' => false,
    'global_namespace_import' => [
        'import_classes' => true,
        'import_constants' => true,
        'import_functions' => true,
    ],
    'group_import' => false,
    'no_leading_import_slash' => true,
    'no_unneeded_import_alias' => true,
    'no_unused_imports' => true,
    'ordered_imports' => [
        'imports_order' => ['class', 'function', 'const'],
        'sort_algorithm' => 'alpha',
    ],
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,

    // Language Construct
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'declare_equal_normalize' => true,
    'declare_parentheses' => true,
    'explicit_indirect_variable' => true,
    'nullable_type_declaration' => true,
    'single_space_around_construct' => true,

    // List Notation
    'list_syntax' => true,

    // Namespace Notation
    'blank_line_after_namespace' => true,
    'blank_lines_before_namespace' => true,
    'clean_namespace' => true,
    'no_leading_namespace_whitespace' => true,

    // Operator
    'assign_null_coalescing_to_coalesce_equal' => true,
    'binary_operator_spaces' => true,
    'concat_space' => ['spacing' => 'one'],
    'increment_style' => ['style' => 'post'],
    'new_with_parentheses' => ['anonymous_class' => false],
    'no_space_around_double_colon' => true,
    'no_useless_concat_operator' => rare(),
    'no_useless_nullsafe_operator' => StaticAnalysis,
    'not_operator_with_successor_space' => true,
    'object_operator_without_whitespace' => true,
    'operator_linebreak' => true,
    'standardize_increment' => true,
    'standardize_not_equals' => true,
    'ternary_operator_spaces' => true,
    'ternary_to_null_coalescing' => true,
    'unary_operator_spaces' => true,

    // PHP Tag
    'blank_line_after_opening_tag' => true,
    'echo_tag_syntax' => true,
    'full_opening_tag' => true,
    'linebreak_after_opening_tag' => true,
    'no_closing_tag' => true,

    // PHPUnit
    'php_unit_attributes' => true,
    'php_unit_fqcn_annotation' => true,
    'php_unit_internal_class' => false,
    'php_unit_size_class' => false,
    'php_unit_test_class_requires_covers' => false,

    // PHPDoc
    'align_multiline_comment' => true,
    'general_phpdoc_annotation_remove' => false,
    'general_phpdoc_tag_rename' => [
        'replacements' => ['inheritDocs' => 'inheritDoc'],
    ],
    'no_blank_lines_after_phpdoc' => false,
    'no_empty_phpdoc' => true,
    'no_superfluous_phpdoc_tags' => [
        'allow_mixed' => true,
        'allow_unused_params' => true,
    ],
    'phpdoc_add_missing_param_annotation' => false,
    'phpdoc_align' => ['align' => 'left'],
    'phpdoc_annotation_without_dot' => false,
    'phpdoc_indent' => true,
    'phpdoc_inline_tag_normalizer' => true,
    'phpdoc_line_span' => ['const' => 'single', 'property' => 'single'],
    'phpdoc_list_type' => StaticAnalysis,
    'phpdoc_no_access' => true,
    'phpdoc_no_alias_tag' => [
        'replacements' => ['type' => 'var', 'link' => 'see'],
    ],
    'phpdoc_no_empty_return' => true,
    'phpdoc_no_package' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_order_by_value' => false,
    'phpdoc_order' => [
        'order' => prefixPhpDocTags(PhpDocOrder),
    ],
    'phpdoc_param_order' => true,
    'phpdoc_return_self_reference' => true,
    'phpdoc_scalar' => true,
    'phpdoc_separation' => [
        'groups' => prefixPhpDocGroups(PhpDocGroups, PhpDocOrder),
    ],
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary' => true,
    'phpdoc_tag_casing' => true,
    'phpdoc_tag_type' => false,
    'phpdoc_to_comment' => false,
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_trim' => true,
    'phpdoc_types' => true,
    'phpdoc_types_order' => [
        'sort_algorithm' => 'none',
        'null_adjustment' => 'always_last',
    ],
    'phpdoc_var_annotation_correct_order' => true,
    'phpdoc_var_without_name' => true,

    // Return Notation
    'no_useless_return' => true,
    'return_assignment' => true,
    'simplified_null_return' => true,

    // Semicolon
    'multiline_whitespace_before_semicolons' => true,
    'no_empty_statement' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'semicolon_after_instruction' => true,
    'space_after_semicolon' => ['remove_in_empty_for_expressions' => true],

    // String Notation
    'explicit_string_variable' => true,
    'heredoc_closing_marker' => [
        'reserved_closing_markers' => ['BLADE', 'FTL', 'JSON', 'PHP', 'SQL', 'XML', 'YAML'],
    ],
    'heredoc_to_nowdoc' => true,
    'multiline_string_to_heredoc' => true,
    'no_binary_string' => true,
    'simple_to_complex_string_variable' => true,
    'single_quote' => true,
    'string_implicit_backslashes' => ['single_quoted' => 'escape'],

    // Whitespace
    'array_indentation' => true,
    'blank_line_before_statement' => [
        'statements' => [
            'break', 'case', 'continue', 'declare', 'default', 'do', 'exit', 'for',
            'foreach', 'goto', 'if', 'include', 'include_once', 'require', 'require_once',
            'return', 'switch', 'throw', 'try', 'while', 'yield', 'yield_from',
        ],
    ],
    'blank_line_between_import_groups' => true,
    'compact_nullable_type_declaration' => true,
    'heredoc_indentation' => true,
    'indentation_type' => true,
    'line_ending' => true,
    'method_chaining_indentation' => true,
    'no_extra_blank_lines' => [
        'tokens' => [
            'attribute', 'case', 'continue', 'curly_brace_block', 'default',
            'extra', 'parenthesis_brace_block', 'switch', 'throw',
        ],
    ],
    'no_spaces_around_offset' => true,
    'no_trailing_whitespace' => true,
    'no_whitespace_in_blank_line' => true,
    'single_blank_line_at_eof' => true,
    'spaces_inside_parentheses' => true,
    'statement_indentation' => [
        'stick_comment_to_next_continuous_control_statement' => true,
    ],
    'type_declaration_spaces' => true,
    'types_spaces' => true,
];
