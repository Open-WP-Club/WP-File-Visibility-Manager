<?php
/**
 * Plugin Name: File Visibility Manager
 * Description: Manage visibility of files through WordPress admin panel
 * Version: 1.0
 * Author: OpenWPClub.com
 */

// Prevent direct file access
defined('ABSPATH') || exit;

class FileVisibilityManager {
    private $options;

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('init', array($this, 'protect_files'));
        $this->options = get_option('fvm_settings');
    }

    public function add_admin_menu() {
        add_menu_page(
            'File Visibility Manager',
            'File Visibility',
            'manage_options',
            'file-visibility-manager',
            array($this, 'admin_page'),
            'dashicons-hidden'
        );
    }

    public function register_settings() {
        register_setting('fvm_settings_group', 'fvm_settings');

        add_settings_section(
            'fvm_general_section',
            'General Settings',
            null,
            'file-visibility-manager'
        );

        add_settings_field(
            'protected_extensions',
            'Protected File Extensions',
            array($this, 'protected_extensions_callback'),
            'file-visibility-manager',
            'fvm_general_section'
        );

        add_settings_field(
            'excluded_files',
            'Excluded Files',
            array($this, 'excluded_files_callback'),
            'file-visibility-manager',
            'fvm_general_section'
        );

        add_settings_field(
            'redirect_url',
            'Redirect URL',
            array($this, 'redirect_url_callback'),
            'file-visibility-manager',
            'fvm_general_section'
        );
    }

    public function admin_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('fvm_settings_group');
                do_settings_sections('file-visibility-manager');
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php
    }

    public function protected_extensions_callback() {
        $value = isset($this->options['protected_extensions']) ? $this->options['protected_extensions'] : 'pdf';
        ?>
        <input type="text" name="fvm_settings[protected_extensions]" value="<?php echo esc_attr($value); ?>" class="regular-text">
        <p class="description">Comma-separated list of file extensions to protect (e.g., pdf,doc,docx)</p>
        <?php
    }

    public function excluded_files_callback() {
        $value = isset($this->options['excluded_files']) ? $this->options['excluded_files'] : '';
        ?>
        <textarea name="fvm_settings[excluded_files]" rows="5" cols="50" class="large-text"><?php echo esc_textarea($value); ?></textarea>
        <p class="description">Enter one filename per line to exclude from protection</p>
        <?php
    }

    public function redirect_url_callback() {
        $value = isset($this->options['redirect_url']) ? $this->options['redirect_url'] : home_url();
        ?>
        <input type="url" name="fvm_settings[redirect_url]" value="<?php echo esc_url($value); ?>" class="regular-text">
        <p class="description">URL to redirect unauthorized users (defaults to homepage)</p>
        <?php
    }

    public function protect_files() {
        if (!is_admin() && !empty($this->options['protected_extensions'])) {
            $current_url = $_SERVER['REQUEST_URI'];
            $extensions = array_map('trim', explode(',', $this->options['protected_extensions']));
            $excluded_files = array_map('trim', explode("\n", isset($this->options['excluded_files']) ? $this->options['excluded_files'] : ''));
            
            foreach ($extensions as $ext) {
                if (preg_match("/\.{$ext}$/i", $current_url)) {
                    $filename = basename($current_url);
                    if (!in_array($filename, $excluded_files) && !is_user_logged_in()) {
                        wp_redirect(isset($this->options['redirect_url']) ? $this->options['redirect_url'] : home_url());
                        exit;
                    }
                }
            }
        }
    }
}

// Initialize the plugin
$file_visibility_manager = new FileVisibilityManager();

// Activation hook
register_activation_hook(__FILE__, function() {
    $default_options = array(
        'protected_extensions' => 'pdf',
        'excluded_files' => '',
        'redirect_url' => home_url()
    );
    add_option('fvm_settings', $default_options);
});

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    delete_option('fvm_settings');
});