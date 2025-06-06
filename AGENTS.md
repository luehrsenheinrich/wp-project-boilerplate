# Repository Agent Guidelines

This AGENTS.md describes how Codex should interact with this repository.

## Commit Messages and Pull Requests
- Follow the **Conventional Commits** specification for commit messages and PR titles.

## Allowed Modification Paths
- Source code changes should be limited to the `plugin/` and `theme/` directories.

Documentation updates and workspace changes may live elsewhere.

## Before Committing
- Run `npm run lint` to check PHP, JS and CSS style.

This command may rely on Docker and Composer. If it fails due to missing dependencies, note this in the PR description.

## Coding Standards
- Follow the WordPress Coding Standards for PHP, JavaScript and CSS.
- Linting is enforced via PHPCS, ESLint and Stylelint as configured in this repository.