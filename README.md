# Color Extractor

Extract colors from image assets in Craft 2.

## Inner working

By using the `imageColor` field on each asset, it doesn't require extra database queries when showing colors. On install it creates a task to extract the color for every image.

## Requirements

- A field named `imageColor` on all assets of kind image (can be color or plaintext)
- Craft 2.6.x (we test on the latest release of Craft 2)
- PHP 7.x at least

## Example usage

Use the `colorExtractor` twig filter to retrieve the image's color from templates.

```twig
<div style="background-color: {{ entry.images[0]|colorExtractor }};"></div>
```

From php:

```php
craft()->colorExtractor_asset->getImageColor($assetFileModel);
```

## License

Copyright © 2018 [Born05](https://www.born05.com/)

See [license](https://github.com/born05/craft-colorextractor/blob/craft-2/LICENSE)

## Credits

Based upon [craft-image-color plugin](https://github.com/familiar-studio/craft-image-color) by familiar-studio.
