# Sidebar Dynamic Menu Setup

This document explains the changes made to convert the hardcoded sidebar into a dynamic menu system, and how to use it.

## What was changed

1. `config/menu.php`
   - Added a centralized menu configuration array.
   - Menu items are defined as `section_label`, `dropdown`, or `link`.
   - Each item uses a unique `key` to support active highlighting.
   - Dropdowns define `child_keys` so the correct submenu stays expanded.

2. `app/Helpers/Sidebar.php`
   - Added a helper class that loads `config/menu.php`.
   - Renders the same HTML structure as the old sidebar.
   - Handles active link classes and expanded dropdowns automatically.

3. `app/Views/layouts/partials/_nav_2.php`
   - Replaced the hardcoded sidebar HTML with a call to the `Sidebar` helper.
   - Kept the partial file intact so the admin layout can continue to include it normally.

## How it works

- The sidebar is still rendered inside the partial `_nav_2.php`.
- The partial now uses `Sidebar::render()` to generate the menu from `config/menu.php`.
- The active page is controlled by the `$currentPage` value.

## How to use it

### 1. Set the current page key in the controller

In the controller that renders a view, define `$currentPage` and pass it to the view data.

Example:
```php
$data['currentPage'] = 'leave_overview';
return view('leave_overview', $data);
```

### 2. Keep the partial included in your layout

Your admin layout should still include the sidebar partial like this:
```php
<?= $this->include('layouts/partials/_nav_2') ?>
```

### 3. Add or change menu items in `config/menu.php`

To add a new top-level link:
```php
[
    'type'  => 'link',
    'label' => 'New Page',
    'icon'  => 'fa-newspaper',
    'route' => '/new-page',
    'key'   => 'new_page'
],
```

To add a new dropdown section:
```php
[
    'type'       => 'dropdown',
    'label'      => 'New Section',
    'icon'       => 'fa-folder',
    'key'        => 'new_section',
    'child_keys' => ['new_page', 'other_page'],
    'children'   => [
        ['label' => 'New Page', 'route' => '/new-page', 'key' => 'new_page'],
        ['label' => 'Other Page', 'route' => '/other-page', 'key' => 'other_page'],
    ]
],
```

### 4. Make sure `$currentPage` matches a menu item key

The active state depends on exact key matching. For example:
- `leave_overview`
- `leave_records`
- `departments`

## Testing checklist

- Open the page in the browser.
- Confirm the sidebar appears normally.
- Confirm the active item is highlighted.
- Confirm its parent dropdown is expanded.
- Confirm there are no PHP or HTML errors from the sidebar partial.

## Notes

- The partial `_nav_2.php` remains the sidebar partial.
- The admin layout simply includes that partial; no layout move was required.
- The dynamic sidebar is now configuration-driven, making future updates easier.

---

If you want, I can also add a small helper section for role-based menu visibility next.