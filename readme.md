# IndieWeb Press This #
**Contributors:** [pfefferle](https://profiles.wordpress.org/pfefferle), [snarfed](https://profiles.wordpress.org/snarfed), [indieweb](https://profiles.wordpress.org/indieweb), [dshanske](https://profiles.wordpress.org/dshanske)  
**Donate link:** https://indieweb.org/how-to-sponsor  
**Tags:** indieweb, webmention, POSSE  
**Requires at least:** 4.7  
**Tested up to:** 6.1.1  
**Stable tag:** 1.2  
**License:** CC0-1.0  
**License URI:** https://creativecommons.org/publicdomain/zero/1.0/  

IndieWebified Press This bookmarklets.

## Description ##

This plugin is based on the idea and code of [@snarfed](https://snarfed.org/indieweb-press-this-bookmarklets-for-wordpress):

It requires the Press This plugin for WordPress with Bookmarklet support as of WordPress 4.9, when Press This was removed from WordPress.

One big [IndieWeb](https://indieweb.org/) _raison d’être_ is using your own web site to [reply](https://indieweb.org/reply),
[like](https://indieweb.org/like), [repost](https://indieweb.org/repost), [follow](https://indieweb.org/follow),
and [RSVP](https://indieweb.org/rsvp) to posts and events. You do this by annotating links on your site with simple [microformats2](http://microformats.org/wiki/microformats2) HTML.

Having said that, most people don’t want to write HTML to like or reply to something. WordPress’s [Press This bookmarklets](http://codex.wordpress.org/Press_This) can already start a new post with a link to the page you’re currently viewing. This code adds IndieWeb microformats2 markup to that link. Combined the [wordpress-webmention](https://github.com/pfefferle/wordpress-webmention) plugin, you can use this to respond to the current page with just two clicks.

What’s more, if you’re currently on a Facebook post or Twitter tweet, this adds the [Bridgy Publish](https://www.brid.gy/about#publish) link that will reply, like, favorite, retweet, or even RSVP _inside_ those social networks.

## Changelog ##

### 1.2 ###

* Update bookmarklets to work in mobile browsers by using the current browser window instead of opening a new one. Background in [WordPress/press-this#50](https://github.com/WordPress/press-this/issues/50).

### 1.1 ###

* Add [follow](https://indieweb.org/follow) support.

### 1.0.4 ###

* Documentation added to explain that WordPress 4.9 now requires the Press This plugin
* Minor refactoring
* Press This Plugin restored bookmarklet functionality in Version 1.1.1, and it will prompt to install if plugin not installed so no conditional coding required

### 1.0.3 ###

* WP.org version

### 1.0.2 ###

* fixed list of contributors

### 1.0.1 ###

* WordPress.org version

### 1.0.0 ###

* initial
