const { test, expect } = require('@playwright/test');

test.beforeEach(async ({ page }) => {
	await page.goto('/wp-login.php', { waitUntil: 'networkidle' });
	await page.locator('#user_pass').fill('password');
	await page.locator('#user_login').fill('admin');
	await page.locator('#wp-submit').click();
	await expect(page).toHaveURL(/\/wp-admin\//);
	await page.goto('/wp-admin/post-new.php');

	// A fresh WordPress installation opens the editor welcome guide once.
	const welcomeClose = page.getByRole('button', { name: 'Close' });
	await welcomeClose.or(page.getByRole('button', { name: 'Block Inserter' })).first().waitFor();
	if (await welcomeClose.isVisible()) {
		await welcomeClose.click();
	}
	await expect(page.getByRole('button', { name: 'Block Inserter' })).toBeVisible();
});

test('an editor publishes a theme-styled plugin block', async ({ page }) => {
	const canvas = page.frameLocator('iframe[name="editor-canvas"]');
	await canvas.locator('.editor-post-title__input').fill('Editorial note test');
	await page.getByRole('button', { name: 'Block Inserter' }).click();
	await page.getByPlaceholder('Search').fill('Editorial Note');
	await page.getByText('Editorial Note', { exact: true }).click();
	await canvas.locator('.lhpbpp-editorial-note__content[contenteditable="true"]').fill('Context for our readers');

	await page.getByRole('button', { name: 'Publish', exact: true }).first().click();
	await page.getByRole('button', { name: 'Publish', exact: true }).last().click();
	await expect(page.getByTestId('snackbar').filter({ hasText: 'Post published.' })).toBeVisible();
	const postUrl = await page.getByRole('link', { name: 'View Post', exact: true }).first().getAttribute('href');
	await page.goto(postUrl);
	await expect(page.locator('.lhpbpp-editorial-note__content')).toContainText('Context for our readers');
	await expect.poll(() => page.locator('.wp-block-lhpbpp-editorial-note').evaluate(
		(element) => getComputedStyle(element).borderInlineStartWidth
	)).toBe('4px');
});

test('curated blocks and flexible layout patterns are available', async ({ page }) => {
	const editorState = await page.evaluate(() => ({
		allowed: wp.data.select('core/block-editor').getSettings().allowedBlockTypes,
		groupVariations: wp.blocks.getBlockVariations('core/group').map(({ name }) => name),
		unsyncedPatternsAreEditable: wp.data.select('core/block-editor').getSettings()
			.disableContentOnlyForUnsyncedPatterns,
		disableCustomColors: wp.data.select('core/block-editor').getSettings().disableCustomColors,
		disableCustomFontSizes: wp.data.select('core/block-editor').getSettings().disableCustomFontSizes,
		disableCustomSpacingSizes: wp.data.select('core/block-editor').getSettings().disableCustomSpacingSizes,
		layout: wp.data.select('core/block-editor').getSettings().__experimentalFeatures.layout,
	}));
	expect(editorState.allowed).toEqual(expect.arrayContaining([
		'core/group', 'core/columns', 'core/cover', 'lhpbpp/editorial-note',
	]));
	expect(editorState.allowed).not.toContain('core/site-title');
	expect(editorState.groupVariations).toContain('group-row');
	expect(editorState.unsyncedPatternsAreEditable).toBe(true);
	expect(editorState.disableCustomColors).toBe(true);
	expect(editorState.disableCustomFontSizes).toBe(true);
	expect(editorState.disableCustomSpacingSizes).toBe(true);
	expect(editorState.layout.allowEditing).toBe(true);
	expect(editorState.layout.allowCustomContentAndWideSize).toBe(false);

	await page.getByRole('button', { name: 'Block Inserter' }).click();
	await page.getByRole('tab', { name: 'Patterns' }).click();
	await page.getByRole('tab', { name: 'Lhpbpt Pattern' }).click();
	await page.getByRole('option', { name: 'Editorial Split' }).click();
	const canvas = page.frameLocator('iframe[name="editor-canvas"]');
	await expect(canvas.locator('.wp-block-columns')).toBeVisible();
	await expect(canvas.locator('.wp-block-column')).toHaveCount(2);
	await canvas.locator('.wp-block-column p[contenteditable="true"]').first().fill('Edited inside a flexible pattern');
	await page.getByRole('button', { name: 'Save draft' }).click();
	await expect(page.getByTestId('snackbar').filter({ hasText: 'Draft saved.' })).toBeVisible();
	await page.reload();
	await expect(canvas.locator('.wp-block-column').first()).toContainText('Edited inside a flexible pattern');
});
