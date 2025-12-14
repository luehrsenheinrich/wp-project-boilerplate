# Contributing to this Boilerplate

Thank you for your interest in contributing to the WordPress Project Boilerplate! This repository serves as a **template for client projects** at Luehrsen // Heinrich, so contributions should focus on improving the boilerplate itself, not project-specific features.

We appreciate help with:
- Improving the boilerplate structure and tooling
- Updating dependencies and build processes
- Enhancing documentation and setup instructions
- Fixing bugs in the template code
- Adding useful features that benefit multiple client projects

## How You Can Contribute

### Reporting Bugs, Asking Questions, Making Suggestions

For any of these, simply [open a GitHub issue](../../issues/new). If you'd like, prefix the title with "Question:", "Bug:", or a relevant area, but this isn't mandatory. Adding appropriate labels can also be helpful if you have write access.

When reporting a bug, please include:
- Clear steps to reproduce the issue.
- The URL where the issue appears (if applicable).
- What you expected to see and what actually happened.

### Setting Up the Development Environment

To contribute code, you'll need to set up the environment locally. Make sure you have:
- **Node.js 20.x** (LTS) and **npm 10.x**
- **PHP 8.4+** and **Composer 2.x**
- **Docker** installed and running

The **`theme`** and **`plugin`** directories contain the working files where code changes should be made. Pull requests with changes outside these directories will not be accepted.

This project's development server and dependencies are managed by [@wordpress/env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/). Here's how to get started:

1. Ensure [Docker is installed](https://docs.docker.com/compose/install/).
2. Run `npm start` from the project's root directory to initialize the WordPress environment. You'll find the WordPress instance at `http://localhost` with the credentials `admin:password`.
3. Start the live reloading watcher by running `npm run watch`. This ensures that any changes you make are compiled automatically, and [LiveReload](http://livereload.com/extensions/) refreshes your browser.

Before committing any changes, run `npm run lint` to make sure your code adheres to the coding standards.

> **Note**: Please work in a branch rather than directly on the main branch.

For more details, see the [`wp-env` documentation](https://github.com/WordPress/gutenberg/tree/master/packages/env).

## Need Help?

It's normal to get stuck! Here are some resources to help you move forward:

1. **WordPress Codex**: Refer to the [WordPress Codex](https://codex.wordpress.org) for detailed documentation.
2. **Reference Projects**: See best practices in action with projects like [TwentyNineteen](https://github.com/WordPress/twentynineteen), [Underscores](https://github.com/automattic/_s), and [TwentySeventeen](https://github.com/WordPress/twentyseventeen).
3. **Ask for Help**: Reach out to a senior developer or mentor for guidance.

## Development Workflow

To keep contributions organized and maintainable, please follow this workflow:

1. Create or choose an existing issue related to your contribution.
2. Create a new branch for your work.
3. Implement your changes.
4. Submit a pull request (PR) to the `main` branch for review.
5. Ensure all automated tests pass and address any feedback.
6. Resolve conflicts by updating your branch from `main`.
7. Once approved, merge the PR, test your changes, and delete your branch.

### Naming Branches

Use prefixes to describe the type of work being done. Suggested formats are:
- **add/** – for new features.
- **try/** – for experimental or tentative changes.
- **update/** – for enhancements to existing features.
- **fix/** – for bug fixes or addressing unwanted behavior.

For example, `add/gallery-block` describes a branch where you're adding a new gallery block.

### Commit Messages

Follow the **Conventional Commits** specification for all commit messages:
- **feat:** – for new features
- **fix:** – for bug fixes
- **chore:** – for maintenance tasks
- **docs:** – for documentation updates
- **refactor:** – for code refactoring
- **test:** – for test updates

Examples:
- `feat: add new block template`
- `fix: resolve linting error in webpack config`
- `docs: update setup instructions`

## Releasing Updates

Releases are **automated via release-please**. When commits following Conventional Commits are merged to `main`, release-please will:
1. Automatically create and update a release PR
2. Update the CHANGELOG.md
3. Bump version numbers appropriately (based on commit types)
4. Create a GitHub release when the release PR is merged
5. Build and package the code into release-ready zip files
6. Upload artifacts to the update server

The release process follows [Semantic Versioning (SemVer)](https://semver.org/):
- **feat:** commits trigger minor version bumps
- **fix:** commits trigger patch version bumps  
- **BREAKING CHANGE:** in commit footer triggers major version bumps

> **Note**: Only project maintainers should merge release PRs to maintain consistency.

Thank you for contributing to the project!
