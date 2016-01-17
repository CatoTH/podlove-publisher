<?php
/**
 * Capabilities
 * 
 * - podlove_read_analytics: can view analytics
 * - podlove_read_dashboard: can view analytics
 */

/**
 * Initialize Capabilities.
 */
function podlove_init_capabilities() {
	podlove_add_capability_to_roles('podlove_read_analytics', ['administrator', 'editor', 'author']);
	podlove_add_capability_to_roles('podlove_read_dashboard', ['administrator', 'editor', 'author']);
}

/**
 * Grant every role the same permissions for podcasts as they already have for posts
 */
function podlove_copy_post_capabilities_to_podcasts() {
	foreach (array_keys(wp_roles()->roles) as $role_name) {
		$role = get_role($role_name);
		$post_type_capabilities = (array) $GLOBALS['wp_post_types']['podcast']->cap;
		foreach ($post_type_capabilities as $cap_post => $cap_podcast) {
			if ($role->has_cap($cap_post)) {
				$role->add_cap($cap_podcast);
			}
		}
	}
}

/**
 * Add capability to a list of roles.
 * 
 * @param  string $capability WordPress capability.
 * @param  array  $roles      List of roles.
 */
function podlove_add_capability_to_roles($capability, $roles = []) {
	foreach ($roles as $role) {
		get_role($role)->add_cap($capability);
	}
}
