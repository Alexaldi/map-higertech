# Navbar and Station List Refresh Design

**Date:** 2026-08-20  
**Status:** Approved in chat  
**Project root:** `C:\Users\Aspire 7\Documents\ChatGPT\map-higertech`

## Goal

Bring the `/map` navigation closer to the supplied Higertech homepage reference and make station results easier to scan without changing the dummy-data prototype or adding unrelated features.

## Approved Direction

- Use the two user-supplied PNG files only for the Higertech and INAPROC navbar brands.
- Keep the locally created station-category SVG pictograms; do not copy marker assets from the reference website.
- Use category pictograms instead of station-photo thumbnails because the prototype has no authentic station photos.
- Increase the desktop sidebar from 360 px to 420 px and the mobile drawer up to 420 px while preserving its collapse/drawer behavior.
- Expand each result card with the station name, full category label and code, status, balai, regency/province, device ID when available, and relative update time.
- Add a compact marker legend for the four primary categories: ARR, AWLR, AWS, and AWLR + ARR.

## Navbar Layout

Desktop keeps two horizontal rows. The upper indigo row contains social and contact links. The larger white row uses the supplied Higertech logo at the left, navigation links in the middle, and the supplied INAPROC logo plus an EN/ID language pill at the right. Online/offline totals remain visible as compact monitoring indicators without competing with the brand navigation.

At narrower widths, the top bar is hidden and the white row becomes a compact header with the Higertech logo, filter button, and navigation menu. External navigation links remain marked as external and existing accessibility labels are retained.

## Station Cards

Cards use the existing `TYPE_META` color and `stationIconSvg()` pictogram so every category remains visually related to its telemetry purpose. The icon grows to a 48 px visual tile. Content remains null-safe and escaped before insertion into HTML.

The location is assembled from regency and province only for compactness. Missing location, device ID, or reading time uses the existing safe formatter behavior and never produces an empty row or JavaScript error.

## Marker Legend

The legend is ordinary Blade markup with empty icon slots populated from the existing JavaScript icon registry. This reuses one icon source for markers, result cards, popups, and the legend. On small screens the legend remains compact and does not obstruct the filter drawer or basemap gallery.

## Verification

- Laravel feature tests verify that the supplied brand image URLs and marker legend are present in the rendered page.
- Node tests verify the richer station-card output, escaping, missing-data fallbacks, and deterministic relative time.
- The full Laravel and JavaScript suites, Pint, and Vite production build must pass.
- Browser QA covers desktop and mobile layout, station-card selection, marker popup, legend, navbar assets, and console errors.

## Boundary

This refresh does not use the Higertech station API, add real station photographs, change the 200 seeded dummy stations, add authentication/admin/CMS, or introduce new frontend dependencies. No commit, push, or pull request is performed without explicit approval.
