#!/bin/bash

# This script is used to initialize the WordPress system. WP-CLI is available.
# We use it to install plugins, themes and set options as needed.

# Check if WordPress is installed, if not, exit.
if ! $(wp core is-installed); then
	echo "WordPress is not installed. Exiting."
	exit 1
fi

# Check if this is a clean install, if not, exit.
# We check this by looking for a set option. If it's not set, it will throw an error.
if wp option get lh_is_installed; then
	echo "This is not a clean install. Exiting."
	exit 1
fi

# Set the option to indicate that this is a clean install.
wp option set lh_is_installed true

# Set the permalink structure.
echo "----- Setting permalink structure."
wp rewrite structure '/%postname%/' --hard

## Remove all plugins.
echo "----- Removing unwanted plugins."
wp plugin delete --all --exclude=plugin

## Install plugins.
echo "----- Installing plugins."

# From the WordPress plugin repository.
wp plugin install wordpress-seo wordpress-importer --activate

# From a local file.
# wp plugin install ./required-plugins/advanced-custom-fields-pro.zip ./required-plugins/gravityforms.zip --activate

# Activate the theme we want to use.
echo "----- Activating working theme."
wp theme activate theme

## Import Demo Content.
echo "----- Importing demo content."

wget https://raw.githubusercontent.com/WPTT/theme-unit-test/master/themeunittestdata.wordpress.xml
wp import themeunittestdata.wordpress.xml --authors=create
