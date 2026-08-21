# Map-First Floating UI Redesign

**Date:** 2026-08-21  
**Status:** Approved direction; written specification awaiting review  
**Project root:** `C:\Users\Aspire 7\Documents\ChatGPT\map-higertech`

## Goal

Redesign only the `/map` workspace so the map becomes the dominant surface and information appears progressively when requested. The existing two-level Higertech navbar remains unchanged. Station data, APIs, Leaflet behavior, telemetry popups, dummy dataset, and supported station types remain functional.

The visual result should feel like a practical Indonesian monitoring product: restrained, readable, and operational. It must avoid the current row of persistent cards and the appearance of a template generated from excessive gradients, glass effects, large radii, or decorative panels.

## Scope

This redesign changes:

- The desktop sidebar into an on-demand floating station panel.
- The mobile sidebar into a bottom sheet using the same content.
- The persistent summary-card row into one compact network-status capsule.
- The placement and presentation of map tools, legend, basemap selection, loading, empty, and error states.
- Spacing, typography, borders, and shadows inside the map workspace.

This redesign does not change:

- `resources/views/map/partials/header.blade.php` or the current navbar composition.
- `/api/stations` filters or response data.
- `/api/stations/summary` response data.
- The 200 deterministic SQLite dummy stations.
- Marker clustering, station icon meanings, telemetry formatting, or popup safety.
- Authentication, admin, CMS, CRUD, historical charts, WebSockets, MQTT, or real Higertech data.
- Frontend dependencies.

## Visual Direction

Use a solid, neutral interface rather than a decorative dashboard:

- White and slate surfaces with Higertech blue as the single primary accent.
- Green and red only for online/offline health.
- Station colors only where a station type must be identified.
- Borders around `#e2e8f0`, small 8-12 px corner radii, and restrained shadows.
- No gradient backgrounds, glowing cards, oversized icon tiles, or persistent translucent overlays.
- Compact system typography with clear differences between labels, values, and supporting text.

The map remains visible behind every optional panel and occupies the full workspace below the unchanged navbar.

## Desktop Layout

### Map Canvas

The Leaflet canvas fills the entire area below the navbar. Opening the station panel overlays the map and does not resize or shift it. Leaflet receives `invalidateSize()` only when genuinely needed, such as entering fullscreen.

### Station Launcher

A compact button in the upper-left map corner displays a list icon, `Daftar Pos`, and the current result count. It is the only persistent station-list control.

Activating it opens a floating panel:

- Width: approximately 380 px.
- Maximum height: available viewport height minus map-edge spacing.
- Position: 12-16 px from the map's left and top edges.
- Solid white background, thin border, restrained shadow.
- Close button and Escape support.
- `aria-expanded` on the launcher and an accessible panel label.

The panel contains, in order:

1. `Daftar Pos Monitoring` heading and live result count.
2. Search input.
3. A collapsed `Filter` control showing whether filters are active.
4. Expandable type, status, and organization filters.
5. Scrollable station results using compact cards.

The filter body is collapsed by default so the list receives most of the vertical space. All 12 station-type filters remain explicit; there is no generic `Lainnya` option.

### Network Status Capsule

Replace the persistent summary-card rail with one small capsule near the top of the map. It shows only:

- Total pos.
- Online.
- Offline.

A `Detail jaringan` button opens an on-demand breakdown containing total organizations and counts for all 12 station types. This breakdown reuses the existing station icons and summary response; it does not require a new API or chart.

### Map Tools

Place a compact vertical tool group in the upper-right:

- Reset Indonesia view.
- Fit current markers.
- Fullscreen.

Leaflet zoom controls join the same visual rhythm. The basemap control remains in the lower-right and opens the existing six choices. The marker legend remains collapsed in the lower-left and displays all 12 station types only when opened.

### Station Popup

Keep the current click-to-open Leaflet popup but simplify its presentation:

- Station name, station-type icon/code, and status first.
- Organization, location, and last update second.
- Only available telemetry metrics afterward.
- Device ID remains secondary.

Missing or null data continues to be omitted or replaced with the existing concise fallback. The popup must not become a separate detail page or introduce charts.

## Mobile Layout

The map remains full width below the unchanged compact mobile navbar.

- The `Daftar Pos` launcher opens a bottom sheet instead of a left panel.
- The sheet occupies at most about 72% of the dynamic viewport height.
- It has a solid backdrop, close control, Escape support where available, and returns focus to the launcher.
- Search and the filter control stay at the top of the sheet while station results scroll below them.
- Selecting a station closes the sheet, flies to the marker, and opens its popup.
- The network capsule becomes horizontally compact and still shows only total, online, and offline.
- Legend and type breakdown use bounded, scrollable panels so they never exceed the viewport.

## State and Data Flow

Existing request behavior remains the source of truth:

1. Page initialization fetches global summary and current station results.
2. Search and filters update the existing filter state and request `/api/stations`.
3. Stale station requests are aborted.
4. Result count updates both the panel header and launcher.
5. Clicking a station card finds its existing marker, closes the mobile sheet when applicable, flies to it, and opens the popup.
6. Summary data populates the three status values and the hidden detailed breakdown.

Only presentation state is added: station panel open/closed, filter body open/closed, network breakdown open/closed, and legend/basemap open/closed. Native `<details>` is preferred where it already covers disclosure behavior. No global store or component framework is introduced.

## Loading, Empty, and Error Handling

- Initial station loading appears inside the floating panel when it is open and as a small unobtrusive map notice when it is closed.
- Empty filtered results keep the map usable and show a reset-filter action inside the panel.
- Station API failure keeps the basemap and map controls usable and exposes the existing retry action.
- Summary failure displays dashes in the network capsule and a retry control in its detail panel.
- A malformed station remains individually skippable without breaking other markers or results.
- Tile-provider errors do not remove the station panel or telemetry data.

## Accessibility and Interaction

- All persistent controls are semantic buttons with visible focus states and descriptive labels.
- Launcher, detail, legend, and basemap controls expose `aria-expanded`.
- Result and loading text continues to use live regions.
- Online/offline state remains textual and is not communicated by color alone.
- Escape closes the foremost optional panel.
- Closing the station panel returns focus to its launcher.
- Reduced-motion preferences continue to disable nonessential transitions.

## Implementation Boundary

Reuse the current Blade partials and JavaScript modules. Expected production changes are limited to:

- `resources/views/map/index.blade.php`
- `resources/views/map/partials/sidebar.blade.php`
- `resources/views/map/partials/summary.blade.php`
- `resources/css/app.css`
- `resources/js/map/index.js`
- Existing frontend tests and page-structure tests

`constants.js`, popup formatters, station APIs, migrations, and seeded data change only if a failing test proves the redesign cannot reuse their current contract. No new package is justified.

## Testing Strategy

Implementation follows red-green-refactor for behavior changes.

Automated checks cover:

- The page exposes the floating launcher, floating panel, compact status capsule, and detailed type breakdown.
- The old permanently visible summary rail is absent.
- All 12 exact type filters remain available.
- Panel open/close state updates accessibility attributes.
- Station filtering, result rendering, card navigation, popup safety, and summary rendering retain their current tests.
- Laravel, JavaScript, Pint, and Vite build checks remain green.

Browser QA covers:

- Default map-first view with the station panel closed.
- Desktop floating panel opening without shifting the map.
- Search, exact type filter, organization filter, and station-card navigation.
- Network detail, 12-type legend, basemap switching, reset, fit bounds, and fullscreen where supported.
- Mobile bottom-sheet behavior when a mobile viewport is available.
- Loading, empty, and retry presentation.
- JavaScript console errors.

## Acceptance Criteria

- The current Higertech navbar is visually and structurally unchanged.
- The default `/map` view contains no persistent multi-card information rail or permanent desktop sidebar.
- The map occupies the full workspace and remains interactive while optional desktop panels are open.
- The launcher opens a floating desktop station panel and a mobile bottom sheet.
- Only total, online, and offline are persistently visible; organization and 12-type counts remain one interaction away.
- All existing station search, filters, markers, clusters, popups, basemaps, and failure states still work.
- No new frontend dependency, API, database change, or out-of-scope feature is added.
- Full automated verification, production build, endpoint checks, and browser console checks pass before completion is claimed.

## Delivery Boundary

Implementation stops after this map-workspace redesign is verified. No commit, push, pull request, deployment, or unrelated feature is performed without explicit user approval.
