# 5. Workflows

## Enquiry workflow

```mermaid
flowchart TD
    A[Visitor submits enquiry] --> B[Validate and store]
    B --> C[Status: New]
    C --> D[Assign sales user]
    D --> E[Contact customer]
    E --> F{Qualified?}
    F -- Yes --> G[Prepare quotation]
    G --> H{Accepted?}
    H -- Yes --> I[Convert to project]
    H -- No --> J[Close]
    F -- No --> J
```

## Content workflow

Admin login → select module → add/edit content → upload media → preview → publish → React website shows updated content.

## Recruitment workflow

Vacancy published → candidate applies → HR reviews → shortlisted/interview/selected/rejected → record retained.

## Quotation workflow

Customer submits requirement → sales review → technical estimate → proposal → accepted/rejected/under discussion → accepted opportunity becomes a project.
