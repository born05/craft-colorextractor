# Color Extractor

Extract colors from image assets in Craft 3.
The Craft 2 plugin is moved to [another branch](https://github.com/born05/craft-colorextractor/tree/craft-2).

## Inner working

By using the `imageColor` field on each asset, it doesn't require extra database queries when showing colors. On install it creates a task to extract the color for every image.

## Requirements

- A field named `imageColor` on all assets of kind image (can be color or plaintext)
- Craft 3 (we test on the latest release of Craft 3)
- PHP 7.1 at least

## Example usage

Use the `colorExtractor` twig filter to retrieve the image's color from templates.

```twig
<div style="background-color: {{ entry.images[0]|colorExtractor }};"></div>
```

From command:

```php
craft color-extractor/default
```

## License

See [license](https://github.com/born05/craft-colorextractor/blob/master/LICENSE.md)

## Credits

Based upon [craft-image-color plugin](https://github.com/familiar-studio/craft-image-color) by familiar-studio.
