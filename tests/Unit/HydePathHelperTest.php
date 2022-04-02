<?php

// Unit test the Hyde::path() helper

use Hyde\Framework\Hyde;

test('method exists', function () {
    expect(method_exists(Hyde::class, 'path'))->toBeTrue();
});

test('string is returned', function () {
    expect(Hyde::path())->toBeString();
});

test(
    'returned directory contains content expected to be in the project directory',
    function () {
        expect(
            file_exists(Hyde::path().DIRECTORY_SEPARATOR.'hyde') &&
            file_exists(Hyde::path().DIRECTORY_SEPARATOR.'_pages') &&
            file_exists(Hyde::path().DIRECTORY_SEPARATOR.'_posts') &&
            file_exists(Hyde::path().DIRECTORY_SEPARATOR.'_site')
        )->toBeTrue();
    }
);

test('method returns qualified file path when supplied with argument', function () {
    expect(Hyde::path('file.php'))->toEqual(Hyde::path().DIRECTORY_SEPARATOR.'file.php');
});

test('method strips trailing directory separators from argument', function () {
    expect(Hyde::path('\\/file.php/'))->toEqual(Hyde::path().DIRECTORY_SEPARATOR.'file.php');
});

test('method returns expected value for nested path arguments', function () {
    expect(Hyde::path('directory/file.php'))
        ->toEqual(Hyde::path().DIRECTORY_SEPARATOR.'directory/file.php');
});

test('method returns expected value regardless of trailing directory separators in argument', function () {
    expect(Hyde::path('directory/file.php/'))
        ->toEqual(Hyde::path().DIRECTORY_SEPARATOR.'directory/file.php');
    expect(Hyde::path('/directory/file.php/'))
        ->toEqual(Hyde::path().DIRECTORY_SEPARATOR.'directory/file.php');
    expect(Hyde::path('\\/directory/file.php/'))
        ->toEqual(Hyde::path().DIRECTORY_SEPARATOR.'directory/file.php');
});
