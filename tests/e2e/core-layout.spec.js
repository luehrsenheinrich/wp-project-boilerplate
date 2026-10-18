const { test, expect } = require('@playwright/test');
const createLayoutContent = require('./fixtures/core-layout');

let editor;
let fixtures;

test.beforeAll(async ({ browser, baseURL }) => {
	editor = await browser.newPage();
	await editor.goto(`${baseURL}/wp-login.php`);
	await editor.locator('#user_pass').fill('password');
	await editor.locator('#user_login').fill('admin');
	await editor.locator('#wp-submit').click();
	await editor.waitForURL('**/wp-admin/**', { waitUntil: 'domcontentloaded' });
	await editor.goto(`${baseURL}/wp-admin/post-new.php`);
	await editor.waitForFunction(() => !!window.wp?.blocks?.createBlock);
	const content = await editor.evaluate(createLayoutContent);
	fixtures = await editor.evaluate(async (markup) => {
		const result = [];
		for (const endpoint of ['posts', 'pages']) {
			const post = await wp.apiFetch({
				path: `/wp/v2/${endpoint}`,
				method: 'POST',
				data: {
					title: 'Core layout regression',
					status: 'publish',
					content: markup,
				},
			});
			result.push({ id: post.id, endpoint, url: post.link });
		}
		return result;
	}, content);
});

test.afterAll(async () => {
	if (fixtures) {
		await editor.evaluate(async (posts) => {
			for (const post of posts) {
				await wp.apiFetch({
					path: `/wp/v2/${post.endpoint}/${post.id}?force=true`,
					method: 'DELETE',
				});
			}
		}, fixtures);
	}
	await editor?.close();
});

for (const width of [320, 390, 767, 768, 959, 960, 1199, 1200, 1440]) {
	test(`Core layouts respect local parents at ${width}px`, async ({ page }) => {
		const errors = [];
		page.on('pageerror', (error) => errors.push(error.message));
		await page.setViewportSize({ width, height: 1000 });
		for (const fixture of fixtures) {
			const response = await page.goto(fixture.url);
			expect(response.status()).toBe(200);
			await expect(page.locator('main .entry-content')).toHaveCount(1);
			await expect(page.locator('.entry-content .wp-caption')).toHaveCount(1);
			await expect(
				page.locator('.entry-content .wp-block-audio audio'),
			).toHaveCount(1);
			const failures = await page.locator('.entry-content').evaluate((root) => {
				const failures = [];
				const check = (valid, label) => {
					if (!valid) failures.push(label);
				};
				const near = (a, b) => Math.abs(a - b) < 1.1;
				const rect = (element) => element.getBoundingClientRect();
				const probe = document.createElement('div');
				probe.style.cssText =
					'position:fixed;visibility:hidden;width:var(--wide-width)';
				document.body.append(probe);
				const wide = rect(probe).width;
				probe.style.width = 'var(--content-width)';
				const content = rect(probe).width;
				probe.remove();
				check(
					document.documentElement.scrollWidth <= innerWidth + 1,
					'page overflow',
				);
				for (const node of root.querySelectorAll(
					'.alignfull,.alignwide,.alignleft,.alignright',
				)) {
					const parent = node.parentElement;
					const p = rect(parent);
					const n = rect(node);
					const css = getComputedStyle(parent);
					const left = parseFloat(css.paddingLeft);
					const right = parseFloat(css.paddingRight);
					const available = p.width - left - right;
					const constrained = parent.classList.contains(
						'is-layout-constrained',
					);
					if (node.classList.contains('alignfull')) {
						check(
							near(n.x, p.x + (constrained ? 0 : left)) &&
								near(n.width, constrained ? p.width : available),
							`${node.id}: Full parent edges`,
						);
					}
					if (node.classList.contains('alignwide')) {
						const expected = constrained
							? Math.min(available, wide)
							: available;
						check(
							near(n.width, expected) &&
								near(n.x, p.x + left + (available - expected) / 2),
							`${node.id}: Wide centering`,
						);
					}
					if (
						node.classList.contains('alignleft') ||
						node.classList.contains('alignright')
					) {
						check(
							n.width <= available / 2 + 1,
							`${node.id}: Float exceeds half parent`,
						);
					}
				}
				for (const group of root.querySelectorAll('.wp-block-group')) {
					const css = getComputedStyle(group);
					const [top, right, bottom, left] = [
						'Top',
						'Right',
						'Bottom',
						'Left',
					].map((side) => parseFloat(css[`padding${side}`]));
					const expected =
						group.id === 'zero'
							? [0, 0, 0, 0]
							: group.id === 'asymmetric'
								? [48, 24, 24, 48]
								: [24, 32, 24, 32];
					check(
						[top, right, bottom, left].every((value, i) =>
							near(value, expected[i]),
						),
						`${group.id}: Padding`,
					);
					for (const child of group.querySelectorAll(':scope > p')) {
						const available = rect(group).width - left - right;
						check(
							near(
								rect(child).width,
								group.classList.contains('is-layout-constrained')
									? Math.min(content, available)
									: available,
							),
							`${group.id}: Flow/Constrained`,
						);
					}
				}
				for (const stacked of [true, false]) {
					const columns = root.querySelector(`#columns-${stacked}`).children;
					check(
						stacked && innerWidth < 782
							? rect(columns[1]).y > rect(columns[0]).y + 1
							: near(rect(columns[0]).y, rect(columns[1]).y),
						`Columns stacking ${stacked}`,
					);
				}
				const asymmetric = root.querySelector('#asymmetric');
				const children = asymmetric.children;
				check(
					near(rect(children[1]).top - rect(children[0]).bottom, 48),
					'Custom block gap',
				);
				check(
					near(parseFloat(getComputedStyle(asymmetric).marginTop), 48),
					'Custom outer margin',
				);
				for (const image of root.querySelectorAll('.alignfull > img')) {
					check(
						near(rect(image).left, rect(image.parentElement).left) &&
							near(rect(image).right, rect(image.parentElement).right),
						'Full image edges',
					);
				}
				return failures;
			});
			expect(failures).toEqual([]);
			await expect(page.locator('.entry-content img').first()).toBeVisible();
		}
		expect(errors).toEqual([]);
	});
}

test('native alignment and spacing controls preserve defaults and undo', async ({
	baseURL,
}) => {
	await editor.goto(
		`${baseURL}/wp-admin/post.php?post=${fixtures[1].id}&action=edit`,
	);
	await editor.waitForFunction(
		() => window.wp?.data?.select('core/block-editor')?.getBlocks().length > 0,
	);
	const close = editor.getByRole('button', { name: 'Close', exact: true });
	if (await close.isVisible()) await close.click();
	const initial = await editor.evaluate(() => ({
		content: wp.data.select('core/editor').getEditedPostContent(),
		clientId: wp.data
			.select('core/block-editor')
			.getBlocks()
			.find((block) => block.attributes.anchor === 'group-normal').clientId,
		invalid: (function all(blocks) {
			return blocks.flatMap((block) => [block, ...all(block.innerBlocks)]);
		})(wp.data.select('core/block-editor').getBlocks())
			.filter((block) => !block.isValid)
			.map((block) => block.name),
	}));
	expect(initial.invalid).toEqual([]);
	const group = editor
		.frameLocator('iframe[name="editor-canvas"]')
		.locator(`[data-block="${initial.clientId}"]`);
	await group.click({ position: { x: 5, y: 5 } });
	const undo = async () => {
		for (
			let i = 0;
			i < 6 &&
			(await editor.evaluate(() =>
				wp.data.select('core/editor').isEditedPostDirty(),
			));
			i++
		) {
			const snapshot = () =>
				editor.evaluate(
					(id) =>
						JSON.stringify({
							attributes: wp.data
								.select('core/block-editor')
								.getBlockAttributes(id),
							dirty: wp.data.select('core/editor').isEditedPostDirty(),
						}),
					initial.clientId,
				);
			const before = await snapshot();
			await editor.getByRole('button', { name: 'Undo', exact: true }).click();
			await expect.poll(snapshot).not.toBe(before);
		}
		await expect
			.poll(() =>
				editor.evaluate(() =>
					wp.data.select('core/editor').isEditedPostDirty(),
				),
			)
			.toBe(false);
		expect(
			await editor.evaluate(() =>
				wp.data.select('core/editor').getEditedPostContent(),
			),
		).toBe(initial.content);
	};
	for (const [label, value] of [
		['Wide width', 'wide'],
		['Full width', 'full'],
	]) {
		await editor.getByRole('button', { name: 'Align', exact: true }).click();
		await editor
			.getByRole('menuitemradio', { name: label })
			.or(editor.getByText(label, { exact: true }))
			.first()
			.click();
		await expect
			.poll(() =>
				editor.evaluate(
					(id) =>
						wp.data.select('core/block-editor').getBlockAttributes(id).align,
					initial.clientId,
				),
			)
			.toBe(value);
	}
	await undo();
	const padding = editor.getByRole('combobox', {
		name: 'Horizontal padding',
		exact: true,
	});
	if (!(await padding.isVisible()))
		await editor.getByRole('button', { name: 'Settings', exact: true }).click();
	for (const [label, pixels] of [
		['S', '24px'],
		['None', '0px'],
		['Default', '32px'],
	]) {
		await padding.click();
		expect(await editor.getByRole('option').allTextContents()).toEqual([
			'Default',
			'None',
			'XS',
			'S',
			'M',
			'L',
			'XL',
			'2XL',
			'3XL',
			'4XL',
		]);
		await editor.getByRole('option', { name: label, exact: true }).click();
		await expect
			.poll(() =>
				group.evaluate((element) => getComputedStyle(element).paddingLeft),
			)
			.toBe(pixels);
		const edges = await group.evaluate((element) => {
			const parent = element.getBoundingClientRect();
			const child = element.querySelector('.alignfull').getBoundingClientRect();
			return [
				Math.abs(parent.left - child.left),
				Math.abs(parent.right - child.right),
			];
		});
		expect(edges.every((value) => value < 1.1)).toBe(true);
	}
	await undo();
});
