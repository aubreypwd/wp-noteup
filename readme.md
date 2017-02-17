# WP NoteUp 1.4.1

## Release Focus

Major fixes to work with WordPress 4.7.2!

Notes were lost when the postbox was moved around from the side to the
"normal" area and back in the Post edit screen.

So, for now, we've disabled the NoteUp metabox from being in side,
and do not allow it to be dragged around to different areas.
Don't worry, we don't break any of your other post-boxes!

![Screenshot](https://cloudup.com/cKtfRa-MxFQ+)

## Developer Notes

There was a bit of refactoring of how JS works, using the Module structure as
closely as possible. Also a lot of code was stripped from the textarea version
from 1.0 that was still lingering around.

Grunt was also added to help with deployments to WordPress.org and CMB2 was updated
to the latest version.

That's about it!

- [Checkout WP NoteUp on WordPress.org](https://wordpress.org/plugins/wp-noteup/)
- [Contributing](https://github.com/aubreypwd/contributing)
- [Closed Issues](https://github.com/aubreypwd/wp-noteup/milestone/6?closed=1)
- [Download](https://github.com/aubreypwd/wp-noteup/releases/tag/1.1.4)
- [1.1.4 PR](https://github.com/aubreypwd/wp-noteup/pull/53)
- [WordPress.org Changelog](readme.txt)


