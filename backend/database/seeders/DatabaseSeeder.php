<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@mahaprabhutech.com'],
            [
                'name' => 'Super Administrator',
                'password' => 'ChangeMe@123',
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        $services = [
            [
                'title' => 'Custom Software Development',
                'slug' => 'custom-software-development',
                'summary' => 'Secure and scalable software tailored to business operations.',
                'description' => 'We design and develop reliable business platforms, portals, workflow systems and APIs based on clearly documented requirements.',
                'icon' => '01',
                'benefits' => ['Requirement-driven architecture','Secure API development','Scalable database design','Maintenance support'],
                'process' => ['Discovery','Planning','Design','Development','Testing','Deployment'],
                'featured' => true, 'active' => true, 'sort_order' => 1,
            ],
            [
                'title' => 'Mobile Application Development',
                'slug' => 'mobile-application-development',
                'summary' => 'High-quality Android and iOS applications with a modern user experience.',
                'description' => 'Cross-platform mobile application development for startups, enterprises and social-impact programmes.',
                'icon' => '02',
                'benefits' => ['Android and iOS','React Native expertise','API integration','Store deployment support'],
                'process' => ['Requirement','Prototype','Development','Quality Assurance','Release'],
                'featured' => true, 'active' => true, 'sort_order' => 2,
            ],
            [
                'title' => 'Website and Portal Development',
                'slug' => 'website-portal-development',
                'summary' => 'Responsive corporate websites, business portals and digital platforms.',
                'description' => 'Fast, accessible and search-engine-ready websites with secure administration and content management.',
                'icon' => '03',
                'benefits' => ['Responsive design','SEO-ready structure','Admin panel','Performance optimisation'],
                'process' => ['Content planning','UI design','Development','Testing','Launch'],
                'featured' => true, 'active' => true, 'sort_order' => 3,
            ],
            [
                'title' => 'Cloud and Server Solutions',
                'slug' => 'cloud-server-solutions',
                'summary' => 'Deployment, hosting, backup and server optimisation for digital products.',
                'description' => 'Production deployment, SSL, backups, monitoring and scalable server planning.',
                'icon' => '04',
                'benefits' => ['Secure deployment','Automated backup','Monitoring','Scaling plan'],
                'process' => ['Assessment','Architecture','Migration','Monitoring'],
                'featured' => true, 'active' => true, 'sort_order' => 4,
            ],
            [
                'title' => 'UI and UX Design',
                'slug' => 'ui-ux-design',
                'summary' => 'Clear, attractive and user-focused interfaces for web and mobile products.',
                'description' => 'Wireframes, design systems, prototypes and production-ready interface planning.',
                'icon' => '05',
                'benefits' => ['Brand consistency','Better usability','Responsive layouts','Reusable components'],
                'process' => ['Research','Wireframe','Prototype','Validation'],
                'featured' => true, 'active' => true, 'sort_order' => 5,
            ],
            [
                'title' => 'Technology Consulting',
                'slug' => 'technology-consulting',
                'summary' => 'Practical project planning, budgeting and technical architecture guidance.',
                'description' => 'We help organisations convert ideas into implementable technology roadmaps.',
                'icon' => '06',
                'benefits' => ['Technical documentation','Budget estimation','Risk identification','Development roadmap'],
                'process' => ['Consultation','Analysis','Recommendation','Roadmap'],
                'featured' => true, 'active' => true, 'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        Project::updateOrCreate(
            ['slug' => 'gaumitra'],
            [
                'title' => 'GauMitra',
                'category' => 'Social Impact and Animal Welfare',
                'summary' => 'A coordinated animal rescue, veterinary support and case-monitoring platform.',
                'description' => 'GauMitra connects citizens, rescue teams, veterinary professionals, gaushalas and authorised administrators through location-based reporting and transparent case status.',
                'features' => ['GPS-based incident reporting','Photo and video evidence','District-wise case routing','Veterinary and gaushala coordination','Case status tracking','Government analytics dashboard'],
                'technologies' => ['Laravel','React Native','React','MySQL','Google Maps'],
                'project_status' => 'Concept and Development',
                'featured' => true, 'active' => true, 'sort_order' => 1,
            ]
        );

        Project::updateOrCreate(
            ['slug' => 'fulawala'],
            [
                'title' => 'Fulawala',
                'category' => 'E-commerce and Subscription Delivery',
                'summary' => 'Fresh pooja flower delivery, subscriptions, custom orders and event booking.',
                'description' => 'Fulawala connects customers with scheduled flower delivery and provides digital management for subscriptions, custom orders, payments and event flower decoration.',
                'features' => ['Daily flower subscription','Custom flower ordering','Event booking','Razorpay payments','Delivery management','Customer mobile application'],
                'technologies' => ['Laravel','React Native','SQLite or MySQL','Razorpay'],
                'project_status' => 'Active Development',
                'featured' => true, 'active' => true, 'sort_order' => 2,
            ]
        );

        Testimonial::updateOrCreate(
            ['name' => 'Technology Partner'],
            [
                'organisation' => 'Business Client',
                'designation' => 'Director',
                'review' => 'The team follows a clear requirement process and focuses on practical, maintainable digital solutions.',
                'rating' => 5,
                'active' => true,
                'sort_order' => 1,
            ]
        );

        BlogPost::updateOrCreate(
            ['slug' => 'building-responsible-digital-solutions'],
            [
                'user_id' => $admin->id,
                'title' => 'Building Responsible Digital Solutions',
                'category' => 'Company',
                'excerpt' => 'How structured planning, secure development and user-focused design improve digital projects.',
                'content' => 'Successful digital products begin with a clear problem statement, measurable goals and maintainable architecture. Our approach combines documentation, interface design, secure backend development, testing and deployment planning.',
                'tags' => ['technology','innovation','software'],
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        $settings = [
            'company_name' => 'MAHAPRABHU TECH INNOVATION PRIVATE LIMITED',
            'hero_title' => 'Technology that creates meaningful progress.',
            'hero_subtitle' => 'We develop secure websites, mobile applications and digital platforms for businesses, institutions and social-impact initiatives.',
            'company_email' => 'info@mahaprabhutech.com',
            'support_email' => 'support@mahaprabhutech.com',
            'company_phone' => '+91 80181 98730',
            'company_location' => 'Odisha, India',
            'projects_count' => '10+',
            'solutions_count' => '6+',
            'seo_title' => 'Mahaprabhu Tech Innovation — Software, Web and Mobile Solutions',
            'seo_description' => 'Corporate website of MAHAPRABHU TECH INNOVATION PRIVATE LIMITED.',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'text', 'group' => 'public']
            );
        }
    }
}
