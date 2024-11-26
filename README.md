# WP File Visibility Manager

## Description

File Visibility Manager is a WordPress plugin that provides granular control over file access and visibility on your WordPress site. It allows administrators to protect specific file types and manage access through an intuitive admin interface.

## Features

- Protect specific file types (e.g., PDF, DOC, DOCX)
- Exclude individual files from protection
- Custom redirect URL for unauthorized users
- User-friendly admin interface
- Secure file access control
- Compatible with WordPress multisite
- Lightweight and optimized performance

## Installation

1. Download the plugin files
2. Upload the `file-visibility-manager` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the plugin settings under 'File Visibility' in the admin menu

## Usage

### Basic Configuration

1. Navigate to 'File Visibility' in your WordPress admin menu
2. Enter file extensions you want to protect (comma-separated)
3. Add any specific files you want to exclude from protection
4. Set a custom redirect URL for unauthorized users
5. Save your settings

### Protected File Extensions

- Default: pdf
- Format: Comma-separated list (e.g., pdf,doc,docx)
- Case-insensitive

### Excluded Files

- Enter one filename per line
- Use exact filenames including extension
- Example:

  ```
  document1.pdf
  presentation.pdf
  report2023.pdf
  ```

### Redirect URL

- Default: Site homepage
- Must be a valid URL
- Can be internal or external

## Security Features

- Prevents direct file access
- WordPress nonce protection
- User capability validation
- Data sanitization
- Secure form handling

## Requirements

- WordPress 5.0 or higher
- PHP 7.2 or higher

## Frequently Asked Questions

### How does the file protection work?

The plugin intercepts file requests and checks if the requested file matches the protected extensions. If it does and the user is not logged in, they are redirected to the specified URL.

### Can I protect specific folders?

Currently, the plugin protects files based on their extension across the entire site. Folder-specific protection may be added in future versions.

### Will this work with my existing files?

Yes, the plugin will protect all files with the specified extensions, including existing files.

### Does this work with CDNs?

Yes, but you may need to configure your CDN to pass through WordPress authentication.

## Support

For support, feature requests, or bug reports, please [create an issue](/issues) on our GitHub repository.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This plugin is licensed under the GPL v2 or later.

## Changelog

### 1.0.0

- Initial release
- Basic file protection functionality
- Admin interface
- File exclusion system
- Custom redirect URLs

### Future Plans

- Role-based access control
- Directory-specific protection
- Bulk file management
- Access logs
- API integration

## Credits

Developed by [Your Name/Company]

## Privacy Policy

This plugin does not collect or store any personal data. It only manages file access permissions within your WordPress installation.
