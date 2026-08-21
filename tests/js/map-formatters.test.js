import test from 'node:test';
import assert from 'node:assert/strict';

import { typeMeta } from '../../resources/js/map/constants.js';
import { escapeHtml, formatLocation, relativeTime, telemetryRows } from '../../resources/js/map/formatters.js';

test('escapeHtml encodes every dangerous HTML character', () => {
    assert.equal(escapeHtml(`<img onerror="x" data-x='y'>&`), '&lt;img onerror=&quot;x&quot; data-x=&#039;y&#039;&gt;&amp;');
});

test('formatLocation joins only available location parts', () => {
    assert.equal(formatLocation({ regency_name: null, province_name: 'Jawa Barat' }), 'Jawa Barat');
    assert.equal(formatLocation({ village_name: 'Suka Maju', district_name: null, regency_name: 'Bandung', province_name: 'Jawa Barat' }), 'Suka Maju, Bandung, Jawa Barat');
    assert.equal(formatLocation({}), 'Lokasi belum tersedia');
});

test('relativeTime uses a fixed clock and handles missing timestamps', () => {
    const now = new Date('2026-08-20T06:00:00Z');

    assert.equal(relativeTime('2026-08-20T05:55:00Z', now), '5 menit lalu');
    assert.equal(relativeTime('2026-08-20T05:59:45Z', now), 'Baru saja');
    assert.equal(relativeTime(null, now), 'Belum ada pembaruan');
});

test('ARR telemetry keeps numeric zero and omits null values', () => {
    assert.deepEqual(
        telemetryRows({
            station_type: 'ARR',
            latest_reading: { rainfall: 0, rainfall_last_hour: null, intensity: 'Berawan' },
        }),
        [
            { label: 'Curah Hujan', value: '0 mm' },
            { label: 'Intensitas', value: 'Berawan' },
        ],
    );
});

test('primary and FM telemetry use the requested labels and units', () => {
    assert.deepEqual(
        telemetryRows({ station_type: 'AWLR', latest_reading: { water_level: 1.58, warning_status: 'Normal' } }),
        [
            { label: 'Tinggi Muka Air', value: '1.58 m' },
            { label: 'Warning Status', value: 'Normal' },
        ],
    );
    assert.deepEqual(
        telemetryRows({ station_type: 'AWS', latest_reading: { temperature: 28.5, humidity: 74, pressure: 1012, wind_speed: 0.44, wind_direction: 'Timur Laut', rainfall: 0 } }),
        [
            { label: 'Suhu', value: '28.5 °C' },
            { label: 'Kelembapan', value: '74%' },
            { label: 'Tekanan Udara', value: '1012 hPa' },
            { label: 'Kecepatan Angin', value: '0.44 m/s' },
            { label: 'Arah Angin', value: 'Timur Laut' },
            { label: 'Curah Hujan', value: '0 mm' },
        ],
    );
    assert.deepEqual(
        telemetryRows({ station_type: 'AWLR_ARR', latest_reading: { water_level: 1.34, rainfall: 0, warning_status: 'Normal', intensity: null } }),
        [
            { label: 'Tinggi Muka Air', value: '1.34 m' },
            { label: 'Curah Hujan', value: '0 mm' },
            { label: 'Warning Status', value: 'Normal' },
        ],
    );
    assert.deepEqual(
        telemetryRows({ station_type: 'FM', latest_reading: { flow_rate: 22.38, flow_total: 57601.24, flow_month: null } }),
        [
            { label: 'Flow Rate', value: '22.38 m³/s' },
            { label: 'Flow Total', value: '57.601,24 m³' },
        ],
    );
});

test('telemetry and type metadata have safe fallbacks', () => {
    assert.deepEqual(telemetryRows({ station_type: 'ARR', latest_reading: null }), []);
    assert.equal(typeMeta('ARR').label, 'Pos Curah Hujan');
    assert.equal(typeMeta('UNLISTED').label, 'Station Lainnya');
});
