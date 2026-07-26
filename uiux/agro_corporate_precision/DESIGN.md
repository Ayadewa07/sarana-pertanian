---
name: Agro-Corporate Precision
colors:
  surface: '#f9f9f7'
  surface-dim: '#dadad8'
  surface-bright: '#f9f9f7'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f4f4f2'
  surface-container: '#eeeeec'
  surface-container-high: '#e8e8e6'
  surface-container-highest: '#e2e3e1'
  on-surface: '#1a1c1b'
  on-surface-variant: '#414943'
  inverse-surface: '#2f3130'
  inverse-on-surface: '#f1f1ef'
  outline: '#717972'
  outline-variant: '#c1c9c1'
  surface-tint: '#3b674e'
  primary: '#063621'
  on-primary: '#ffffff'
  primary-container: '#214d36'
  on-primary-container: '#8ebd9f'
  inverse-primary: '#a2d1b3'
  secondary: '#7e570a'
  on-secondary: '#ffffff'
  secondary-container: '#ffc875'
  on-secondary-container: '#795204'
  tertiary: '#2a302d'
  on-tertiary: '#ffffff'
  tertiary-container: '#414643'
  on-tertiary-container: '#aeb4af'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#bdeece'
  primary-fixed-dim: '#a2d1b3'
  on-primary-fixed: '#002112'
  on-primary-fixed-variant: '#234f38'
  secondary-fixed: '#ffddaf'
  secondary-fixed-dim: '#f3bd6b'
  on-secondary-fixed: '#281800'
  on-secondary-fixed-variant: '#614000'
  tertiary-fixed: '#dfe4df'
  tertiary-fixed-dim: '#c3c8c3'
  on-tertiary-fixed: '#171d1a'
  on-tertiary-fixed-variant: '#424845'
  background: '#f9f9f7'
  on-background: '#1a1c1b'
  surface-variant: '#e2e3e1'
typography:
  display-lg:
    fontFamily: Manrope
    fontSize: 56px
    fontWeight: '700'
    lineHeight: 64px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Manrope
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.01em
  headline-lg:
    fontFamily: Manrope
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Manrope
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.05em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  max-container: 1280px
  section-padding: 120px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 40px
  stack-sm: 8px
  stack-md: 16px
  stack-lg: 24px
---

## Brand & Style

The design system is engineered to project a sense of **Institutional Trust, Scientific Rigor, and Premium Stewardship**. It targets high-level stakeholders in the agricultural sector—investors, large-scale industrial farmers, and agritech researchers—who require data-driven clarity paired with an elite aesthetic.

The visual style is **Corporate Modern with Tactile Precision**. It balances the organic origins of agriculture with the sharp, calculated edges of modern laboratory science. The interface should feel spacious, expensive, and authoritative, avoiding "earthy" clutter in favor of "clinical" cleanliness. 

Emotional responses to evoke:
- **Command:** A feeling of being in control of complex environmental data.
- **Prestige:** The sense that the platform is a high-value asset.
- **Reliability:** Rock-solid stability through structural alignment and refined typography.

## Colors

The palette is anchored by **Deep Green (#214D36)**, representing the depth of mature foliage and corporate authority. This is contrasted against a high-end **Off-white (#FCFCFA)** foundation, which keeps the interface feeling light and contemporary.

- **Primary & Primary Dark:** Used for structural elements, navigation, and primary actions. It denotes the "Permanent" layer of the brand.
- **Gold Accent (#B8893C):** Reserved for "Premium Harvest" cues—special highlights, success states, or high-tier feature labels. It should be used sparingly to maintain its value.
- **Soft Green (#EFF4EF):** Used for large surface areas like container backgrounds or subtle highlighting to reduce visual fatigue.
- **Secondary Background (#F8F6F2):** Provides a warm, sophisticated "Bone" tone to distinguish sections or card surfaces from the primary canvas.

## Typography

This design system utilizes a dual-font strategy to bridge the gap between character and utility. 

**Manrope** is the voice of the brand. It is used for all headlines and display text. Its geometric yet slightly condensed nature conveys modern engineering and precision. Use **Bold (700)** for primary impact and **Semi-bold (600)** for sub-headers.

**Inter** is the functional workhorse. It is used for all body copy, data visualizations, and interface labels. Its high legibility ensures that complex agricultural data is easily digestible. For labels and small UI elements, use a slightly tighter tracking and medium weights to maintain a professional, technical feel.

## Layout & Spacing

The layout follows a **Fixed-Fluid Hybrid Grid**. The central content is housed within a **1280px max-width container** to ensure readability on ultra-wide monitors, while the background surfaces extend to the viewport edges.

- **Grid:** A 12-column grid is used for desktop layouts.
- **Section Rhythm:** A generous **120px vertical spacing** between major sections provides the "Premium" airiness required to differentiate from cluttered, low-end tools.
- **Internal Spacing:** Components should use a base-8 scale (8px, 16px, 24px) for internal padding to maintain mathematical consistency.
- **Responsive Behavior:** On mobile devices, margins shrink to 16px and the 12-column grid collapses into a single-column stack, prioritizing data hierarchy.

## Elevation & Depth

This design system uses **Tonal Layering** supplemented by **Ambient Shadows** to create a sophisticated, shallow depth. 

- **Level 0 (Canvas):** The Off-white (#FCFCFA) base.
- **Level 1 (Sections):** Use the Secondary Background (#F8F6F2) for full-width alternating sections to break up long-form content.
- **Level 2 (Cards/Containers):** Pure white (#FFFFFF) surfaces. These should use a very soft shadow: `0 4px 20px rgba(0, 0, 0, 0.05)`. This shadow should feel like a natural falloff of light rather than a harsh drop-shadow.
- **Level 3 (Overlays):** Modals and dropdowns use a slightly deeper shadow: `0 12px 40px rgba(23, 54, 36, 0.08)`. Note the subtle green tint in the shadow color to tie it back to the primary brand color.

## Shapes

The shape language is **Structured and Approachable**. While the grid is rigid and professional, the corners are softened to prevent the UI from feeling hostile or overly "industrial."

- **Cards & Primary Containers:** Use a **16px** radius (`rounded-lg` in this system).
- **Interactive Elements:** Buttons, input fields, and tags use a slightly tighter **12px** radius. This distinction helps users subconsciously separate static content containers from actionable interface components.
- **Icons:** Use a 2px stroke weight with slightly rounded caps to match the typography of Manrope.

## Components

### Buttons
- **Primary:** Deep Green (#214D36) background with White text. 12px border radius. Bold Manrope text.
- **Secondary:** Transparent background with Deep Green border (1.5px) and text.
- **Premium:** Gold Accent (#B8893C) background with White text. Reserved for high-value conversions or "Pro" features.

### Cards
Cards are the primary vehicle for data. They feature a white background, 16px radius, and the standard soft shadow. Header areas within cards often use a subtle Soft Green (#EFF4EF) background to separate titles from content.

### Input Fields
Inputs use a white background with a 1px border in a muted version of the primary green. On focus, the border thickens to 2px in the Primary Green with a soft outer glow.

### Lists & Data Tables
Tables should be minimalist. Use horizontal dividers only (no vertical lines). The header row should use a Soft Green background with `label-md` typography. 

### Chips & Badges
Use the Soft Green (#EFF4EF) for neutral tags and the Gold Accent (#B8893C) with low opacity for "Premium" or "Featured" status indicators. 

### Additional Components
- **Data Visualizations:** Use the Primary Green for main data lines and the Gold Accent for target goals or highlight points.
- **Progress Bars:** Thin, precise lines using Primary Green for the fill and Soft Green for the track.