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

## Help

https://discord.gg/54tt3Yj4
