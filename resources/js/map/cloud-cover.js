export const applyCloudCover = (stations, cloudCovers, markers, buildPopup) => {
    if (!Array.isArray(stations) || !cloudCovers || typeof cloudCovers !== 'object' || Array.isArray(cloudCovers)) return;

    for (const station of stations) {
        const stationId = Number(station.id);
        const key = String(station.id);
        if (!Number.isFinite(stationId) || !Object.hasOwn(cloudCovers, key)) continue;

        const value = cloudCovers[key];
        if (typeof value !== 'number' || !Number.isFinite(value) || value < 0 || value > 100) continue;

        station.cloud_cover = value;
        const marker = markers?.get(stationId);
        if (marker && typeof buildPopup === 'function') {
            marker.setPopupContent(buildPopup(station));
        }
    }
};
