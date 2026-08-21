import test from 'node:test';
import assert from 'node:assert/strict';

import { buildPopup } from '../../resources/js/map/popup.js';

const now = new Date('2026-08-20T06:00:00Z');

test('popup escapes API text and renders only available telemetry', () => {
    const html = buildPopup({
        name: '<img src=x onerror=alert(1)>',
        station_type: 'ARR',
        device_status: 'online',
        balai_name: 'Balai & Pantau',
        regency_name: 'Bandung',
        province_name: 'Jawa Barat',
        device_id: 'ARR-DUMMY-001',
        reading_at: '2026-08-20T05:55:00Z',
        latest_reading: { rainfall: 0, rainfall_last_hour: null, intensity: 'Berawan' },
    }, now);

    assert.match(html, /&lt;img src=x onerror=alert\(1\)&gt;/);
    assert.doesNotMatch(html, /<img src=x/);
    assert.match(html, /Balai &amp; Pantau/);
    assert.match(html, /Online/);
    assert.match(html, /ARR/);
    assert.match(html, /station-popup__category-icon/);
    assert.match(html, /station-popup__category-icon-svg/);
    assert.match(html, /0 mm/);
    assert.match(html, /Berawan/);
    assert.match(html, /5 menit lalu/);
    assert.doesNotMatch(html, /Curah Hujan 1 Jam/);
    assert.doesNotMatch(html, /null|undefined/);
});

test('popup stays useful when telemetry and regional fields are missing', () => {
    const html = buildPopup({
        name: 'Station Tanpa Telemetry',
        station_type: 'OSP',
        device_status: 'offline',
        balai_name: null,
        regency_name: null,
        province_name: null,
        device_id: null,
        reading_at: null,
        latest_reading: null,
    }, now);

    assert.match(html, /Offline/);
    assert.match(html, /Lokasi belum tersedia/);
    assert.match(html, /Data telemetry belum tersedia/);
    assert.match(html, /Belum ada pembaruan/);
    assert.doesNotMatch(html, /null|undefined/);
});
