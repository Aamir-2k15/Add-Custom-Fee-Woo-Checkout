# Add Custom Fee to WooCommerce


## Description

This WordPress plugin dynamically adjusts an artwork fee on the WooCommerce checkout page based on user selection.

## Features

- Adds a custom artwork fee to the WooCommerce cart.
- Uses AJAX to handle user input and update the fee in real-time.
- Sets different fee amounts based on the selected option in a radio button.
- Ensures seamless integration with WooCommerce's fee calculation system.

## How It Works

1. **Template Redirect**: Adds a JavaScript block to the footer on the checkout page.
2. **JavaScript**: Listens for changes in a specific radio button, triggering AJAX requests to update the fee.
3. **Fee Calculation**: Adds the appropriate fee amount (`$1000` or `$8000`) based on the user's selection.
4. **AJAX Handlers**: Updates the session variable to reflect the user's choice and recalculates the cart total.
5. **Lifecycle Hooks**: Manages plugin activation, deactivation, and uninstallation, ensuring clean setup and removal.

## Installation

1. Download and install the plugin.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

1. Navigate to the WooCommerce checkout page.
2. Select the desired option in the provided radio button.
3. The artwork fee will be added to the cart total based on your selection.


#PS: Can Adjust commented code adds a custom admin page in WordPress to manage the settings for adding a custom fee to the WooCommerce checkout. 
