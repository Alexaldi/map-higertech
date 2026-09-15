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
      btnLight.classList.remove('bg-white', 'shadow-xs', 'border', 'border-white/20', 'text-slate-900', 'font-bold');
      btnLight.classList.add('bg-transparent', 'text-slate-300');
      btnDark.classList.add('bg-cyan-600', 'border', 'border-cyan-400/40', 'text-white', 'font-bold');
      btnDark.classList.remove('bg-transparent', 'text-slate-300');
    } else {
      btnLight.classList.add('bg-white', 'shadow-xs', 'border', 'border-white/20', 'text-slate-900', 'font-bold');
      btnLight.classList.remove('bg-transparent', 'text-slate-300');
      btnDark.classList.remove('bg-cyan-600', 'border', 'border-cyan-400/40', 'text-white', 'font-bold');
      btnDark.classList.add('bg-transparent', 'text-slate-300');
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
