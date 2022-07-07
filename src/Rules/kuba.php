<?php

namespace Major\CS\Rules;

use PhpCsFixerCustomFixers\Fixer as F;

return [
    F\CommentSurroundedBySpacesFixer::name() => true,
    F\MultilineCommentOpeningClosingAloneFixer::name() => true,
    F\MultilinePromotedPropertiesFixer::name() => true,
    // F\NoCommentedOutCodeFixer::name() => true,
    F\NoDuplicatedArrayKeyFixer::name() => true,
    F\NoDuplicatedImportsFixer::name() => true,
    F\NoLeadingSlashInGlobalNamespaceFixer::name() => true,
    F\NoSuperfluousConcatenationFixer::name() => true,
    F\NoTrailingCommaInSinglelineFixer::name() => true,
    F\NoUselessCommentFixer::name() => true,
    F\NoUselessParenthesisFixer::name() => true,
    // F\PhpdocNoSuperfluousParamFixer::name() => true,
    F\PhpdocParamOrderFixer::name() => true,
    F\PhpdocParamTypeFixer::name() => true,
    F\PhpdocSelfAccessorFixer::name() => true,
    F\PhpdocSingleLineVarFixer::name() => true,
    F\PhpdocTypesCommaSpacesFixer::name() => true,
    F\PromotedConstructorPropertyFixer::name() => true,
    F\SingleSpaceAfterStatementFixer::name() => true,
    F\SingleSpaceBeforeStatementFixer::name() => true,
    // F\StringableInterfaceFixer::name() => true,
];
