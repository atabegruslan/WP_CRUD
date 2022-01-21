## Alter Image Editor

![](/Illustrations/image_editor.PNG)

## Alter Media Manager

![](/Illustrations/media_manager_1.PNG)

![](/Illustrations/media_manager_2.PNG)

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
