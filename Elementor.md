# Elementor

## Detect if is using Elementor

`is_plugin_active('elementor/elementor.php')`

## Common Issues

### Including scripts

Sometimes when you want to put your own JS into a admin-size, Elementor-affected edit-post page, you'd realize that your script isn't there, as if Elementor overwritten it all with their own stuff.

You counter this issue by using one of Elementor's hooks:

`add_action('elementor/editor/after_enqueue_scripts', 'include_custom_script');`

Reference: https://github.com/elementor/elementor-hello-world/blob/502959a8101668fd0d196773a1e931b522da39a3/plugin.php#L144

See ALL Elementor hooks: https://developers.elementor.com/docs/hooks/php/

### Create custom widgets

https://github.com/Ruslan-Aliyev/WP_Elementor_Widget

### Insert image (URL) into Elementor programatically

#### JS

```js
// Imitated from: wp-content\plugins\elementor\assets\js\editor-document.js container.model.get('elements')
var iframe = document.getElementById("elementor-preview-iframe");
var element = iframe.contentWindow.document.getElementsByClassName("elementor-element-editable")[0];

if (element) 
{
    let elementId = $(element).attr('data-id');
    let imgTag = element.getElementsByTagName("img")[0];
    imgTag.setAttribute('src', IMAGE_URL);
    $('.elementor-control-media__preview').attr('style', 'background-image: url("' + IMAGE_URL + '");');

    let document = elementor.documents.getCurrent();
    let container = document.container;
    let elements = [];

    if (elementor.config.document.panel.has_elements) 
    {
        let elementTests = container.model.get('elements');
        elements = elementTests.models;
    }

    elements.forEach(element => {
        checkElementImage(element);
    });
    
    function checkElementImage(element) 
    {
        if (element.attributes.elements.length) 
        {
            let elementItem = element.attributes.elements.models;

            elementItem.forEach(elementChild => {
                checkElementImage(elementChild);
            });
        } 
        else 
        {
            if (element.attributes.widgetType === "image" && elementId === element.attributes.id) 
            { // For Elementor Basic - Image widget and Elementor General - Image Box widget
                //   THE PART THAT ACTUALLY DOES THE INSERTION
                element.attributes.settings.attributes = {
                    image: {
                        url: IMAGE_URL,
                        alt: "",
                        source: "Custom"
                    },
                    image_size: $('.elementor-control-image_size select[data-setting="image_size"]').val()
                };
                // ( THE PART THAT ACTUALLY DOES THE INSERTION )
            }
        }
    }
}
```

![](https://user-images.githubusercontent.com/20809372/178475851-c5e3da8a-0ea6-49de-937d-0c47556a913f.png)

![](https://user-images.githubusercontent.com/20809372/178476846-ca97da7a-eba6-4651-8edc-6cb193fff492.png)

#### PHP

https://stackoverflow.com/questions/63898766/wordpress-programmatically-insert-elementor-widgets-in-a-page/63961871#63961871


## Help

https://discord.gg/54tt3Yj4
