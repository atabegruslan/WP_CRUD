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

### Add item to Media Menu

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

- https://wordpress.stackexchange.com/questions/185271/how-to-add-new-tab-to-media-upload-manager-with-custom-set-of-images
- https://sumtips.com/tips-n-tricks/add-remove-tab-wordpress-3-5-media-upload-page/

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

## Alter Menu

- https://whiteleydesigns.com/editing-wordpress-admin-menus/

## Alter Admin-side Post Editor

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
