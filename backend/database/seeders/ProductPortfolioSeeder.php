<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProductPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Project::updateOrCreate(
            ['slug' => 'gaumitra'],
            [
                'title' => 'GauMitra',
                'category' => 'Animal Welfare & Emergency Response',
                'product_type' => 'Social Impact Platform',
                'tagline' => 'Location-first animal rescue coordination with transparent case, ambulance and medical workflows.',
                'summary' => 'A unified platform for reporting injured or stray animals, coordinating rescue teams, tracking ambulances, managing veterinary care and maintaining an auditable case history.',
                'description' => 'GauMitra is designed to connect citizens, field responders, veterinary teams, gaushalas, district administrators and authorised officials in one accountable animal-welfare workflow. The platform starts with location-aware reporting and continues through dispatch, rescue, treatment, transport, shelter coordination and closure evidence.',
                'problem_statement' => 'Animal rescue is often delayed because the reporter may not know the exact address, response teams work through disconnected calls or messages, ambulance movement is difficult to verify, and treatment or closure records can become fragmented. GauMitra addresses these coordination gaps with location, evidence, role-based workflows and traceable case history.',
                'solution_overview' => 'The platform combines GPS-assisted incident reporting, image evidence, district/block routing, ambulance assignment, live GPS freshness, medical operations, medicine inventory, gaushala capacity, case logs, prescriptions and management reporting. It is designed for phased deployment from local pilots to wider district or state-level operations.',
                'project_plan' => "Phase 1 — Core rescue reporting, authentication, role-scoped dashboards and case lifecycle.\nPhase 2 — Ambulance dispatch, GPS device mapping, trip history, medical staff and medicine management.\nPhase 3 — Gaushala registration/capacity, district operations, public transparency views and stronger MIS.\nPhase 4 — Scale, integrations, analytics, operational hardening and government/NGO deployment support.",
                'cover_image' => '/images/gau-mitra.png',
                'logo_image' => '/images/gau-mitra.png',
                'features' => [
                    'Current GPS or manual location with district, block, road/area and landmark details',
                    'Photo evidence, animal type, condition and severity-based emergency reporting',
                    'Role-based Super Admin, District Admin, Gaushala Admin and Medical Admin operations',
                    'Ambulance assignment, live GPS freshness, route/trip history and kilometre tracking',
                    'Veterinary case status, prescriptions, closure media and chronological case logs',
                    'Medicine inventory with batches, stock transactions, low-stock visibility and transfers',
                    'Gaushala registration, capacity and support-service visibility',
                    'Public case/gaushala information and management reporting for authorised stakeholders',
                ],
                'technologies' => ['Laravel', 'Sanctum', 'MySQL', 'React Native Expo', 'React', 'GPS APIs', 'Maps', 'Firebase Notifications'],
                'audiences' => [
                    'Citizens and volunteers reporting injured or stray animals',
                    'Animal rescue teams, drivers and field attendants',
                    'Veterinary doctors, paravets, pharmacists and medical administrators',
                    'Gaushalas and temporary animal shelters',
                    'District administrators, authorised departments and NGO operations teams',
                ],
                'workflow' => [
                    'Emergency report created with location, condition and evidence',
                    'Case validated and routed to the responsible district/operations team',
                    'Ambulance or response team assigned and dispatched',
                    'GPS movement and case status tracked while the team is en route',
                    'Responder marks arrival, rescue/treatment and transport where required',
                    'Prescription, treatment notes, shelter handover and closure evidence are recorded',
                    'Completed case remains available for audit, MIS and service-quality review',
                ],
                'roadmap' => [
                    'Foundation — case reporting, users, role-scoped dashboards and evidence capture',
                    'Operations — ambulance GPS, medical workflows, staff, medicines and trip controls',
                    'Network — gaushala capacity, district coordination, notifications and public visibility',
                    'Scale — analytics, integrations, performance hardening, reporting and wider deployment',
                ],
                'security_features' => [
                    'Role-based access and scoped administrative permissions',
                    'HTTPS/TLS transport protection and protected application credentials',
                    'Authenticated APIs, request validation and auditable case/action logs',
                    'Backup and restoration process for critical operational data',
                    'GPS device mapping and invalid/unknown device controls for fleet integrations',
                    'Least-privilege access to operational, medical and location information',
                ],
                'impact_points' => [
                    'Reduce ambiguity when an emergency reporter does not know the exact address',
                    'Improve dispatch coordination and visibility of rescue progress',
                    'Create traceable case movement from report to treatment and closure',
                    'Support medical, medicine, fleet and shelter decisions from one operational view',
                    'Provide structured records for authorised monitoring and service improvement',
                ],
                'project_status' => 'In Development',
                'featured' => true,
                'active' => true,
                'sort_order' => 1,
            ]
        );

        Project::updateOrCreate(
            ['slug' => 'jeev-sathi'],
            [
                'title' => 'Jeev Sathi',
                'category' => 'Farmer, Dairy, Pet & Veterinary Care',
                'product_type' => 'Domestic Animal Care Platform',
                'tagline' => 'A farmer-friendly digital companion for animal identity, health records, farm management and direct veterinary support.',
                'summary' => 'A multilingual domestic-animal platform that connects farmers, dairy users, pet owners and approved veterinary providers through health QR, records, reminders, direct calls, reports, appointments and farm tools.',
                'description' => 'Jeev Sathi is designed as a daily-use animal-care and farm-support platform. Users can register farms and animals, maintain health and productivity records, scan a health QR, receive reminders, discover schemes and connect with approved veterinary doctors through reports, appointments and in-app audio/video consultation workflows.',
                'problem_statement' => 'Farm and pet records are frequently kept on paper or not maintained at all, health history can be unavailable during treatment, farmers may struggle to understand when follow-up is due, and finding the right veterinary support quickly can be difficult. Jeev Sathi brings identity, records, reminders and veterinary access into one simple multilingual experience.',
                'solution_overview' => 'The product combines farm and animal registration, QR health identity, health/breeding/milk timelines, feed and finance tools, government schemes, reminders, veterinary provider verification, report acceptance, prescriptions, appointments and direct audio/video calls. The interface is designed around simple farmer-friendly language in English, Hindi and Odia.',
                'project_plan' => "Phase 1 — Farmer/farm/animal registration, health QR, records, reminders and core dashboards.\nPhase 2 — Veterinary provider onboarding, emergency reports, appointments, prescription workflow and direct audio/video consultation.\nPhase 3 — Milk, breeding, feed, finance, schemes/subsidies and subscription usage management.\nPhase 4 — Scale, analytics, partner integrations, stronger automation and wider farmer/veterinary network rollout.",
                'cover_image' => '/images/jeev-sathi.png',
                'logo_image' => '/images/jeev-sathi.png',
                'features' => [
                    'Farmer, dairy, pet and doctor care modes with simple task-oriented navigation',
                    'Farm registration with location/address and ownership/operational details',
                    'Animal registration with photo, species, breed, age, sex, markings, milk and pregnancy details',
                    'Automatic animal Health QR and in-app QR scanning with native health-card details',
                    'Health records, animal timeline, breeding records and milk entry/reporting',
                    'Feed management, farm finance, reminders and government schemes/loans/subsidies discovery',
                    'Approved veterinary doctor registration, dashboard, service areas and availability',
                    'Emergency veterinary report acceptance, diagnosis, prescription and follow-up workflow',
                    'Direct in-app audio/video consultation plus appointment-based veterinary support',
                    'Subscription usage, payment, doctor wallet/payout and service entitlement foundations',
                    'English, Hindi and Odia language support for farmer-friendly use',
                ],
                'technologies' => ['Laravel', 'Sanctum', 'MySQL', 'React Native Expo', 'WebRTC', 'Socket.IO', 'TURN/STUN', 'Firebase Notifications', 'QR'],
                'audiences' => [
                    'Small and medium farmers managing one or more animals',
                    'Dairy farmers tracking milk, breeding, feed and animal health',
                    'Pet owners who need organised health records and veterinary access',
                    'Approved veterinary doctors and veterinary organisations',
                    'Farmer-support, livestock-development and animal-welfare programmes',
                ],
                'workflow' => [
                    'User selects Farmer, Dairy or Pet mode and creates a farm/profile where applicable',
                    'Animal is registered with photo and core identity/health information',
                    'A Health QR links the animal to a readable digital health profile',
                    'Owner records health, breeding, milk, feed or finance events and receives reminders',
                    'When help is needed, the user can raise a vet report, book an appointment or start an eligible direct call',
                    'An approved doctor reviews/accepts the case, consults and sends diagnosis/prescription/advice',
                    'The consultation and follow-up become part of the animal timeline for future care',
                ],
                'roadmap' => [
                    'Core Identity — profiles, farms, animals, QR health card, timelines and reminders',
                    'Vet Connectivity — doctor verification, reports, appointments, direct calls and prescriptions',
                    'Farm Productivity — milk, breeding, feed, finance and useful scheme discovery',
                    'Scale & Ecosystem — subscriptions, analytics, partner integrations and broader service coverage',
                ],
                'security_features' => [
                    'Authenticated user and provider APIs with owner/provider access checks',
                    'Doctor approval and active-status checks before provider-only operations',
                    'Report-claim controls so consultation access follows the accepted veterinary case',
                    'Role-aware data access for farms, animals, health records and provider workflows',
                    'Secure signaling/TURN architecture for direct in-app communication where deployed',
                    'Protected payment state changes through verified server/gateway processes',
                ],
                'impact_points' => [
                    'Give each registered animal a portable, scannable health identity',
                    'Help farmers maintain records without complex paperwork',
                    'Make veterinary access clearer through report, appointment and direct-call options',
                    'Support better follow-up with reminders and chronological health history',
                    'Bring animal care and farm-management tools together in one multilingual application',
                ],
                'project_status' => 'In Development',
                'featured' => true,
                'active' => true,
                'sort_order' => 2,
            ]
        );
    }
}
