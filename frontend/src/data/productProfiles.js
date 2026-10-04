const productProfiles = {
  gaumitra: {
    logo: '/images/gau-mitra.png',
    eyebrow: 'Animal Welfare · Emergency Response · GPS Operations',
    productType: 'Social Impact Platform',
    tagline: 'A location-first rescue platform that connects emergency reporting, ambulance movement, veterinary care and shelter coordination.',
    heroHighlights: [
      { value: 'GPS', label: 'Location-aware emergency reporting' },
      { value: 'Live', label: 'Ambulance & case movement visibility' },
      { value: '360°', label: 'Case, medical, medicine & shelter records' },
      { value: 'Audit', label: 'Traceable actions and closure evidence' },
    ],
    problem: 'Animal rescue can become slow and difficult to verify when a reporter does not know the exact address, teams depend on disconnected calls or messages, ambulance movement is not visible, and treatment or shelter records are stored in different places.',
    solution: 'GauMitra creates one coordinated operational flow from the first emergency report to final closure. Location, evidence, dispatch, GPS status, treatment, medicine, gaushala capacity and management reporting are connected around the same case.',
    featureGroups: [
      {
        number: '01',
        title: 'Emergency Reporting',
        description: 'Simple reporting designed for a person who may be standing at an unknown or rural location.',
        items: [
          'Current GPS location or manual address entry',
          'District, block, road/area and landmark details',
          'Animal type, condition, report type and severity',
          'Photo evidence before dispatch',
          'Case confirmation and status visibility',
        ],
      },
      {
        number: '02',
        title: 'Dispatch & Ambulance GPS',
        description: 'A dispatch layer for assigning a vehicle and keeping the trip connected to the emergency case.',
        items: [
          'Ambulance assignment and availability',
          'Registered GPS device / vehicle mapping',
          'Live latitude, longitude, speed and last update',
          'Stale/offline GPS exception visibility',
          'Route history, trip kilometres and movement review',
        ],
      },
      {
        number: '03',
        title: 'Medical Operations',
        description: 'Structured workflows for veterinary response, treatment evidence and medicine control.',
        items: [
          'Medical Admin dashboard and assigned cases',
          'Doctor, paravet, pharmacist, driver and support staff',
          'Prescription, treatment notes and closure evidence',
          'Medicine batches, stock transactions and low-stock alerts',
          'Trip, fuel and operational MIS foundations',
        ],
      },
      {
        number: '04',
        title: 'Gaushala & Shelter Network',
        description: 'Capacity and service information to support transport and shelter decisions after rescue.',
        items: [
          'Gaushala registration and verification status',
          'Total and available capacity tracking',
          'Doctor, rescue vehicle, food and temporary shelter support',
          'Assigned case coordination',
          'Public or authorised gaushala discovery views',
        ],
      },
      {
        number: '05',
        title: 'Administration & Accountability',
        description: 'Role-scoped tools for district operations and programme management.',
        items: [
          'Super Admin and District Admin controls',
          'Case assignment, accept/reject/reached/completed timestamps',
          'Case action logs with notes and location metadata',
          'District/facility filters and fleet status',
          'Authorised reporting for response time and operational review',
        ],
      },
      {
        number: '06',
        title: 'Public & Field Experience',
        description: 'A mobile-first experience for reporting, field response and transparent service access.',
        items: [
          'React Native mobile application',
          'Push notification workflow',
          'Addresses and emergency contacts',
          'Live cases and public information pages',
          'Farmer-friendly and field-friendly interaction patterns',
        ],
      },
    ],
    stakeholders: [
      { title: 'Citizen / Volunteer', text: 'Reports an injured or stray animal with current location and evidence.' },
      { title: 'Field Responder', text: 'Receives the case, travels to the location and updates rescue progress.' },
      { title: 'Medical Team', text: 'Records treatment, prescription, medicine use and case closure information.' },
      { title: 'Gaushala', text: 'Supports shelter, capacity and handover when transport is required.' },
      { title: 'District / Programme Admin', text: 'Monitors cases, fleet activity, exceptions, service quality and MIS.' },
    ],
    workflow: [
      'Report emergency with GPS, address, condition and photos',
      'Validate location and route the case to the responsible operations team',
      'Assign ambulance / response team',
      'Track en-route movement and GPS freshness',
      'Mark arrival, rescue / treatment and transport when required',
      'Record prescription, shelter handover and closure media',
      'Retain complete history for MIS, review and audit',
    ],
    roadmap: [
      { phase: 'Phase 1', title: 'Rescue Foundation', text: 'Authentication, reporting, role-scoped dashboards, case lifecycle and evidence.' },
      { phase: 'Phase 2', title: 'Operational Control', text: 'Ambulance GPS, trip history, medical staff, medicines and response monitoring.' },
      { phase: 'Phase 3', title: 'Welfare Network', text: 'Gaushala capacity, district coordination, notifications and public transparency.' },
      { phase: 'Phase 4', title: 'Scale & Intelligence', text: 'Analytics, integrations, hardening, MIS and broader department/NGO deployment.' },
    ],
    architecture: [
      { label: 'Mobile & Web', value: 'Citizen app · Field app · Public website · Admin portals' },
      { label: 'Application Layer', value: 'Laravel APIs · Role-based workflows · Notifications' },
      { label: 'Operations Data', value: 'Cases · Assignments · Logs · Media · Medicines · Trips · Gaushalas' },
      { label: 'Location Layer', value: 'GPS devices · Maps · Route history · GPS freshness' },
      { label: 'Security & Recovery', value: 'Authentication · HTTPS/TLS · audit trail · backup & restore controls' },
    ],
    security: [
      'Role-based access for operational, district, gaushala and medical responsibilities',
      'Authenticated APIs with input validation and scoped resource access',
      'HTTPS/TLS for data in transit and protected environment credentials',
      'GPS device mapping so unknown or invalid device identifiers can be rejected or flagged',
      'Audit-friendly case/action logs and retained trip/location history for authorised review',
      'Backup, recovery and incident-management controls for critical operational data',
    ],
    outcomes: [
      'Reduce location ambiguity during emergency reporting',
      'Improve dispatch visibility and response coordination',
      'Keep rescue, treatment and transport evidence in one case history',
      'Support medical inventory, fleet and shelter decisions from structured data',
      'Provide management information for authorised service review and improvement',
    ],
  },

  'jeev-sathi': {
    logo: '/images/jeev-sathi.png',
    eyebrow: 'Farmer · Dairy · Pet · Veterinary Care',
    productType: 'Domestic Animal Care Platform',
    tagline: 'A multilingual animal-care companion for identity, health history, farm records and direct access to approved veterinary support.',
    heroHighlights: [
      { value: 'QR', label: 'Digital animal Health Card' },
      { value: '3', label: 'English · Hindi · Odia' },
      { value: 'Vet', label: 'Report · Appointment · Audio · Video' },
      { value: 'Farm', label: 'Health · Milk · Breeding · Feed · Finance' },
    ],
    problem: 'Farmers and pet owners often depend on paper records or memory for animal health, breeding, milk and follow-up information. During illness, a complete history may not be available, reminders can be missed, and connecting with the right veterinary professional quickly can be difficult.',
    solution: 'Jeev Sathi gives every registered animal a structured digital profile and Health QR, then connects daily farm records with reminders and veterinary workflows. The same application supports farmers, dairy users, pet owners and approved doctors using simple, multilingual navigation.',
    featureGroups: [
      {
        number: '01',
        title: 'Farm & Animal Identity',
        description: 'A clear starting point for farmers to organise farms and individual animals.',
        items: [
          'Farm registration with state, district, block, village and address information',
          'Farm type, ownership and estimated animal count',
          'Animal photo, species, breed, sex and estimated age',
          'Colour/markings, tag, milk and pregnancy details',
          'Automatic QR-linked animal profile',
        ],
      },
      {
        number: '02',
        title: 'Health QR & Timeline',
        description: 'A portable health identity that makes animal history easier to access during care.',
        items: [
          'Health QR visible on the animal profile',
          'In-app QR scanner opening native health-card details',
          'External QR access through a web page where configured',
          'Health records and chronological animal timeline',
          'Follow-up reminders linked to animal care',
        ],
      },
      {
        number: '03',
        title: 'Daily Farm Records',
        description: 'Simple record keeping for practical livestock and dairy routines.',
        items: [
          'Breeding records and reproductive events',
          'Milk entries, monthly totals and milk history/reporting',
          'Feed management',
          'Farm income/expense finance records',
          'Reminders for important animal and farm activities',
        ],
      },
      {
        number: '04',
        title: 'Veterinary Support',
        description: 'Multiple ways to reach veterinary care based on urgency and user preference.',
        items: [
          'Emergency veterinary report',
          'Book veterinary appointment',
          'Direct eligible audio consultation',
          'Direct eligible video consultation',
          'Prescription, advice and follow-up workflow',
        ],
      },
      {
        number: '05',
        title: 'Doctor Ecosystem',
        description: 'Provider onboarding and case tools for verified veterinary professionals.',
        items: [
          'Veterinary doctor registration and document verification',
          'Approved/active provider dashboard',
          'Services, service areas and availability',
          'Incoming report review, accept/skip and case claim controls',
          'Diagnosis, prescription and consultation completion',
        ],
      },
      {
        number: '06',
        title: 'Farmer Services & Growth',
        description: 'Useful services around animal care, affordability and long-term farm support.',
        items: [
          'Government schemes, loans and subsidy discovery',
          'Subscription plans and consultation usage tracking',
          'Payment workflow foundations',
          'Doctor wallet and payout foundations',
          'Push notifications for reports, calls and reminders',
        ],
      },
    ],
    stakeholders: [
      { title: 'Farmer', text: 'Registers farms and animals, tracks health and receives reminders or veterinary help.' },
      { title: 'Dairy User', text: 'Adds milk, breeding, feed and finance records alongside animal health history.' },
      { title: 'Pet Owner', text: 'Maintains a simple digital health profile and connects to veterinary support.' },
      { title: 'Veterinary Doctor', text: 'Registers, gets verified, manages availability, accepts cases and sends prescriptions.' },
      { title: 'Programme / Support Team', text: 'Can use structured data and service workflows to support livestock and animal-care programmes.' },
    ],
    workflow: [
      'Choose Farmer, Dairy or Pet mode and complete the profile/farm setup',
      'Register animal with photo and core identity details',
      'Generate and use the animal Health QR',
      'Record health, breeding, milk, feed or finance activity',
      'Receive reminders and discover relevant farmer-support information',
      'Raise a vet report, book an appointment or start an eligible direct call',
      'Approved doctor consults, sends prescription/advice and sets follow-up',
      'Consultation history remains connected to the animal timeline',
    ],
    roadmap: [
      { phase: 'Phase 1', title: 'Animal Digital Identity', text: 'Farmer/farm/animal registration, QR health card, records, reminders and dashboards.' },
      { phase: 'Phase 2', title: 'Veterinary Connectivity', text: 'Doctor registration, verification, reports, appointments, calls and prescriptions.' },
      { phase: 'Phase 3', title: 'Farm Productivity', text: 'Milk, breeding, feed, finance, schemes and subscription usage.' },
      { phase: 'Phase 4', title: 'Scale & Ecosystem', text: 'Analytics, integrations, automation and expansion of farmer/veterinary service coverage.' },
    ],
    architecture: [
      { label: 'User Experience', value: 'React Native mobile app · multilingual farmer-first screens · QR scanner' },
      { label: 'Core APIs', value: 'Laravel · Sanctum · farm, animal, health and veterinary modules' },
      { label: 'Communication', value: 'Push notifications · WebRTC audio/video · signaling · TURN/STUN where deployed' },
      { label: 'Care Data', value: 'Animals · health · breeding · milk · feed · finance · reports · prescriptions' },
      { label: 'Commercial Layer', value: 'Subscriptions · usage entitlements · payment state · doctor wallet/payout foundations' },
    ],
    security: [
      'Authenticated APIs and ownership checks around farms, animals and user records',
      'Approved/active provider checks before veterinary provider operations',
      'Case-claim controls so report-based consultation follows the doctor who accepted the case',
      'Role-aware access to user, provider and consultation information',
      'Protected credentials and secure signaling/TURN configuration for real-time calls where deployed',
      'Payment status designed to be changed only by verified server/gateway processing',
    ],
    outcomes: [
      'Give each animal a simple digital identity and readable care history',
      'Reduce dependence on paper-based farm and health records',
      'Make follow-up easier through reminders and chronological timelines',
      'Give farmers multiple understandable ways to reach veterinary support',
      'Connect animal care and everyday farm-management information in one multilingual experience',
    ],
  },
};

export function getProductProfile(slug) {
  return productProfiles[slug] || null;
}

export function isFlagshipProduct(slug) {
  return Boolean(productProfiles[slug]);
}

export default productProfiles;
