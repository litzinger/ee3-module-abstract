ExpressionEngine 3 makes it really easy to create control panel module pages. This example makes it even easier.

The mcp.mymodule.php file is still the "controller" that ExpressionEngine loads in the control panel. Each public method is considered a page or action within the control panel. 
For the sake of our sanity and to keep the mcp file clean, all controllers are put into their own directory. Until the mcp file in EE3 gets an overhaul, each controller file
in this example is effectively 1 page, or action.

The AbstractController.php file should be extended by all of your controller classes. It will handle the form submission (via a callback) and sidebar menus you define in your controllers.
In this example the Settings.php file is extending the Abstract, and the General.php file extends the Settings, thus turning it into a general settings page with form fields.

This is intended to serve as a starting point for creating EE3 module pages. It is unsupported, but pull requests are welcome.
