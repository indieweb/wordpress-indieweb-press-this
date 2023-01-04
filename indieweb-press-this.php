<?php
/**
 * Plugin Name: IndieWeb Press This
 * Plugin URI: http://github.com/indieweb/wordpress-indieweb-press-this
 * Description: This plugin adds IndieWeb microformats2 markup to WordPress' press this. After activating, go to the Tools tab to install the bookmarklets.
 * Author: IndieWeb WordPress Outreach Club
 * Author URI: https://indieweb.org/WordPress_Outreach_Club
 * Version: 1.3
 * License: CC0-1.0
 * License URI: https://creativecommons.org/publicdomain/zero/1.0/
 */

// initialize plugin
add_action( 'init', array( 'IndieWebPressThis', 'init' ) );

/**
 * WordPress plugin based on @snarfeds press-this extension
 *
 * @see https://snarfed.org/indieweb-press-this-bookmarklets-for-wordpress
 */
class IndieWebPressThis {
	/**
	 * add some hooks and filters
	 */
	public static function init() {
		add_action( 'admin_print_scripts-press-this.php', array( 'IndieWebPressThis', 'js' ) );
		add_action( 'tool_box', array( 'IndieWebPressThis', 'bookmarklets_page' ) );
	}

	/**
	 * add custom JavaScript to extend the press-this
	 * bookmarklet with some IndieWeb magic
	 *
	 * @see https://github.com/snarfed/misc/blob/master/press_this.js
	 */
	public static function js() {
		wp_enqueue_script( 'indieweb-press-this', plugins_url( '/js/press-this.js', __FILE__ ), false, '1.0', true );
	}

	/**
	 * render admin page with a short description (taken from @snarfeds Blog-post)
	 * and to provide the custom bookmarklets
	 */
	public static function bookmarklets_page() {
	?>
	<div class="card">
		<h3 class="title"><?php _e( 'IndieWeb bookmarklets', 'indieweb_press_this' ); ?></h3>
		<p>
			One big <a href="https://indieweb.org/">IndieWeb</a> <em>raison d’être</em> is using your own
			web site to <a href="https://indieweb.org/reply">reply</a>,
			<a href="https://indieweb.org/like">like</a>, <a href="https://indieweb.org/repost">repost</a>,
            <a href="https://indieweb.org/follow">follow</a>, and <a href="https://indieweb.org/rsvp">RSVP</a>
            to posts and events. You do this by annotating links on your site with simple
			<a href="http://microformats.org/wiki/microformats2">microformats2</a> HTML.
		</p>

		<p>
			Having said that, most people don’t want to write HTML just to like or reply to
			something. WordPress’s
			<a href="http://codex.wordpress.org/Press_This">Press This bookmarklets</a> can already
			start a new post with a link to the page you’re currently viewing. As of WordPress 4.9, this 
			is no longer part of WordPress and must be installed 
			<a href="https://wordpress.org/plugins/press-this/">separately</a></p>
		<p>	This code adds IndieWeb microformats2 markup to that link. Combined the
			<a href="https://github.com/pfefferle/wordpress-webmention">wordpress-webmention</a>
			plugin, you can use this to respond to the current page with just two clicks.
		</p>

		<p>
			What’s more, if you’re currently on a Facebook post or Twitter tweet, this adds
			the <a href="https://www.brid.gy/about#publish">Bridgy Publish</a> link that will reply,
			like, favorite, retweet, or even RSVP <em>inside</em> those social networks.
		</p>

		<p><small>— <cite><a href="https://snarfed.org/indieweb-press-this-bookmarklets-for-wordpress">snarfed.org</a></cite></small></p>

		<p class="description"><?php _e( 'Drag-and-drop the following link to your bookmarks bar or right click it and add it to your favorites for a posting shortcut.', 'indieweb_press_this' ); ?></p>
		<p class="pressthis-bookmarklet-wrapper">
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'reply' ); ?>"><span>Reply</span></a>
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'like' ); ?>"><span>Like</span></a>
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'repost' ); ?>"><span>Repost</span></a>
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'rsvp' ); ?>"><span>RSVP</span></a>
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'follow' ); ?>"><span>Follow</span></a>
		</p>

        <br>
		<p class="description"><?php _e( 'For mobile browsers, use these instead.', 'indieweb_press_this' ); ?></p>
		<p class="pressthis-bookmarklet-wrapper">
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'reply', true ); ?>"><span>Reply</span></a>
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'like', true); ?>"><span>Like</span></a>
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'repost', true ); ?>"><span>Repost</span></a>
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'rsvp', true ); ?>"><span>RSVP</span></a>
			<a class="pressthis-bookmarklet" href="<?php echo self::generate_bookmarklet_js( 'follow', true ); ?>"><span>Follow</span></a>
		</p>
	</div>
	<?php
	}

	/**
	 * a small helper to generate the differnet bookmarklet codes
	 *
	 * Base bookmarklet comes from https://github.com/WordPress/press-this/blob/trunk/assets/bookmarklet.min.js
	 *
	 * @param string $type the type of the bookmarklet (reply, like, repost, follow, or RSVP)
	 * @return string the JavaScript bookmarket code
	 */
	public static function generate_bookmarklet_js( $type = 'reply', $mobile = false ) {
		return "javascript:(function(a,b,c,d){function%20e(a,c){if('undefined'!=typeof%20c){var%20d=b.createElement('input');d.name=a,d.value=c,d.type='hidden',p.appendChild(d)}}var%20f,g,h,i,j,k,l,m,n,o=a.encodeURIComponent,p=b.createElement('form'),q=b.getElementsByTagName('head')[0],r='_press_this_app',s=!0;if(d){if(!c.match(/^https?:/))return%20void(top.location.href=d);if(d+='&u='+o(c),c.match(/^https:/)&&d.match(/^http:/)&&(s=!1),a.getSelection?h=a.getSelection()+'':b.getSelection?h=b.getSelection()+'':b.selection&&(h=b.selection.createRange().text||''),d+='&buster='+(new%20Date).getTime(),s||(b.title&&(d+='&t='+o(b.title.substr(0,256))),h&&(d+='&s='+o(h.substr(0,512)))),f=a.outerWidth||b.documentElement.clientWidth||600,g=a.outerHeight||b.documentElement.clientHeight||700,f=800>f||f>5e3?600:.7*f,g=800>g||g>3e3?700:.9*g,!s)return%20void%20a.open(d,r,'location,resizable,scrollbars,width='+f+',height='+g);i=q.getElementsByTagName('meta')||[];for(var%20t=0;t<i.length&&!(t>200);t++){var%20u=i[t],v=u.getAttribute('name'),w=u.getAttribute('property'),x=u.getAttribute('content');x&&(v?e('_meta['+v+']',x):w&&e('_meta['+w+']',x))}j=q.getElementsByTagName('link')||[];for(var%20y=0;y<j.length&&!(y>=50);y++){var%20z=j[y],A=z.getAttribute('rel');('canonical'===A||'icon'===A||'shortlink'===A)&&e('_links['+A+']',z.getAttribute('href'))}b.body.getElementsByClassName&&(k=b.body.getElementsByClassName('hfeed')[0]),k=b.getElementById('content')||k||b.body,l=k.getElementsByTagName('img')||[];for(var%20B=0;B<l.length&&!(B>=100);B++)n=l[B],n.src.indexOf('avatar')>-1||n.className.indexOf('avatar')>-1||n.width&&n.width<256||n.height&&n.height<128||e('_images[]',n.src);m=b.body.getElementsByTagName('iframe')||[];for(var%20C=0;C<m.length&&!(C>=50);C++)e('_embeds[]',m[C].src);b.title&&e('t',b.title),h&&e('s',h),p.setAttribute('method','POST'),p.setAttribute('action',d)," . ($mobile ? "" : "p.setAttribute('target',r),") . "p.setAttribute('style','display:%20none;')," . ($mobile ? "" : "a.open('about:blank',r,'location,resizable,scrollbars,width='+f+',height='+g),") . "b.body.appendChild(p),p.submit()}})(window,document,top.location.href,'" . admin_url( 'press-this.php' ) . "?v=8&type=$type');";
	}
}
