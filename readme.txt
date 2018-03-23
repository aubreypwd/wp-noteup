=== WP NoteUp ===
Contributors: aubreypwd
Donate link: http://github.com/aubreypwd/wp-noteup
Tags: notes, note, markup, text, footnotes, research
Requires at least: 3.8
Tested up to: 4.8.1
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Take notes on your posts, pages, and other custom post types.

== Description ==

WP NoteUp allows you to take simple notes when you're editing your posts, pages, or other custom post types.

== Installation ==

Install by going to your WordPress Dashboard > Plugins > Add New and searching for "WP NoteUp."

== Screenshots ==

1. WP NoteUp in a Post

== Changelog ==

= 1.2.2 =

Update of CMB2 to the latest version to fix [issue with PHP 7.2](https://github.com/aubreypwd/wp-noteup/issues/68)

CMB2 is now maintained/updated using Composer

= 1.2.1 =

Quick update to fix problems when using < PHP 5.5 that was causing "Fatal error: Can't use method return value in write context in ...wp-noteup/class/class-wp-noteup-post-type-settings.php"
Tested down to PHP 5.2.4

= 1.2 =

The update adds the ability to use WP NoteUp on other custom post types! Just checkout Settings > General to enable other post types. Also, we've simplified the Metabox, it now says "Notes" instead of "NoteUp." And, I've made it safer by validating and filters used under the hood by other developers.

= 1.1.4 =

Major fixes to work with WordPress 4.7.2! Notes were lost when the postbox was moved around from the side to the "normal" area and back in the Post edit screen. So, for now, we've disabled the NoteUp metabox from being in side, and do not allow it to be dragged around to different areas. Don't worry, we don't break any of your other post-boxes!

= 1.1.3 =

Yet another small change in hopes that activation through WordPress.org is again possible.

= 1.1.2 =

Another small tweak fixing the issue people are having activating the plugin.

= 1.1.1 =

Small tweak that keeps other Add Media buttons from showing up in the NoteUp box.

= 1.1 =

This major update, dubbed Cube, was entirely focused on updating the experience of note taking to include formatting and media.

Special thanks to the [CMB2](https://github.com/WebDevStudios/CMB2) crew [@webdevstudios](http://webdevstudios.com).

= 1.0 =

Initial release that allows simple text notes on Posts and Pages.

== Development & Bugs ==

NoteUp is developed with sparkle-dust on [Github](https://github.com/aubreypwd/wp-noteup)!

== Credits ==

Super thanks to the authors of [CMB2](https://github.com/WebDevStudios/CMB2).

== Upgrade Notice ==

If you are having problems with NoteUp metaboxes not showing up on PHP 7.2, you can upgrade to fix that.
