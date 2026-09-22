# Admin Auth Redirection & Dashboard Quick-Access Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Configure native Laravel 13 redirection for authenticated admins hitting guest routes to `/admin/dashboard` while keeping guests protected from `/admin/*`, and provide a prominent "@auth" Dashboard Admin button on public header navigation for quick panel access.

**Architecture:** Utilize Laravel 13's native `Middleware::redirectTo(guests: '/login', users: '/admin/dashboard')` in `bootstrap/app.php`. Update `resources/views/partials/header.blade.php` with an `@auth` button linking directly to `route('admin.dashboard')` on both desktop and mobile drawer views. Cover everything with automated feature tests.

**Architecture Diagram:**

```mermaid
graph TD
    subgraph "Guest Flow"
        G[Unauthenticated Guest] -->|Access /admin/*| MW1[auth Middleware]
        MW1 -->|Redirect 302| L[/login]
        G -->|Access /| P[Public Website]
        P -->|@guest| HideBtn[Hide Admin Button]
    end

    subgraph "Authenticated Admin Flow"
        A[Authenticated Admin] -->|Access /login| MW2[guest Middleware / redirectTo]
        MW2 -->|Redirect 302| D[/admin/dashboard]
        A -->|Access /| P
        P -->|@auth| ShowBtn[Show 'Dashboard Admin' Button]
        ShowBtn -->|Click| D
    end
```

**Tech Stack:** Laravel 13, Blade, Tailwind CSS v4, PHPUnit.

## Global Constraints

- Laravel 13.x native architecture (`bootstrap/app.php`)
- Strict PSR-4 naming (`App\Http\Controllers\Auth`)
- Backward compatible with all 65 existing tests
- Zero disruption to guest user experience on company profile pages

---

### Task 1: Configure Native Middleware Redirection & Automated Feature Tests

**Files:**

- Modify: `bootstrap/app.php`
- Create: `tests/Feature/AdminAuthRedirectionTest.php`

**Interfaces:**

- Consumes: `Illuminate\Foundation\Configuration\Middleware::redirectTo()`
- Produces: `guests -> /login`, `users -> /admin/dashboard`

- [ ] **Step 1: Write the failing feature test**

Create `tests/Feature/AdminAuthRedirectionTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthRedirectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_accessing_admin_dashboard_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_accessing_login_page_is_redirected_to_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/admin/dashboard');
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=AdminAuthRedirectionTest`
Expected: FAIL on `test_authenticated_admin_accessing_login_page_is_redirected_to_admin_dashboard` because Laravel default redirects to `/` instead of `/admin/dashboard`.

- [ ] **Step 3: Update `bootstrap/app.php`**

Modify `bootstrap/app.php` inside `withMiddleware`:

```php
        $middleware->redirectTo(
            guests: '/login',
            users: '/admin/dashboard',
        );
```

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=AdminAuthRedirectionTest`
Expected: PASS (2 passed).

- [ ] **Step 5: Commit**

```bash
git add bootstrap/app.php tests/Feature/AdminAuthRedirectionTest.php
git commit -m "feat(auth): configure native middleware redirect for guests and authenticated users"
```

---

### Task 2: Add "Dashboard Admin" Button to Public Header Navigation & Tests

**Files:**

- Modify: `resources/views/partials/header.blade.php:315-360`
- Create: `tests/Feature/AdminQuickAccessButtonTest.php`

**Interfaces:**

- Consumes: Blade `@auth` / `@endauth`, `route('admin.dashboard')`
- Produces: Responsive button in desktop header and mobile drawer

- [ ] **Step 1: Write the failing feature test**

Create `tests/Feature/AdminQuickAccessButtonTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQuickAccessButtonTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_header_does_not_render_admin_dashboard_button_for_guests(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee(route('admin.dashboard'));
        $response->assertDontSee('Dashboard Admin');
    }

    public function test_public_header_renders_admin_dashboard_button_for_authenticated_admin(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/');

        $response->assertOk();
        $response->assertSee(route('admin.dashboard'));
        $response->assertSee('Dashboard Admin');
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=AdminQuickAccessButtonTest`
Expected: FAIL on `test_public_header_renders_admin_dashboard_button_for_authenticated_admin` (cannot find Dashboard Admin).

- [ ] **Step 3: Implement Dashboard Admin Button in `resources/views/partials/header.blade.php`**

Add the `@auth` button next to INAPROC link in desktop view and inside the mobile drawer:

In Desktop Action area:

```blade
@auth
    <a href="{{ route('admin.dashboard') }}"
        class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-blue-500/40 bg-blue-50/80 dark:bg-blue-950/60 dark:border-cyan-500/40 text-blue-700 dark:text-cyan-300 hover:bg-blue-100 dark:hover:bg-blue-900/60 transition shadow-sm text-xs font-bold"
        aria-label="Panel Dashboard Admin">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <svg class="w-4 h-4 text-blue-600 dark:text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
            <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
            <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
            <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
        </svg>
        <span>Dashboard Admin</span>
    </a>
@endauth
```

In Mobile Drawer area:

```blade
@auth
    <div class="pb-2 mb-2 border-b border-slate-200/80 dark:border-slate-800">
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-blue-600 dark:bg-cyan-600 text-white font-bold text-xs shadow-sm">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                </svg>
                <span>Dashboard Admin</span>
            </span>
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        </a>
    </div>
@endauth
```

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=AdminQuickAccessButtonTest`
Expected: PASS (2 passed).

- [ ] **Step 5: Run full test suite**

Run: `php artisan test`
Expected: PASS (69 passed, 0 failures).

- [ ] **Step 6: Commit**

```bash
git add resources/views/partials/header.blade.php tests/Feature/AdminQuickAccessButtonTest.php
git commit -m "feat(ui): add responsive Dashboard Admin button in public header for authenticated users"
```
