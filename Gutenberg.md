# Gutenberg

## Detect if is using Gutenberg

- PHP: `get_current_screen()->is_block_editor()`
- JS: `document.body.classList.contains( 'block-editor-page' )`
- https://deluxeblogtips.com/how-to-detect-gutenberg-via-javascript-and-php/
- https://wordpress.org/support/topic/if-gutenberg/

## Event for when new block is added

![](/Illustrations/Gutenberg_add_block.PNG)

```js
const { getBlocks: getBlockList } = wp.data.select('core/editor');

// Get current blocks client ids
let blockList = getBlockList().map((block) => block.clientId);

wp.data.subscribe(() => {
	// Get new blocks client ids
	const newBlockList = getBlockList().map((block) => block.clientId);

	// Compare lengths
	const blockListChanged = newBlockList.length !== blockList.length;

	if (!blockListChanged) {
		return;
	}

	// Block Added
	if (newBlockList > blockList) {
		// Get added blocks
		const added = newBlockList.filter((x) => !blockList.includes(x));
		console.log('added', added);
	} else if (newBlockList < blockList) {
		// Get removed blocks
		const removed = blockList.filter((x) => !newBlockList.includes(x));
		console.log('removed', removed);
	}

	// Update current block list with the new blocks for further comparison
	blockList = newBlockList;
});
```

https://github.com/WordPress/gutenberg/issues/8655#issuecomment-940948868

## Insert image into Image Block

**The old way of doing that:**

https://discord.com/channels/308083132177973249/456219418096041986/963805216518590544

```js
// First create a new instance of a block
const myBlock = wp.blocks.createBlock('core/image',{url:'URL_TO_YOUR_IMAGE'});
// Insert the block into the the Block editor
wp.data.dispatch('core/editor').insertBlock(myBlock)
```

**More updated way of doing that:**

Add image to an existing block:
```js
// `wp.data.select('core/editor').getBlockSelectionStart` is deprecated since version 5.3
var currentlySelectedBlockId = wp.data.select('core/block-editor').getBlockSelectionStart();
// `wp.data.dispatch('core/editor').updateBlockAttributes` is deprecated since version 5.3
wp.data.dispatch('core/block-editor').updateBlockAttributes(currentlySelectedBlockId, {url:'URL_TO_YOUR_IMAGE'});
```

Creating a block and insert an image into it:
```js
var aNewImage = wp.blocks.createBlock('core/image',{url:'URL_TO_YOUR_IMAGE'});
wp.data.dispatch('core/block-editor').insertBlock(aNewImage);
```

- NOTE: You can always use `wp.data.select('core/block-editor').getBlock('block-id')` to find a block's attributes
- Its source: `wp-content\plugins\gutenberg\build\block-editor\index.js`
- Relevant: https://gist.github.com/bfintal/beebe46593df25326c0271f4cb227d96
- Relevant: https://gist.github.com/skitzophrenia/fce13398ef22c81717252837d0b8cf1c
- Relevant: https://github.com/WordPress/gutenberg/issues/16175
- Relevant: https://wordpress.org/support/topic/getting-and-modifying-gutenberg-post-content-with-javascript/
- Relevant: https://stackoverflow.com/questions/50065834/how-to-manually-programmatically-insert-a-block-in-gutenberg/51760723#51760723
- Relevant: https://www.codingem.com/gutenberg-how-to-add-a-block-to-a-selected-block/
- Relevant: https://awhitepixel.com/blog/wordpress-gutenberg-add-image-select-custom-block/ <sup>React</sup>
- Relevant: https://kurtrank.me/gutenberg-custom-innerblocks-appender/ <sup>React</sup>
- Relevant: https://www.liip.ch/en/blog/add-an-image-selector-to-a-gutenberg-block <sup>React</sup>

## Insert image(s) into Gallery Block

**Create new gallery block:**

https://discord.com/channels/308083132177973249/456219418096041986/964161623273111582

```js
var currentlySelectedBlockId = wp.data.select('core/block-editor').getBlockSelectionStart();

var gallerySubBlocks = [];
gallerySubBlocks[0] = wp.blocks.createBlock('core/image', {url: {IMAGE_URL}});
gallerySubBlocks[1] = wp.blocks.createBlock('core/image', {url: {ANOTHER_IMAGE_URL}});
// and so on ...

wp.data.dispatch('core/block-editor').updateBlock(currentlySelectedBlockId, {innerBlocks: gallerySubBlocks});

// Reset all blocks
setTimeout(function () {
	const getBlockList = () => wp.data.select('core/block-editor').getBlocks();
	let blockList = getBlockList();
	wp.data.dispatch('core/block-editor').resetBlocks(blockList);
}, 1000);
```

**Update existing gallery block:**

```js
var currentlySelectedBlockId = wp.data.select('core/block-editor').getBlockSelectionStart();

var currentBlock = wp.data.select('core/block-editor').getBlocksByClientId(currentlySelectedBlockId)[0];
var gallerySubBlocks = currentBlock.innerBlocks; // Get existing gallery blocks

var galleryNewItemBlock = wp.blocks.createBlock('core/image', {url: {NEW_IMAGE_URL}});
gallerySubBlocks.push(galleryNewItemBlock);
var galleryNewItemBlock2 = wp.blocks.createBlock('core/image', {url: {ANOTHER_NEW_IMAGE_URL}});
gallerySubBlocks.push(galleryNewItemBlock2);
// and so on ...

wp.data.dispatch('core/block-editor').updateBlock(currentlySelectedBlockId, {innerBlocks: gallerySubBlocks});

// Reset all blocks
setTimeout(function () {
	const getBlockList = () => wp.data.select('core/block-editor').getBlocks();
	let blockList = getBlockList();
	wp.data.dispatch('core/block-editor').resetBlocks(blockList);
}, 1000);
```

## Feature Image

Add Feature Image programatically

```js
wp.data.dispatch('core/editor').editPost(
	{
		featured_media: IMAGE/POST/ATTACHMENT_ID
	}
);
```

https://stackoverflow.com/questions/61293705/how-to-update-featured-image-programatically-in-gutenburg/61299736#61299736

Relevant: https://wordpress.stackexchange.com/questions/326211/gutenberg-editor-get-post-featured-image-by-id

## Block Editor Docs

- https://developer.wordpress.org/block-editor/
- https://developer.wordpress.org/block-editor/reference-guides/filters/
- https://developer.wordpress.org/block-editor/how-to-guides/javascript/loading-javascript/
- https://developer.wordpress.org/block-editor/reference-guides/data/data-core-block-editor/

## Other cool stuff

- https://gist.github.com/codersantosh/189e1fb8317df050585fc206427ed1f8
- On save: https://wordpress.stackexchange.com/questions/319054/trigger-javascript-on-gutenberg-block-editor-save
- Custom block-editor-menu button: https://mariecomet.fr/en/2021/12/14/adding-options-controls-existing-gutenberg-block/

## Help

https://discord.gg/eDMYBADR
