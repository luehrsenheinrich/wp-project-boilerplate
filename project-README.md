# [ PROJECT NAME ]

[![🏗 Build & Deploy](../../actions/workflows/main.yml/badge.svg)](../../actions/workflows/main.yml)

[ SHORT PROJECT DESCRIPTION ]

This WordPress project is made with love and brought to you by the folks of [WP Munich](http://www.wp-munich.de) and [Luehrsen // Heinrich](http://www.luehrsen-heinrich.de).

## What's in This Project?

This project includes two main components:

1. **Hybrid Theme**: A flexible WordPress theme that combines traditional theme features with block-based capabilities, offering compatibility with both the classic editor and the Full Site Editing (FSE) experience. This hybrid approach allows for advanced customization while retaining a familiar editing environment. All styling for custom blocks is stored in the theme, keeping presentation elements within the theme layer.

2. **Plugin for Business Logic**: A companion plugin that encapsulates all business logic, data handling, and custom functionality, ensuring that essential features remain intact even if the theme is changed. Additionally, custom block logic is stored within the plugin, enabling reusable and consistent block functionality independent of the theme.

Together, these components provide a complete WordPress solution that offers both flexibility in design and consistency in functionality.

## Key Terminal Commands

Here are some of the most useful commands available in this boilerplate to assist with setup, development, and release.

### General Commands
- **`npm start`**: Initializes the Docker-based WordPress development environment using `wp-env`. Runs necessary initial scripts defined in `prestart`.
- **`npm run stop`**: Stops the `wp-env` Docker environment without deleting data, useful when you want to pause development.
- **`npm run build`**: Builds the project in development mode using `webpack`.
- **`npm run release`**: Prepares a production-ready release by running all necessary build steps: `release:build`, `release:version`, and `release:package`.

### Development Workflow
- **`npm run watch`**: Starts `webpack` in watch mode, automatically rebuilding the project when file changes are detected. Ideal for local development alongside `npm start`.
- **`npm run dev`**: Runs both `npm start` and `npm run watch`, setting up the development environment and live rebuilding in one step.

### Linting & Fixing
- **`npm run lint`**: Runs lint checks on PHP, JavaScript, and CSS files.
### Testing
- **`npm test`**: Runs all unit tests across plugins and themes.

## Contributing

Every bit of help is highly appreciated. Even if you don't code, you can file an issue to help us find bugs or suggest new features. Please see the [CONTRIBUTING.md](./CONTRIBUTING.md) for details on how to contribute.

## License

This plugin is licensed under the [GNU General Public License v2 (or later)](./LICENSE.md).

## Changelog

Please find the current [changelog here](../../releases).
