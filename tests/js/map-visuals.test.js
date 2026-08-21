import test from 'node:test';
import assert from 'node:assert/strict';

import * as constants from '../../resources/js/map/constants.js';

test('every supported station type renders a distinct inline SVG pictogram', () => {
    assert.equal(typeof constants.stationIconSvg, 'function');

    const icons = Object.keys(constants.TYPE_META).map((type) => constants.stationIconSvg(type));

    assert.equal(icons.length, 12);
    assert.equal(new Set(icons).size, 12);
    for (const icon of icons) {
        assert.match(icon, /^<svg /);
        assert.match(icon, /aria-hidden="true"/);
        assert.doesNotMatch(icon, /<img|https?:\/\//);
    }
});

test('stationLegendHtml explains every supported category with a local pictogram', () => {
    assert.equal(typeof constants.stationLegendHtml, 'function');

    const html = constants.stationLegendHtml();

    for (const type of Object.keys(constants.TYPE_META)) {
        assert.match(html, new RegExp(`data-legend-type="${type}"`));
    }

    assert.equal((html.match(/data-legend-type=/g) ?? []).length, 12);
    assert.match(html, /Pos Curah Hujan/);
    assert.match(html, /Pos Duga Air/);
    assert.match(html, /Pos Klimatologi/);
    assert.match(html, /Early Warning System/);
    assert.match(html, /Kualitas Air/);
    assert.match(html, /map-legend__icon-svg/);
    assert.doesNotMatch(html, /Station Lainnya|>Lainnya</);
    assert.doesNotMatch(html, /<img|https?:\/\//);
});

test('stationTypeSummaryHtml renders all type counts and uses zero for missing values', () => {
    assert.equal(typeof constants.stationTypeSummaryHtml, 'function');

    const html = constants.stationTypeSummaryHtml({ ARR: 18, FM: 7 });

    assert.equal((html.match(/data-summary-type=/g) ?? []).length, 12);
    assert.match(html, /data-summary-type="ARR"[\s\S]*?>18</);
    assert.match(html, /data-summary-type="FM"[\s\S]*?>7</);
    assert.match(html, /data-summary-type="OSP"[\s\S]*?>0</);
});

test('basemap registry offers six keyless map styles including non-Google satellite', () => {
    assert.equal(Array.isArray(constants.BASEMAPS), true);
    assert.deepEqual(constants.BASEMAPS.map(({ key }) => key), [
        'street',
        'humanitarian',
        'topographic',
        'light',
        'dark',
        'satellite',
    ]);

    const satellite = constants.BASEMAPS.at(-1);
    assert.match(satellite.url, /s2cloudless/i);
    assert.doesNotMatch(satellite.url, /google|api[_-]?key|token/i);
    assert.match(satellite.attribution, /Sentinel|EOX/i);
});
