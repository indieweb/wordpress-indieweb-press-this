# IndieWeb press this

This plugin is based on the idea and code of
[@snarfed](https://snarfed.org/indieweb-press-this-bookmarklets-for-wordpress):

One big [IndieWeb](http://indiewebcamp.com/) _raison d’être_ is using your own
web site to [reply](http://indiewebcamp.com/reply),
[like](http://indiewebcamp.com/like), [repost](http://indiewebcamp.com/repost),
and [RSVP](http://indiewebcamp.com/rsvp) to posts and events. You do this by
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
