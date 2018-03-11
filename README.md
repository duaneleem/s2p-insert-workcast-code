# Insert Workcast Code
Turn any WordPress Page to a WorkCast page (which uses your Header/Footer of your theme).

This plugin does the following:
- Creates a WordPress Theme template that displays HTML from CloudFront.
- Injects CSS/JS assets to style the <iframe> in the WordPress template page for mobile responsiveness.
- Injects a theme template as "WorkCast" template page to your existing theme.

WorkCast has a specific jquery version that needs to be loaded into the header.  To accomplish this, a theme template must be selected as "WorkCast" on a WordPress page so it will take over the main body content of the page and inject a <iframe> to take care of encapsulating the dependencies.

# Credits
The following algorithms have contributed to the development of this plugin.
- [Header and Footer Scripts](https://github.com/anandkumar/header-and-footer-scripts)
- [WordPress Page Templater by WPExplorer.com](https://github.com/wpexplorer/page-templater)
- [WordPress.com Codex](https://codex.wordpress.org/)