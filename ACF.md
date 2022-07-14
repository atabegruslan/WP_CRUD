# Advanced Custom Fields - Programming knowhows

## Programatically insert media

### ACF Basic - Image

Before and after

![](https://user-images.githubusercontent.com/20809372/179023046-4d36f8e7-b1a2-4317-88f9-7eca393fa042.png)

![](https://user-images.githubusercontent.com/20809372/179024475-9b11fc2f-1c8c-4795-85cc-05fb55ece180.png)

```js
$(`.acf-field-${acfIdentifier} .acf-input .show-if-value img`).attr({ // 1. acfIdentifier
    src: IMAGE_URL, // 2. Set image URL
    alt: ''
});

$(`.acf-field-${acfIdentifier} .acf-input input[type="hidden"]`).val(WP_POST/ATTACHMENT_ID); // 3. Set attachment ID
$(`.acf-field-${acfIdentifier} .acf-input .acf-image-uploader`).addClass('has-value'); // 4. Add 'has-value' class
```
                
Imitated from `wp-content/plugins/advanced-custom-fields/assets/build/js/acf-input.js` 
- `"./src/advanced-custom-fields-pro/assets/src/js/_acf-field-image.js"`
- `render: function (attachment)`

### ACF Basic - File

Before and after

![](https://user-images.githubusercontent.com/20809372/179023115-0037f37f-8e0d-4e86-9def-f6e80f957175.png)

![](https://user-images.githubusercontent.com/20809372/179024523-888b812b-6e9e-45b1-81aa-ebc7eef93bd5.png)

```js
jQuery(`.acf-field-${acfIdentifier} .acf-input .show-if-value img`).attr({ // 1. acfIdentifier
    src: "<?php echo includes_url('/images/media/default.png'); ?>", // 2. Set icon
    alt: '',
    title: ''
});

jQuery(`.acf-field-${acfIdentifier} .acf-input .show-if-value [data-name="title"]`).text('');
jQuery(`.acf-field-${acfIdentifier} .acf-input .show-if-value [data-name="filename"]`).text(IMAGE_NAME).attr('href', IMAGE_URL); // 3. Set file URL and name
jQuery(`.acf-field-${acfIdentifier} .acf-input .show-if-value [data-name="filesize"]`).text('');

jQuery(`.acf-field-${acfIdentifier} .acf-input input[type="hidden"]`).val(WP_POST/ATTACHMENT_ID); // 4. Set attachment ID

jQuery(`.acf-field-${acfIdentifier} .acf-input .acf-file-uploader`).addClass('has-value'); // 5. Add 'has-value' class
```

Imitated from `wp-content/plugins/advanced-custom-fields/assets/build/js/acf-input.js` 
- `"./src/advanced-custom-fields-pro/assets/src/js/_acf-field-file.js"`
- `render: function (attachment)`
