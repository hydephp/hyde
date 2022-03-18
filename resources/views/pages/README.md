# About the Pages directory

If you want full control over a static page you can create blade views here, and they will be compiled into static HTML.

Currently, only top level pages are supported. The filename of the generated file is based on the view filename.
For example, `resources\views\pages\custom-page.blade.php` gets saved as `_site\custom-page.html`.

## ⚠ Warning:
Files here take precedence over files in _pages! Do not use duplicate slugs.

## Using the layout
If you want to match the styles of the rest of your app you can extend the default layout.
```blade
@extends('layouts.app')
@section('content')

// Place content here

@endsection
```

