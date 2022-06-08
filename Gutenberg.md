# Gutenberg

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

## Help

https://discord.gg/eDMYBADR
