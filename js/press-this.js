// IndieWeb Press This bookmarklet tweaks. Use indieweb categories, set
// microformats2 classes on link and remove text.

if (window.parent !== window) {
	window.parent.postMessage(JSON.stringify({
		// The config of your reply endpoint
		reply: 'https://notizblog.org/wp-admin/press-this.php?u={url}'
	}), '*');
}

/* map type to mf2 class(es), wordpress category id, and content prefix */
var classes = {
	"follow": "u-follow-of",
	"like": "u-like u-like-of",
	"reply": "u-in-reply-to",
	"repost": "u-repost u-repost-of",
	"rsvp": "u-in-reply-to",
	"checkin": ""
};
var content_prefixes = {
	"follow": "follows ",
	"like": "likes ",
	"reply": "",
	"repost": "reposted ",
	"rsvp": "RSVPs <data class='p-rsvp' value='XXX'>XXX</data> to ",
	"checkin": ""
};

window.onload = function () {
	/* get 'type' query param. default to 'reply'.
	 * (my kingdom, my kingdom for the URL API and searchParams!)
	 */
	var type = 'reply', u = '';
	var params = window.location.search.substr(1).split('&');
	for (var i = 0; i < params.length; i++) {
		var parts = params[i].split('=');
		if (parts[0] == 'type') {
			type = parts[1];
		} else if (parts[0] == 'u') {
			u = parts[1];
		}
	}

	/* Sometimes the u query param has both the title and URL, e.g. when coming
	/* from a share intent in Android. If so, separate them and redirect with the
	/* new params. */
	u = decodeURIComponent(u.replace(/\+/g, ' '));
	var match = u.match(/['"]?(.*?)['"]?(:|\s+-)\s+(https?:\/\/.+)/);
	if (match) {
		var url = new URL(window.location);
		url.search = '?type=' + type + '&t=' + match[1] + '&u=' + match[3];
		document.location = url;
		return;
	}

	var titleContainer = document.getElementById("title-container");
	var title = titleContainer.textContent;
	if (type == 'checkin') {
		titleContainer.textContent = '';
	}
	if (title.length > 60) {
		title = title.substr(0, 60) + "...";
	}

    // this is a <textarea>
	var content = document.getElementById("pressthis");
	var match = content.value.match('<a href="(.+)">(.*)</a>');
	if (!match) {
		return;
	}

    var url = match[1];
	var prefix = content_prefixes[type] +
		"<a class='" + classes[type] + "' href='" + url + "'>";

	// TODO(snarfed): ugh, this logic is such spaghetti. Rewrite it all, maybe
	// with templates.
	if (match[1].startsWith("https://www.facebook.com/") ||
		match[1].startsWith("https://m.facebook.com/")) {
		/* Facebook. Add embed and Bridgy publish link. */
		if (type == 'rsvp') {
			content.value = prefix + 'this event</a>:';
		} else if (type == 'reply') {
			content.value = '\n' + prefix + '</a>';
		} else {
			content.value = prefix + 'this post</a>:';
		}
		content.value += '\n\
<div id="fb-root"></div> \n\
<script>(function(d, s, id) { \n\
  var js, fjs = d.getElementsByTagName(s)[0]; \n\
  if (d.getElementById(id)) return; \n\
  js = d.createElement(s); js.id = id; \n\
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=318683258228687"; \n\
  fjs.parentNode.insertBefore(js, fjs); \n\
}(document, "script", "facebook-jssdk"));</script> \n\
<div class="fb-post" data-href="' + url + '"></div>';

	} else if (url.startsWith("https://twitter.com/") ||
		url.startsWith("https://mobile.twitter.com/")) {
		/* Twitter. Add embed link. */
		if (type == 'reply') {
			content.value = '\n' + prefix + '</a>';
		} else {
			content.value = prefix + 'this tweet</a>:';
		}
		content.value += '\n\
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script> \n\
<blockquote class="twitter-tweet" lang="en" data-conversation="none" data-dnt="true"> \n\
<a href="' + url + '"></a> \n\
</blockquote> \n\
<a href="https://www.brid.gy/publish/twitter" class="u-bridgy-omit-link u-bridgy-ignore-formatting"></a>';

	} else if (url.startsWith("http://instagram.com/")) {
		/* Instagram. Add embed and Bridgy publish link. */
		content.value = prefix + 'this post</a>:\n\
<script async defer src="//platform.instagram.com/en_US/embeds.js"></script>\n\
<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="4" style="margin: 0 auto;">\n\
  <a href="' + url + '" target="_top"></a>\n\
</blockquote>\n\
<a href="https://www.brid.gy/publish/instagram" class="u-bridgy-omit-link"></a>';

	} else {
		/* Other post. Include title directly. */
		var name = title ? match[2] : "this";
		if (type == 'checkin') {
			content.value = '\
<blockquote class="h-as-checkin">\n\
Checked into <a class="h-event" href="' + url + '">' + name + '</a>\n\
at <a class="h-card p-location" href=""></a>\n\
with <a class="h-card" href=""></a>.\n\
</blockquote>';
		} else {
			// make sure there's some content inside the link, even just &nbsp; , so that
			// WP doesn't think it's blank and remove it when you switch to the
			// standard editor
			content.value = (type == 'reply' ? ('\n' + prefix + '&nbsp;') : (prefix + name))
		        + '</a>';
		}
	}

	content.focus();
	content.setSelectionRange(0, 0);
}

// Polyfill String.startsWith() since it's only supported in Firefox right now.
if (!String.prototype.startsWith) {
	Object.defineProperty(String.prototype, 'startsWith', {
		enumerable: false,
		configurable: false,
		writable: false,
		value: function (searchString, position) {
			position = position || 0;
			return this.indexOf(searchString, position) === position;
		}
	});
}
