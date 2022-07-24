## Alter Image Editor

![](/Illustrations/image_editor.PNG)

### Load custom image into WP Image Editor
```php
add_filter('image_editor_save_pre', 'load_custom_image_for_edit', 10, 2);  
public function load_custom_image_for_edit($image, $attachment_id)
{
  return wp_get_image_editor('https://path.to.image.png'); // This has to be a local image
}
```

- https://developer.wordpress.org/reference/classes/wp_image_editor/

### Replace WP Image Editor

Replace the "Edit Image" button with your custom button, which leads to your custom editor.

```php
add_action('admin_menu', 'register_menu');
add_action('admin_init', 'register_settings');
add_action('admin_enqueue_scripts', 'register_scripts');

public function register_menu()
{
  add_submenu_page( 
    null, 
    'Custom Image Editor', 
    'Custom Image Editor', 
    'manage_options', 
    'custom-image-edit-slug', 
    [ $this, 'custom_image_editor_callback']
  );
}
public function custom_image_editor_callback() 
{
  if(!(basename($_SERVER['PHP_SELF']) === "admin.php" && $_GET['page'] === "custom-image-edit-slug" && current_user_can('manage_options'))) 
  {
    return;
  }

  $post_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';

  if(empty($post_id)) 
  {
    return;
  }

  $image_url = 'whatever';

  require_once(dirname(__FILE__) . "/custom_image_editor_page.php");
  exit;
}
public function register_settings()
{
  wp_register_script('jquery_initialize_js', plugin_dir_url(__FILE__) . '/what/ever/jquery.initialize.js', ['jquery'], '1.4.0', true);
  wp_register_script('image_editor', plugin_dir_url(__FILE__) . '/what/ever/image_editor.js', ['media-views', 'jquery_initialize_js']);
}
public function register_scripts()
{
  wp_localize_script('image_editor', 'custom_image_editor_params', ['wp_admin_url' => admin_url()]);
  wp_enqueue_script('image_editor');
}
```

Please see https://github.com/atabegruslan/WP_CRUD/blob/master/Illustrations/jquery.initialize.js

image_editor.js
```js
window.wp = window.wp || {};

(function( exports, $ ) {
  wp.media.view.Attachment.Details.prototype.attributes = function () 
  {
    return {
      'tabIndex': 0,
      'data-id' : this.model.get( 'id' )
    };
  };

  $.initialize(".attachment-actions", function () 
  {
    var attachment_actions = $(this);
    attachment_actions.empty();

    var attachment_details = attachment_actions.parents('.attachment-details');
    var attachment_id      = attachment_details.data('id');

    var custom_edit_image_button = attachment_details.parent().find('.custom-edit-attachment');

    if(!attachment_id || attachment_details.length < 1 || custom_edit_image_button.length > 0)
    {
      return;
    }

    var custom_edit_image_button = jQuery('<a href="javascript:void(0);" class="button custom-edit-attachment" data-attachment-id="'+attachment_id+'">Custom Image Editor</a>'); // Name on button
    attachment_actions.append(custom_edit_image_button);

    custom_edit_image_button.click(function () {
      var $self         = $(this);
      var attachment_id = $self.data('attachmentId');

      window.open_custom_editor(attachment_id);
    });
  });

  window.open_custom_editor = function (attachment_id) 
  {
    var custom_edit_attachment_frame = wp.media.frames.custom_edit_attachment_frame = wp.media({
      button : {},
      title  : 'Custom Image Editor', // Name on title tab
      toolbar: null
    });

    custom_edit_attachment_frame.on('open', function () {
      var $el               = custom_edit_attachment_frame.$el;
      var $attachment_frame = $el.parent().parent();

      $attachment_frame.find('.edit-media-header').hide();
      $attachment_frame.find('.media-frame-router').remove();
      $attachment_frame.find('.media-frame-toolbar').remove();
      $attachment_frame.find('.media-frame-content').css({
        'overflow': 'hidden',
        'top': '50px',
        'bottom': '0px'
      });
      
      $attachment_frame.find('.media-frame-content').html('<iframe src="'+custom_image_editor_params.wp_admin_url+'admin.php?page=custom-image-edit-slug&id='+attachment_id+'" id="custom-editor-frame" frameborder="0" style="width: 100%; height: 100%; border: none;"></iframe>');
    });

    custom_edit_attachment_frame.on('close', function () {
      //if ($('#post_type').length > 0 && $('#post_type').val() == "attachment") {
        window.location.reload();
      //}
    });
    custom_edit_attachment_frame.open();
  }
})(wp, jQuery);
```

custom_image_editor_page.php
```html
<?php
    //var_dump($image_url);die;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
      #adminmenumain,
      #wpadminbar,
      .notice 
      { 
        display:none !important;
      }
      #wpbody 
      { 
        position: absolute !important;
        left: 0;
        width: 100%;
      }

      #spinner_wrap 
      {
        position: absolute;
        z-index: 10;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255,255,255,0.8);
      }
      #spinner
      {
        margin: 50% 50%;
      }
    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  </head>
  <body>
    <div id="spinner_wrap">
      <div class="spinner-border text-primary" id="spinner" role="status">
        <span class="sr-only">Processing...</span>
      </div>
    </div>

    <!-- Whatever -->

    <script>
      var image_url = "<?php echo $image_url; ?>";
    </script>
  </body>
</html>
```

## Alter Media Manager

![](/Illustrations/media_manager_1.PNG)

![](/Illustrations/media_manager_2.PNG)

### Add tab to Media Router

```php
add_action('admin_enqueue_scripts', 'register_scripts');
public function register_scripts()
{
  wp_enqueue_script('media_router_tab', plugin_dir_url( __FILE__ ) . '/what/ever/media_router_tab.js', array('jquery'), '1.4.0', true);
}
```

```js
var l10n = wp.media.view.l10n;
wp.media.view.MediaFrame.Select.prototype.browseRouter = function(routerView) 
{
    routerView.set({
      upload: {
        text:     l10n.uploadFilesTitle,
        priority: 20
      },
      browse: {
        text:     l10n.mediaLibraryTitle,
        priority: 40
      },
      my_tab: {
        text:     "Custom Tab",
        priority: 60
      }
    });
};

jQuery(document).ready(function() {
    if (wp.media) 
    {
        wp.media.view.Modal.prototype.on('open', function() {
            if(jQuery('body').find('.media-modal-content .media-router button.media-menu-item.active')[0].innerText === "Custom Tab")
            {
                doMyTabContent();
            }
        });
        jQuery(wp.media).on('click', '.media-router button.media-menu-item', function(e) {
            if(e.target.innerText === "Custom Tab")
            {
                doMyTabContent();
            }
        });
    }
});
function doMyTabContent() 
{
    jQuery('body .media-modal-content .media-frame-content').load('custom_content.html'); 
}
```

- https://wordpress.stackexchange.com/questions/185271/how-to-add-new-tab-to-media-upload-manager-with-custom-set-of-images

### Add item to Media Menu

#### Via PHP

```php
add_filter('media_upload_tabs', 'custom_media_upload_tab_name');
function custom_media_upload_tab_name($tabs) 
{
  return array_merge($tabs, ['custom_item' => 'Custom Item']);
}

add_action('media_upload_custom_item', 'custom_media_upload_tab_content');
function custom_media_upload_tab_content() 
{
  include_once('custom_content.php');
}
```

Or:
```php
add_filter('media_upload_tabs', 'custom_media_upload_tab_name');
function custom_media_upload_tab_name($tabs) 
{
  return array_merge($tabs, ['custom_item' => 'Custom Item']);
}

add_action('media_upload_custom_item', 'custom_media_upload_tab_content');
function custom_media_upload_tab_content() 
{
  wp_iframe('media_upload_tab_slug_content__iframe');
}
function media_upload_tab_slug_content__iframe() 
{
  include_once('custom_content.php');
}
```

- https://sumtips.com/tips-n-tricks/add-remove-tab-wordpress-3-5-media-upload-page/

#### Via JS

```js
// Create a new Library, base on defaults, you can put your attributes in
var insertImage = wp.media.controller.Library.extend({
  defaults :  _.defaults({
    id:        'insert-image',
    title:      'Insert Image Url',
    allowLocalEdits: true,
    displaySettings: true,
    displayUserSettings: true,
    multiple : true,
    type : 'image'//audio, video, application/pdf, ... etc
  }, wp.media.controller.Library.prototype.defaults )
});

// Setup media frame
var frame = wp.media({
  button : { text : 'Select' },
  state : 'insert-image',
  states : [
    new insertImage()
  ]
});

// On close, if there is no select files, remove all the files already selected in your main frame
frame.on('close',function() {
  var selection = frame.state('insert-image').get('selection');
  if(!selection.length)
  {
    // Remove file nodes, such as: jq("#my_file_group_field").children('div.image_group_row').remove();
  }
});

frame.on( 'select',function() {
  var state = frame.state('insert-image');
  var selection = state.get('selection');
  var imageArray = [];

  if (!selection) return;

  // Remove file nodes, such as: jq("#my_file_group_field").children('div.image_group_row').remove();

  // To get right side attachment UI info, such as: size and alignments
  // Org code from /wp-includes/js/media-editor.js, arround `line 603 -- send: { ... attachment: function( props, attachment ) { ... `
  selection.each(function(attachment) {
    var display = state.display( attachment ).toJSON();
    var obj_attachment = attachment.toJSON()
    var caption = obj_attachment.caption, options, html;

    // If captions are disabled, clear the caption.
    if (!wp.media.view.settings.captions)
      delete obj_attachment.caption;

      display = wp.media.string.props(display, obj_attachment);

      options = {
        id:        obj_attachment.id,
        post_content: obj_attachment.description,
        post_excerpt: caption
      };

      if (display.linkUrl)
        options.url = display.linkUrl;

      if ('image' === obj_attachment.type) 
      {
        html = wp.media.string.image(display);
        _.each({
          align: 'align',
          size:  'image-size',
          alt:   'image_alt'
          }, function( option, prop ) {
          if ( display[ prop ] )
            options[ option ] = display[ prop ];
          });
      } 
      else if ('video' === obj_attachment.type) 
      {
        html = wp.media.string.video(display, obj_attachment);
      } 
      else if ('audio' === obj_attachment.type) 
      {
        html = wp.media.string.audio(display, obj_attachment);
      } 
      else 
      {
        html = wp.media.string.link(display);
        options.post_title = display.title;
      }

      //attach info to attachment.attributes object
      attachment.attributes['nonce'] = wp.media.view.settings.nonce.sendToEditor;
      attachment.attributes['attachment'] = options;
      attachment.attributes['html'] = html;
      attachment.attributes['post_id'] = wp.media.view.settings.post.id;

      //do what ever you like to use it
      console.log(attachment.attributes);
      console.log(attachment.attributes['attachment']);
      console.log(attachment.attributes['html']);
    });
});

// Reset selection in popup, when open the popup
frame.on('open',function() {
  var selection = frame.state('insert-image').get('selection');

  // Remove all the selection first
  selection.each(function(image) {
    var attachment = wp.media.attachment( image.attributes.id );
    attachment.fetch();
    selection.remove( attachment ? [ attachment ] : [] );
  });

  // Add back current selection, in here let us assume you attach all the [id] to <div id="my_file_group_field">...<input type="hidden" id="file_1" .../>...<input type="hidden" id="file_2" .../>
  jQuery("#my_file_group_field").find('input[type="hidden"]').each(function() {
    var input_id = jq(this);
    
    if( input_id.val() )
    {
      attachment = wp.media.attachment( input_id.val() );
      attachment.fetch();
      selection.add( attachment ? [ attachment ] : [] );
    }
  });
});

// Assuming you already added a custom Media Menu Item with the `id` of `menu-item-iframe:custom_item`
jQuery(wp.media).on('click', '.media-menu #menu-item-iframe\\:custom_item', function(e) { // In Media Menu Item, WP have `id` attributes with colons. Colons are allowed in HTML `id` names. But when selecting them with JS, be sure to escape it using `\\:`.
  e.preventDefault();
  frame.open();
});
```

https://stackoverflow.com/questions/21540951/custom-wp-media-with-arguments-support

### Delete/Alter the options showing on the Media Manager

```php
add_filter('media_view_strings', 'custom_media_uploader');
function custom_media_uploader( $strings ) 
{
    unset( $strings['selected'] ); //Removes Upload Files & Media Library links in Insert Media tab
    unset( $strings['insertMediaTitle'] ); //Insert Media
    unset( $strings['uploadFilesTitle'] ); //Upload Files
    unset( $strings['mediaLibraryTitle'] ); //Media Library
    unset( $strings['createGalleryTitle'] ); //Create Gallery
    unset( $strings['setFeaturedImageTitle'] ); //Set Featured Image
    unset( $strings['insertFromUrlTitle'] ); //Insert from URL
    
    return $strings; // You can also return [], which removes everything
}
```

### Make a Menu Item the default opened when opening Media Manager

When clicking on "Add media" on a post editor page in admin.

```php
add_action('admin_footer-post-new.php', 'set_media_manager_default_tab');
add_action('admin_footer-post.php', 'set_media_manager_default_tab');

public function set_media_manager_default_tab()
{ 
  ?>
  <script type="text/javascript">
    var my_tab_has_been_activated = 0;
    
    (function($) {
      $(document).ready( function() {
        $(document.body).on( 'click', '.insert-media', function( event ) {
          if ( 0 == my_tab_has_been_activated ) 
          {
            // Locates and activates media tab with label of search_text when the Media Library is initially opened.
            var search_text = "Custom Item";

            var $search_tab = $( ".media-menu-item" ).filter( function () {
              return $( this ).text().toLowerCase().indexOf( search_text.toLowerCase() ) >= 0;
            }).first(); // Returns the first element that matches the text. You can return the last one with .last()
            
            $search_tab.trigger( 'click' );
            my_tab_has_been_activated = 1;
          }
        }); 
      });
    })(jQuery);
  </script>
  <?php
}
```

- https://wordpress.stackexchange.com/questions/265469/is-there-a-way-to-specify-the-tab-to-display-when-the-media-uploader-is-displaye/265536#265536
- https://www.beginwp.com/how-to-make-the-upload-files-selected-by-default-when-inserting-media/

### Media Manager - All common/useful events

https://wordpress.stackexchange.com/questions/269099/how-to-capture-the-selectiontoggle-event-fired-by-wp-media/269181#269181

```php
add_action( 'admin_print_footer_scripts', 'wpse_media_library_selection_toggle' );
function wpse_media_library_selection_toggle() { ?>
<script type="text/javascript">
    ( function( $ ) {
        $( document ).ready( function() {

            // Ensure the wp.media object is set, otherwise we can't do anything.
            if ( wp.media ) 
            {
                wp.media.featuredImage.frame().on('selection:toggle', function() {
                    console.log( 'image selected' );
                });

                wp.media.view.Modal.prototype.on( "ready", function() {
                    console.log( "media modal ready" );

                    wp.media.view.Modal.prototype.on( "open", function() {
                        console.log( "media modal open" );

                        // The sidebar boxes get deleted and recreated on each select - hack into this to do the same.
                        var selection = wp.media.frame.state().get( "selection" );
                        selection.on( "selection:single", function ( event ) {
                            console.log( "selection:single" );
                        } );

                        selection.on( "selection:unsingle", function ( event ) {
                            console.log( "selection:unsingle" );
                        } );    
                    });

                    wp.media.view.Modal.prototype.on( "close", function() {
                         console.log( "media modal close" );
                    });
                });
            }

        });
    })( jQuery );
</script><?php
}
```

## Add Custom Image Sizes

- Add a new custom size programatically: https://developer.wordpress.org/reference/functions/add_image_size/
- Add a new custom size in admin: https://quadlayers.com/add-custom-image-sizes-in-wordpress/ (Admin, Settings > Media)
- Retrieve: https://wordpress.stackexchange.com/questions/33532/how-to-get-a-list-of-all-the-possible-thumbnail-sizes-set-within-a-theme/251602#251602
- Example: https://stackoverflow.com/questions/14200815/how-to-hook-into-wordpress-thumbnail-generation/26699842
- Relevant: https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/

## Alter Menu

- https://whiteleydesigns.com/editing-wordpress-admin-menus/

## Alter Admin-side Post Editor

### The Content Part

`the_content` filter is for front side  
`the_editor_content` filter is for admin side

```php
add_filter('the_content', 'alter_content');
public function alter_content($content) 
{
  // modify $content
  return $content;
}
add_filter('the_content', 'alter_content_admin');
public function alter_content_admin($content) 
{
  // modify $content
  return $content;
}
```

### Media within Contents

#### Upon media added into contents

```php
add_filter('image_send_to_editor', 'alter_chosen_media_before_adding_into_content');
public function alter_chosen_media_before_adding_into_content($html)
{
  // Modify the img tag
  return $html;
}
```

#### Make custom 'Insert media to content' button

1. Make button using HTML in the frontend, use AJAX to call to a function in PHP.
2. Imitate the function `image_media_send_to_editor`, let this be the function that handles the AJAX.

- https://wordpress.stackexchange.com/questions/9838/add-new-insert-into-post-button-with-another-function
  - https://developer.wordpress.org/reference/functions/wp_ajax_send_attachment_to_editor/
  - https://developer.wordpress.org/reference/functions/get_image_send_to_editor/
  - https://developer.wordpress.org/reference/hooks/image_send_to_editor/
- Relevant: https://wordpress.stackexchange.com/questions/9838/add-new-insert-into-post-button-with-another-function
- Relevant: https://stackoverflow.com/questions/13279093/wordpress-custom-insert-into-post-button
- Relevant: https://developer.wordpress.org/reference/functions/wp_insert_attachment/

`$html = get_image_send_to_editor($id, $caption, $title, $align, $url, $rel, $size, $alt);` returns a HTML string (eg: `<a href="https://blah/blah.png"><img src="https://blah/blah.png" alt="" class="align size- wp-image-42" /></a>`)

In the frontend, you can insert that HTML string into the content by: `wp.media.editor.insert($html);` 

Documentation of `wp.media.editor.insert`: http://atimmer.github.io/wordpress-jsdoc/-_enqueues_wp_media_editor.js.html#sunlight-1-line-728

- Relevant: https://stackoverflow.com/questions/53205085/wp-media-insert-into-text-editor/53216745#53216745
- Relevant: https://core.trac.wordpress.org/browser/tags/4.9.8/src/wp-includes/js/media-editor.js#L852

### Feature Image

```js
// Imitated from `wp-includes/js/media-editor.js` `wp.media.featuredImage.set`
// - `wp-admin/includes/ajax-actions.php` `function wp_ajax_get_post_thumbnail_html()`
// -- `wp-admin/includes/post.php function` `_wp_post_thumbnail_html($thumbnail_id = null, $post = null)`
wp.media.post( 'get-post-thumbnail-html', {
    post_id:      wp.media.view.settings.post.id,
    thumbnail_id: IMAGE/POST/ATTACHMENT_ID,
    _wpnonce:     wp.media.view.settings.post.nonce
}).done( function( html ) {
    if ('0' === html) {
        window.alert( wp.i18n.__( 'Could not set that as the thumbnail image. Try a different attachment.' ) );
        return;
    }

    jQuery('.inside', '#postimagediv').html(html);

    jQuery('.media-modal-close').click();
});
```

### Other parts

`edit_form_before_permalink` for changing or prepending before the permalink

Here is an example of changing the permalink:
```php
add_action('edit_form_before_permalink', 'alter_permalink');
public function alter_permalink($post) 
{
  // You can use $post->guid, which gives the original permalink
  
  // Hide original permalink
  echo '<style>#edit-slug-box{display:none !important;}</style>';
  
  // Make new custom permalink
  echo '
    <div id="edit-slug-box-adjusted">
      <strong>Permalink:</strong>
      <a id="sample-permalink" href="'.$custom_permalink.'">'.$custom_permalink.'</a>
    </div>';
}
```

Other useful hooks
- https://wp-kama.com/123/hooks-on-the-edit-post-admin-page

## Post's parts (in admin editor)

![](https://user-images.githubusercontent.com/20809372/180630337-9ea0aa5e-7feb-47fe-8048-1fa8c2a0667b.png)

Taken from https://code.tutsplus.com/articles/integrating-with-wordpress-ui-meta-boxes-on-custom-pages--wp-26843
