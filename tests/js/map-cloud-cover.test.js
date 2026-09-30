import test from 'node:test';
import assert from 'node:assert/strict';

import { applyCloudCover } from '../../resources/js/map/cloud-cover.js';

test('cloud cover updates popup using station ID instead of response order', () => {
    const stationA = { id: 101, name: 'Station A' };
    const stationB = { id: 202, name: 'Station B' };
    const popupUpdates = [];
    const markers = new Map([
        [101, { setPopupContent: (content) => popupUpdates.push(['A', content]) }],
        [202, { setPopupContent: (content) => popupUpdates.push(['B', content]) }],
    ]);

    applyCloudCover(
        [stationA, stationB],
        { 202: 63, 101: 54 },
        markers,
        (station) => `${station.name}: ${station.cloud_cover}%`,
    );

    assert.equal(stationA.cloud_cover, 54);
    assert.equal(stationB.cloud_cover, 63);
    assert.deepEqual(popupUpdates, [['A', 'Station A: 54%'], ['B', 'Station B: 63%']]);
});

test('cloud cover updates accept zero and safely ignore missing or invalid values', () => {
    const clear = { id: 1 };
    const missing = { id: 2 };
    const invalid = { id: 3 };
    const popupUpdates = [];
    const markers = new Map([1, 2, 3].map((id) => [id, { setPopupContent: (content) => popupUpdates.push(content) }]));

    applyCloudCover(
        [clear, missing, invalid],
        { 1: 0, 3: null },
        markers,
        (station) => `${station.id}:${station.cloud_cover}%`,
    );

    assert.equal(clear.cloud_cover, 0);
    assert.equal(missing.cloud_cover, undefined);
    assert.equal(invalid.cloud_cover, undefined);
    assert.deepEqual(popupUpdates, ['1:0%']);
});
