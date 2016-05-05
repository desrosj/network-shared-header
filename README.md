# Network Shared Header
Allows any site on a WordPress multisite install to have access to a specific site's header markup. This is really useful when a company wants header content to
be shared on other sites on their network.

#Installation
1. Network activate the plugin.
2. Create a header-network.php file within the theme the content should originate from.
3. Use `the_network_shared_header()` and `get_network_shared_header()` in your themes.

#Filters
There are currently two filters in the plugin:

###nsh_blog_id
Allows you to change the blog that the network header is generated from. Defaults to the primary blog, 1.

###nsh_refresh_frequency
Allows you to change the frequency the regeneration will run at. This should return a WordPress cron schedule ID. Defaults to `twicedaily`.
