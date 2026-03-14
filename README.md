# Abjad Widget for WordPress

A powerful, customizable floating widget for Abjad (Ebced), Bastet, and Huddam calculations. Supports Arabic, Hebrew, Turkish, and English.

![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/abjad-widget)
![WordPress Plugin Downloads](https://img.shields.io/wordpress/plugin/dt/abjad-widget)
![License](https://img.shields.io/github/license/metatronslove/abjad-widget)

## Features

- 🔮 **Abjad Calculation** - Traditional Arabic alphanumeric system
- 📿 **Bastet Calculation** - Advanced numeric transformations with loop support
- 👤 **Huddam Generation** - Spiritual entity name generation
- 🌍 **Multi-language** - Arabic, Hebrew, Turkish, English interfaces
- 🎨 **Customizable** - Colors, positions, button styles (emoji, SVG, PNG)
- ⌨️ **Virtual Keyboard** - Built-in keyboard for Arabic/Hebrew input
- 🎯 **Element Classification** - Fire, Air, Water, Earth
- 💝 **Buy Me a Coffee** - Integrated support button

## Installation

### WordPress.org
1. Go to Plugins → Add New
2. Search for "Abjad Widget"
3. Install and activate

### Manual
1. Upload `abjad-widget` folder to `/wp-content/plugins/`
2. Activate via WordPress admin
3. Configure at Settings → Abjad Widget

## Requirements

- WordPress 5.0+
- PHP 7.2+
- jQuery (included with WordPress)

## Configuration

1. Enter your Buy Me a Coffee username
2. Choose button color and position
3. Select button type (emoji/SVG/PNG)
4. Save and enjoy!

## Development

### Local Setup
```bash
git clone https://github.com/metatronslove/abjad-widget.git
cd abjad-widget
# Symlink to your WordPress plugins directory
ln -s $(pwd) /path/to/wp-content/plugins/abjad-widget
```

### Building
No build process required - pure PHP/JavaScript.

### Translations
```bash
# Generate .pot file
wp i18n make-pot . languages/abjad-widget.pot
# Update .po files
msgmerge -U languages/tr_TR.po languages/abjad-widget.pot
# Compile .mo
msgfmt languages/tr_TR.po -o languages/tr_TR.mo
```

## Deployment

This plugin uses GitHub Actions for automatic deployment to WordPress.org SVN. 
To release a new version:

```bash
git tag v1.0.1
git push origin v1.0.1
```

## License

GPL-2.0+ - See [LICENSE](LICENSE) file.

## Support

- [WordPress.org Forum](https://wordpress.org/support/plugin/abjad-widget)
- [GitHub Issues](https://github.com/metatronslove/abjad-widget/issues)

## Buy Me a Coffee

If you find this plugin useful, consider [buying me a coffee](https://www.buymeacoffee.com/metatronslove)!
