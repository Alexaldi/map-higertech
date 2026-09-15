/**
 * Theme Switcher — Higertech
 * Default: system preference (prefers-color-scheme)
 * Override: stored in localStorage as 'higertech_theme' ('dark' | 'light')
 */

const STORAGE_KEY = 'higertech_theme';

/**
 * Apply theme to <html> element.
 * Called immediately (inline in <head>) to prevent flash of wrong theme.
 */
export function applyTheme() {
  const saved = localStorage.getItem(STORAGE_KEY);
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isDark = saved === 'dark' || (saved === null && prefersDark);
  document.documentElement.classList.toggle('dark', isDark);
  return isDark ? 'dark' : 'light';
}

/**
 * Set theme manually and persist to localStorage.
 * Pass null to clear override and revert to system default.
 */
export function setTheme(theme) {
  if (theme === null) {
    localStorage.removeItem(STORAGE_KEY);
  } else {
    localStorage.setItem(STORAGE_KEY, theme);
  }
  applyTheme();
  syncThemeButtons();
}

/**
 * Sync the visual state of theme toggle buttons.
 */
export function syncThemeButtons() {
  const isDark = document.documentElement.classList.contains('dark');
  const btnLight = document.getElementById('btn-theme-light');
  const btnDark = document.getElementById('btn-theme-dark');

  if (btnLight && btnDark) {
    if (isDark) {
      btnLight.className = 'flex items-center gap-1 px-2.5 py-1 rounded-md text-slate-400 hover:text-white bg-transparent transition-all duration-150 text-xs font-semibold';
      btnDark.className = 'flex items-center gap-1 px-2.5 py-1 rounded-md text-white bg-cyan-600 border border-cyan-400/40 shadow-xs transition-all duration-150 text-xs font-bold';
    } else {
      btnLight.className = 'flex items-center gap-1 px-2.5 py-1 rounded-md text-slate-900 bg-white shadow-xs border border-slate-300/80 transition-all duration-150 text-xs font-bold';
      btnDark.className = 'flex items-center gap-1 px-2.5 py-1 rounded-md text-slate-600 hover:text-slate-900 bg-transparent transition-all duration-150 text-xs font-semibold';
    }
  }
}

/**
 * Listen for OS-level preference changes (e.g., user switches Windows to dark mode).
 * Only applies when no manual override is stored.
 */
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
  if (!localStorage.getItem(STORAGE_KEY)) {
    document.documentElement.classList.toggle('dark', e.matches);
    syncThemeButtons();
  }
});

// Expose to window for inline onclick attributes in Blade templates
window.setTheme = setTheme;

// Auto-sync button state setiap halaman selesai dimuat
document.addEventListener('DOMContentLoaded', () => {
    syncThemeButtons();
});
