<?php

namespace App\Helpers;

/**
 * Sidebar Helper
 * 
 * Renders the sidebar menu dynamically based on the menu configuration
 * and the current page key.
 */
class Sidebar
{
    protected string $currentKey;
    protected array $menu;

    public function __construct(string $currentKey = '', array $menu = null)
    {
        $this->currentKey = $currentKey;
        $this->menu = $menu ?? require __DIR__ . '/../../config/menu.php';
    }

    /**
     * Render the entire menu
     */
    public function render(): string
    {
        $html = '';
        foreach ($this->menu as $item) {
            $type = $item['type'] ?? 'link';
            switch ($type) {
                case 'section_label':
                    $html .= $this->renderSectionLabel($item['label']);
                    break;
                case 'dropdown':
                    $html .= $this->renderDropdown($item);
                    break;
                case 'link':
                    $html .= $this->renderLink($item);
                    break;
            }
        }
        return $html;
    }

    /**
     * Render a section label divider
     */
    protected function renderSectionLabel(string $label): string
    {
        return <<<HTML
        <li class="nav-item"><!-- label-->
            <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                <div class="col-auto navbar-vertical-label">$label</div>
                <div class="col ps-0"><hr class="mb-0 navbar-vertical-divider" /></div>
            </div>
        </li>
        HTML;
    }

    /**
     * Render a single link
     */
    protected function renderLink(array $item): string
    {
        $active = ($this->currentKey === $item['key']) ? 'active' : '';
        $icon = $item['icon'] ?? '';
        $iconHtml = $icon ? "<span class=\"nav-link-icon\"><span class=\"fas {$icon}\"></span></span>" : '';
        
        return <<<HTML
        <li class="nav-item"><!-- parent pages-->
            <a class="nav-link {$active}" href="{$item['route']}" role="button">
                <div class="d-flex align-items-center">
                    {$iconHtml}
                    <span class="nav-link-text ps-1">{$item['label']}</span>
                </div>
            </a><!-- parent pages-->
        </li>
        HTML;
    }

    /**
     * Render a dropdown menu with children
     */
    protected function renderDropdown(array $item): string
    {
        $childKeys = $item['child_keys'] ?? array_column($item['children'] ?? [], 'key');
        $isActive = in_array($this->currentKey, $childKeys);
        $collapsedClass = $isActive ? '' : 'collapsed';
        $showClass = $isActive ? 'show' : '';
        $expanded = $isActive ? 'true' : 'false';
        $icon = $item['icon'] ?? '';
        $iconHtml = $icon ? "<span class=\"nav-link-icon\"><span class=\"fas {$icon}\"></span></span>" : '';
        $key = $item['key'];

        $childrenHtml = '';
        if (!empty($item['children'])) {
            foreach ($item['children'] as $child) {
                $childActive = ($this->currentKey === $child['key']) ? 'active' : '';
                $childrenHtml .= <<<HTML
                <li class="nav-item"><a class="nav-link {$childActive}" href="{$child['route']}">
                    <div class="d-flex align-items-center"><span class="nav-link-text ps-1">{$child['label']}</span></div>
                </a><!-- more inner pages--></li>
                HTML;
            }
        }

        return <<<HTML
        <li class="nav-item"><!-- parent pages-->
            <a class="nav-link dropdown-indicator {$collapsedClass}" href="#{$key}" role="button"
               data-bs-toggle="collapse" aria-expanded="{$expanded}" aria-controls="{$key}">
                <div class="d-flex align-items-center">
                    {$iconHtml}
                    <span class="nav-link-text ps-1">{$item['label']}</span>
                </div>
            </a>
            <ul class="nav collapse {$showClass}" id="{$key}">
                {$childrenHtml}
            </ul>
        </li><!-- parent pages-->
        HTML;
    }
}
