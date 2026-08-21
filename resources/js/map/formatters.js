const HTML_ENTITIES = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
};

const TELEMETRY_FIELDS = {
    ARR: [
        ['rainfall', 'Curah Hujan', ' mm'],
        ['rainfall_last_hour', 'Curah Hujan 1 Jam', ' mm'],
        ['intensity', 'Intensitas'],
    ],
    AWLR: [
        ['water_level', 'Tinggi Muka Air', ' m'],
        ['warning_status', 'Warning Status'],
    ],
    AWS: [
        ['temperature', 'Suhu', ' °C'],
        ['humidity', 'Kelembapan', '%'],
        ['pressure', 'Tekanan Udara', ' hPa'],
        ['wind_speed', 'Kecepatan Angin', ' m/s'],
        ['wind_direction', 'Arah Angin'],
        ['rainfall', 'Curah Hujan', ' mm'],
        ['solar_radiation', 'Radiasi Matahari', ' W/m²'],
    ],
    AWLR_ARR: [
        ['water_level', 'Tinggi Muka Air', ' m'],
        ['rainfall', 'Curah Hujan', ' mm'],
        ['warning_status', 'Warning Status'],
        ['intensity', 'Intensitas'],
    ],
    AGWLR: [
        ['groundwater_level', 'Muka Air Tanah', ' m'],
        ['battery_voltage', 'Tegangan Baterai', ' V'],
    ],
    FM: [
        ['flow_rate', 'Flow Rate', ' m³/s'],
        ['flow_total', 'Flow Total', ' m³', true],
        ['flow_month', 'Flow Bulanan', ' m³', true],
    ],
    EWS: [
        ['warning_status', 'Warning Status'],
        ['signal_strength', 'Kekuatan Sinyal', '%'],
    ],
    AVWR: [
        ['gate_opening', 'Bukaan Pintu', ' m'],
        ['water_level', 'Tinggi Muka Air', ' m'],
    ],
    WQ: [
        ['ph', 'pH'],
        ['turbidity', 'Kekeruhan', ' NTU'],
        ['dissolved_oxygen', 'Oksigen Terlarut', ' mg/L'],
    ],
    VNOTCH: [
        ['discharge', 'Debit', ' m³/s'],
        ['water_height', 'Tinggi Air', ' m'],
    ],
    OW: [
        ['observation_value', 'Nilai Observasi', ' m'],
        ['condition', 'Kondisi'],
    ],
    OSP: [
        ['pump_status', 'Status Pompa'],
        ['discharge', 'Debit', ' m³/s'],
    ],
};

const isPresent = (value) => value !== null && value !== undefined && value !== '';

export const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => HTML_ENTITIES[character]);

export const formatLocation = (station = {}) => {
    const location = [station.village_name, station.district_name, station.regency_name, station.province_name]
        .filter(isPresent)
        .join(', ');

    return location || 'Lokasi belum tersedia';
};

export const relativeTime = (value, now = new Date()) => {
    if (!value) return 'Belum ada pembaruan';

    const reading = new Date(value);
    if (Number.isNaN(reading.getTime())) return 'Belum ada pembaruan';

    const seconds = Math.max(0, Math.floor((now.getTime() - reading.getTime()) / 1000));
    if (seconds < 60) return 'Baru saja';
    if (seconds < 3600) return `${Math.floor(seconds / 60)} menit lalu`;
    if (seconds < 86400) return `${Math.floor(seconds / 3600)} jam lalu`;
    if (seconds < 2592000) return `${Math.floor(seconds / 86400)} hari lalu`;

    return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }).format(reading);
};

export const telemetryRows = (station = {}) => {
    const reading = station.latest_reading;
    if (!reading || typeof reading !== 'object' || Array.isArray(reading)) return [];

    return (TELEMETRY_FIELDS[station.station_type] ?? [])
        .filter(([key]) => isPresent(reading[key]))
        .map(([key, label, unit = '', localize = false]) => {
            const raw = reading[key];
            const value = localize && typeof raw === 'number'
                ? new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 }).format(raw)
                : String(raw);

            return { label, value: `${value}${unit}` };
        });
};
