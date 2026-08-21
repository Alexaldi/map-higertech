# Map-First Floating UI Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the permanently visible map sidebar and summary-card rail with an on-demand floating station panel and one compact network-status capsule while leaving the Higertech navbar unchanged.

**Architecture:** Keep the existing Laravel/Blade shell, API contracts, Leaflet modules, and station metadata. Move the existing sidebar partial inside the map workspace, drive one `is-open` panel state from the existing mobile header button plus a new desktop map launcher, and reuse native `<details>` for filters, network breakdown, and legend disclosures.

**Tech Stack:** Laravel, Blade, Vite, Tailwind CSS, vanilla JavaScript modules, Leaflet.js, Leaflet MarkerCluster, Node built-in test runner.

**Spec:** `docs/superpowers/specs/2026-08-21-map-first-floating-ui-design.md`

## Global Constraints

- Keep `resources/views/map/partials/header.blade.php` and the current two-level Higertech navbar composition unchanged.
- Keep the 200 deterministic SQLite dummy stations and both API response contracts unchanged.
- Keep all 12 exact station types; do not restore a generic `Lainnya` UI filter.
- Add no frontend dependency, SPA framework, chart, authentication, admin, CMS, or real Higertech data.
- Use solid white/slate surfaces, one blue primary accent, restrained borders/shadows, and no new gradient or glow effects.
- Preserve loading, empty, retry, null-safety, escaping, keyboard focus, textual status, and reduced-motion behavior.
- Do not commit, push, open a pull request, or deploy without explicit user authorization.

## File Map

- `tests/Feature/MapPageTest.php`: server-rendered contracts for the floating shell, unchanged header, explicit filters, and compact summary.
- `tests/js/map-state.test.js`: panel open/close state and accessibility attributes.
- `resources/views/map/index.blade.php`: map-first composition, desktop launcher, panel placement, map notices, tools, backdrop.
- `resources/views/map/partials/sidebar.blade.php`: floating-panel content shared by desktop and mobile.
- `resources/views/map/partials/summary.blade.php`: compact total/online/offline capsule plus on-demand detailed breakdown.
- `resources/js/map/state.js`: one small DOM-state helper for panel visibility.
- `resources/js/map/index.js`: bind launchers, close controls, Escape/backdrop behavior, and existing station navigation to the new panel.
- `resources/css/app.css`: floating desktop panel, mobile bottom sheet, compact capsule, simplified tools/legend/popup, responsive and focus states.

---

### Task 1: Lock the map-first Blade contract

**Files:**
- Modify: `tests/Feature/MapPageTest.php`
- Modify: `resources/views/map/index.blade.php`
- Modify: `resources/views/map/partials/sidebar.blade.php`
- Modify: `resources/views/map/partials/summary.blade.php`

**Interfaces:**
- Consumes: Existing `data-live-map`, API URL data attributes, `#station-map`, `#station-results`, filter IDs, summary IDs, and all existing map-control IDs.
- Produces: `#station-panel-launcher`, `.station-panel`, `#station-panel-close`, `#network-status`, `#network-details`, and the unchanged `#type-summary-items` hook for JavaScript rendering.

- [ ] **Step 1: Replace page-shell assertions with the floating-layout contract**

Update `test_map_page_exposes_filter_and_layout_controls()` and add a dedicated test:

```php
public function test_map_workspace_uses_on_demand_panel_and_compact_network_status(): void
{
    $html = $this->get('/map')->assertOk()->getContent();

    $this->assertStringContainsString('id="station-panel-launcher"', $html);
    $this->assertStringContainsString('class="station-panel"', $html);
    $this->assertStringContainsString('id="station-panel-close"', $html);
    $this->assertStringContainsString('id="network-status"', $html);
    $this->assertStringContainsString('id="network-details"', $html);
    $this->assertStringContainsString('id="type-summary-items"', $html);
    $this->assertStringNotContainsString('map-summary__rail', $html);
    $this->assertStringNotContainsString('data-summary-key="ARR"', $html);
    $this->assertStringNotContainsString('data-summary-key="AWLR"', $html);
    $this->assertStringNotContainsString('data-summary-key="AWS"', $html);
}
```

Keep the existing assertions for all 12 `data-type` values, station/map IDs, loading/empty/error text, brand assets, and unchanged navbar links. Replace assertions for `#sidebar-toggle`/`#drawer-close` with `#station-panel-close` while retaining the existing header `#drawer-toggle` assertion.

- [ ] **Step 2: Run the page test and verify the new contract fails**

Run:

```powershell
php artisan test tests\Feature\MapPageTest.php
```

Expected: FAIL because `#station-panel-launcher`, `.station-panel`, `#network-status`, and `#network-details` do not yet exist and the old summary rail is still rendered.

- [ ] **Step 3: Move the panel into the map workspace**

In `resources/views/map/index.blade.php`, remove the sidebar include as a flex sibling before the map section. Inside `#map-workspace`, directly after `#station-map`, add the launcher and include the sidebar:

```blade
<button
    id="station-panel-launcher"
    class="station-panel-launcher"
    type="button"
    aria-controls="station-sidebar"
    aria-expanded="false"
>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
        <path d="M4 6h16M4 12h16M4 18h10" />
    </svg>
    <span><strong>Daftar Pos</strong><small id="station-launcher-count">Memuat...</small></span>
</button>

@include('map.partials.sidebar')
```

Keep summary, legend, map toolbar, map notices, and backdrop inside or immediately adjacent to the same workspace. Do not change the header include.

- [ ] **Step 4: Convert sidebar markup to a neutral floating panel**

In `resources/views/map/partials/sidebar.blade.php`, replace layout-heavy fixed/relative Tailwind classes with:

```blade
<aside id="station-sidebar" class="station-panel" aria-label="Filter dan daftar station">
    <header class="station-panel__header">
        <div>
            <p>Jaringan Telemetri</p>
            <h2>Daftar Pos Monitoring</h2>
            <span id="station-result-status" aria-live="polite">Menyiapkan data...</span>
        </div>
        <button id="station-panel-close" type="button" aria-label="Tutup daftar pos">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="m6 6 12 12M18 6 6 18" />
            </svg>
        </button>
    </header>
    {{-- Keep the existing search, collapsed #station-filter-panel, all 12 type buttons,
         status buttons, organization select, reset button, and #station-results. --}}
</aside>
```

Delete the old desktop collapse button and separate drawer-close button. Keep the filter disclosure closed by default.

- [ ] **Step 5: Replace the summary rail with one compact capsule**

In `resources/views/map/partials/summary.blade.php`, keep only the SVG symbols needed by the capsule and detailed breakdown. Replace the card loop with:

```blade
<section id="network-status" class="network-status" aria-label="Status jaringan telemetry">
    <div class="network-status__metric">
        <span>Total Pos</span><strong id="summary-total">—</strong>
    </div>
    <div class="network-status__metric is-online">
        <span>Online</span><strong id="summary-online">—</strong>
    </div>
    <div class="network-status__metric is-offline">
        <span>Offline</span><strong id="summary-offline">—</strong>
    </div>

    <details id="network-details" class="network-details">
        <summary>Detail jaringan</summary>
        <div class="network-details__panel">
            <header>
                <span>Instansi</span><strong id="summary-organizations">—</strong>
            </header>
            <ul id="type-summary-items"></ul>
            <button id="summary-retry" class="hidden" type="button">Coba lagi</button>
        </div>
    </details>
</section>
```

Do not render always-visible ARR, AWLR, AWS, or AWLR_ARR summary cards. Their counts remain available through `stationTypeSummaryHtml(summary.types)`.

- [ ] **Step 6: Run the Blade contract tests**

Run:

```powershell
php artisan test tests\Feature\MapPageTest.php
```

Expected: PASS. If an old assertion still requires `sidebar-toggle`, `drawer-close`, or a category summary card, update that assertion only when it contradicts the approved spec.

---

### Task 2: Implement one tested panel visibility state

**Files:**
- Modify: `tests/js/map-state.test.js`
- Modify: `resources/js/map/state.js`
- Modify: `resources/js/map/index.js`

**Interfaces:**
- Consumes: `{ panel, launchers, backdrop }`, where `launchers` is an array containing the map launcher and existing mobile header `#drawer-toggle` when present.
- Produces: `setStationPanelOpen(elements, open): void`; toggles `.is-open`, backdrop `.hidden`, and every launcher `aria-expanded` value.

- [ ] **Step 1: Add a failing unit test for open and closed state**

Append to `tests/js/map-state.test.js`:

```js
import { setStationPanelOpen } from '../../resources/js/map/state.js';

const fakeElement = (classes = []) => {
    const values = new Set(classes);
    const attributes = new Map();

    return {
        attributes,
        classList: {
            contains: (name) => values.has(name),
            toggle: (name, force) => force ? values.add(name) : values.delete(name),
        },
        setAttribute: (name, value) => attributes.set(name, value),
    };
};

test('setStationPanelOpen synchronizes panel, launchers, and backdrop', () => {
    const panel = fakeElement();
    const backdrop = fakeElement(['hidden']);
    const launchers = [fakeElement(), fakeElement()];

    setStationPanelOpen({ panel, backdrop, launchers }, true);
    assert.equal(panel.classList.contains('is-open'), true);
    assert.equal(backdrop.classList.contains('hidden'), false);
    assert.deepEqual(launchers.map((item) => item.attributes.get('aria-expanded')), ['true', 'true']);

    setStationPanelOpen({ panel, backdrop, launchers }, false);
    assert.equal(panel.classList.contains('is-open'), false);
    assert.equal(backdrop.classList.contains('hidden'), true);
    assert.deepEqual(launchers.map((item) => item.attributes.get('aria-expanded')), ['false', 'false']);
});
```

- [ ] **Step 2: Run the state test and verify it fails**

Run:

```powershell
node --test tests\js\map-state.test.js
```

Expected: FAIL because `setStationPanelOpen` is not exported.

- [ ] **Step 3: Add the minimal state helper**

Append to `resources/js/map/state.js`:

```js
export const setStationPanelOpen = ({ panel, launchers = [], backdrop }, open) => {
    panel?.classList.toggle('is-open', open);
    backdrop?.classList.toggle('hidden', !open);

    for (const launcher of launchers) {
        launcher?.setAttribute('aria-expanded', String(open));
    }
};
```

- [ ] **Step 4: Use the helper from map initialization**

In `resources/js/map/index.js`:

1. Import `setStationPanelOpen` from `state.js`.
2. Add `panelLauncher: document.querySelector('#station-panel-launcher')` and `panelClose: document.querySelector('#station-panel-close')` to `elements`.
3. Build `elements.panelLaunchers = [elements.panelLauncher, elements.drawerToggle].filter(Boolean)` after the element lookup.
4. Replace the old collapse/drawer binding with `bindStationPanel(elements)`.

Use this binding:

```js
function bindStationPanel(elements) {
    const open = () => setStationPanelOpen({
        panel: elements.sidebar,
        launchers: elements.panelLaunchers,
        backdrop: elements.drawerBackdrop,
    }, true);
    const close = ({ restoreFocus = false } = {}) => {
        setStationPanelOpen({
            panel: elements.sidebar,
            launchers: elements.panelLaunchers,
            backdrop: elements.drawerBackdrop,
        }, false);
        if (restoreFocus) elements.panelLauncher?.focus();
    };

    for (const launcher of elements.panelLaunchers) launcher.addEventListener('click', open);
    elements.panelClose?.addEventListener('click', () => close({ restoreFocus: true }));
    elements.drawerBackdrop?.addEventListener('click', () => close());
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && elements.sidebar.classList.contains('is-open')) {
            close({ restoreFocus: true });
        }
    });

    return close;
}
```

Store the returned `closePanel` function and pass it to station navigation. In `bindStationNavigation`, close only when `window.matchMedia('(max-width: 1023px)').matches`; desktop selection leaves the floating panel open.

- [ ] **Step 5: Update the launcher result count without a new request**

In `renderStations()`, immediately after updating `#station-result-status`, set:

```js
const launcherCount = document.querySelector('#station-launcher-count');
if (launcherCount) launcherCount.textContent = `${validStations.length} pos`;
```

Use `0 pos` for an empty result and set `Gagal memuat` in the station-request catch block.

- [ ] **Step 6: Run focused and complete JavaScript tests**

Run:

```powershell
node --test tests\js\map-state.test.js
npm run test:js
```

Expected: both commands PASS with no warning or unhandled rejection.

---

### Task 3: Apply restrained map-first styling

**Files:**
- Modify: `resources/css/app.css`
- Test: `tests/Feature/MapPageTest.php`

**Interfaces:**
- Consumes: `.station-panel`, `.is-open`, `.station-panel-launcher`, `.network-status`, `.network-details`, existing `.map-toolbar`, `.map-legend`, `.basemap-gallery`, station card, marker, and popup classes.
- Produces: Desktop overlay panel, mobile bottom sheet, compact top capsule, bounded disclosure panels, and a full map workspace without layout reflow.

- [ ] **Step 1: Remove obsolete permanent-layout CSS**

Delete or replace rules that implement:

- `#station-sidebar` as a desktop flex sibling or collapsed 3.5 rem rail.
- `.map-summary`, `.map-summary__rail`, and `.summary-card` as persistent map overlays.
- Desktop sidebar width transitions and child-hiding selectors for `.is-collapsed`.
- Decorative popup gradient styling.

Keep marker, cluster, basemap, telemetry, focus, loading, and reduced-motion rules unless the following steps explicitly replace them.

- [ ] **Step 2: Style the desktop launcher and floating panel**

Add rules equivalent to:

```css
.station-panel-launcher {
    position: absolute;
    left: 12px;
    top: 12px;
    z-index: 520;
    display: flex;
    align-items: center;
    gap: 8px;
    min-height: 42px;
    padding: 7px 10px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 4px 14px rgb(15 23 42 / 0.1);
    color: #0f172a;
}

.station-panel {
    position: absolute;
    left: 12px;
    top: 62px;
    bottom: 12px;
    z-index: 610;
    display: flex;
    width: min(380px, calc(100% - 24px));
    flex-direction: column;
    overflow: hidden;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 12px 32px rgb(15 23 42 / 0.16);
    transform: translateX(calc(-100% - 24px));
    transition: transform 180ms ease;
}

.station-panel.is-open {
    transform: translateX(0);
}
```

Style the panel header, close button, search, filter disclosure, and results with 11-13 px typography and 8-10 px radii. Keep compact station cards and ensure five or more cards can be scanned at a 720 px desktop viewport when filters are closed.

- [ ] **Step 3: Style the compact network capsule and detail panel**

Place `.network-status` at `top: 12px` and center it horizontally without covering the launcher or right-side tools. Use one white capsule with dividers, not separate cards:

```css
.network-status {
    position: absolute;
    left: 50%;
    top: 12px;
    z-index: 520;
    display: flex;
    align-items: stretch;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 4px 14px rgb(15 23 42 / 0.09);
    transform: translateX(-50%);
}

.network-status__metric {
    display: grid;
    min-width: 76px;
    padding: 7px 10px;
    border-right: 1px solid #e2e8f0;
}
```

Use green/red only on the online/offline dot or value. Position `.network-details__panel` below the capsule, limit it to the viewport, and reuse the existing two-column `#type-summary-items` layout. The details disclosure is closed by default.

- [ ] **Step 4: Align map tools and progressive disclosures**

- Put `.map-toolbar` at the upper-right with 36 px solid buttons.
- Offset the Leaflet zoom control below or alongside that group so controls never overlap.
- Keep basemap at lower-right and legend at lower-left.
- Keep legend closed by default; opened legend shows all 12 types in a bounded two-column grid.
- Keep loading/error notices compact and centered without dimming the entire map.
- Use solid popup sections; do not reintroduce gradients.

- [ ] **Step 5: Add mobile bottom-sheet rules**

Within `@media (max-width: 1023px)`:

```css
.station-panel-launcher {
    display: none;
}

.station-panel {
    position: absolute;
    inset: auto 0 0;
    width: 100%;
    height: min(72dvh, 620px);
    border-width: 1px 0 0;
    border-radius: 16px 16px 0 0;
    transform: translateY(100%);
}

.station-panel.is-open {
    transform: translateY(0);
}
```

Keep the existing header `#drawer-toggle` as the mobile launcher without changing header markup. Make the network capsule fit within the map width; on very narrow screens use abbreviated labels but retain total, online, and offline values. Bound network details and legend to available height with internal scrolling.

- [ ] **Step 6: Verify Blade, CSS compilation, and unchanged header**

Run:

```powershell
php artisan test tests\Feature\MapPageTest.php
npm run build
```

Expected: page tests PASS and Vite exits `0` with generated CSS/JS assets. Inspect the rendered page test to confirm the header asset URLs and navigation assertions are still present.

---

### Task 4: Regression and browser verification

**Files:**
- Modify only if a failure identifies a regression in an in-scope file.
- Verify: `/map`, `/api/stations`, `/api/stations/summary`.

**Interfaces:**
- Consumes: Completed Blade, JavaScript, CSS, current SQLite data, and current APIs.
- Produces: Evidence that map-first presentation did not break station functionality.

- [ ] **Step 1: Run formatter and all automated tests**

Run:

```powershell
.\vendor\bin\pint --test
php artisan test
npm run test:js
npm run build
```

Expected: Pint passes; all Laravel and JavaScript tests pass; Vite exits `0`.

- [ ] **Step 2: Verify isolated SQLite seed data and endpoints**

Confirm `.env` uses SQLite inside this workspace, then run:

```powershell
php artisan migrate:fresh --seed
php artisan serve --host=127.0.0.1 --port=8000
```

Check:

```powershell
$map = Invoke-WebRequest 'http://127.0.0.1:8000/map' -UseBasicParsing
$stations = Invoke-RestMethod 'http://127.0.0.1:8000/api/stations'
$summary = Invoke-RestMethod 'http://127.0.0.1:8000/api/stations/summary'
$fm = Invoke-RestMethod 'http://127.0.0.1:8000/api/stations?type=FM'
```

Expected: `/map` is `200`; stations contain `200` seeded records; summary has total `200`, online `167`, offline `33`, and 12 type keys; FM contains `12` records.

- [ ] **Step 3: Perform desktop browser QA**

At a 1280×720-or-larger browser viewport verify:

1. Header composition and height are unchanged.
2. Default map has no permanent left panel or multi-card rail.
3. `Daftar Pos` launcher opens a 380 px floating panel without changing map bounds or width.
4. Filters are initially collapsed and station results scroll independently.
5. FM filter returns 12 cards; selecting one flies to its marker and opens a telemetry popup.
6. Network capsule shows `200`, `167`, and `33`; details show 8 organizations and all 12 type counts.
7. Legend displays all 12 types when opened.
8. Satellite basemap can be selected and the gallery closes afterward.
9. Closing the panel returns focus to the launcher.
10. Browser console contains no JavaScript errors.

- [ ] **Step 4: Perform mobile QA when the active browser supports a mobile viewport**

At approximately 390×844 verify:

1. Existing mobile header remains unchanged.
2. Header filter button opens a bottom sheet, not a left drawer.
3. Sheet height is bounded, results scroll, and the backdrop closes it.
4. Selecting a station closes the sheet and opens the marker popup.
5. Status capsule, legend, and network details remain within the viewport.

If the active browser cannot provide a mobile viewport, report mobile visual QA as not run rather than claiming success; rely only on responsive CSS/build evidence.

- [ ] **Step 5: Review the approved acceptance criteria and stop**

Re-read `docs/superpowers/specs/2026-08-21-map-first-floating-ui-design.md`. Confirm every acceptance criterion with test, endpoint, or browser evidence. Report any blocked item explicitly. Do not add another feature, commit, push, open a PR, or deploy.
