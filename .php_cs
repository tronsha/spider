<?php

$header = <<<'EOF'
The MIT License (MIT)

Copyright (c) 2017 - 2018 Stefan Hüsges

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@PSR2' => true,
        'combine_consecutive_unsets' => true,
        'function_typehint_space' => true,
        'header_comment' => array('header' => $header),
        'include' => true,
        'method_separation' => true,
        'no_alias_functions' => true,
        'no_empty_statement' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_unused_imports' => true,
        'no_useless_return' => true,
        'no_short_echo_tag' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'php_unit_construct' => true,
        'php_unit_dedicate_assert' => true,
        'php_unit_strict' => true,
        'no_mixed_echo_print' => ['use' => 'echo'],
        'array_syntax' => ['syntax' => 'short'],
        'single_quote' => true,
        'standardize_not_equals' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'whitespace_after_comma_in_array' => true,
        'concat_space' => ['spacing' => 'one'],
    ))
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    )
;
