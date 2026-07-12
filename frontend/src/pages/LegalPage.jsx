import PageHero from '../components/PageHero';

const content = {
  privacy: {
    eyebrow: 'Legal information', title: 'Privacy Policy',
    sections: [
      ['Information we collect', 'We may collect contact information, project requirements, submitted files and technical usage information when you use our website forms.'],
      ['How information is used', 'Information is used to respond to enquiries, prepare quotations, process job applications, improve services and maintain website security.'],
      ['Data protection', 'Access is limited to authorised personnel. Reasonable technical and organisational safeguards are used to protect submitted information.'],
      ['Contact', 'For privacy-related questions, contact support@mahaprabhutech.com. Replace this starter policy with a lawyer-reviewed final policy before production launch.'],
    ],
  },
  terms: {
    eyebrow: 'Legal information', title: 'Terms and Conditions',
    sections: [
      ['Website use', 'The website provides general information about the company, services and projects. Content may be updated without prior notice.'],
      ['Quotations', 'A submitted quotation request is not a binding contract. Final scope, price, timeline and payment terms require a separate written agreement.'],
      ['Intellectual property', 'Company branding, text and project materials may not be reproduced without written permission unless otherwise stated.'],
      ['Important notice', 'This starter text is provided for project setup and should be reviewed by a qualified legal professional before public launch.'],
    ],
  },
};

export default function LegalPage({ type }) {
  const page = content[type];
  return <><PageHero eyebrow={page.eyebrow} title={page.title} text="Official website policy information for MAHAPRABHU TECH INNOVATION PRIVATE LIMITED." /><section className="section"><div className="container legal-content">{page.sections.map(([title, text]) => <section key={title}><h2>{title}</h2><p>{text}</p></section>)}</div></section></>;
}
