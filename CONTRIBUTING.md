# Contributing to this Project

Hello! Thank you for your interest in contributing to this project. We appreciate every bit of help, whether it’s through reporting bugs, suggesting new features, fixing issues, or submitting pull requests.

## How You Can Contribute

### Reporting Bugs, Asking Questions, Making Suggestions

For any of these, simply [open a GitHub issue](../../issues/new). If you’d like, prefix the title with “Question:”, “Bug:”, or a relevant area, but this isn’t mandatory. Adding appropriate labels can also be helpful if you have write access.

When reporting a bug, please include:
- Clear steps to reproduce the issue.
- The URL where the issue appears (if applicable).
- What you expected to see and what actually happened.

### Setting Up the Development Environment

To contribute code, you’ll need to set up the environment locally. Make sure you have `node`, `npm`, `docker`, and `webpack` installed.

The **`theme`** and **`plugin`** directories contain the working files where code changes should be made. Pull requests with changes outside these directories will not be accepted.

This project’s development server and dependencies are managed by [@wordpress/env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/). Here’s how to get started:

1. Ensure [Docker is installed](https://docs.docker.com/compose/install/).
2. Run `npm start` from the project’s root directory to initialize the WordPress environment. You’ll find the WordPress instance at `http://localhost` with the credentials `admin:password`.
3. Start the live reloading watcher by running `npm run watch`. This ensures that any changes you make are compiled automatically, and [LiveReload](http://livereload.com/extensions/) refreshes your browser.

Before committing any changes, run `npm run test` to make sure your code adheres to the coding standards and passes all tests.

> **Note**: Please work in a branch rather than directly on the main branch.

For more details, see the [`wp-env` documentation](https://github.com/WordPress/gutenberg/tree/master/packages/env).

## Need Help?

It’s normal to get stuck! Here are some resources to help you move forward:

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

For example, `add/gallery-block` describes a branch where you’re adding a new gallery block.

## Releasing Updates

The release process is largely automated. Our GitHub workflow will build the code and package it into a release-ready zip file, which is attached to a GitHub release and distributed via our update server.

To create a release:
1. Go to the [`Create Release` action](./actions/workflows/release.yml) and trigger it with the `Run Workflow` button.
2. Specify the version details for the new release.

> **Note**: We follow [Semantic Versioning (SemVer)](https://semver.org/), so please review [npm’s versioning guidelines](https://docs.npmjs.com/cli/v7/commands/npm-version) to choose an appropriate version.

While anyone with write access can initiate a release, it’s recommended that only the *build master* or *project manager* handle this to maintain consistency.

Thank you for contributing to the project!
