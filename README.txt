=== Ultimate Page Builder ===
Contributors: EmranAhmed, wpeshaan, webdzainer
Tags: ultimate builder, page builder, drag and drop page builder, front-end builder, home page builder, landing page builder, layout builder, page, page builder, page builder plugin, site-builder, template builder, visual page builder, website builder, wysiwyg builder
Requires at least: 4.5
Tested up to: 4.7
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An Incredibly easiest and highly customizable drag and drop page builder helps create professional websites without writing a line of code.

== Description ==

[youtube http://www.youtube.com/watch?v=LTSmCs5eRSY]

Ultimate Page Builder is efficiently crafted powerful drag and drop frontend WordPress page builder.
It offers WYSIWYG interface to build web page LIVE.
Say goodbye the days to click back and forth between the clunky dashboard and site frontend while editing or building page.

The powerful technology like Vue.JS is powering the innovating website builder for WordPress which has made it possible to compose high-end page designs and unique layouts real-time without writing a single line of code.

= Useful Links =
[Facebook User Group](https://www.facebook.com/groups/UltimatePageBuilder/) | [Website](https://themehippo.com/?utm_source=wordpress.org&utm_campaign=Ultimate+Page+Builder) | [Documentation](https://upb-guide.themehippo.com/?utm_source=wordpress.org&utm_campaign=Ultimate+Page+Builder)

== Installation ==

### Automatic Install From WordPress Dashboard

1. Login to your the admin panel
2. Navigate to Plugins -> Add New
3. Search **Ultimate Page Builder**
4. Click install and activate respectively.

### Manual Install From WordPress Dashboard

If your server is not connected to the Internet, then you can use this method-

1. Download the plugin by clicking on the red button above. A ZIP file will be downloaded.
2. Login to your site's admin panel and navigate to Plugins -> Add New -> Upload.
3. Click choose file, select the plugin file and click install

### Install Using FTP

If you are unable to use any of the methods due to internet connectivity and file permission issues, then you can use this method-

1. Download the plugin by clicking on the red button above. A ZIP file will be downloaded.
2. Unzip the file.
3. Launch your favorite FTP client. Such as FileZilla, FireFTP, CyberDuck etc. If you are a more advanced user, then you can use SSH too.
4. Upload the folder to wp-content/plugins/
5. Log in to your WordPress dashboard.
6. Navigate to Plugins -> Installed
7. Activate the plugin

== Frequently Asked Questions ==

= How to add section? =

Edit a page with **Ultimate Page Builder**, Click on **SECTION** tab and click on **ADD SECTION** button to add new tab.

= How to disable builder on specific page? =

Go to **Settings Panel** and you will find **ENABLE / DISABLE** toggle option to enable or disable page builder on specific page.

= Does it show short codes on page when uninstalled or disabled plugin? =

No, It doesn't.

= Is it possible to extend? =

Yes, **Ultimate Page Builder** is easily extendable.

= How to add more elements / shortcodes? =

[Documentation about adding more elements / modify existing elements](https://upb-guide.themehippo.com/registering-new-element.html)

= I am a theme developer, Can I save my pre-build templates for my clients? =

Yes, you can save your generated template contents.

= Is it possible to save section for future usages? =

Yes, it is possible to save section and re-use on any of your page with page builder.

= As a theme developer I use Twitter Bootstrap to develop my themes. Is it possible to use Bootstrap with Ultimate Page Builder? =

Yes.

== Screenshots ==

1. Sections panel to add new section.
2. Settings panel to enable or disable page builder on specific page or change element position display.
3. Elements panel.
4. Row and Column panel of a section.
5. Section settings fields
6. Show notice to use grid column simplified form and generate a simplified ratio.
7. Saved Section
7. Contact form 7 settings

== Changelog ==

= 1.0.0-beta.28 =

- Fix Device Hidden Input Issue

= 1.0.0-beta.27 =

- Improve Shortcode JS and Inline Js Loading
- Improve Device Hidden input

= 1.0.0-beta.26 =

- Fix `upb_rgb2HEX` function issue.
- Default Active Item UI Improved for Tab / Accordion etc.
- Function attribute to control background options.
- Improve responsive hidden input type

= 1.0.0-beta.25 =

- Improve `upb_list_pluck` function.
- More Flexible grid option for Twitter Bootstrap 3 and Twitter Bootstrap 4 Grid System
- `upb_responsive_hidden_output` filter added to modify Responsive Hidden Input Options

= 1.0.0-beta.24 =

- Add specific attribute generated content.

= 1.0.0-beta.23 =

- Fix Preview InlineJS attributes value.
- `upb_background_input_group` argument added.

= 1.0.0-beta.22 =

- Improve Shortcode Inline JS loading.
- `upb_is_valid_url()` function added.
- Element Tag Class Improved.
- Meta Generator Added
- `upb_enqueue_shortcode_scripts` action added to enqueue scripts / styles for specific shortcode.
- Improved `upb_add_attribute_after` function

= 1.0.0-beta.21 =

- Set default image size on `media-image` and `background-image` popup display settings.
- `upb_replace_element_attribute` helper function added to replace specific element attribute
- `upb_add_attribute_after` helper function added to add element attribute after specific attribute
- Improve `toHEX()` `toRGB()` functions
- Fix UPB Tab and UPB Accordion Shortcode JS Issue
- Extra Query Option Added on `ajax-select` and `ajax-icon-select`

= 1.0.0-beta.20 =

- `spacing` input type modified with unit
- `toHEX()` `toRGB()` for JS and `upb_hex2RGB()` `upb_rgb2HEX()` for PHP functions added to convert colors.
- `device-value` for individual media query device value option added to use `upb_media_query_based_input_group()`.
- split `builder` and `vendor` scripts.
- `upb_remove_element_attribute` helper function added to simply remove element attributes.

= 1.0.0-beta.19 =

- Click to open UPB Tab and UPB Accordion Settings Panel from Preview Panel.

= 1.0.0-beta.18 =

- Image Size media popup
- Dashicon Icons Added
- `icon-popup` input type Added

= 1.0.0-beta.17 =

- Template Overriding directory changed from `upb-templates` to `ultimate-page-builder`
- `upb_hook_info` function added.
- Pre-build layout reset function
- CSS3 Gradient Background Support

= 1.0.0-beta.16 =
- Media based element attributes added
- `spacing` field for margin and padding input
- Color input palettes option added

= 1.0.0-beta.15 =
- Self-Close ShortCode generate if no content available
- Auto remove un registered or un available elements.
- Developer friendly error message for preview and console
- Tag added to show: New, Soon, Plugin, Theme, Woo, WP

= 1.0.0-beta.14 =
- Custom menu widget base error fixed

= 1.0.0-beta.13 =

- Element Panel title fix
- Media Image select support for add_image_size
- Preview class and element class function separated
- Shortcode Preview feature added

= 1.0.0-beta.12 =

- Refactor input fields
- Fix Recent Posts widget element
- Updated material design icons

= 1.0.0-beta.11 =

- WordPress core widgets added
- Ajax MultiSelect, Single select Option added
- Searchable Icon added with ajax feature
- Heading added
- Updated section background options
- Number Input added
- Iconic Checkbox added
- Iconic Radio added
- Iconic SelectBox added
- Message input added to show messages

= 1.0.0-beta.10 =

- Function `upb_is_preview_request` and `upb_is_boilerplate_request` added.
- Filter added to each builtin input to more control.
- Fixed Debug Bar Console JS loading issue.

= 1.0.0-beta.9 =

- Fixed ui draggable issue after hide sidebar.
- Fixed column sorting draggable issue.
- Disable builder on posts page, woocommerce_shop_page, cart page, checkout page, pay_page, thank you page
myaccount_page etc.
- `upb_non_allowed_pages` filter added to customize those page ids.
- Remove tab from admin editor tabs and add media button to open builder
- Fixed front page loading issue.

= 1.0.0-beta.8 =

- Move Elements from one column to another from preview panel
- Delete functionality added on preview toolbar
- Css class added to use each grid column for more control
- Destroy and Remount preview elements when changes page builder elements position

= 1.0.0-beta.7 =

- Action `upb_remove_elements` added to remove element filter
- Ajax Preview
- Input Field Mixin

= 1.0.0-beta.6 =

- Force added UPB TAB files to SVN

= 1.0.0-beta.5 =

- Accordion active style modified.

= 1.0.0-beta.4 =

- Range Input added
- Spacer added to make gape between sections
- Tab Element Added
- Update Preview Placeholder styles

= 1.0.0-beta.3 =

- Element Preview Inline Script

= 1.0.0-beta.2 =

- Background position required field fix for background-image
- Change v-if directive to v-show.
- Fix preview script loading issue

= 1.0.0-beta.1 =

- Initial release