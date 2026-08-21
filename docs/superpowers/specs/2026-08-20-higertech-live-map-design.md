# Higertech Live Monitoring Map MVP Design

**Date:** 2026-08-20  
**Status:** Approved in chat; written specification awaiting review  
**Project root:** `C:\Users\Aspire 7\Documents\ChatGPT\map-higertech`

## Goal

Build a runnable Laravel prototype at `/map` that recreates the monitoring-map capabilities of the Higertech reference using only locally seeded dummy data. The interface will be a modern, responsive Indonesian telemetry dashboard built with Blade, Vite, Tailwind CSS, Leaflet, OpenStreetMap tiles, and Leaflet MarkerCluster.

## Scope

The MVP includes exactly:

- One public Blade page at `/map`.
- One filtered station endpoint at `GET /api/stations`.
- One summary endpoint at `GET /api/stations/summary`.
- SQLite persistence with a `Station` model, migration, factory, and deterministic seeder.
- Fifty fictional monitoring stations distributed across Indonesia.
- Interactive station search, type/status/organization filters, clustered markers, modern popups, layer switching, reset/fit-bounds, and fullscreen.
- Responsive desktop sidebar and mobile drawer.
- Loading, empty, and error states that keep the page usable.

The MVP explicitly excludes authentication, authorization, admin panels, CMS, station CRUD, detailed station pages, historical charts, MQTT, WebSockets, production data, Google Maps, and copied Higertech assets or data.

## Architecture

Use a conventional Laravel monolith. Blade renders the page shell while a small JavaScript application fetches the JSON endpoints and manages Leaflet. Laravel owns querying, filtering, summary aggregation, and serialization; the browser owns display state and map interaction.

No repository interface, event bus, SPA framework, or component framework will be introduced. A single `StationService` provides the reusable query and summary operations required by `StationController`. This keeps controller code small without creating speculative abstractions.

## Runtime and Dependencies

- Laravel stable release resolved by Composer and compatible with the installed PHP 8.4 runtime.
- SQLite as the default database.
- Blade and Laravel routes/controllers for server rendering and JSON APIs.
- Vite and Tailwind CSS for the asset pipeline and layout styling.
- `leaflet` and `leaflet.markercluster` from npm.
- Vanilla JavaScript modules for UI state and behavior.
- Native Fullscreen API wrapped in a Leaflet control; no fullscreen plugin is required.
- OpenStreetMap Standard and OpenStreetMap Humanitarian tiles in Leaflet's layer control. Both layers show proper attribution and require no API key.

## Data Model

The `stations` table contains:

- `id`
- `name`
- `slug`, unique
- `station_type`
- nullable `latitude` and `longitude`
- nullable `balai_name`
- nullable `organization_code`
- nullable `province_name`, `regency_name`, `district_name`, and `village_name`
- nullable `river_area_name` and `watershed_name`
- nullable `device_id`
- `device_status`, constrained by application data to `online` or `offline`
- `timezone`, defaulting to `Asia/Jakarta`
- nullable `reading_at`
- nullable JSON `latest_reading`
- Laravel timestamps

The model casts latitude and longitude to floats, `reading_at` to a datetime, and `latest_reading` to an array.

## Dummy Dataset

The seeder creates exactly 50 map-visible stations with realistic but fictional station names and device identifiers. Coordinates span Sumatra, Java, Bali, Nusa Tenggara, Kalimantan, Sulawesi, Maluku, and Papua. Real province and city names may be used as geographic context, but station telemetry and organization combinations are invented and are not copied from Higertech.

All source types are represented:

- Primary: `ARR`, `AWLR`, `AWS`, `AWLR_ARR`.
- Other: `AGWLR`, `FM`, `EWS`, `AVWR`, `WQ`, `VNOTCH`, `OW`, `OSP`.

The dataset includes online/offline devices, multiple organizations, staggered reading timestamps, nullable regional fields, and at least one station with `latest_reading = null`. Factory states generate type-appropriate telemetry for reuse in tests.

Telemetry examples follow the requested shapes. Only non-null values are serialized into popup rows. No generated telemetry is presented as actual live or historical Higertech data.

## API Design

### `GET /api/stations`

Only records with both latitude and longitude are returned. Supported query parameters:

- `search`: case-insensitive match against station name, location names, balai name, organization code, or device ID.
- `type`: one of the exact source station types, or `OTHER` for every type outside `ARR`, `AWLR`, `AWS`, and `AWLR_ARR`.
- `status`: `online` or `offline`.
- `organization`: exact organization code.

Unknown or empty filter values are ignored rather than causing a server error. Results are sorted by name. The response shape is:

```json
{
  "data": [
    {
      "id": 1,
      "name": "PCH Bukit Raya",
      "slug": "pch-bukit-raya",
      "station_type": "ARR",
      "latitude": -6.21,
      "longitude": 106.84,
      "balai_name": "Balai Hidrologi Nusantara Barat",
      "organization_code": "BHN-BARAT",
      "province_name": "DKI Jakarta",
      "regency_name": "Jakarta Selatan",
      "district_name": null,
      "village_name": null,
      "river_area_name": null,
      "watershed_name": null,
      "device_id": "ARR-NUS-001",
      "device_status": "online",
      "timezone": "Asia/Jakarta",
      "reading_at": "2026-08-20T12:00:00+07:00",
      "latest_reading": {
        "rainfall": 0,
        "rainfall_last_hour": 0,
        "intensity": "Berawan"
      }
    }
  ],
  "meta": {
    "count": 1,
    "organizations": [
      {
        "code": "BHN-BARAT",
        "name": "Balai Hidrologi Nusantara Barat"
      }
    ]
  }
}
```

`meta.organizations` contains the complete organization option list so the sidebar does not need a third endpoint.

### `GET /api/stations/summary`

The summary is global and does not change with sidebar filters:

```json
{
  "total": 50,
  "online": 42,
  "offline": 8,
  "organizations": 8,
  "types": {
    "ARR": 15,
    "AWLR": 15,
    "AWS": 8,
    "AWLR_ARR": 5,
    "OTHER": 7
  }
}
```

The actual seeded distribution may differ from the example counts, but the keys and aggregation rules are fixed. The summary counts all stations, including a future record with missing coordinates, while the map endpoint excludes records without complete coordinates.

## Page Structure

`/map` renders a full-height application shell with:

1. A compact header containing the product mark, `Higertech Live Monitoring`, `Realtime Telemetry Network`, global online/offline indicators, and the mobile filter button.
2. A desktop sidebar containing search, type chips, status chips, organization select, result count, station result cards, and collapse control.
3. A mobile slide-in drawer containing the same filter and result content.
4. A large map canvas as the visual focus.
5. Seven compact summary cards over or adjacent to the map: total, AWLR, ARR, AWS, organizations, online, and offline.
6. Map controls for zoom, layer selection, fit/reset, and fullscreen.

Blade partials are used for the header, sidebar/filter content, summary cards, and reusable icon markup when splitting them keeps the main view readable. Interactive code stays out of Blade.

## Frontend Modules and State

- `resources/js/app.js` imports the CSS and starts the map page only when its root element exists.
- `resources/js/map/index.js` owns initialization, request orchestration, filters, result rendering, marker replacement, and interaction wiring.
- `resources/js/map/popup.js` builds escaped, null-safe popup content and type-specific telemetry rows.
- `resources/js/map/markers.js` defines station type metadata and creates CSS-backed SVG/div icons.
- `resources/js/map/formatters.js` contains pure helpers for HTML escaping, nullable location formatting, telemetry units, and relative timestamps.

State is limited to current filters, returned stations, current request controller, Leaflet map, cluster layer, and a marker-by-station-ID map. Search input is debounced. Each filter change requests `/api/stations`; stale requests are aborted before applying their results.

Clicking a result card calls `flyTo` and opens the matching marker popup. If that station has disappeared after a filter refresh, the click is safely ignored. Reset clears filters and returns the map to the Indonesia view. Fit-bounds frames current markers and falls back to the default Indonesia view when none exist.

## Marker and Popup Design

Each station type has a distinct color and short symbol. The four primary types have prominent individual colors; all other types retain distinguishable colors but are grouped under `Lainnya` in the filter and summary. Icons are created locally with CSS and inline SVG/div markup, with no assets copied from Higertech.

Marker popups use a modern card layout with:

- Station name, station type badge, and online/offline indicator.
- Balai/organization and a compact non-empty location line.
- Device ID and last update.
- Only the telemetry rows supported by that station's type and actually present in `latest_reading`.

All inserted API text is escaped before entering HTML. Numeric zero remains visible; only `null`, `undefined`, and empty strings are omitted.

## Failure Handling

- Page shell and map initialize even when an API request fails.
- Loading state is shown during station and summary requests.
- Empty state explains that no station matches the current filters.
- Error state shows a concise message and retry button without discarding the map controls.
- A failed summary request displays unavailable values rather than crashing station loading.
- Missing coordinates never reach marker creation.
- Missing region fields produce a shorter location string with no repeated separators.
- Missing or partial `latest_reading` produces an informational empty-telemetry message or only the available rows.
- Unexpected station records are skipped individually if marker creation fails.
- Leaflet tile failure leaves the dashboard shell, filters, and station list usable.

## Responsive and Accessibility Behavior

- Desktop uses sidebar plus map; the sidebar can collapse to maximize map area.
- Mobile uses an off-canvas drawer with a backdrop and closes after selecting a station.
- Map resizing calls `invalidateSize()` after drawer/sidebar transitions.
- Controls use semantic buttons, labels, visible focus states, `aria-expanded`, and appropriate live regions for result/loading/error text.
- Status is communicated through text and icons in addition to color.

## Testing Strategy

Implementation follows red-green-refactor for behavior-bearing production code.

Laravel feature tests cover:

- `/map` renders the application shell.
- `/api/stations` returns only complete coordinates.
- Search, exact type, `OTHER`, status, and organization filters.
- Null telemetry and nullable location fields serialize without errors.
- The summary contract and aggregation for primary and other types.

Pure JavaScript helpers use Node's built-in test runner instead of adding a test framework. Tests cover escaping, zero-valued telemetry, nullable locations, type metadata fallback, and popup rows for requested primary/FM types. Browser QA verifies Leaflet initialization, clustering, popup opening, filter/search interaction, sidebar collapse, mobile drawer behavior, API error presentation, responsive layout, and no JavaScript console errors.

Final verification runs:

- Fresh SQLite migration and seeding.
- Complete Laravel test suite.
- JavaScript unit tests.
- Vite production build.
- Laravel route listing.
- HTTP checks for `/map`, `/api/stations`, a filtered station request, and `/api/stations/summary`.
- Interactive browser checks at desktop and mobile viewport sizes, including console inspection.

## Acceptance Criteria

The MVP is accepted when:

- A fresh install can run using the documented Composer, npm, Artisan, and Vite commands.
- The seeded database contains exactly 50 fictional stations covering all requested station types.
- `/map` shows a responsive Leaflet map of Indonesia with clustered, distinct, clickable station markers.
- All requested filter, search, station-card, popup, map-control, summary, and responsive behaviors work.
- Both API endpoints return the documented structures and handle null/empty cases.
- The page shows graceful loading, empty, and error states.
- Migration/seeding, tests, production build, endpoint checks, and browser console checks complete without errors.
- No excluded feature is added.

## Delivery Boundary

After the verified MVP, work stops. No commit, push, pull request, deployment, or post-MVP feature is performed without explicit user approval.
