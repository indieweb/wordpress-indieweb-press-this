# IndieWeb press this

_As of
[`1e8acea`](https://github.com/pfefferle/wordpress-indieweb-press-this/commit/1e8acea47c53921d6f12f53527071e57f74ff7c3)
(2015-08-21), this plugin REQUIRES WordPress 4.3. If you want to use it with a
previous WordPress version, use
[`164e26c`](https://github.com/pfefferle/wordpress-indieweb-press-this/tree/164e26c1b4df1aa1370e2afec43b93df9919562e) instead._

This plugin is based on the idea and code of
[@snarfed](https://snarfed.org/indieweb-press-this-bookmarklets-for-wordpress):

One big [IndieWeb](https://indieweb.org/) _raison d’être_ is using your own
web site to [reply](https://indieweb.org/reply),
[like](https://indieweb.org/like), [repost](https://indieweb.org/repost),
and [RSVP](https://indieweb.org/rsvp) to posts and events. You do this by
annotating links on your site with simple
[microformats2](http://microformats.org/wiki/microformats2) HTML.

Having said that, most people don’t want to write HTML just to like or reply to
something. WordPress’s
[Press This bookmarklets](http://codex.wordpress.org/Press_This) can already
start a new post with a link to the page you’re currently viewing. This code
adds IndieWeb microformats2 markup to that link. Combined the
[wordpress-webmention](https://github.com/pfefferle/wordpress-webmention)
plugin, you can use this to respond to the current page with just two clicks.

What’s more, if you’re currently on a Facebook post or Twitter tweet, this adds
the [Bridgy Publish](https://www.brid.gy/about#publish) link that will reply,
like, favorite, retweet, or even RSVP _inside_ those social networks.
