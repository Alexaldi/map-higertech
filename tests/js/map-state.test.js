import test from 'node:test';
import assert from 'node:assert/strict';

import { applyFilterDraft, buildStationCard, buildStationQuery, buildStationSuggestions, focusStationMarker, hasValidCoordinates, setStationPanelOpen } from '../../resources/js/map/state.js';

const fakeElement = (initialClasses = []) => {
    const classes = new Set(initialClasses);
    const attributes = new Map();

    return {
        classList: {
            contains: (name) => classes.has(name),
            toggle: (name, force) => {
                if (force) classes.add(name);
                else classes.delete(name);
            },
        },
        getAttribute: (name) => attributes.get(name) ?? null,
        setAttribute: (name, value) => attributes.set(name, String(value)),
    };
};

test('buildStationQuery includes only active filters and encodes their values', () => {
    assert.equal(
        buildStationQuery({ search: 'PCH A&B', type: 'ARR', status: '', organization: 'BTN BARAT' }),
        'search=PCH+A%26B&type=ARR&organization=BTN+BARAT',
    );
    assert.equal(buildStationQuery({ search: '  ', type: '', status: '', organization: '' }), '');
});

test('applyFilterDraft preserves live search while committing staged filters', () => {
    assert.deepEqual(
        applyFilterDraft(
            { search: 'PCH Bandung', type: 'ARR', status: 'online', organization: 'BBWS-A' },
            { type: 'AWS', status: 'offline', organization: 'BBWS-B' },
        ),
        { search: 'PCH Bandung', type: 'AWS', status: 'offline', organization: 'BBWS-B' },
    );
});

test('buildStationSuggestions prioritizes matching station names and limits results', () => {
    const stations = [
        { id: 1, name: 'PCH Bandung 01' },
        { id: 2, name: 'AWLR Jambi 02' },
        { id: 3, name: 'Pos PCH Bandung Selatan' },
        { id: 4, name: 'AWS Ambon 04' },
    ];

    assert.deepEqual(
        buildStationSuggestions(stations, 'bandung', 2).map((station) => station.id),
        [1, 3],
    );
    assert.deepEqual(buildStationSuggestions(stations, '  ', 5), []);
    assert.deepEqual(buildStationSuggestions([{ id: 9 }], 'pos', 5), []);
});

test('hasValidCoordinates accepts finite numbers and rejects incomplete records', () => {
    assert.equal(hasValidCoordinates({ latitude: -6.2, longitude: 106.8 }), true);
    assert.equal(hasValidCoordinates({ latitude: '-6.2', longitude: '106.8' }), true);
    assert.equal(hasValidCoordinates({ latitude: null, longitude: 106.8 }), false);
    assert.equal(hasValidCoordinates({ latitude: -6.2, longitude: undefined }), false);
    assert.equal(hasValidCoordinates({ latitude: 'bukan-koordinat', longitude: 106.8 }), false);
});

test('buildStationCard renders escaped category, location, device, update time, and textual status', () => {
    const html = buildStationCard({
        id: 17,
        name: '<script>alert(1)</script>',
        station_type: 'AWLR',
        balai_name: 'Balai & Sungai',
        regency_name: 'Bandung',
        province_name: 'Jawa Barat',
        device_id: 'AWLR-NUS-017',
        device_status: 'offline',
        reading_at: '2026-08-20T12:00:00+07:00',
    }, new Date('2026-08-20T12:05:00+07:00'));

    assert.match(html, /data-station-id="17"/);
    assert.match(html, /class="station-card__logo"/);
    assert.match(html, /station-card__logo-svg/);
    assert.match(html, /&lt;script&gt;alert\(1\)&lt;\/script&gt;/);
    assert.doesNotMatch(html, /<script>/);
    assert.match(html, /Pos Duga Air/);
    assert.match(html, /AWLR/);
    assert.match(html, /Balai &amp; Sungai/);
    assert.match(html, /Bandung, Jawa Barat/);
    assert.match(html, /AWLR-NUS-017/);
    assert.match(html, /5 menit lalu/);
    assert.match(html, /Offline/);
});

test('buildStationCard keeps missing optional station details useful', () => {
    const html = buildStationCard({ id: 18, station_type: 'ARR', device_status: 'online' });

    assert.match(html, /Station tanpa nama/);
    assert.match(html, /Instansi belum tersedia/);
    assert.match(html, /Lokasi belum tersedia/);
    assert.match(html, /Belum ada pembaruan/);
    assert.doesNotMatch(html, /undefined|null/);
});

test('buildStationCard remains safe when passed directly to Array.map', () => {
    const stations = [{
        id: 19,
        name: 'PCH Array Callback',
        station_type: 'ARR',
        device_status: 'online',
        reading_at: '2026-08-20T12:00:00+07:00',
    }];

    assert.doesNotThrow(() => stations.map(buildStationCard));
});

test('focusStationMarker does not depend on a cluster callback to fly and open', () => {
    const events = [];
    let onMoveEnd;
    const marker = {
        getLatLng: () => ({ lat: -6.2, lng: 106.8 }),
        openPopup: () => events.push('open-popup'),
    };
    const map = {
        getZoom: () => 5,
        once: (event, callback) => {
            events.push(`listen-${event}`);
            onMoveEnd = callback;
        },
        flyTo: () => events.push('fly-to'),
    };
    focusStationMarker(map, marker);
    assert.deepEqual(events, ['listen-moveend zoomend', 'fly-to']);

    onMoveEnd();
    onMoveEnd();
    assert.deepEqual(events, ['listen-moveend zoomend', 'fly-to', 'open-popup']);
});

test('setStationPanelOpen keeps panel, launchers, and backdrop in one accessible state', () => {
    const panel = fakeElement();
    const desktopLauncher = fakeElement();
    const mobileLauncher = fakeElement();
    const backdrop = fakeElement(['hidden']);
    const controls = { panel, launchers: [desktopLauncher, mobileLauncher], backdrop };

    setStationPanelOpen(controls, true);

    assert.equal(panel.classList.contains('is-open'), true);
    assert.equal(panel.getAttribute('aria-hidden'), 'false');
    assert.equal(backdrop.classList.contains('hidden'), false);
    assert.equal(desktopLauncher.getAttribute('aria-expanded'), 'true');
    assert.equal(mobileLauncher.getAttribute('aria-expanded'), 'true');

    setStationPanelOpen(controls, false);

    assert.equal(panel.classList.contains('is-open'), false);
    assert.equal(panel.getAttribute('aria-hidden'), 'true');
    assert.equal(backdrop.classList.contains('hidden'), true);
    assert.equal(desktopLauncher.getAttribute('aria-expanded'), 'false');
    assert.equal(mobileLauncher.getAttribute('aria-expanded'), 'false');
});
