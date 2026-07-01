<?php
namespace App\Admin;

/**
 * Declarative schema for editable content sections per public page.
 */
class ContentSchema {
    public static function pageMeta() {
        return [
            'home' => ['label' => 'Homepage', 'public_url' => '/'],
            'about' => ['label' => 'About', 'public_url' => '/about'],
            'services' => ['label' => 'Services Page', 'public_url' => '/services'],
            'portfolio' => ['label' => 'Portfolio Page', 'public_url' => '/portfolio'],
            'contact' => ['label' => 'Contact Page', 'public_url' => '/contact'],
        ];
    }

    public static function pages() {
        return array_keys(self::fields());
    }

    public static function fieldsForPage($pageKey) {
        $all = self::fields();
        return $all[$pageKey] ?? [];
    }

    public static function sectionLabel($sectionKey) {
        return ucwords(str_replace('_', ' ', $sectionKey));
    }

    public static function linkedEntities($pageKey) {
        $links = [
            'home' => [
                ['label' => 'Manage Projects (featured carousel)', 'url' => url('admin/projects')],
                ['label' => 'Manage Testimonials', 'url' => url('admin/quotes')],
                ['label' => 'Manage Tips (homepage block)', 'url' => url('admin/tips')],
            ],
            'services' => [
                ['label' => 'Manage Services list', 'url' => url('admin/services')],
            ],
            'portfolio' => [
                ['label' => 'Manage Projects', 'url' => url('admin/projects')],
            ],
        ];
        return $links[$pageKey] ?? [];
    }

    public static function fields() {
        return [
            'home' => [
                'hero' => [
                    'eyebrow' => ['label' => 'Hero Eyebrow', 'type' => 'text', 'default' => 'Building Excellence'],
                    'heading' => ['label' => 'Hero Heading', 'type' => 'textarea', 'default' => "Transforming Spaces.\nCreating Legacies."],
                    'body' => ['label' => 'Hero Body', 'type' => 'textarea', 'default' => 'We deliver high-quality construction and landscaping solutions that are durable, functional and beautifully designed.'],
                    'primary_cta' => ['label' => 'Primary CTA Label', 'type' => 'text', 'default' => 'Our Services'],
                    'secondary_cta' => ['label' => 'Secondary CTA Label', 'type' => 'text', 'default' => 'View Projects'],
                    'slide_1_image' => ['label' => 'Hero Slide 1 Image', 'type' => 'image', 'default' => ''],
                    'slide_2_image' => ['label' => 'Hero Slide 2 Image', 'type' => 'image', 'default' => ''],
                    'slide_3_image' => ['label' => 'Hero Slide 3 Image', 'type' => 'image', 'default' => ''],
                    'slide_4_image' => ['label' => 'Hero Slide 4 Image', 'type' => 'image', 'default' => ''],
                    'slide_5_image' => ['label' => 'Hero Slide 5 Image', 'type' => 'image', 'default' => ''],
                ],
                'metrics' => [
                    'metric_1_title' => ['label' => 'Metric 1 Title', 'type' => 'text', 'default' => 'Quality Workmanship'],
                    'metric_1_body' => ['label' => 'Metric 1 Description', 'type' => 'textarea', 'default' => 'We deliver excellence in every detail.'],
                    'metric_2_title' => ['label' => 'Metric 2 Title', 'type' => 'text', 'default' => 'On-Time Delivery'],
                    'metric_2_body' => ['label' => 'Metric 2 Description', 'type' => 'textarea', 'default' => 'Your deadlines are our priority.'],
                    'metric_3_title' => ['label' => 'Metric 3 Title', 'type' => 'text', 'default' => 'Experienced Team'],
                    'metric_3_body' => ['label' => 'Metric 3 Description', 'type' => 'textarea', 'default' => 'Skilled professionals committed to you.'],
                    'metric_4_title' => ['label' => 'Metric 4 Title', 'type' => 'text', 'default' => 'Client Satisfaction'],
                    'metric_4_body' => ['label' => 'Metric 4 Description', 'type' => 'textarea', 'default' => 'We build lasting relationships.'],
                ],
                'welcome' => [
                    'eyebrow' => ['label' => 'Welcome Eyebrow', 'type' => 'text', 'default' => 'Welcome to Freddy Investments'],
                    'heading' => ['label' => 'Welcome Heading', 'type' => 'textarea', 'default' => 'Building More Than Structures - We Build Lasting Relationships'],
                    'body' => ['label' => 'Welcome Body', 'type' => 'textarea', 'default' => 'Freddy Investments is a trusted construction and landscaping company committed to bringing your vision to life. From modern builds to outdoor transformations, we combine expertise, creativity and integrity to deliver projects that stand the test of time.'],
                    'bullet_1' => ['label' => 'Bullet Point 1', 'type' => 'text', 'default' => 'Residential & Commercial Construction'],
                    'bullet_2' => ['label' => 'Bullet Point 2', 'type' => 'text', 'default' => 'Landscaping & Outdoor Solutions'],
                    'bullet_3' => ['label' => 'Bullet Point 3', 'type' => 'text', 'default' => 'Renovations & Extensions'],
                    'cta_label' => ['label' => 'CTA Button Label', 'type' => 'text', 'default' => 'Learn More About Us →'],
                    'badge_years' => ['label' => 'Years Badge Number', 'type' => 'text', 'default' => '5+'],
                    'badge_label_1' => ['label' => 'Badge Label Line 1', 'type' => 'text', 'default' => 'Years of'],
                    'badge_label_2' => ['label' => 'Badge Label Line 2', 'type' => 'text', 'default' => 'Excellence'],
                    'image_primary' => ['label' => 'Welcome Image 1', 'type' => 'image', 'default' => ''],
                    'image_secondary' => ['label' => 'Welcome Image 2', 'type' => 'image', 'default' => ''],
                ],
                'quote_form' => [
                    'title' => ['label' => 'Form Title', 'type' => 'text', 'default' => 'Get a Free Quotation'],
                    'subtitle' => ['label' => 'Form Subtitle', 'type' => 'textarea', 'default' => 'Tell us about your project and we will get back to you.'],
                    'submit_label' => ['label' => 'Submit Button Label', 'type' => 'text', 'default' => 'Submit Request →'],
                    'privacy_note' => ['label' => 'Privacy Note', 'type' => 'text', 'default' => 'We respect your privacy.'],
                ],
                'why_choose_us' => [
                    'eyebrow' => ['label' => 'Section Eyebrow', 'type' => 'text', 'default' => 'Why Choose Us'],
                    'heading' => ['label' => 'Section Heading', 'type' => 'text', 'default' => 'We Deliver Value at Every Step'],
                    'item_1_title' => ['label' => 'Item 1 Title', 'type' => 'text', 'default' => 'Reliable & Timely'],
                    'item_1_body' => ['label' => 'Item 1 Description', 'type' => 'textarea', 'default' => 'We deliver projects on time without compromising quality.'],
                    'item_2_title' => ['label' => 'Item 2 Title', 'type' => 'text', 'default' => 'Skilled Workforce'],
                    'item_2_body' => ['label' => 'Item 2 Description', 'type' => 'textarea', 'default' => 'Our team brings experience, dedication and professionalism.'],
                    'item_3_title' => ['label' => 'Item 3 Title', 'type' => 'text', 'default' => 'Cost-Effective'],
                    'item_3_body' => ['label' => 'Item 3 Description', 'type' => 'textarea', 'default' => 'Quality solutions that offer the best value for your investment.'],
                    'item_4_title' => ['label' => 'Item 4 Title', 'type' => 'text', 'default' => 'Attentive to Detail'],
                    'item_4_body' => ['label' => 'Item 4 Description', 'type' => 'textarea', 'default' => 'We focus on every detail from start to finish.'],
                    'item_5_title' => ['label' => 'Item 5 Title', 'type' => 'text', 'default' => 'Client Satisfaction'],
                    'item_5_body' => ['label' => 'Item 5 Description', 'type' => 'textarea', 'default' => 'Your satisfaction is at the heart of everything we do.'],
                ],
                'service_cards' => [
                    'section_eyebrow' => ['label' => 'Section Eyebrow', 'type' => 'text', 'default' => 'Our Services'],
                    'section_heading' => ['label' => 'Section Heading', 'type' => 'text', 'default' => 'Our Services'],
                    'card_1_title' => ['label' => 'Card 1 Title', 'type' => 'text', 'default' => 'Building Construction'],
                    'card_1_body' => ['label' => 'Card 1 Description', 'type' => 'textarea', 'default' => 'From foundations to roofing, we handle residential and commercial construction with precision.'],
                    'card_1_image' => ['label' => 'Card 1 Image', 'type' => 'image', 'default' => ''],
                    'card_2_title' => ['label' => 'Card 2 Title', 'type' => 'text', 'default' => 'Landscaping Services'],
                    'card_2_body' => ['label' => 'Card 2 Description', 'type' => 'textarea', 'default' => 'We design and maintain beautiful outdoor spaces that enhance your property and lifestyle.'],
                    'card_2_image' => ['label' => 'Card 2 Image', 'type' => 'image', 'default' => ''],
                    'card_3_title' => ['label' => 'Card 3 Title', 'type' => 'text', 'default' => 'Paving & Driveways'],
                    'card_3_body' => ['label' => 'Card 3 Description', 'type' => 'textarea', 'default' => 'Durable and attractive paving solutions for driveways, walkways and outdoor areas.'],
                    'card_3_image' => ['label' => 'Card 3 Image', 'type' => 'image', 'default' => ''],
                    'card_4_title' => ['label' => 'Card 4 Title', 'type' => 'text', 'default' => 'Renovations & Extensions'],
                    'card_4_body' => ['label' => 'Card 4 Description', 'type' => 'textarea', 'default' => 'Upgrade and expand your space with our professional renovation and extension services.'],
                    'card_4_image' => ['label' => 'Card 4 Image', 'type' => 'image', 'default' => ''],
                ],
                'featured_projects' => [
                    'eyebrow' => ['label' => 'Section Eyebrow', 'type' => 'text', 'default' => 'Featured Projects'],
                    'heading' => ['label' => 'Section Heading', 'type' => 'text', 'default' => 'See Our Work'],
                    'body' => ['label' => 'Section Body', 'type' => 'textarea', 'default' => 'We take pride in the projects we complete. Check out some of our recent construction and landscaping transformations.'],
                    'cta_label' => ['label' => 'CTA Label', 'type' => 'text', 'default' => 'View All Projects →'],
                ],
                'testimonials' => [
                    'show_section' => ['label' => 'Show Testimonials Section', 'type' => 'toggle', 'default' => '1'],
                    'eyebrow' => ['label' => 'Section Eyebrow', 'type' => 'text', 'default' => 'Client Feedback'],
                    'heading' => ['label' => 'Section Heading', 'type' => 'text', 'default' => 'What Clients Say'],
                ],
                'footer_metrics' => [
                    'metric_1_title' => ['label' => 'Metric 1 Title', 'type' => 'text', 'default' => 'Quality Materials'],
                    'metric_1_body' => ['label' => 'Metric 1 Description', 'type' => 'textarea', 'default' => 'We use the best materials for long lasting results.'],
                    'metric_2_title' => ['label' => 'Metric 2 Title', 'type' => 'text', 'default' => 'Modern Techniques'],
                    'metric_2_body' => ['label' => 'Metric 2 Description', 'type' => 'textarea', 'default' => 'We embrace innovation to deliver better outcomes.'],
                    'metric_3_title' => ['label' => 'Metric 3 Title', 'type' => 'text', 'default' => 'Safe & Sustainable'],
                    'metric_3_body' => ['label' => 'Metric 3 Description', 'type' => 'textarea', 'default' => 'We prioritize safety and environmental care.'],
                    'metric_4_title' => ['label' => 'Metric 4 Title', 'type' => 'text', 'default' => 'Local & Trusted'],
                    'metric_4_body' => ['label' => 'Metric 4 Description', 'type' => 'textarea', 'default' => 'Proudly serving our community with integrity.'],
                ],
                'latest_tips' => [
                    'show_section' => ['label' => 'Show Latest Tips Section', 'type' => 'toggle', 'default' => '0'],
                    'eyebrow' => ['label' => 'Section Eyebrow', 'type' => 'text', 'default' => 'Tips & Insights'],
                    'heading' => ['label' => 'Section Heading', 'type' => 'text', 'default' => 'Latest From Our Blog'],
                    'count' => ['label' => 'Number of Tips to Show', 'type' => 'text', 'default' => '3'],
                ],
            ],
            'about' => [
                'hero' => [
                    'eyebrow' => ['label' => 'Hero Eyebrow', 'type' => 'text', 'default' => 'Who We Are'],
                    'heading' => ['label' => 'Hero Heading', 'type' => 'text', 'default' => 'About Freddy Investments'],
                    'body' => ['label' => 'Hero Body', 'type' => 'textarea', 'default' => 'Providing high-quality building construction and expert landscaping services to residential home builders and commercial developers.'],
                    'background_image' => ['label' => 'Hero Background Image', 'type' => 'image', 'default' => ''],
                ],
                'story' => [
                    'eyebrow' => ['label' => 'Story Eyebrow', 'type' => 'text', 'default' => 'Company Story'],
                    'heading' => ['label' => 'Story Heading', 'type' => 'text', 'default' => 'Dynamic Craftsmanship & Botanical Solutions'],
                    'body_one' => ['label' => 'Story Paragraph 1', 'type' => 'textarea', 'default' => 'Freddy Investments is a dynamic and forward-thinking company specializing in premium building construction and landscaping services. We are fully committed to delivering high-quality, durable, and aesthetically appealing projects that meet the evolving needs and expectations of our clients.'],
                    'body_two' => ['label' => 'Story Paragraph 2', 'type' => 'textarea', 'default' => 'With a strong focus on on-site craftsmanship, technical innovation, and absolute reliability, Freddy Investments has successfully positioned itself as a trusted partner in transforming spaces.'],
                    'image' => ['label' => 'Story Image', 'type' => 'image', 'default' => ''],
                ],
                'vision_mission' => [
                    'vision' => ['label' => 'Vision Text', 'type' => 'textarea', 'default' => 'To become a leading construction and landscaping company known for excellence, innovation, and sustainable development across Monkey Bay, Mangochi, and all regions in Malawi.'],
                    'mission' => ['label' => 'Mission Text', 'type' => 'textarea', 'default' => 'To provide high-quality construction and landscaping services that combine functionality, durability, and beauty while consistently exceeding client expectations.'],
                ],
            ],
            'services' => [
                'hero' => [
                    'eyebrow' => ['label' => 'Hero Eyebrow', 'type' => 'text', 'default' => 'What We Offer'],
                    'heading' => ['label' => 'Hero Heading', 'type' => 'text', 'default' => 'Our Specialist Services'],
                    'body' => ['label' => 'Hero Body', 'type' => 'textarea', 'default' => 'Providing expert building development and creative botanical landscaping schemas.'],
                    'background_image' => ['label' => 'Hero Background Image', 'type' => 'image', 'default' => ''],
                ],
                'intro' => [
                    'heading' => ['label' => 'Intro Heading', 'type' => 'text', 'default' => 'Comprehensive Construction & Landscaping'],
                    'body' => ['label' => 'Intro Body', 'type' => 'textarea', 'default' => 'Explore our full range of professional services tailored to residential and commercial projects.'],
                ],
            ],
            'portfolio' => [
                'hero' => [
                    'eyebrow' => ['label' => 'Hero Eyebrow', 'type' => 'text', 'default' => 'Our Masterpieces'],
                    'heading' => ['label' => 'Hero Heading', 'type' => 'text', 'default' => 'Project Capability Portfolio'],
                    'body' => ['label' => 'Hero Body', 'type' => 'textarea', 'default' => 'Witness our master craftsmanship firsthand. Explore our actual construction works and landscape designs.'],
                    'background_image' => ['label' => 'Hero Background Image', 'type' => 'image', 'default' => ''],
                ],
                'intro' => [
                    'heading' => ['label' => 'Intro Heading', 'type' => 'text', 'default' => 'Our Recent Work'],
                    'body' => ['label' => 'Intro Body', 'type' => 'textarea', 'default' => 'Browse completed projects across construction and landscaping.'],
                ],
            ],
            'contact' => [
                'hero' => [
                    'eyebrow' => ['label' => 'Hero Eyebrow', 'type' => 'text', 'default' => 'Get Connected'],
                    'heading' => ['label' => 'Hero Heading', 'type' => 'text', 'default' => 'Secure Contact Portal'],
                    'body' => ['label' => 'Hero Body', 'type' => 'textarea', 'default' => 'Reach our administrative offices in Monkey Bay. Request detailed pricing estimates or book an on-site consultation.'],
                    'background_image' => ['label' => 'Hero Background Image', 'type' => 'image', 'default' => ''],
                ],
                'form' => [
                    'heading' => ['label' => 'Form Heading', 'type' => 'text', 'default' => 'Send Us a Message'],
                    'subtitle' => ['label' => 'Form Subtitle', 'type' => 'textarea', 'default' => 'Fill out the form below and our team will respond promptly.'],
                    'submit_label' => ['label' => 'Submit Button Label', 'type' => 'text', 'default' => 'Send Message'],
                ],
            ],
        ];
    }
}
