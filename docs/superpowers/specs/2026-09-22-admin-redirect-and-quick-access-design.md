# Design Spec: Admin Auth Redirection & Dashboard Quick-Access

- **Date:** 2026-09-22
- **Topic:** Auth Redirection & Admin Quick-Access on Public Website
- **Status:** Proposed

---

## 1. Background & Problem Statement

Currently:

1. When an authenticated admin visits `/login`, Laravel default redirects them to `/` (home page) instead of `/admin/dashboard`.
2. When an authenticated admin is browsing public company profile pages (Home, Products, Map, Articles, Tutorials, Internship), there is no visual indicator or quick link to return to `/admin/dashboard`. Admin has to manually type `/admin/dashboard` in the URL bar.
3. Unauthenticated guests are already properly blocked from `/admin/*` via `auth` and `prevent-back` middlewares.

## 2. Goals & Success Criteria

1. **Smart Guest Redirection:** Any authenticated user trying to access `/login` must be immediately redirected to `/admin/dashboard`.
2. **Unauthenticated Protection:** Any unauthenticated guest attempting to access `/admin/*` remains strictly redirected to `/login`.
3. **Admin Quick Access on Public Site:** When an admin is logged in and browsing public company profile pages, a prominent and elegant **"Dashboard Admin"** button/badge appears in the header and mobile drawer.
4. **Zero Regression:** All 65 existing tests must continue to pass without error.

---

## 3. Architecture & Technical Design

### A. Laravel 13 Native Middleware Redirection (`bootstrap/app.php`)

In Laravel 11/13, `Middleware::redirectTo` provides clean, native configuration for both guest and authenticated redirection without custom middleware clutter:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->redirectTo(
        guests: '/login',
        users: '/admin/dashboard',
    );
    // ...
})
```

- **`guests: '/login'`**: Ensures unauthenticated requests to protected `/admin/*` routes redirect to the login page.
- **`users: '/admin/dashboard'`**: Ensures authenticated users hitting guest-only routes (`/login`) are redirected straight to `/admin/dashboard`.

### B. UI/UX: Admin Dashboard Quick Access Button

In `resources/views/partials/header.blade.php`:
Wrap an admin button with Blade's `@auth` directive:

- **Desktop Header:** Positioned adjacent to the INAPROC badge. Styled with brand accent colors (`border-blue-500/40 bg-blue-50/80 dark:bg-blue-950/50 text-blue-700 dark:text-cyan-300`).
- **Mobile Drawer:** Positioned at the top of the mobile menu drawer so mobile admin users can easily navigate back to their admin panel with 1 tap.
- **Icon & Label:** Layout dashboard icon + "Dashboard Admin" label + glowing live pulse dot.

---

## 4. Verification Plan

1. **Automated Tests:** Run `php artisan test` (must pass 65/65).
2. **Feature Tests:**
    - Test guest accessing `/admin/dashboard` -> redirects to `/login`.
    - Test authenticated admin accessing `/login` -> redirects to `/admin/dashboard`.
    - Test public pages render the Dashboard Admin button when authenticated, and hide it when unauthenticated.
3. **Manual Verification:** Test in browser on both local and VPS.
