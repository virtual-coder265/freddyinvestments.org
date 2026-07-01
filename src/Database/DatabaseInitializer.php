<?php
namespace App\Database;

/**
 * Database Schema Initializer
 * Creates all required tables for the CMS (MySQL)
 */
class DatabaseInitializer {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Initialize all database tables
     */
    public function initialize() {
        $this->createAdminsTable();
        $this->createPagesTable();
        $this->createAssetsTable();
        $this->createServicesTable();
        $this->createProjectsTable();
        $this->createTipsTable();
        $this->createQuotesTable();
        $this->createMessagesTable();
        $this->createBusinessSettingsTable();
        $this->createContentSectionsTable();
        $this->createAuditLogsTable();

        return true;
    }

    protected function createAdminsTable() {
        $query = "CREATE TABLE IF NOT EXISTS admins (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            full_name VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'editor',
            status VARCHAR(50) DEFAULT 'active',
            last_login DATETIME NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createPagesTable() {
        $query = "CREATE TABLE IF NOT EXISTS pages (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            content LONGTEXT NULL,
            featured_image VARCHAR(255) NULL,
            meta_description TEXT NULL,
            meta_keywords TEXT NULL,
            status VARCHAR(50) DEFAULT 'draft',
            author_id INT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (author_id) REFERENCES admins(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createAssetsTable() {
        $query = "CREATE TABLE IF NOT EXISTS assets (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            filename VARCHAR(255) NOT NULL,
            original_name VARCHAR(255) NOT NULL,
            filepath VARCHAR(500) NOT NULL,
            file_size INT UNSIGNED NULL,
            mime_type VARCHAR(100) NULL,
            asset_type VARCHAR(50) NULL,
            alt_text VARCHAR(255) NULL,
            description TEXT NULL,
            uploaded_by INT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (uploaded_by) REFERENCES admins(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createServicesTable() {
        $query = "CREATE TABLE IF NOT EXISTS services (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description TEXT NULL,
            icon VARCHAR(100) NULL,
            image_id INT UNSIGNED NULL,
            order_position INT DEFAULT 0,
            status VARCHAR(50) DEFAULT 'active',
            created_by INT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (image_id) REFERENCES assets(id) ON DELETE SET NULL,
            FOREIGN KEY (created_by) REFERENCES admins(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createProjectsTable() {
        $query = "CREATE TABLE IF NOT EXISTS projects (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            category VARCHAR(100) NULL,
            category_label VARCHAR(255) NULL,
            description TEXT NULL,
            location VARCHAR(255) NULL,
            image_id INT UNSIGNED NULL,
            fallback_image VARCHAR(255) NULL,
            featured TINYINT(1) DEFAULT 0,
            order_position INT DEFAULT 0,
            status VARCHAR(50) DEFAULT 'active',
            created_by INT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (image_id) REFERENCES assets(id) ON DELETE SET NULL,
            FOREIGN KEY (created_by) REFERENCES admins(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createTipsTable() {
        $query = "CREATE TABLE IF NOT EXISTS tips (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NULL,
            content LONGTEXT NULL,
            image_id INT UNSIGNED NULL,
            category VARCHAR(100) NULL,
            order_position INT DEFAULT 0,
            status VARCHAR(50) DEFAULT 'active',
            created_by INT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (image_id) REFERENCES assets(id) ON DELETE SET NULL,
            FOREIGN KEY (created_by) REFERENCES admins(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createQuotesTable() {
        $query = "CREATE TABLE IF NOT EXISTS quotes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            client_name VARCHAR(255) NOT NULL,
            client_company VARCHAR(255) NULL,
            quote_text TEXT NOT NULL,
            rating TINYINT UNSIGNED NULL,
            image_id INT UNSIGNED NULL,
            status VARCHAR(50) DEFAULT 'active',
            created_by INT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (image_id) REFERENCES assets(id) ON DELETE SET NULL,
            FOREIGN KEY (created_by) REFERENCES admins(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createMessagesTable() {
        $query = "CREATE TABLE IF NOT EXISTS messages (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50) NULL,
            service VARCHAR(255) NULL,
            message TEXT NOT NULL,
            ip_address VARCHAR(45) NULL,
            status VARCHAR(50) DEFAULT 'unread',
            response TEXT NULL,
            responded_by INT UNSIGNED NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (responded_by) REFERENCES admins(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createBusinessSettingsTable() {
        $query = "CREATE TABLE IF NOT EXISTS business_settings (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) NOT NULL UNIQUE,
            setting_value TEXT NULL,
            setting_type VARCHAR(50) DEFAULT 'text',
            description TEXT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);

        $this->insertDefaultSettings();
    }

    protected function insertDefaultSettings() {
        $defaults = [
            ['site_name', 'Freddy Investments', 'text', 'Website name'],
            ['site_description', 'Building Construction & Landscaping', 'text', 'Website description'],
            ['company_email', 'info@freddyinvestments.org', 'text', 'Main company email'],
            ['company_phone', '', 'text', 'Main company phone'],
            ['company_phone_secondary', '', 'text', 'Secondary company phone'],
            ['whatsapp_number', '', 'text', 'WhatsApp number in international format'],
            ['company_address', '', 'text', 'Company address'],
            ['footer_description', 'Building excellence and landscaping design through high-quality construction and landscaping services.', 'textarea', 'Footer company description'],
            ['default_meta_description', 'Freddy Investments specializes in premium building construction and landscaping services. Transforming residential and commercial spaces in Malawi.', 'textarea', 'Default SEO meta description'],
            ['default_meta_keywords', 'construction, landscaping, bricklaying, roofing, paving, garden design, monkey bay, mangochi, malawi, building contractor', 'textarea', 'Default SEO meta keywords'],
            ['social_facebook', '', 'text', 'Facebook URL'],
            ['social_instagram', '', 'text', 'Instagram URL'],
            ['social_twitter', '', 'text', 'Twitter URL'],
            ['social_linkedin', '', 'text', 'LinkedIn URL'],
            ['about_company', '', 'textarea', 'About company text'],
            ['business_hours', '', 'textarea', 'Business hours info'],
        ];

        foreach ($defaults as $setting) {
            $this->db->execute(
                "INSERT IGNORE INTO business_settings (setting_key, setting_value, setting_type, description) VALUES (?, ?, ?, ?)",
                [$setting[0], $setting[1], $setting[2], $setting[3]]
            );
        }
    }

    protected function createContentSectionsTable() {
        $query = "CREATE TABLE IF NOT EXISTS content_sections (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            page_key VARCHAR(100) NOT NULL,
            section_key VARCHAR(100) NOT NULL,
            field_key VARCHAR(100) NOT NULL,
            field_value LONGTEXT NULL,
            field_type VARCHAR(50) DEFAULT 'text',
            label VARCHAR(255) NULL,
            updated_by INT UNSIGNED NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY content_sections_unique (page_key, section_key, field_key),
            FOREIGN KEY (updated_by) REFERENCES admins(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    protected function createAuditLogsTable() {
        $query = "CREATE TABLE IF NOT EXISTS audit_logs (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            admin_id INT UNSIGNED NULL,
            action VARCHAR(100) NOT NULL,
            entity_type VARCHAR(100) NULL,
            entity_id INT UNSIGNED NULL,
            changes TEXT NULL,
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->execute($query);
    }

    /**
     * Lightweight migrations for existing databases.
     */
    public function migrate() {
        if (!$this->db->hasColumn('tips', 'slug')) {
            $this->db->execute('ALTER TABLE tips ADD COLUMN slug VARCHAR(255) NULL AFTER title');
            $tips = $this->db->fetchAll('SELECT id, title FROM tips');
            foreach ($tips as $tip) {
                $slug = $this->makeSlug($tip['title'], (int) $tip['id']);
                $this->db->update('tips', ['slug' => $slug], 'id = ?', [$tip['id']]);
            }
        }
    }

    protected function makeSlug($title, $id) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        if ($slug === '') {
            $slug = 'tip-' . $id;
        }
        return $slug;
    }
}
