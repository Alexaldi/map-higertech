# Navbar and Station List Refresh Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Refresh the `/map` navbar with the supplied assets and make station results and category guidance substantially easier to scan.

**Architecture:** Keep the existing Blade shell and vanilla JavaScript map modules. Blade owns the static navbar and legend structure, `state.js` owns escaped station-card HTML, and the existing station icon registry supplies all category pictograms without a new dependency.

**Tech Stack:** Laravel 13, Blade, Vite, Tailwind CSS, vanilla JavaScript, Leaflet, Node test runner, PHPUnit.

**Spec:** `docs/superpowers/specs/2026-08-20-navbar-station-list-refresh-design.md`

## Global Constraints

- Continue using the existing 200 deterministic dummy stations; do not call `https://higertech.com/Main/GetStationAll`.
- Use only the two PNG files supplied by the user for navbar brands.
- Keep category icons local and original.
- Do not add dependencies or unrelated pages/features.
- Preserve null safety, HTML escaping, responsive behavior, sidebar collapse, and mobile drawer behavior.
- Do not commit, push, or open a pull request without explicit approval.

---

### Task 1: Lock the richer station-card contract

**Files:**
- Modify: `tests/js/map-state.test.js`
- Modify: `resources/js/map/state.js`

**Interfaces:**
- Consumes: `typeMeta(type)`, `stationIconSvg(type, className)`, `escapeHtml(value)`, `formatLocation(station)`, and `relativeTime(value, now)`.
- Produces: `buildStationCard(station, now = new Date()) => string`.

- [ ] **Step 1: Write the failing behavior test**

Extend the station-card fixture with `regency_name`, `province_name`, `device_id`, and `reading_at`, call `buildStationCard()` with `new Date('2026-08-20T12:05:00+07:00')`, and assert literal output for `Pos Duga Air`, `Bandung, Jawa Barat`, `AWLR-NUS-017`, and `5 menit lalu` while retaining the existing XSS and status assertions.

- [ ] **Step 2: Run the focused Node test and verify RED**

Run: `node --test tests/js/map-state.test.js`  
Expected: the richer content assertions fail because the current card only renders the short code, balai, and status.

- [ ] **Step 3: Implement the minimal escaped card markup**

Import `formatLocation` and `relativeTime`, accept the optional clock argument, render the full category label/code, balai, compact location, optional device ID, relative time, and textual status. Reuse `stationIconSvg()` for the visual tile.

- [ ] **Step 4: Run the focused Node test and verify GREEN**

Run: `node --test tests/js/map-state.test.js`  
Expected: all station-state tests pass.

### Task 2: Lock and implement the refreshed navbar and legend shell

**Files:**
- Modify: `tests/Feature/MapPageTest.php`
- Modify: `resources/views/map/partials/header.blade.php`
- Modify: `resources/views/map/index.blade.php`
- Create: `public/images/brand/higertech-logo.png`
- Create: `public/images/brand/inaproc-logo.png`

**Interfaces:**
- Consumes: Laravel `asset()` URLs and the existing DOM IDs for network totals and drawer controls.
- Produces: rendered brand images with stable accessible labels and `#map-legend` with four `[data-legend-type]` slots.

- [ ] **Step 1: Write the failing Laravel feature test**

Assert that `/map` contains `/images/brand/higertech-logo.png`, `/images/brand/inaproc-logo.png`, `id="map-legend"`, and data slots for `ARR`, `AWLR`, `AWS`, and `AWLR_ARR`. Replace the obsolete assertion that reference assets must not be used with assertions for the user-authorized local copies.

- [ ] **Step 2: Run the focused PHPUnit test and verify RED**

Run: `php artisan test tests/Feature/MapPageTest.php`  
Expected: assertions fail because the PNG URLs and legend shell do not exist yet.

- [ ] **Step 3: Add the authorized assets and minimal Blade structure**

Copy the two supplied PNGs into `public/images/brand`, replace the generated navbar mark/text-only INAPROC label with responsive `<img>` elements, add the visual EN/ID pill, and add a compact semantic legend to the map section. Preserve existing navigation destinations and drawer IDs.

- [ ] **Step 4: Run the focused PHPUnit test and verify GREEN**

Run: `php artisan test tests/Feature/MapPageTest.php`  
Expected: all map page tests pass.

### Task 3: Apply the responsive visual treatment and shared legend icons

**Files:**
- Modify: `resources/views/map/partials/sidebar.blade.php`
- Modify: `resources/js/map/index.js`
- Modify: `resources/css/app.css`
- Test: `tests/js/map-visuals.test.js`

**Interfaces:**
- Consumes: `stationIconSvg(type, className)` and `[data-legend-type]` elements.
- Produces: a 420 px desktop sidebar, expanded result cards, reference-like navbar proportions, and category pictograms in every primary legend row.

- [ ] **Step 1: Write the failing legend behavior test**

Add a pure `buildLegendIcon(type)` export or equivalent minimal helper and assert that an ARR icon contains the requested legend class and inline SVG rather than an external image.

- [ ] **Step 2: Run the focused test and verify RED**

Run: `node --test tests/js/map-visuals.test.js`  
Expected: the helper assertion fails because the legend population behavior does not exist.

- [ ] **Step 3: Implement the smallest shared-icon and CSS changes**

Populate legend slots from `stationIconSvg()`, widen the sidebar/drawer to 420 px, increase card padding/icon size, style the new card metadata, size the supplied logos, and keep compact breakpoints for mobile and mid-sized desktops. Use existing colors and CSS rather than a new UI library.

- [ ] **Step 4: Run focused and full frontend tests**

Run: `node --test tests/js/*.test.js`  
Expected: all JavaScript tests pass without warnings.

### Task 4: Verify the complete refresh

**Files:**
- Verify only; no new production files expected.

**Interfaces:**
- Consumes: completed Laravel/Blade/JavaScript/CSS implementation.
- Produces: current evidence that the refresh runs without regression.

- [ ] **Step 1: Run automated verification**

Run `php artisan test`, `node --test tests/js/*.test.js`, `vendor/bin/pint --test`, and `npm run build`. All commands must exit successfully.

- [ ] **Step 2: Run HTTP checks**

Start the local Laravel server, confirm `/map`, `/api/stations`, and `/api/stations/summary` return HTTP 200, and confirm the map API still returns 200 dummy stations.

- [ ] **Step 3: Run desktop and mobile browser QA**

At desktop width, verify both brand assets, two-row navbar, 420 px sidebar, category legend, result-card selection, marker popup, and basemap control. At mobile width, verify the compact header, drawer, readable result cards, and unobstructed map.

- [ ] **Step 4: Inspect the browser console**

Confirm there are no JavaScript errors after loading the page and interacting with search, a station card, the drawer, and the legend area.
