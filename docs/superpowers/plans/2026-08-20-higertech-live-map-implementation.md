# Higertech Live Monitoring Map MVP Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use `superpowers:executing-plans` to implement this plan task-by-task. Sub-agent execution is intentionally not selected because the user requested direct work in the current task.

**Goal:** Build and verify a Laravel `/map` prototype with seeded SQLite station data, filterable JSON APIs, and a responsive interactive Leaflet monitoring dashboard.

**Architecture:** A conventional Laravel monolith renders a Blade dashboard shell and exposes station JSON through one controller backed by one query service. Vanilla JavaScript modules fetch the APIs and manage Leaflet, MarkerCluster, popup rendering, filters, responsive sidebar state, and graceful failures.

**Tech Stack:** PHP 8.4, Composer, Laravel, SQLite, Blade, Vite, Tailwind CSS, Leaflet, Leaflet MarkerCluster, vanilla JavaScript, PHPUnit/Pest as scaffolded by Laravel, and Node's built-in test runner.

**Spec:** `docs/superpowers/specs/2026-08-20-higertech-live-map-design.md`

## Global Constraints

- Project root is exactly `C:\Users\Aspire 7\Documents\ChatGPT\map-higertech`; do not create a nested Laravel project.
- Use no Google Maps code, key, imagery, API, or copied Higertech data/assets.
- Seed exactly 50 fictional, map-visible stations spanning all 12 requested station types.
- Only `/map`, `/api/stations`, and `/api/stations/summary` are product routes in scope.
- Add no authentication, admin, CMS, CRUD, charts, WebSockets, MQTT, or station detail page.
- Use SQLite, Blade, Vite, Tailwind CSS, Leaflet, OpenStreetMap tiles, and Leaflet MarkerCluster.
- Use one `StationService`; do not add a repository interface or SPA framework.
- Treat null coordinates, regions, timestamps, and telemetry as valid input and never crash the whole page for one bad record.
- All custom behavior-bearing production code follows a witnessed red-green-refactor cycle.
- Generated Laravel scaffold and dependency/configuration files are framework setup; verify them immediately before custom behavior work.
- Do not commit, push, create a pull request, deploy, or add post-MVP features.

## File Structure

- `app/Models/Station.php`: station fillable/cast configuration.
- `app/Services/StationService.php`: coordinate eligibility, API filters, organization options, and summary aggregation.
- `app/Http/Controllers/Api/StationController.php`: station index and summary HTTP responses.
- `app/Http/Resources/StationResource.php`: stable public station JSON contract.
- `database/migrations/2026_08_20_000000_create_stations_table.php`: SQLite-compatible station schema.
- `database/factories/StationFactory.php`: reusable fictional type-aware station fixtures.
- `database/seeders/StationSeeder.php`: deterministic 50-station Indonesia dataset.
- `database/seeders/DatabaseSeeder.php`: invokes `StationSeeder` only.
- `routes/web.php`: `/map` Blade route.
- `routes/api.php`: `/stations` and `/stations/summary` API routes.
- `bootstrap/app.php`: enables `routes/api.php` in Laravel's routing configuration.
- `resources/views/map/index.blade.php`: full-height page shell and Vite entry.
- `resources/views/map/partials/header.blade.php`: product identity and global status indicators.
- `resources/views/map/partials/sidebar.blade.php`: responsive filter drawer and station list shell.
- `resources/views/map/partials/summary.blade.php`: seven map summary cards.
- `resources/js/app.js`: global asset imports and conditional map bootstrap.
- `resources/js/map/constants.js`: station type labels/colors and API/default map configuration.
- `resources/js/map/formatters.js`: pure escaping, nullable formatting, telemetry, and time helpers.
- `resources/js/map/popup.js`: modern null-safe popup HTML.
- `resources/js/map/controls.js`: Leaflet reset/fit and native-fullscreen controls.
- `resources/js/map/index.js`: map, API request, marker cluster, filter, result-list, and drawer orchestration.
- `resources/css/app.css`: Tailwind import plus Leaflet/dashboard component styles.
- `tests/Feature/StationDatasetTest.php`: schema, factory casts, seeded volume/type coverage.
- `tests/Feature/StationApiTest.php`: station contract, filters, coordinate exclusion, null safety.
- `tests/Feature/StationSummaryApiTest.php`: summary aggregation contract.
- `tests/Feature/MapPageTest.php`: map route and required interactive shell.
- `tests/js/map-formatters.test.js`: formatter and telemetry-row behavior.
- `tests/js/map-popup.test.js`: popup escaping and optional-row behavior.
- `README.md`: local setup, run, test, build, and scope notes.

---

### Task 1: Scaffold Laravel and the Asset Pipeline

**Files:**

- Create: Laravel framework scaffold in the project root.
- Modify: `.env.example`
- Modify: `.env`
- Modify: `package.json`
- Modify: `resources/js/app.js`
- Modify: `resources/css/app.css`

**Interfaces:**

- Produces: a bootable Laravel application, SQLite environment, npm scripts, and installed `leaflet`/`leaflet.markercluster` imports used by later tasks.

- [ ] **Step 1: Create the Laravel scaffold without replacing the existing `.git` or docs**

Create the project in a temporary sibling directory with Composer, copy the generated scaffold into the project root while preserving `.git` and `docs`, then remove only the validated temporary scaffold directory. Do not initialize another Git repository.

- [ ] **Step 2: Verify the generated baseline**

Run:

```powershell
php artisan --version
php artisan test
```

Expected: Artisan reports the installed Laravel version and the generated tests pass.

- [ ] **Step 3: Configure SQLite and install frontend dependencies**

Set `DB_CONNECTION=sqlite`, remove active host/port/database credential lines from `.env` and `.env.example`, create `database/database.sqlite`, then run:

```powershell
npm install
npm install leaflet leaflet.markercluster
```

Add scripts:

```json
{
  "scripts": {
    "test:js": "node --test tests/js/*.test.js"
  }
}
```

- [ ] **Step 4: Establish the shared asset entry**

`resources/js/app.js` imports `../css/app.css`, Leaflet CSS, MarkerCluster CSS, and conditionally imports `./map/index.js` only when `[data-live-map]` exists. `resources/css/app.css` keeps the scaffolded Tailwind import and establishes `html`, `body`, and `#app` full-height defaults.

- [ ] **Step 5: Verify scaffold assets build**

Run:

```powershell
npm run build
```

Expected: Vite exits 0 with compiled CSS and JavaScript assets.

### Task 2: Station Schema, Model, Factory, and Seeder

**Files:**

- Create: `app/Models/Station.php`
- Create: `database/migrations/2026_08_20_000000_create_stations_table.php`
- Create: `database/factories/StationFactory.php`
- Create: `database/seeders/StationSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`
- Create: `tests/Feature/StationDatasetTest.php`

**Interfaces:**

- Produces: `Station::factory()`, type-aware `latest_reading`, model casts, and exactly 50 seeded station records.

- [ ] **Step 1: Generate behavior-free skeletons**

Use Artisan to generate the model/factory/seeder, then add the explicitly named migration file. Skeleton generation is setup; do not add station fields, cast behavior, or seed records yet.

- [ ] **Step 2: Write the failing dataset tests**

The tests must demonstrate these contracts with literal expectations:

```php
public function test_station_casts_coordinates_reading_time_and_telemetry(): void
{
    $station = Station::factory()->create([
        'latitude' => '-6.2000000',
        'longitude' => '106.8166667',
        'reading_at' => '2026-08-20 12:00:00',
        'latest_reading' => ['rainfall' => 0],
    ]);

    $this->assertIsFloat($station->latitude);
    $this->assertIsFloat($station->longitude);
    $this->assertInstanceOf(Carbon::class, $station->reading_at);
    $this->assertSame(['rainfall' => 0], $station->latest_reading);
}

public function test_station_seeder_creates_fifty_records_covering_every_type(): void
{
    $this->seed(StationSeeder::class);

    $this->assertDatabaseCount('stations', 50);
    $this->assertSame(
        ['AGWLR', 'ARR', 'AVWR', 'AWLR', 'AWLR_ARR', 'AWS', 'EWS', 'FM', 'OSP', 'OW', 'VNOTCH', 'WQ'],
        Station::query()->distinct()->orderBy('station_type')->pluck('station_type')->all(),
    );
}
```

Also assert all 50 seeded records have coordinates, more than one organization exists, online/offline both exist, and at least one `latest_reading` is null.

- [ ] **Step 3: Run the tests and witness RED**

Run:

```powershell
php artisan test tests/Feature/StationDatasetTest.php
```

Expected: FAIL because the empty schema/factory/seeder cannot satisfy the documented station contract.

- [ ] **Step 4: Implement the minimum station domain**

Create all requested nullable columns and indexes on `station_type`, `device_status`, and `organization_code`. Configure `$fillable` and casts. Implement factory states or a telemetry switch for all station types. Implement a deterministic array of 50 fictional stations across Indonesian regions and use factory-backed data creation without external API calls.

`DatabaseSeeder::run()` contains only:

```php
$this->call(StationSeeder::class);
```

- [ ] **Step 5: Verify GREEN and refactor duplication**

Run:

```powershell
php artisan test tests/Feature/StationDatasetTest.php
```

Expected: all dataset tests pass. Extract repeated telemetry builders in the factory only if the passing implementation contains real duplication.

### Task 3: Filterable Station API

**Files:**

- Create: `app/Services/StationService.php`
- Create: `app/Http/Controllers/Api/StationController.php`
- Create: `app/Http/Resources/StationResource.php`
- Create: `routes/api.php`
- Modify: `bootstrap/app.php`
- Create: `tests/Feature/StationApiTest.php`

**Interfaces:**

- Consumes: `Station` query scopes through Eloquent.
- Produces: `StationService::filtered(array $filters): Collection`, `StationService::organizations(): Collection`, and `GET /api/stations` with `{data, meta}`.

- [ ] **Step 1: Write failing API contract tests**

Create literal fixtures and separate tests proving:

```php
$response = $this->getJson('/api/stations?type=ARR&status=online&organization=BHN-BARAT');

$response->assertOk()
    ->assertJsonPath('meta.count', 1)
    ->assertJsonPath('data.0.name', 'PCH Bukit Raya')
    ->assertJsonPath('data.0.latest_reading.rainfall', 0);
```

Additional tests cover case-insensitive `search`, source type `AWLR_ARR`, `type=OTHER`, status, organization, alphabetical ordering, exclusion of missing latitude or longitude, complete organization metadata, and null region/telemetry serialization. Each test changes one relevant fixture so the wrong branch cannot pass accidentally.

- [ ] **Step 2: Run the API tests and witness RED**

Run:

```powershell
php artisan test tests/Feature/StationApiTest.php
```

Expected: FAIL with 404 because the API route is not registered.

- [ ] **Step 3: Implement the API minimally**

Register API routing in `bootstrap/app.php`, add routes in this order so `summary` is never interpreted as an identifier:

```php
Route::get('/stations/summary', [StationController::class, 'summary']);
Route::get('/stations', [StationController::class, 'index']);
```

Implement service filtering with conditional Eloquent clauses, exact recognized values, and a grouped `OTHER` condition. Always require non-null latitude and longitude. `StationResource` returns the exact public fields from the spec. Controller `index()` returns:

```php
return response()->json([
    'data' => StationResource::collection($stations),
    'meta' => [
        'count' => $stations->count(),
        'organizations' => $this->stations->organizations(),
    ],
]);
```

- [ ] **Step 4: Verify GREEN**

Run:

```powershell
php artisan test tests/Feature/StationApiTest.php
```

Expected: all station API tests pass.

### Task 4: Station Summary API

**Files:**

- Modify: `app/Services/StationService.php`
- Modify: `app/Http/Controllers/Api/StationController.php`
- Create: `tests/Feature/StationSummaryApiTest.php`

**Interfaces:**

- Produces: `StationService::summary(): array` and `GET /api/stations/summary`.

- [ ] **Step 1: Write the failing aggregation test**

Create a literal fixture set with two ARR, one AWLR, one AWS, one AWLR_ARR, and two other types; include online/offline and repeated organization codes. Assert the complete literal payload:

```php
$response->assertExactJson([
    'total' => 7,
    'online' => 5,
    'offline' => 2,
    'organizations' => 3,
    'types' => [
        'ARR' => 2,
        'AWLR' => 1,
        'AWS' => 1,
        'AWLR_ARR' => 1,
        'OTHER' => 2,
    ],
]);
```

- [ ] **Step 2: Run and witness RED**

Run:

```powershell
php artisan test tests/Feature/StationSummaryApiTest.php
```

Expected: FAIL because `summary()` or the controller response is not implemented.

- [ ] **Step 3: Implement one aggregate query plus fixed response keys**

Use database conditional sums and `COUNT(DISTINCT organization_code)` where SQLite compatibility is preserved. Normalize missing groups to integer zero and return keys in the documented order.

- [ ] **Step 4: Verify GREEN**

Run:

```powershell
php artisan test tests/Feature/StationSummaryApiTest.php
```

Expected: the exact aggregation contract passes.

### Task 5: Blade Map Shell and Responsive Content Structure

**Files:**

- Modify: `routes/web.php`
- Create: `resources/views/map/index.blade.php`
- Create: `resources/views/map/partials/header.blade.php`
- Create: `resources/views/map/partials/sidebar.blade.php`
- Create: `resources/views/map/partials/summary.blade.php`
- Create: `tests/Feature/MapPageTest.php`

**Interfaces:**

- Produces: public `/map` and stable DOM hooks consumed by `resources/js/map/index.js`.

- [ ] **Step 1: Write the failing page contract tests**

Assert `/map` is public and contains literal visible copy plus required DOM hooks:

```php
$this->get('/map')
    ->assertOk()
    ->assertSee('Higertech Live Monitoring')
    ->assertSee('Realtime Telemetry Network')
    ->assertSee('Cari nama pos...')
    ->assertSee('data-live-map', false)
    ->assertSee('id="station-map"', false)
    ->assertSee('id="station-results"', false)
    ->assertSee('/api/stations', false)
    ->assertSee('/api/stations/summary', false);
```

- [ ] **Step 2: Run and witness RED**

Run:

```powershell
php artisan test tests/Feature/MapPageTest.php
```

Expected: FAIL with 404 because `/map` is absent.

- [ ] **Step 3: Implement semantic Blade partials**

Add the route and render a page containing the header, one reusable responsive sidebar/drawer, seven summary placeholders, map canvas, map loading/error/empty overlays, drawer backdrop, retry buttons, and Vite entry. Expose endpoint URLs as root `data-*` attributes instead of hard-coding them in JavaScript.

Use real `<label>`, `<input type="search">`, `<select>`, and `<button>` elements. Include `aria-live` for request status and `aria-expanded` for sidebar/drawer controls.

- [ ] **Step 4: Verify GREEN**

Run:

```powershell
php artisan test tests/Feature/MapPageTest.php
```

Expected: all page contract tests pass.

### Task 6: Pure JavaScript Map Formatting and Popup Contracts

**Files:**

- Create: `resources/js/map/constants.js`
- Create: `resources/js/map/formatters.js`
- Create: `resources/js/map/popup.js`
- Create: `tests/js/map-formatters.test.js`
- Create: `tests/js/map-popup.test.js`
- Modify: `package.json`

**Interfaces:**

- Produces: `TYPE_META`, `escapeHtml(value)`, `formatLocation(station)`, `relativeTime(value, now)`, `telemetryRows(station)`, `buildPopup(station, now)`.

- [ ] **Step 1: Write failing formatter tests**

Use Node's `node:test` and strict assertions. Literal cases must prove:

```js
assert.equal(escapeHtml('<img onerror="x">'), '&lt;img onerror=&quot;x&quot;&gt;');
assert.equal(formatLocation({ regency_name: null, province_name: 'Jawa Barat' }), 'Jawa Barat');
assert.deepEqual(
  telemetryRows({ station_type: 'ARR', latest_reading: { rainfall: 0, rainfall_last_hour: null, intensity: 'Berawan' } }),
  [
    { label: 'Curah Hujan', value: '0 mm' },
    { label: 'Intensitas', value: 'Berawan' },
  ],
);
```

Cover AWLR, AWS, AWLR_ARR, FM, a null reading, an unknown type, and a fixed relative-time clock.

- [ ] **Step 2: Write failing popup tests**

Assert the HTML includes escaped station text, type/status badges, only non-null telemetry rows, a friendly no-telemetry message, and never emits literal `null` or `undefined`.

- [ ] **Step 3: Run and witness RED**

Run:

```powershell
npm run test:js
```

Expected: FAIL because the map modules do not exist.

- [ ] **Step 4: Implement the pure functions minimally**

Use mapping objects instead of nested type conditionals. Treat `0` as present and only omit `null`, `undefined`, and empty strings. `escapeHtml` must cover `&`, `<`, `>`, `"`, and `'`. Do not access the DOM or Leaflet in these modules.

- [ ] **Step 5: Verify GREEN**

Run:

```powershell
npm run test:js
```

Expected: all pure JavaScript tests pass with no warnings.

### Task 7: Interactive Leaflet Map, Filters, Clusters, and Controls

**Files:**

- Create: `resources/js/map/controls.js`
- Create: `resources/js/map/index.js`
- Modify: `resources/js/app.js`
- Modify: `tests/Feature/MapPageTest.php`

**Interfaces:**

- Consumes: DOM hooks from Task 5, formatter/popup functions from Task 6, and both JSON endpoints.
- Produces: working map initialization, current marker/result state, filter requests, search selection, sidebar/drawer interaction, layer switcher, reset/fit/fullscreen controls, and graceful API states.

- [ ] **Step 1: Extend the shell test for the interaction contract and witness RED**

Assert the Blade page exposes controls and states by accessible copy and stable IDs: type/status buttons, organization select, collapse button, mobile drawer button, loading text, empty text, error message container, station retry, summary retry, reset, fit, and fullscreen labels. Run `php artisan test tests/Feature/MapPageTest.php` and confirm failure before adding missing hooks.

- [ ] **Step 2: Implement map initialization**

Initialize at `[-2.5, 118]`, zoom `5`, with OSM Standard and OSM Humanitarian layers, attribution, zoom control, MarkerCluster, and a `Map<number, L.Marker>` marker index. Validate numeric coordinates again before marker creation and catch individual-record errors.

- [ ] **Step 3: Implement request and render flow**

Build query parameters from non-empty filters, debounce search, abort stale station requests, and independently request summary data. Render loading/empty/error states and retry actions. Replace cluster contents atomically after successful responses; do not erase the previous markers on a failed refresh.

- [ ] **Step 4: Implement station result navigation**

Render escaped station cards with type, organization, and text status. Event delegation reads a numeric station ID, finds the indexed marker, calls `flyTo(marker.getLatLng(), Math.max(map.getZoom(), 12))`, then opens its popup. Close the mobile drawer after selection and safely ignore stale IDs.

- [ ] **Step 5: Implement map and layout controls**

Use Leaflet controls for reset, fit current markers, and native Fullscreen API. Toggle one sidebar element between desktop panel and mobile drawer states. After layout transitions and fullscreen changes, call `map.invalidateSize()`.

- [ ] **Step 6: Verify static contracts and build**

Run:

```powershell
php artisan test tests/Feature/MapPageTest.php
npm run test:js
npm run build
```

Expected: all commands exit 0.

### Task 8: Monitoring Dashboard Styling and Responsive Polish

**Files:**

- Modify: `resources/css/app.css`
- Modify: `resources/views/map/index.blade.php`
- Modify: `resources/views/map/partials/header.blade.php`
- Modify: `resources/views/map/partials/sidebar.blade.php`
- Modify: `resources/views/map/partials/summary.blade.php`

**Interfaces:**

- Produces: modern white/slate/blue monitoring layout, locally styled type markers, popup cards, cluster bubbles, responsive drawer, and accessible focus/status presentation.

- [ ] **Step 1: Add the visual system without changing behavior**

Use Tailwind utilities for shell layout and a focused CSS component section for Leaflet popup chrome, marker pins, cluster bubbles, map controls, overlay cards, transitions, and map height. Use soft borders, restrained shadows, rounded corners, blue primary, green online, and red offline.

- [ ] **Step 2: Add responsive states**

Desktop shows a 360px sidebar that collapses to zero width. Mobile displays the same sidebar as a fixed drawer with backdrop. Summary cards become horizontally scrollable/compact on narrow viewports without hiding the map.

- [ ] **Step 3: Verify behavior did not regress**

Run:

```powershell
php artisan test
npm run test:js
npm run build
```

Expected: all tests and build pass.

### Task 9: Fresh Database and Operator Documentation

**Files:**

- Modify: `README.md`
- Modify: `.env.example`

**Interfaces:**

- Produces: copy-pasteable setup, development, test, build, and endpoint verification commands.

- [ ] **Step 1: Run the fresh database workflow**

Run:

```powershell
php artisan migrate:fresh --seed
php artisan tinker --execute="echo App\Models\Station::count();"
```

Expected: migrations and seeding exit 0; count prints `50`.

- [ ] **Step 2: Write concise README instructions**

Document:

```powershell
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
New-Item database/database.sqlite -ItemType File -Force
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Also document `npm run dev`, `php artisan test`, `npm run test:js`, the three public endpoints, fictional-data notice, OSM attribution/network requirement, and explicit MVP exclusions.

- [ ] **Step 3: Verify instructions from the current checkout**

Run the documented test/build commands exactly and correct documentation if any command differs from the actual scaffold.

### Task 10: Full Verification and Browser QA

**Files:**

- Modify only files required by a reproduced failing test or browser defect.

**Interfaces:**

- Produces: fresh evidence for every delivery claim.

- [ ] **Step 1: Run full automated verification**

Run:

```powershell
php artisan migrate:fresh --seed
php artisan test
npm run test:js
npm run build
php artisan route:list
```

Expected: migration/seed succeeds, exactly 50 stations are present, all PHP and JS tests pass, Vite exits 0, and route list includes `map`, `api/stations`, and `api/stations/summary` with GET/HEAD as appropriate.

- [ ] **Step 2: Start the application for HTTP and browser checks**

Run Laravel on a fixed local port and Vite only if required for development inspection. Use hidden/background execution and capture logs so the processes can be stopped cleanly.

- [ ] **Step 3: Verify HTTP contracts**

Check status and JSON for:

```text
GET /map
GET /api/stations
GET /api/stations?type=ARR
GET /api/stations?type=OTHER&status=offline
GET /api/stations?search=pos
GET /api/stations/summary
```

Expected: every request returns 200, station responses include only complete coordinates, and summary totals match the seeded database.

- [ ] **Step 4: Perform interactive desktop browser QA**

Verify map tiles, Indonesia default view, clustering, distinct markers, popup telemetry, search card fly-to/open-popup, every type/status/organization filter, reset, fit, fullscreen, sidebar collapse, summary cards, loading/empty/error presentation, and retry behavior. Inspect the browser console and network panel; record zero JavaScript errors.

- [ ] **Step 5: Perform interactive mobile browser QA**

At a phone-size viewport verify the drawer/backdrop, filter controls, station selection, popup visibility, summary card overflow, map resizing after drawer close, and touch-friendly controls. Inspect the console again.

- [ ] **Step 6: Reproduce and fix any defect test-first**

For each defect, add the smallest failing PHP or Node regression test when the behavior is automatable, witness the expected failure, implement the minimal fix, rerun the focused test, then rerun the full suite and browser check.

- [ ] **Step 7: Stop background processes and inspect final changes**

Stop only the application processes started for this task. Run `git status --short` and `git diff --check`; do not stage or commit. Report the implemented file structure, verification evidence, endpoints, and run commands, then stop at the MVP boundary.
