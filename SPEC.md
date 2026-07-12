# Blade Blocks Example

Blade Blocks let you embed and execute Blade within any Markdown page using code blocks. It is a sister feature to Hyde's `[Blade]:` BladeDown support, and works on ordinary Markdown pages, posts, and documentation pages alike — there is no special page type or file extension.

Blade Blocks and BladeDown are enabled by default and are both controlled by `markdown.enable_blade` in your `config/markdown.php`. They allow arbitrary PHP to run, so disable this option if your Markdown is not trusted.

If you want to write an actual code block, use four backticks as the terminator.

In all cases, we will pass the `$page` variable to the view, meaning that you can access the data for the page. The Blade is evaluated at build time.

Each rendered block is wrapped with a div containing the classes `blade-block not-prose`.

## A bare `blade` block is just a highlighted code sample

Anything Hyde executes is keyed off the `blade` prefix followed by a directive. Since fence info strings only use their first word for syntax highlighting, this keeps real Blade highlighting in every case, while a bare `blade` block stays an ordinary code sample and is not executed.

````markdown
```blade
{{ "This is not executed" }}
```
````

```blade
{{ "This is not executed" }}
```

## Using the `blade render` directive, you can put any arbitrary Blade code

````markdown
```blade render
@php($world = 'world')

{{ "Hello $world" }}
```
````

```blade render
@php($world = 'world')

{{ "Hello $world" }}
```

This kind of "anonymous" component will render using `Blade::render()`.

## Using the `blade component(name)` directive you can call a Blade component using YAML front matter syntax

````markdown
```blade component(component-name)
---
foo: bar
---
```
````

```blade component(component-name)
---
foo: bar
---
```

Each variable will be passed to the Blade view. In the future we may try to parse the props of a page to validate the properties added in front matter.

When the block does not start with YAML front matter, its content is treated as Markdown and passed to the component's `$slot`:

````markdown
```blade component(component-name)
This is Markdown passed directly to the **component slot**.
```
````

```blade component(component-name)
This is Markdown passed directly to the **component slot**.
```

To pass both variables and Markdown slot content, add the Markdown after the front matter. That Markdown is compiled to HTML using the HydePHP Markdown converter (meaning features like coloured blockquotes and more are available), though you may need to add the `prose` class to your container.

````markdown
```blade component(component-name)
---
foo: bar
---

# I can now write Markdown here!
```
````

```blade component(component-name)
---
foo: bar
---

# I can now write Markdown here!
```

---

## And of course, normal code blocks are unaffected
```
<h1>Hello World!</h1>
```

```blade component(component-name)
---
foo: bar
---

Also, in component Markdown slots, the {{ $blade }} is not rendered.
```

## Edge cases & Considerations

### Equal code blocks

Note that blocks with the same content will still be compiled independently.

````
```blade render
@php($random = rand(1, 1000))

{{ "Random $random" }}
```

```blade render
@php($random = rand(1, 1000))

{{ "Random $random" }}
```
````

```blade render
@php($random = rand(1, 1000))

{{ "Random $random" }}
```

```blade render
@php($random = rand(1, 1000))

{{ "Random $random" }}
```

### Component without a name

A component without a name in the directive will throw an error.

````markdown
```blade component
Will throw an error.
```
````

Here is the logic table for this

| Block                     | Behavior            |
| ------------------------- | ------------------- |
| `blade`                   | highlighted sample  |
| `blade render`            | valid Blade block   |
| `blade component(name)`   | valid Blade block   |
| `blade component`         | throw               |
| `blade component()`       | throw               |
| `blade component(foo`     | throw               |
| `blade foo`               | throw               |
| `php`, `js`, `html`, etc. | ordinary code block |
