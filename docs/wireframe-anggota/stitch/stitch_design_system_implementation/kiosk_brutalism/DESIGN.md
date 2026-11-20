---
name: Kiosk Brutalism
colors:
  surface: '#faf9ff'
  surface-dim: '#d5d9ea'
  surface-bright: '#faf9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f1f3ff'
  surface-container: '#e9edfe'
  surface-container-high: '#e4e8f8'
  surface-container-highest: '#dee2f3'
  on-surface: '#161b27'
  on-surface-variant: '#454652'
  inverse-surface: '#2b303d'
  inverse-on-surface: '#edf0ff'
  outline: '#767683'
  outline-variant: '#c6c5d4'
  surface-tint: '#4755b6'
  primary: '#142588'
  on-primary: '#ffffff'
  primary-container: '#E8EAF6'
  on-primary-container: '#aab4ff'
  inverse-primary: '#bbc3ff'
  secondary: '#575e6d'
  on-secondary: '#ffffff'
  secondary-container: '#d9e0f1'
  on-secondary-container: '#5c6372'
  tertiary: '#003267'
  on-tertiary: '#ffffff'
  tertiary-container: '#004890'
  on-tertiary-container: '#91b9ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dfe0ff'
  primary-fixed-dim: '#bbc3ff'
  on-primary-fixed: '#000d5f'
  on-primary-fixed-variant: '#2d3c9c'
  secondary-fixed: '#dce2f4'
  secondary-fixed-dim: '#c0c6d8'
  on-secondary-fixed: '#151c28'
  on-secondary-fixed-variant: '#404755'
  tertiary-fixed: '#d6e3ff'
  tertiary-fixed-dim: '#a9c7ff'
  on-tertiary-fixed: '#001b3d'
  on-tertiary-fixed-variant: '#00468c'
  background: '#faf9ff'
  on-background: '#161b27'
  surface-variant: '#dee2f3'
  surface-canvas: '#F7F8FA'
  surface-panel: '#FFFFFF'
  border-structural: '#E0E3E8'
  text-primary: '#1F2430'
  text-secondary: '#5F6675'
  status-success-text: '#2E7D32'
  status-success-bg: '#E8F5E9'
  status-warning-text: '#B26A00'
  status-warning-bg: '#FFF3E0'
  status-danger-text: '#C62828'
  status-danger-bg: '#FFEBEE'
  status-info-text: '#1565C0'
  status-info-bg: '#E3F2FD'
typography:
  headline-xl:
    fontFamily: Space Grotesk
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
  headline-xl-mobile:
    fontFamily: Space Grotesk
    fontSize: 26px
    fontWeight: '700'
    lineHeight: 32px
  headline-lg:
    fontFamily: Space Grotesk
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-md:
    fontFamily: Space Grotesk
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  title-md:
    fontFamily: Space Grotesk
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Geist
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Geist
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Geist
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
  label-lg:
    fontFamily: Geist
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
  label-md:
    fontFamily: Geist
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
  label-sm:
    fontFamily: Geist
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 14px
spacing:
  gutter: 1rem
  gutter-mobile: 0.5rem
  margin: 1rem
  margin-desktop: 5rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style

This design system reimagines self-service library borrowing as an uncompromising, high-efficiency technical kiosk terminal. Stripping away decorative fluff, ambient blurs, and skeuomorphic textures, the visual language treats catalog management, circulation records, and membership verification with the rigor of an industrial operating console.

The style is an **Experimental Technical Brutalism**:
- **Geometry**: Strict rectilinear discipline. Zero rounded corners (`radius: 0`) across all interactive cards, controls, badges, and modals.
- **Tone**: Pragmatic, authoritative, institutional, and hyper-legible. Visual noise is eliminated to reduce friction during high-frequency physical checkouts.
- **Aesthetic Tenets**: High-contrast divider rules, bold 1px structural framing, functional monospaced metadata layouts, and crisp technical headers paired with a calibrated developer-grade body font.

## Colors

The palette is engineered around high structural readability and instantaneous state recognition:

- **Primary (`#303F9F`)**: The central operational anchor. Used for primary execution commands, focused outlines, system tabs, and confirmed checkout actions.
- **Primary Container (`#E8EAF6`)**: Low-intensity indigo surface for high-density contextual selections, active filter matrices, and digital member badge backgrounds.
- **Neutrals**:
  - `surface-canvas` (`#F7F8FA`): The terminal frame base.
  - `surface-panel` (`#FFFFFF`): High-clarity operational tiles, form cards, and dialog sheets.
  - `text-primary` (`#1F2430`): Stark, ink-dense black for high contrast scan readability.
  - `text-secondary` (`#5F6675`): Secondary metadata, Dewey classification tags, and catalog attributes.
  - `border-structural` (`#E0E3E8`): The universal grid border separating functional modules.
- **Semantic Matrix**: Strict light-fill backgrounds with deep, high-contrast text foregrounds (`4.5:1+` compliance). Each semantic role communicates real-time circulation state: Available/Active (`#2E7D32` on `#E8F5E9`), Reserved/Waiting (`#B26A00` on `#FFF3E0`), and Overdue/Halt (`#C62828` on `#FFEBEE`).

## Typography

Typography establishes an intentional tension between technical brutalism and micro-legibility:

- **Display & Headlines (`Space Grotesk`)**: Geometric, engineered letterforms that command screen real estate. Generates an authentic industrial terminal atmosphere on view titles, collection section heads, and system dialogue banners.
- **Reading & Controls (`Geist`)**: Neutral, sharp, and highly technical. Geist provides monospaced-adjacent precision for dense tabular metadata, ISBN sequences, due dates, author strings, and interactive button text.
- **Hierarchy Enforcement**:
  - `headline-lg` commands primary route headers.
  - `headline-md` is reserved strictly for book and media titles.
  - `label-md` and `label-sm` govern status stamps, metadata tags, and inventory IDs.

## Layout & Spacing

The layout is anchored on an uncompromising 8px baseline rhythm configured for both mobile terminal hardware (390px viewport standard) and wide-screen institutional kiosks:

- **Mobile Viewport (390px baseline)**:
  - Outer screen edge margin: `1rem` (16px).
  - 4-column fluid layout with `0.5rem` (8px) internal slot gutters.
  - Interactive targets conform to standard touch ergonomics: `48px` minimum height for inputs and buttons; `56px` for the top operational bar; `64px` for the persistent bottom command dock.
- **Desktop / Kiosk Viewport (1440px baseline)**:
  - 12-column grid capped at `1200px` centered canvas.
  - Lateral layout margins: `5rem` (80px), inter-column gutter: `1.5rem` (24px).
- **Rhythm Rules**: All intra-component padding and stack gaps follow strict multiples of 4px/8px tokens (`space-xs` = 4px, `space-sm` = 8px, `space-md` = 16px, `space-lg` = 24px, `space-xl` = 32px).

## Elevation & Depth

This design system deliberately rejects blurred drop shadows, diffuse glows, and pseudo-skeuomorphic depth. Depth is defined strictly through **architectural planes and high-contrast structural framing**:

1. **Flat Structural Borders**: Layer elevation is articulated through solid `1px` borders (`#E0E3E8`). Surfaces are separated by crisp lines rather than atmospheric blur.
2. **Hard Focus Offsets**: Active or highlighted components utilize a 2px offset border (`#303F9F`) or high-contrast inverted fills.
3. **Hard Drop Projections (Modals & Overlays)**: In desktop or modal environments requiring immediate attention, depth is communicated through a hard `4px 4px 0px 0px #1F2430` directional boundary instead of soft shadows.
4. **Modal Scrim**: Overlaid sheets, scanner views, and alert dialogues cast a flat `#000000` scrim calibrated to 40% opacity.

## Shapes

The shape system enforces an absolute **zero-radius (`0px`) constraint** across all controls, containers, surfaces, and badges:

- Buttons, chips, book thumbnail containers, input fields, notification toasts, dialogs, and segmented control tabs maintain hard, square corners (`roundedness: 0`).
- This angular architectural motif emphasizes structural discipline, echoing the physical form of library index cards, shelf tags, barcode labels, and kiosk receipt printouts.

## Components

### Buttons
- **Primary Button**: Solid `#303F9F` fill, white `#FFFFFF` text (`Geist`, semi-bold 14px), 48px height, 0px border-radius. Edge-to-edge on mobile flows. State hover/active triggers a deep indigo shift (`#1A237E`).
- **Secondary Button**: Flat `#FFFFFF` fill, 1px solid `#E0E3E8` border, `#1F2430` text. Pressed state shifts background to `#F7F8FA`.
- **Destructive Action**: Transparent background with 1px `#C62828` border and `#C62828` text.

### Badges & Status Chips
- **Status Badges**: 24px height, rectangular 0px radius, strictly monospaced/semi-bold 11px label.
  - *Available / Active*: `#2E7D32` text within `#E8F5E9` container, 1px border `#C8E6C9`.
  - *Borrowed / Pending*: `#B26A00` text within `#FFF3E0` container, 1px border `#FFE0B2`.
  - *Late / Action Required*: `#C62828` text within `#FFEBEE` container, 1px border `#FFCDD2`.
- **Filter Chips**: 32px height, rectangular 0px radius, 1px `#E0E3E8` border. Active state adopts `#E8EAF6` surface with `#303F9F` text and border.

### Input Fields
- 48px height, solid `#FFFFFF` fill, bounded by a 1px `#E0E3E8` border.
- Active/Focus: 2px hard border in `#303F9F`.
- Error state: 1px `#C62828` border accompanied by an inline warning indicator.
- Helper and placeholder text: `#5F6675` in `Geist` regular 14px.

### Cards & Media Items
- **Catalog Cards**: Rectangular grid cards featuring a rigid 2:3 ratio book cover container. Outer frame encased in 1px `#E0E3E8` with `#FFFFFF` background. No drop shadow.
- **Circulation Loan Item**: Two-column tabular layout. Left column houses a fixed 56x84px thumbnail; right column presents `Space Grotesk` title, author metadata, and right-aligned status badge.
- **Member Barcode Block**: High-contrast `#E8EAF6` card, bordered by `#303F9F`, framing vector barcode/QR codes with accompanying monospaced ID tags.

### Navigation & Segmented Controls
- **Bottom Navigation Dock**: 64px fixed bar on mobile, `#FFFFFF` surface with a crisp 1px `#E0E3E8` top divider. Active item uses `#303F9F` glyph and text; inactive uses `#5F6675`.
- **Segmented Control**: 40px height, encased in a `#E0E3E8` outer box. Active segment snaps with solid `#303F9F` text over `#FFFFFF` with an immediate zero-animation transition.

### Overlays & Sheets
- **Dialogs**: 326px fixed width, pure square bounds (`0px` radius), 1px solid `#1F2430` border over 40% black scrim.
- **Bottom Sheets**: Full-width sheet sliding from screen base, 0px radius across all corners, separated from the scrim with a 1px solid `#E0E3E8` top perimeter.