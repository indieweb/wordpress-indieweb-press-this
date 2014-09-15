<?php
/*
 Plugin Name: IndieWeb Press This
 Plugin URI: https://github.com/pfefferle/wordpress-webmention
 Description: This plugin adds IndieWeb microformats2 markup to WordPress' press this.
 Author: pfefferle, snarfed
 Author URI: http://github.com/pfefferle/wordpress-indieweb-press-this
 Version: 1.0.0-dev
*/

// check if class already exists
if (!class_exists("IndieWebPressThis")) :

// initialize plugin
add_action('init', array( 'IndieWebPressThis', 'init' ));

/**
 * WordPress plugin based on @snarfeds press-this extension
 *
 * @see https://snarfed.org/indieweb-press-this-bookmarklets-for-wordpress
 */
class IndieWebPressThis {
  /**
   * add some hooks and filters
   */
  public function init() {
    add_action('admin_print_scripts-press-this.php', array('IndieWebPressThis', 'js'));
    add_action('tool_box', array('IndieWebPressThis', 'bookmarklets_page'));
  }

  /**
   * add custom JavaScript to extend the press-this
   * bookmarklet with some IndieWeb magic
   *
   * @see https://github.com/snarfed/misc/blob/master/press_this.js
   */
  public function js() {
    wp_enqueue_script('indieweb-press-this', plugins_url('/js/press-this.js' , __FILE__ ), false, '1.0', true);
  }

  /**
   * render admin page with a short description (taken from @snarfeds Blog-post)
   * and to provide the custom bookmarklets
   */
  public function bookmarklets_page() {
  ?>
    <div class="tool-box">
      <h3 class="title"><?php _e('IndieWeb bookmarklets', 'indieweb_press_this') ?></h3>

      <p>
        One big <a href="http://indiewebcamp.com/">IndieWeb</a> <em>raison d’être</em> is using your own
        web site to <a href="http://indiewebcamp.com/reply">reply</a>,
        <a href="http://indiewebcamp.com/like">like</a>, <a href="http://indiewebcamp.com/repost">repost</a>,
        and <a href="http://indiewebcamp.com/rsvp">RSVP</a> to posts and events. You do this by
        annotating links on your site with simple
        <a href="http://microformats.org/wiki/microformats2">microformats2</a> HTML.
      </p>

      <p>
        Having said that, most people don’t want to write HTML just to like or reply to
        something. WordPress’s
        <a href="http://codex.wordpress.org/Press_This">Press This bookmarklets</a> can already
        start a new post with a link to the page you’re currently viewing. This code
        adds IndieWeb microformats2 markup to that link. Combined the
        <a href="https://github.com/pfefferle/wordpress-webmention">wordpress-webmention</a>
        plugin, you can use this to respond to the current page with just two clicks.
      </p>

      <p>
        What’s more, if you’re currently on a Facebook post or Twitter tweet, this adds
        the <a href="https://www.brid.gy/about#publish">Bridgy Publish</a> link that will reply,
        like, favorite, retweet, or even RSVP <em>inside</em> those social networks.
      </p>

      <p><small>— <cite><a href="https://snarfed.org/indieweb-press-this-bookmarklets-for-wordpress">snarfed.org</a></cite></small></p>

      <p class="description"><?php _e('Drag-and-drop the following link to your bookmarks bar or right click it and add it to your favorites for a posting shortcut.') ?></p>
      <p>
        <div class="pressthis" style="display: inline-block;"><a href="<?php echo self::generate_bookmarklet_js("reply"); ?>"><span>Reply</span></a></div>
        <div class="pressthis" style="display: inline-block;"><a href="<?php echo self::generate_bookmarklet_js("like"); ?>"><span>Like</span></a></div>
        <div class="pressthis" style="display: inline-block;"><a href="<?php echo self::generate_bookmarklet_js("repost"); ?>"><span>Repost</span></a></div>
        <div class="pressthis" style="display: inline-block;"><a href="<?php echo self::generate_bookmarklet_js("rsvp"); ?>"><span>RSVP</span></a></div>
      </p>
    </div>
  <?php
  }

  /**
   * a small helper to generate the differnet bookmarklet codes
   *
   * @param string $type the type of the bookmarklet (reply, like, repost or RSVP)
   * @return string the JavaScript bookmarket code
   */
  public function generate_bookmarklet_js($type = "reply") {
    return "javascript:var%20d=document,w=window,e=w.getSelection,k=d.getSelection,x=d.selection,s=(e?e():(k)?k():(x?x.createRange().text:0)),f='".admin_url('press-this.php')."',l=d.location,e=encodeURIComponent,u=f+'?u='+e(l.href)+'&t='+e(d.title)+'&s='+e(s)+'&v=4&type=$type';a=function () {if(!w.open(u,'t','toolbar=0,resizable=1,scrollbars=1,status=1,width=720,height=570'))l.href=u;};if%20(/Firefox/.test(navigator.userAgent))%20setTimeout(a,%200);%20else%20a();void(0)";
  }
}

endif;
