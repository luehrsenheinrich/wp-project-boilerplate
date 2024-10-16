# WordPress Project Boilerplate

[![🧪 Tests](../../actions/workflows/test.yml/badge.svg)](../../actions/workflows/test.yml)

This boilerplate provides a structured project template for creating a **Hybrid WordPress Theme**, which combines traditional classic theme features with the block-based capabilities introduced by the WordPress Block Editor (Gutenberg). Leveraging **@wordpress/env**, **webpack**, and **PostCSS**, this boilerplate adheres to WordPress best practices by separating data and business logic (plugin) from presentation and styling (theme).

Learn more about Hybrid Themes [here](https://gutenbergmarket.com/news/what-are-hybrid-wordpress-themes).

## Getting Started

Follow these steps to set up your project and start coding:

### Prerequisites

1. **Use as Repository Template**: Create a new repository from this template to avoid manually setting up the structure.
2. **Project Slug**: Choose a unique slug that won’t conflict with other repositories or projects.

### Step 1: Set Up Project Slug and Names

1. **Replace Project Slug**:
   - Search and replace (case-sensitive):
     - `lhpbp` with your new project-specific slug.
     - `LHPBP` with the uppercase version of your slug.

2. **Update Details**:
   - Modify project information in `package.json`.
   - Update file headers in `theme/style.css` and `plugin/lhpbpp.php`.

3. **Rename Plugin File**:
   - Rename the main plugin file from `plugin/lhpbpp.php` to `plugin/<your_project_slug>p.php`.

### Step 2: Run the Development Environment

1. **Start the Environment**:
   - Run `npm start` to spin up the Docker environment.

2. **Access WordPress Admin**:
   - Open `http://localhost/wp-admin` in your browser.
   - Use the credentials `admin` (username) and `password` (password) to log in.

### Step 3: Test the Release Workflow

1. **Set up GitHub Secrets**:
   - Add `GH_ADMIN_TOKEN` to [GitHub Action secrets](../../settings/secrets/actions) and [Dependabot secrets](../../settings/secrets/dependabot).

2. **Create a Test Release**:
   - Trigger a patch release via the [GitHub release action](../../actions/workflows/release.yml).

3. **Verify Release**:
   - Check the [releases](../../releases) section on GitHub to confirm the release was created and uploaded.

### Step 4: Finalize Documentation

1. **Customize Documentation**:
   - Edit `project-README.md` with your specific project details.

2. **Organize README Files**:
   - Delete or rename this `README.md` (current file).
   - Rename `project-README.md` to `README.md`.

3. **Celebrate 🎉**

## What Are Hybrid Themes?

Hybrid WordPress Themes represent a **middle ground** between traditional Classic Themes and Full Site Editing (FSE) Block Themes. They combine elements of both, allowing users to take advantage of block-based design capabilities while retaining familiar classic theme functionality. Hybrid Themes offer a balanced approach, providing flexibility without requiring a full commitment to FSE.

**Benefits of Hybrid Themes**:
- **Balanced Editing Experience**: Supports both classic and block editing modes, allowing for flexibility in design and layout.
- **Enhanced Block Capabilities**: Includes features like block templates, block parts, and custom configurations via `theme.json`.
- **Greater Design Control**: Allows extensive customization for pages, posts, and archive layouts while keeping traditional editing options.
- **Compatibility**: Works seamlessly with both classic WordPress setups and Block Editor elements, providing the best of both worlds.

This boilerplate enables you to develop a flexible, scalable Hybrid Theme that leverages the strengths of both classic and block-based features, delivering a future-ready WordPress experience with maximal control and compatibility.
