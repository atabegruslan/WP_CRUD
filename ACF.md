# Advanced Custom Fields - Programming knowhows

## Programatically insert media

### ACF Basic - Image

Before and after

![image](https://user-images.githubusercontent.com/20809372/179019752-88bc1dad-27a0-46e6-96bf-6bb8d8dd3740.png)

```js
$(`.acf-field-${acfIdentifier} .acf-input .show-if-value img`).attr({
    src: IMAGE_URL,
    alt: ''
});

$(`.acf-field-${acfIdentifier} .acf-input input[type="hidden"]`).val(WP_POST/ATTACHMENT_ID);
$(`.acf-field-${acfIdentifier} .acf-input .acf-image-uploader`).addClass('has-value');
```
                
Imitated from `wp-content/plugins/advanced-custom-fields/assets/build/js/acf-input.js` 
- `"./src/advanced-custom-fields-pro/assets/src/js/_acf-field-image.js"`
- `render: function (attachment)`

### ACF Basic - File

Before and after

![image](https://user-images.githubusercontent.com/20809372/179020332-dbcea795-77e8-42d9-b5d5-8be8363454aa.png)

```js
jQuery(`.acf-field-${acfIdentifier} .acf-input .show-if-value img`).attr({
    src: "<?php echo includes_url('/images/media/default.png'); ?>",
    alt: '',
    title: ''
});

jQuery(`.acf-field-${acfIdentifier} .acf-input .show-if-value [data-name="title"]`).text('');
jQuery(`.acf-field-${acfIdentifier} .acf-input .show-if-value [data-name="filename"]`).text(IMAGE_NAME).attr('href', IMAGE_URL);
jQuery(`.acf-field-${acfIdentifier} .acf-input .show-if-value [data-name="filesize"]`).text('');

jQuery(`.acf-field-${acfIdentifier} .acf-input input[type="hidden"]`).val(WP_POST/ATTACHMENT_ID);

jQuery(`.acf-field-${acfIdentifier} .acf-input .acf-file-uploader`).addClass('has-value');
```

Imitated from `wp-content/plugins/advanced-custom-fields/assets/build/js/acf-input.js` 
- `"./src/advanced-custom-fields-pro/assets/src/js/_acf-field-file.js"`
- `render: function (attachment)`
