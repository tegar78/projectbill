<?php
/**
 * @var array $stats
 * @var array $unmapped_stats
 * @var array $customer
 * @var array $coverage
 */
$stats = isset($stats) && is_array($stats) ? $stats : [
    'total' => 0,
    'aktif' => 0,
    'isolir' => 0,
    'non_aktif' => 0,
    'menunggu' => 0,
    'free' => 0,
    'unmapped' => isset($customer) && is_array($customer) ? count($customer) : 0
];
?>
<!-- Load Leaflet Plugins -->
<link rel="stylesheet" href="<?= base_url('assets/backend/leaflet-search/leaflet-search.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/backend/leaflet-markercluster/MarkerCluster.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/backend/leaflet-markercluster/MarkerCluster.Default.css') ?>" />

<script src="<?= base_url('assets/backend/leaflet-search/leaflet-search.js') ?>"></script>
<script src="<?= base_url('assets/backend/leaflet-markercluster/leaflet.markercluster.js') ?>"></script>

<style>
    /* ==========================================================================
       MAPS LOCATION AUTHENTIC NEUMORPHISM (SOFT UI) SYSTEM
       ========================================================================== */

    /* Card Wrapper: Raised Soft UI Canvas */
    .maps-card-wrapper {
        border-radius: var(--nm-radius-lg, 22px);
        background: var(--nm-bg, #e6ecf4);
        box-shadow: var(--nm-raised, 8px 8px 16px var(--nm-shadow-dark), -8px -8px 16px var(--nm-shadow-light));
        border: 1px solid rgba(255, 255, 255, 0.65);
        overflow: hidden;
        margin-bottom: 1.75rem;
        transition: box-shadow 0.25s ease, transform 0.25s ease;
    }

    html.dark-mode .maps-card-wrapper {
        background: var(--nm-bg, #111625);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: var(--nm-raised, 6px 6px 14px var(--nm-shadow-dark), -6px -6px 14px var(--nm-shadow-light));
    }

    /* Header Bar: Smooth Surface with Soft Divider */
    .maps-header-bar {
        padding: 1.1rem 1.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.85rem;
        border-bottom: 1px solid var(--nm-shadow-dark, #b8c4d4);
        background: var(--nm-bg, #e6ecf4);
    }

    html.dark-mode .maps-header-bar {
        background: var(--nm-bg, #111625);
        border-bottom-color: rgba(255, 255, 255, 0.06);
    }

    /* Tactile Neumorphic Header Icon Well */
    .nm-header-icon-well {
        width: 44px;
        height: 44px;
        border-radius: var(--nm-radius-md, 14px);
        background: var(--nm-bg, #e6ecf4);
        box-shadow: var(--nm-raised-sm, 4px 4px 8px var(--nm-shadow-dark), -4px -4px 8px var(--nm-shadow-light));
        border: 1px solid rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    html.dark-mode .nm-header-icon-well {
        background: var(--nm-bg, #111625);
        border-color: rgba(255, 255, 255, 0.06);
    }

    /* Quick Counter Badges: Raised Soft UI Pills */
    .nm-stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: var(--nm-radius-pill, 9999px);
        background: var(--nm-bg, #e6ecf4);
        box-shadow: var(--nm-raised-xs, 2px 2px 5px var(--nm-shadow-dark), -2px -2px 5px var(--nm-shadow-light));
        border: 1px solid rgba(255, 255, 255, 0.65);
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--nm-text-main, #141d2b);
        user-select: none;
    }

    html.dark-mode .nm-stat-pill {
        background: var(--nm-bg, #111625);
        border-color: rgba(255, 255, 255, 0.06);
        color: var(--nm-text-main, #f8fafc);
    }

    /* Toolbar: Neumorphic Control Surface */
    .maps-toolbar {
        padding: 0.9rem 1.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.85rem;
        background: var(--nm-bg, #e6ecf4);
        border-bottom: 1px solid var(--nm-shadow-dark, #b8c4d4);
    }

    html.dark-mode .maps-toolbar {
        background: var(--nm-bg, #111625);
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }

    /* Status Filter Chips: Tactile Soft Buttons */
    .filter-chips-group {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 15px;
        border-radius: var(--nm-radius-pill, 9999px);
        font-size: 0.81rem;
        font-weight: 700;
        cursor: pointer;
        background: var(--nm-bg, #e6ecf4);
        color: var(--nm-text-main, #141d2b);
        box-shadow: var(--nm-raised-xs, 2px 2px 5px var(--nm-shadow-dark), -2px -2px 5px var(--nm-shadow-light));
        border: 1px solid rgba(255, 255, 255, 0.65);
        transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }

    html.dark-mode .filter-chip {
        background: var(--nm-bg, #111625);
        border-color: rgba(255, 255, 255, 0.05);
        color: var(--nm-text-main, #f8fafc);
    }

    .filter-chip:hover {
        box-shadow: var(--nm-raised-sm, 4px 4px 8px var(--nm-shadow-dark), -4px -4px 8px var(--nm-shadow-light));
        transform: translateY(-1px);
        color: var(--nm-brand, #f47b20);
    }

    /* Active / Selected: Tactile Debossed Inset Well */
    .filter-chip.active {
        background: var(--nm-bg, #e6ecf4) !important;
        box-shadow: var(--nm-inset-sm, inset 2px 2px 5px var(--nm-shadow-dark), inset -2px -2px 5px var(--nm-shadow-light)) !important;
        border-color: rgba(0, 0, 0, 0.06) !important;
        transform: translateY(1px);
        color: var(--nm-accent-blue, #2563eb) !important;
        font-weight: 800;
    }

    html.dark-mode .filter-chip.active {
        background: var(--nm-bg, #111625) !important;
        border-color: rgba(255, 255, 255, 0.04) !important;
    }

    .filter-chip.chip-aktif.active {
        color: #059669 !important;
    }

    .filter-chip.chip-isolir.active {
        color: #d97706 !important;
    }

    .filter-chip.chip-nonaktif.active {
        color: #dc2626 !important;
    }

    .filter-chip.chip-menunggu.active {
        color: #4b5563 !important;
    }

    .filter-chip.chip-free.active {
        color: #0891b2 !important;
    }

    .filter-chip .chip-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .filter-chip .chip-count {
        background: var(--nm-bg, #e6ecf4);
        box-shadow: var(--nm-inset-sm, inset 1px 1px 3px var(--nm-shadow-dark), inset -1px -1px 3px var(--nm-shadow-light));
        padding: 2px 8px;
        border-radius: var(--nm-radius-pill, 9999px);
        font-size: 0.73rem;
        font-weight: 700;
    }

    html.dark-mode .filter-chip .chip-count {
        background: var(--nm-bg, #111625);
    }

    .filter-chip.active .chip-count {
        box-shadow: var(--nm-raised-xs, 2px 2px 4px var(--nm-shadow-dark), -2px -2px 4px var(--nm-shadow-light));
        background: var(--nm-bg, #e6ecf4);
    }

    html.dark-mode .filter-chip.active .chip-count {
        background: var(--nm-bg, #111625);
    }

    /* Neumorphic Tool / Action Buttons */
    .map-tool-btn {
        padding: 7px 15px;
        border-radius: var(--nm-radius-sm, 10px);
        font-size: 0.81rem;
        font-weight: 700;
        background: var(--nm-bg, #e6ecf4);
        color: var(--nm-text-main, #141d2b);
        box-shadow: var(--nm-raised-xs, 2px 2px 5px var(--nm-shadow-dark), -2px -2px 5px var(--nm-shadow-light));
        border: 1px solid rgba(255, 255, 255, 0.65);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }

    html.dark-mode .map-tool-btn {
        background: var(--nm-bg, #111625);
        border-color: rgba(255, 255, 255, 0.05);
        color: var(--nm-text-main, #f8fafc);
    }

    .map-tool-btn:hover {
        box-shadow: var(--nm-raised-sm, 4px 4px 8px var(--nm-shadow-dark), -4px -4px 8px var(--nm-shadow-light));
        transform: translateY(-1px);
        color: var(--nm-brand, #f47b20);
    }

    .map-tool-btn:active {
        box-shadow: var(--nm-inset-sm, inset 2px 2px 5px var(--nm-shadow-dark), inset -2px -2px 5px var(--nm-shadow-light));
        transform: translateY(1px);
    }

    .map-tool-btn.active-tool {
        background: var(--nm-bg, #e6ecf4);
        box-shadow: var(--nm-inset-sm, inset 2px 2px 5px var(--nm-shadow-dark), inset -2px -2px 5px var(--nm-shadow-light));
        color: var(--nm-brand, #f47b20) !important;
        font-weight: 800;
        border-color: rgba(244, 123, 32, 0.35);
    }

    html.dark-mode .map-tool-btn.active-tool {
        background: var(--nm-bg, #111625);
        border-color: rgba(244, 123, 32, 0.4);
    }

    /* Harmonized Tool Icons */
    .map-tool-btn .map-tool-icon {
        font-size: 0.85rem;
        color: var(--nm-text-muted, #64748b);
        transition: color 0.15s ease, transform 0.15s ease;
    }

    html.dark-mode .map-tool-btn .map-tool-icon {
        color: #94a3b8;
    }

    .map-tool-btn:hover .map-tool-icon {
        color: var(--nm-brand, #f47b20);
        transform: scale(1.12);
    }

    .map-tool-btn.active-tool .map-tool-icon {
        color: var(--nm-brand, #f47b20) !important;
    }

    /* Map Screen Console Bezel Frame */
    .map-screen-frame {
        padding: 14px 18px 18px 18px;
        background: var(--nm-bg, #e6ecf4);
    }

    html.dark-mode .map-screen-frame {
        background: var(--nm-bg, #111625);
    }

    .map-screen-inner {
        border-radius: var(--nm-radius-lg, 18px);
        box-shadow: var(--nm-inset, inset 4px 4px 10px var(--nm-shadow-dark), inset -4px -4px 10px var(--nm-shadow-light));
        padding: 6px;
        background: var(--nm-bg, #e6ecf4);
        border: 1px solid rgba(255, 255, 255, 0.45);
    }

    html.dark-mode .map-screen-inner {
        background: var(--nm-bg, #111625);
        border-color: rgba(255, 255, 255, 0.04);
    }

    #map {
        width: 100%;
        height: 560px;
        border-radius: calc(var(--nm-radius-lg, 18px) - 6px);
        overflow: hidden;
        z-index: 1;
        background: #cbd5e1;
    }

    html.dark-mode #map {
        background: #090c14;
    }

    @media (max-width: 768px) {
        #map {
            height: 420px;
        }
        .maps-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-chips-group {
            overflow-x: auto;
            padding-bottom: 4px;
        }
    }

    /* Map Loading Overlay */
    .map-loading-overlay {
        position: absolute;
        top: 6px;
        left: 6px;
        right: 6px;
        bottom: 6px;
        border-radius: calc(var(--nm-radius-lg, 18px) - 6px);
        background: rgba(230, 236, 244, 0.88);
        backdrop-filter: blur(4px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 999;
        transition: opacity 0.3s ease;
    }

    html.dark-mode .map-loading-overlay {
        background: rgba(17, 22, 37, 0.92);
        color: #e2e8f0;
    }

    /* Custom High-DPI Vector Pin Markers */
    .custom-svg-pin {
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.38));
        transform: translateZ(0);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }

    .custom-svg-pin svg {
        overflow: visible;
        display: block;
    }

    .custom-svg-pin:hover {
        transform: scale(1.22) translateY(-4px);
        z-index: 9999 !important;
    }

    /* Custom Marker Clustering Colors & Safe Inner Transform (Coordinates Never Shift!) */
    .marker-cluster {
        background-clip: padding-box;
        border-radius: 50%;
        cursor: pointer !important;
    }
    .marker-cluster div {
        width: 30px;
        height: 30px;
        margin-left: 5px;
        margin-top: 5px;
        text-align: center;
        border-radius: 50%;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        line-height: 30px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
        transition: transform 0.18s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.18s ease;
        cursor: pointer !important;
    }
    .marker-cluster span {
        cursor: pointer !important;
        user-select: none;
    }
    /* Hover scale is applied ONLY to the inner circle div so Leaflet's translate3d coordinates never get overridden */
    .marker-cluster:hover div {
        transform: scale(1.15);
        box-shadow: 0 5px 14px rgba(0, 0, 0, 0.35);
    }
    .marker-cluster-small {
        background-color: rgba(16, 185, 129, 0.28) !important;
    }
    .marker-cluster-small div {
        background-color: #10b981 !important;
        color: #fff !important;
    }
    .marker-cluster-medium {
        background-color: rgba(245, 158, 11, 0.28) !important;
    }
    .marker-cluster-medium div {
        background-color: #f59e0b !important;
        color: #fff !important;
    }
    .marker-cluster-large {
        background-color: rgba(59, 130, 246, 0.28) !important;
    }
    .marker-cluster-large div {
        background-color: #3b82f6 !important;
        color: #fff !important;
    }

    /* ==========================================================================
       CRISP HIGH-DPI VECTOR LEAFLET CONTROLS (Zero Blurry Raster PNGs)
       ========================================================================== */

    .leaflet-bar,
    .leaflet-control-layers,
    .leaflet-control-zoom {
        background: var(--nm-bg, #e6ecf4) !important;
        box-shadow: var(--nm-raised-sm, 4px 4px 8px var(--nm-shadow-dark), -4px -4px 8px var(--nm-shadow-light)) !important;
        border: 1px solid rgba(255, 255, 255, 0.65) !important;
        border-radius: var(--nm-radius-sm, 10px) !important;
        overflow: hidden !important;
    }

    html.dark-mode .leaflet-bar,
    html.dark-mode .leaflet-control-layers,
    html.dark-mode .leaflet-control-zoom {
        background: var(--nm-bg, #111625) !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
    }

    .leaflet-bar a {
        background: var(--nm-bg, #e6ecf4) !important;
        color: var(--nm-text-main, #141d2b) !important;
        border-bottom: 1px solid var(--nm-shadow-dark, #b8c4d4) !important;
        transition: all 0.15s ease !important;
    }

    html.dark-mode .leaflet-bar a {
        background: var(--nm-bg, #111625) !important;
        color: var(--nm-text-main, #f8fafc) !important;
        border-bottom-color: rgba(255, 255, 255, 0.08) !important;
    }

    .leaflet-bar a:last-child {
        border-bottom: none !important;
    }

    .leaflet-bar a:hover {
        background: var(--nm-bg, #e6ecf4) !important;
        color: var(--nm-brand, #f47b20) !important;
    }

    .leaflet-bar a:active {
        box-shadow: var(--nm-inset-sm) !important;
    }

    /* Zoom Buttons - Crisp Typography & Alignment */
    .leaflet-control-zoom-in,
    .leaflet-control-zoom-out {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 34px !important;
        height: 34px !important;
        line-height: 34px !important;
        font-size: 19px !important;
        font-weight: 700 !important;
        color: var(--nm-text-main, #141d2b) !important;
        text-decoration: none !important;
        -webkit-font-smoothing: antialiased;
    }

    html.dark-mode .leaflet-control-zoom-in,
    html.dark-mode .leaflet-control-zoom-out {
        color: var(--nm-text-main, #f8fafc) !important;
    }

    /* Fullscreen Control Button - Crystal Clear FontAwesome Vector Icon */
    .leaflet-control-fullscreen {
        border-radius: var(--nm-radius-sm, 10px) !important;
        margin-top: 8px !important;
    }

    .leaflet-control-fullscreen a,
    .leaflet-control-fullscreen-button {
        background-image: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 34px !important;
        height: 34px !important;
        line-height: 34px !important;
        text-decoration: none !important;
        border-bottom: none !important;
    }

    .leaflet-control-fullscreen a::after,
    .leaflet-control-fullscreen-button::after {
        content: '\f065'; /* FontAwesome fa-expand */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 14px;
        color: var(--nm-text-main, #141d2b);
        display: inline-block;
        line-height: 1;
        transition: color 0.15s ease, transform 0.15s ease;
    }

    html.dark-mode .leaflet-control-fullscreen a::after,
    html.dark-mode .leaflet-control-fullscreen-button::after {
        color: var(--nm-text-main, #f8fafc);
    }

    .leaflet-control-fullscreen a:hover::after,
    .leaflet-control-fullscreen-button:hover::after {
        color: var(--nm-brand, #f47b20);
        transform: scale(1.15);
    }

    .leaflet-fullscreen-on .leaflet-control-fullscreen a::after,
    .leaflet-fullscreen-on .leaflet-control-fullscreen-button::after {
        content: '\f066'; /* FontAwesome fa-compress */
        color: var(--nm-brand, #f47b20);
    }

    /* Leaflet Layers Toggle - Crystal Clear FontAwesome Vector Icon */
    .leaflet-control-layers-toggle {
        background-image: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 38px !important;
        height: 38px !important;
        text-decoration: none !important;
        cursor: pointer !important;
    }

    .leaflet-control-layers-toggle::after {
        content: '\f5fd'; /* FontAwesome fa-layer-group */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 16px;
        color: var(--nm-brand, #f47b20);
        display: inline-block;
        line-height: 1;
        transition: transform 0.2s ease, color 0.15s ease;
    }

    .leaflet-control-layers-toggle:hover::after {
        transform: scale(1.18);
        color: #e06a10;
    }

    .leaflet-control-layers-expanded {
        padding: 12px 16px !important;
        color: var(--nm-text-main) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
    }

    /* Search Control - Crystal Clear FontAwesome Vector Icons */
    .leaflet-control-search {
        background: var(--nm-bg, #e6ecf4) !important;
        border-radius: var(--nm-radius-sm, 10px) !important;
        box-shadow: var(--nm-raised-sm, 4px 4px 8px var(--nm-shadow-dark), -4px -4px 8px var(--nm-shadow-light)) !important;
        border: 1px solid rgba(255, 255, 255, 0.65) !important;
        overflow: visible !important;
        margin-top: 8px !important;
    }

    html.dark-mode .leaflet-control-search {
        background: var(--nm-bg, #111625) !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
    }

    .leaflet-control-search .search-input {
        background: var(--nm-bg, #e6ecf4) !important;
        box-shadow: var(--nm-inset-sm) !important;
        border: 1px solid rgba(255, 255, 255, 0.35) !important;
        border-radius: 8px !important;
        color: var(--nm-text-main) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
    }

    html.dark-mode .leaflet-control-search .search-input {
        background: var(--nm-bg, #111625) !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }

    .leaflet-control-search .search-button {
        background-image: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 34px !important;
        height: 34px !important;
        line-height: 34px !important;
        text-decoration: none !important;
        cursor: pointer !important;
        background-color: transparent !important;
        border: none !important;
    }

    .leaflet-control-search .search-button::after {
        content: '\f002'; /* FontAwesome fa-search */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 13px;
        color: var(--nm-text-main, #141d2b);
        display: inline-block;
        line-height: 1;
        transition: color 0.15s ease, transform 0.15s ease;
    }

    html.dark-mode .leaflet-control-search .search-button::after {
        color: var(--nm-text-main, #f8fafc);
    }

    .leaflet-control-search .search-button:hover::after {
        color: var(--nm-brand, #f47b20);
        transform: scale(1.15);
    }

    .leaflet-control-search .search-cancel {
        background-image: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 22px !important;
        height: 22px !important;
        right: 36px !important;
        top: 6px !important;
        text-decoration: none !important;
        cursor: pointer !important;
    }

    .leaflet-control-search .search-cancel::after {
        content: '\f00d'; /* FontAwesome fa-times */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 12px;
        color: #ef4444;
        display: inline-block;
        line-height: 1;
    }

    /* Neumorphic Leaflet Popup */
    .leaflet-popup-content-wrapper {
        border-radius: var(--nm-radius-lg, 18px) !important;
        padding: 0 !important;
        overflow: hidden !important;
        box-shadow: var(--nm-raised-lg, 12px 12px 24px var(--nm-shadow-dark), -12px -12px 24px var(--nm-shadow-light)) !important;
        border: 1px solid rgba(255, 255, 255, 0.65) !important;
        background: var(--nm-bg, #e6ecf4) !important;
        color: var(--nm-text-main) !important;
    }

    html.dark-mode .leaflet-popup-content-wrapper {
        background: var(--nm-bg, #111625) !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
        color: #f1f5f9;
    }

    .leaflet-popup-content {
        margin: 0 !important;
        line-height: 1.4 !important;
        min-width: 280px;
        max-width: 320px;
    }

    .cust-popup-header {
        padding: 12px 16px;
        background: var(--nm-bg, #e6ecf4);
        border-bottom: 1px solid var(--nm-shadow-dark, #b8c4d4);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    html.dark-mode .cust-popup-header {
        background: var(--nm-bg, #111625);
        border-bottom-color: rgba(255, 255, 255, 0.06);
    }

    .cust-popup-header h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--nm-text-main);
    }

    .cust-popup-body {
        padding: 12px 16px;
        font-size: 0.82rem;
        background: var(--nm-bg, #e6ecf4);
    }

    html.dark-mode .cust-popup-body {
        background: var(--nm-bg, #111625);
    }

    .cust-popup-row {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid rgba(184, 196, 212, 0.25);
    }

    html.dark-mode .cust-popup-row {
        border-bottom-color: rgba(255, 255, 255, 0.06);
    }

    .cust-popup-row .label {
        color: var(--nm-text-muted, #4b5b70);
        font-weight: 600;
    }

    html.dark-mode .cust-popup-row .label {
        color: #94a3b8;
    }

    .cust-popup-row .val {
        font-weight: 700;
        text-align: right;
        color: var(--nm-text-main, #141d2b);
    }

    html.dark-mode .cust-popup-row .val {
        color: #f8fafc;
    }

    .cust-popup-actions {
        padding: 10px 16px;
        background: var(--nm-bg, #e6ecf4);
        border-top: 1px solid var(--nm-shadow-dark, #b8c4d4);
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    html.dark-mode .cust-popup-actions {
        background: var(--nm-bg, #111625);
        border-top-color: rgba(255, 255, 255, 0.06);
    }

    /* DataTables in Neumorphism */
    #dataTable_wrapper .dataTables_length,
    #dataTable_wrapper .dataTables_filter {
        color: var(--nm-text-muted);
        font-weight: 700;
        font-size: 0.82rem;
        margin-bottom: 12px;
    }

    #dataTable_wrapper .dataTables_filter input,
    #dataTable_wrapper .dataTables_length select {
        background-color: var(--nm-bg, #e6ecf4) !important;
        color: var(--nm-text-main, #141d2b) !important;
        box-shadow: var(--nm-inset-sm, inset 2px 2px 5px var(--nm-shadow-dark), inset -2px -2px 5px var(--nm-shadow-light)) !important;
        border: 1px solid rgba(255, 255, 255, 0.45) !important;
        border-radius: var(--nm-radius-sm, 10px) !important;
        padding: 5px 12px !important;
        margin-left: 6px;
        outline: none !important;
        font-weight: 600;
    }

    html.dark-mode #dataTable_wrapper .dataTables_filter input,
    html.dark-mode #dataTable_wrapper .dataTables_length select {
        background-color: var(--nm-bg, #111625) !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
        color: var(--nm-text-main, #f8fafc) !important;
    }

    #dataTable_wrapper table.table {
        border-collapse: separate !important;
        border-spacing: 0 4px !important;
        border: none !important;
        background: transparent !important;
    }

    #dataTable_wrapper table.table thead th {
        border: none !important;
        border-bottom: 2px solid var(--nm-shadow-dark, #b8c4d4) !important;
        color: var(--nm-text-muted, #4b5b70) !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        font-size: 0.78rem !important;
        letter-spacing: 0.05em !important;
        padding: 12px 10px !important;
        background: transparent !important;
    }

    html.dark-mode #dataTable_wrapper table.table thead th {
        border-bottom-color: rgba(255, 255, 255, 0.08) !important;
    }

    #dataTable_wrapper table.table tbody tr {
        transition: all 0.15s ease;
        border-radius: 8px;
    }

    #dataTable_wrapper table.table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.45) !important;
        box-shadow: var(--nm-raised-xs, 2px 2px 5px var(--nm-shadow-dark), -2px -2px 5px var(--nm-shadow-light));
    }

    html.dark-mode #dataTable_wrapper table.table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    #dataTable_wrapper table.table tbody td {
        border: none !important;
        border-top: 1px solid rgba(184, 196, 212, 0.25) !important;
        padding: 12px 10px !important;
        vertical-align: middle !important;
        color: var(--nm-text-main) !important;
        font-size: 0.85rem !important;
    }

    html.dark-mode #dataTable_wrapper table.table tbody td {
        border-top-color: rgba(255, 255, 255, 0.04) !important;
    }

    #dataTable_wrapper .dataTables_info {
        color: var(--nm-text-muted) !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        padding-top: 14px !important;
    }

    #dataTable_wrapper .dataTables_paginate {
        padding-top: 10px !important;
    }

    #dataTable_wrapper .dataTables_paginate .paginate_button {
        background-color: var(--nm-bg, #e6ecf4) !important;
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        box-shadow: var(--nm-raised-xs, 2px 2px 5px var(--nm-shadow-dark), -2px -2px 5px var(--nm-shadow-light)) !important;
        border-radius: var(--nm-radius-sm, 8px) !important;
        margin: 0 3px !important;
        padding: 5px 12px !important;
        color: var(--nm-text-main, #141d2b) !important;
        font-weight: 700 !important;
        font-size: 0.82rem !important;
        transition: all 0.15s ease !important;
    }

    html.dark-mode #dataTable_wrapper .dataTables_paginate .paginate_button {
        background-color: var(--nm-bg, #111625) !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
        color: var(--nm-text-main, #f8fafc) !important;
    }

    #dataTable_wrapper .dataTables_paginate .paginate_button:hover {
        box-shadow: var(--nm-raised-sm) !important;
        color: var(--nm-brand) !important;
        transform: translateY(-1px);
    }

    #dataTable_wrapper .dataTables_paginate .paginate_button.current,
    #dataTable_wrapper .dataTables_paginate .paginate_button.active {
        background-color: var(--nm-bg, #e6ecf4) !important;
        box-shadow: var(--nm-inset-sm, inset 2px 2px 5px var(--nm-shadow-dark), inset -2px -2px 5px var(--nm-shadow-light)) !important;
        color: var(--nm-brand, #f47b20) !important;
        font-weight: 800 !important;
        border-color: rgba(0, 0, 0, 0.05) !important;
    }

    /* Modal Quick Picker Map */
    #picker-map {
        width: 100%;
        height: 360px;
        border-radius: var(--nm-radius-md, 14px);
        box-shadow: var(--nm-inset-sm);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    /* Modal Neumorphism Overrides */
    .nm-modal-content {
        background-color: var(--nm-bg, #e6ecf4) !important;
        border-radius: var(--nm-radius-lg, 22px) !important;
        box-shadow: var(--nm-raised-lg, 12px 12px 24px var(--nm-shadow-dark), -12px -12px 24px var(--nm-shadow-light)) !important;
        border: 1px solid rgba(255, 255, 255, 0.65) !important;
        overflow: hidden !important;
    }

    html.dark-mode .nm-modal-content {
        background-color: var(--nm-bg, #111625) !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
    }

    .nm-modal-header {
        padding: 1.1rem 1.4rem;
        background: var(--nm-bg, #e6ecf4);
        border-bottom: 1px solid var(--nm-shadow-dark, #b8c4d4);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    html.dark-mode .nm-modal-header {
        background: var(--nm-bg, #111625);
        border-bottom-color: rgba(255, 255, 255, 0.06);
    }

    .nm-modal-footer {
        padding: 0.9rem 1.4rem;
        background: var(--nm-bg, #e6ecf4);
        border-top: 1px solid var(--nm-shadow-dark, #b8c4d4);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    html.dark-mode .nm-modal-footer {
        background: var(--nm-bg, #111625);
        border-top-color: rgba(255, 255, 255, 0.06);
    }

    /* Tactile Status Pill Badges */
    .nm-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 11px;
        border-radius: var(--nm-radius-pill, 9999px);
        font-size: 0.77rem;
        font-weight: 700;
        box-shadow: var(--nm-raised-xs, 2px 2px 4px var(--nm-shadow-dark), -2px -2px 4px var(--nm-shadow-light));
        border: 1px solid rgba(255, 255, 255, 0.55);
        user-select: none;
    }

    html.dark-mode .nm-pill-badge {
        border-color: rgba(255, 255, 255, 0.06);
    }

    .nm-pill-badge-aktif {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
    }

    html.dark-mode .nm-pill-badge-aktif {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
    }

    .nm-pill-badge-isolir {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    html.dark-mode .nm-pill-badge-isolir {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
    }

    .nm-pill-badge-nonaktif {
        background: rgba(239, 68, 68, 0.12);
        color: #dc2626;
    }

    html.dark-mode .nm-pill-badge-nonaktif {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
    }

    .nm-pill-badge-menunggu {
        background: rgba(100, 116, 139, 0.12);
        color: #475569;
    }

    html.dark-mode .nm-pill-badge-menunggu {
        background: rgba(100, 116, 139, 0.2);
        color: #94a3b8;
    }

    .nm-pill-badge-free {
        background: rgba(6, 182, 212, 0.12);
        color: #0891b2;
    }

    html.dark-mode .nm-pill-badge-free {
        background: rgba(6, 182, 212, 0.2);
        color: #22d3ee;
    }

    /* Tactile Monospace Code Pill */
    .nm-badge-code {
        display: inline-block;
        padding: 3px 8px;
        border-radius: var(--nm-radius-sm, 8px);
        background: var(--nm-bg, #e6ecf4);
        box-shadow: var(--nm-inset-xs, inset 1px 1px 3px var(--nm-shadow-dark), inset -1px -1px 3px var(--nm-shadow-light));
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--nm-text-main, #141d2b);
        border: 1px solid rgba(255, 255, 255, 0.45);
    }

    html.dark-mode .nm-badge-code {
        background: var(--nm-bg, #111625);
        border-color: rgba(255, 255, 255, 0.05);
        color: var(--nm-text-main, #f8fafc);
    }
</style>

<!-- Main Container -->
<div class="row">
    <div class="col-12">

        <!-- Card: Maps Location Pelanggan -->
        <div class="maps-card-wrapper position-relative">

            <!-- Header Bar -->
            <div class="maps-header-bar">
                <div class="d-flex align-items-center">
                    <div class="nm-header-icon-well mr-3">
                        <i class="fas fa-map-marked-alt text-primary"></i>
                    </div>
                    <div>
                        <h6 class="m-0 font-weight-bold" style="color: var(--nm-text-main, #1e293b);">Maps Location Pelanggan</h6>
                        <small class="text-muted">Visualisasi sebaran posisi GPS seluruh pelanggan dan coverage area</small>
                    </div>
                </div>

                <!-- Quick Counter Badges -->
                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <div class="nm-stat-pill" title="Total Pelanggan Ditandai">
                        <i class="fas fa-map-pin text-primary"></i>
                        <strong id="stat-total"><?= $stats['total'] ?></strong> Ditandai
                    </div>
                    <div class="nm-stat-pill" title="Pelanggan Belum Ada Koordinat">
                        <i class="fas fa-exclamation-circle text-warning"></i>
                        <strong id="stat-unmapped"><?= $stats['unmapped'] ?></strong> Belum Ditandai
                    </div>
                </div>
            </div>

            <!-- Toolbar: Status Filters & Map Actions -->
            <div class="maps-toolbar">
                <!-- Filter Status Chips -->
                <div class="filter-chips-group">
                    <span class="text-muted mr-1 d-none d-md-inline" style="font-size: 0.8rem; font-weight: 600;">Status:</span>
                    <div class="filter-chip active" data-filter="all" onclick="filterByStatus('all')">
                        <span>Semua</span>
                        <span class="chip-count" id="count-all"><?= $stats['total'] ?></span>
                    </div>
                    <div class="filter-chip chip-aktif" data-filter="Aktif" onclick="filterByStatus('Aktif')">
                        <span class="chip-dot" style="background: #10b981;"></span>
                        <span>Aktif</span>
                        <span class="chip-count" id="count-aktif"><?= $stats['aktif'] ?></span>
                    </div>
                    <div class="filter-chip chip-isolir" data-filter="Isolir" onclick="filterByStatus('Isolir')">
                        <span class="chip-dot" style="background: #f59e0b;"></span>
                        <span>Isolir</span>
                        <span class="chip-count" id="count-isolir"><?= $stats['isolir'] ?></span>
                    </div>
                    <div class="filter-chip chip-nonaktif" data-filter="Non-Aktif" onclick="filterByStatus('Non-Aktif')">
                        <span class="chip-dot" style="background: #ef4444;"></span>
                        <span>Non-Aktif</span>
                        <span class="chip-count" id="count-non_aktif"><?= $stats['non_aktif'] ?></span>
                    </div>
                    <div class="filter-chip chip-menunggu" data-filter="Menunggu" onclick="filterByStatus('Menunggu')">
                        <span class="chip-dot" style="background: #64748b;"></span>
                        <span>Menunggu</span>
                        <span class="chip-count" id="count-menunggu"><?= $stats['menunggu'] ?></span>
                    </div>
                    <div class="filter-chip chip-free" data-filter="Free" onclick="filterByStatus('Free')">
                        <span class="chip-dot" style="background: #06b6d4;"></span>
                        <span>Free</span>
                        <span class="chip-count" id="count-free"><?= $stats['free'] ?></span>
                    </div>
                </div>

                <!-- Map Action Buttons (Clean & Grouped) -->
                <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                    <div class="d-inline-flex align-items-center" style="gap: 6px;" role="group" aria-label="Navigasi Peta">
                        <button type="button" class="map-tool-btn" onclick="fitAllMarkers()" title="Pusatkan Tampilan ke Seluruh Marker Pelanggan">
                            <i class="fas fa-expand-arrows-alt map-tool-icon"></i>
                            <span>Pusatkan</span>
                        </button>
                        <button type="button" class="map-tool-btn" onclick="locateUserPosition()" title="Deteksi Lokasi GPS Saya Saat Ini">
                            <i class="fas fa-crosshairs map-tool-icon"></i>
                            <span>Lokasi Saya</span>
                        </button>
                    </div>
                    <div class="d-inline-flex align-items-center" style="gap: 6px;" role="group" aria-label="Layer Peta">
                        <button type="button" class="map-tool-btn" id="btn-coverage-toggle" onclick="toggleCoverageOverlay()" title="Tampilkan/Sembunyikan Radius Coverage Area">
                            <i class="fas fa-broadcast-tower map-tool-icon"></i>
                            <span>Coverage</span>
                        </button>
                        <button type="button" class="map-tool-btn" id="btn-sync-toggle" onclick="toggleSyncFilter()" title="Sinkronkan Filter Status Peta & Tabel">
                            <i class="fas fa-link map-tool-icon"></i>
                            <span>Sync Tabel</span>
                        </button>
                    </div>
                    <button type="button" class="map-tool-btn px-2" onclick="reloadMapData(true)" title="Muat Ulang Data Maps">
                        <i class="fas fa-sync-alt map-tool-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Map Screen Console Bezel Frame -->
            <div class="map-screen-frame">
                <div class="map-screen-inner position-relative">
                    <div id="map"></div>

                    <div id="map-loader" class="map-loading-overlay">
                        <div class="spinner-border text-primary mb-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="font-weight-bold" style="font-size: 0.85rem; color: var(--nm-text-main, #141d2b);">Memuat Data Peta Pelanggan...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Data Pelanggan yang Belum Ditandai Maps -->
        <?php if (!empty($customer) && count($customer) > 0) { ?>
            <div class="maps-card-wrapper mt-3">
                <div class="maps-header-bar">
                    <div class="d-flex align-items-center">
                        <div class="nm-header-icon-well mr-3">
                            <i class="fas fa-map-marker-alt text-warning"></i>
                        </div>
                        <div>
                            <h6 class="m-0 font-weight-bold" style="color: var(--nm-text-main, #1e293b);">Data Pelanggan yang Belum Ditandai Maps</h6>
                            <small class="text-muted">Pelanggan di bawah ini belum memiliki titik koordinat GPS. Klik tombol <b>Tandai</b> untuk menentukan posisi pelanggan.</small>
                        </div>
                    </div>
                    <div>
                        <span class="nm-stat-pill" style="color: #d97706;" id="table-unmapped-count">
                            <i class="fas fa-users mr-1"></i> <strong><?= count($customer) ?></strong> Pelanggan
                        </span>
                    </div>
                </div>

                <!-- Table Filter Toolbar: Status & Coverage -->
                <div class="maps-toolbar">
                    <div class="d-flex align-items-center flex-wrap justify-content-between w-100" style="gap: 10px;">
                        <!-- Status Filter Chips for Table -->
                        <div class="filter-chips-group">
                            <span class="text-muted mr-1 d-none d-sm-inline" style="font-size: 0.8rem; font-weight: 600;">
                                <i class="fas fa-filter text-primary mr-1"></i> Filter Status:
                            </span>
                            <div class="filter-chip tbl-filter-chip active" data-status="all" onclick="filterTableByStatus('all')">
                                <span>Semua</span>
                                <span class="chip-count" id="tbl-count-all"><?= $unmapped_stats['total'] ?? count($customer) ?></span>
                            </div>
                            <div class="filter-chip tbl-filter-chip chip-aktif" data-status="Aktif" onclick="filterTableByStatus('Aktif')">
                                <span class="chip-dot" style="background: #10b981;"></span>
                                <span>Aktif</span>
                                <span class="chip-count" id="tbl-count-aktif"><?= $unmapped_stats['aktif'] ?? 0 ?></span>
                            </div>
                            <div class="filter-chip tbl-filter-chip chip-isolir" data-status="Isolir" onclick="filterTableByStatus('Isolir')">
                                <span class="chip-dot" style="background: #f59e0b;"></span>
                                <span>Isolir</span>
                                <span class="chip-count" id="tbl-count-isolir"><?= $unmapped_stats['isolir'] ?? 0 ?></span>
                            </div>
                            <div class="filter-chip tbl-filter-chip chip-nonaktif" data-status="Non-Aktif" onclick="filterTableByStatus('Non-Aktif')">
                                <span class="chip-dot" style="background: #ef4444;"></span>
                                <span>Non-Aktif</span>
                                <span class="chip-count" id="tbl-count-nonaktif"><?= $unmapped_stats['non_aktif'] ?? 0 ?></span>
                            </div>
                            <div class="filter-chip tbl-filter-chip chip-menunggu" data-status="Menunggu" onclick="filterTableByStatus('Menunggu')">
                                <span class="chip-dot" style="background: #64748b;"></span>
                                <span>Menunggu</span>
                                <span class="chip-count" id="tbl-count-menunggu"><?= $unmapped_stats['menunggu'] ?? 0 ?></span>
                            </div>
                            <div class="filter-chip tbl-filter-chip chip-free" data-status="Free" onclick="filterTableByStatus('Free')">
                                <span class="chip-dot" style="background: #06b6d4;"></span>
                                <span>Free</span>
                                <span class="chip-count" id="tbl-count-free"><?= $unmapped_stats['free'] ?? 0 ?></span>
                            </div>
                        </div>

                        <!-- Coverage Filter Dropdown & Reset -->
                        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                            <span class="text-muted d-none d-md-inline" style="font-size: 0.8rem; font-weight: 600;">
                                <i class="fas fa-broadcast-tower text-info mr-1"></i> Area:
                            </span>
                            <select id="filter-table-coverage" class="form-control form-control-sm" style="width: auto; min-width: 160px; font-weight: 600; font-size: 0.82rem;" onchange="filterTableByCoverage(this.value)">
                                <option value="">Semua Area Coverage</option>
                                <?php if (!empty($coverage)) {
                                    foreach ($coverage as $cov) { ?>
                                        <option value="<?= htmlspecialchars($cov->c_name) ?>"><?= htmlspecialchars($cov->c_name) ?></option>
                                <?php }
                                } ?>
                            </select>
                            <button type="button" class="map-tool-btn" onclick="resetTableFilters()" title="Reset Filter Tabel">
                                <i class="fas fa-undo mr-1"></i> <span>Reset</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-3">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr style="text-align: center;">
                                    <th style="width: 25px;">No</th>
                                    <th>No Layanan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>No Telp.</th>
                                    <th>Status</th>
                                    <th>Coverage Area</th>
                                    <th>Alamat</th>
                                    <th style="width: 140px; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($customer as $r => $data) { ?>
                                    <tr id="unmapped-row-<?= $data->customer_id ?>">
                                        <td class="text-center font-weight-bold"><?= $no++ ?>.</td>
                                        <td>
                                            <span class="nm-badge-code"><?= $data->no_services ?></span>
                                        </td>
                                        <td class="font-weight-bold" style="color: var(--nm-text-main, #1e293b);"><?= htmlspecialchars($data->name) ?></td>
                                        <td>
                                            <?php $waNum = format_whatsapp_number($data->no_wa); ?>
                                            <?php if (!empty($waNum)) { ?>
                                                <a href="https://wa.me/<?= $waNum ?>" target="_blank" class="text-success text-decoration-none font-weight-bold">
                                                    <i class="fab fa-whatsapp mr-1"></i> <?= indo_tlp($data->no_wa) ?>
                                                </a>
                                            <?php } else { ?>
                                                <span class="text-muted">-</span>
                                            <?php } ?>
                                        </td>
                                        <?php
                                        $is_isolir = ((int)($data->connection ?? 0) === 1 || strtolower(trim($data->c_status ?? '')) === 'isolir');
                                        $display_status = $is_isolir ? 'Isolir' : ($data->c_status ?? 'Aktif');
                                        $st = strtolower(trim($display_status));
                                        $badgeClass = 'nm-pill-badge-menunggu';
                                        $dotColor = '#64748b';
                                        if ($st === 'isolir') {
                                            $badgeClass = 'nm-pill-badge-isolir';
                                            $dotColor = '#f59e0b';
                                        } elseif ($st === 'aktif' || $st === 'active') {
                                            $badgeClass = 'nm-pill-badge-aktif';
                                            $dotColor = '#10b981';
                                        } elseif ($st === 'non-aktif' || $st === 'non-active') {
                                            $badgeClass = 'nm-pill-badge-nonaktif';
                                            $dotColor = '#ef4444';
                                        } elseif ($st === 'free') {
                                            $badgeClass = 'nm-pill-badge-free';
                                            $dotColor = '#06b6d4';
                                        }
                                        ?>
                                        <td class="text-center" data-search="<?= htmlspecialchars($display_status) ?>" data-order="<?= htmlspecialchars($display_status) ?>">
                                            <span class="nm-pill-badge <?= $badgeClass ?>">
                                                <span class="chip-dot" style="background: <?= $dotColor ?>; width: 6px; height: 6px;"></span>
                                                <?= htmlspecialchars($display_status) ?>
                                            </span>
                                        </td>
                                        <td data-search="<?= !empty($data->coverage_name) ? htmlspecialchars($data->coverage_name) : '' ?>" data-order="<?= !empty($data->coverage_name) ? htmlspecialchars($data->coverage_name) : '' ?>">
                                            <?= !empty($data->coverage_name) ? htmlspecialchars($data->coverage_name) : '-' ?>
                                        </td>
                                        <td><?= htmlspecialchars($data->address) ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn nm-btn nm-btn-xs nm-btn-primary mr-1" onclick="openLocationPickerModal(<?= $data->customer_id ?>, '<?= addslashes(htmlspecialchars($data->name)) ?>', '<?= addslashes($data->no_services) ?>', '<?= addslashes(htmlspecialchars($data->address)) ?>')" title="Tandai Titik Lokasi Maps">
                                                <i class="fas fa-map-marker-alt mr-1"></i> Tandai
                                            </button>
                                            <?php if ($this->session->userdata('role_id') == 1 || (!empty($role['edit_customer']) && $role['edit_customer'] == 1)) { ?>
                                                <a href="<?= site_url('customer/edit/' . $data->customer_id) ?>" class="btn nm-btn nm-btn-xs" title="Edit Lengkap" target="_blank">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<!-- MODAL 1: Detail Pelanggan Penuh -->
<div class="modal fade" id="modalCustomerDetail" tabindex="-1" role="dialog" aria-labelledby="modalCustomerDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content nm-modal-content">
            <div class="nm-modal-header">
                <div class="d-flex align-items-center">
                    <div class="nm-header-icon-well mr-2" style="width: 36px; height: 36px; font-size: 1rem;">
                        <i class="fas fa-id-card text-primary"></i>
                    </div>
                    <h6 class="m-0 font-weight-bold" id="modalCustomerDetailLabel" style="color: var(--nm-text-main, #141d2b);">
                        Rincian Data Pelanggan
                    </h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: var(--nm-text-muted); opacity: 0.8; text-shadow: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <table class="table table-sm mb-3">
                    <tbody>
                        <tr>
                            <th style="width: 35%;">No Layanan</th>
                            <td><strong id="det-no-services" class="nm-badge-code"></strong></td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td><strong id="det-name" style="color: var(--nm-text-main, #141d2b);"></strong></td>
                        </tr>
                        <tr>
                            <th>Status Langganan</th>
                            <td><span id="det-status" class="nm-pill-badge nm-pill-badge-aktif"></span></td>
                        </tr>
                        <tr>
                            <th>No. WhatsApp</th>
                            <td><span id="det-phone"></span></td>
                        </tr>
                        <tr>
                            <th>Mode Koneksi</th>
                            <td><span id="det-mode" class="badge badge-secondary"></span></td>
                        </tr>
                        <tr>
                            <th>User Mikrotik</th>
                            <td><code id="det-user"></code></td>
                        </tr>
                        <tr>
                            <th>Coverage Area</th>
                            <td><span id="det-coverage"></span></td>
                        </tr>
                        <tr>
                            <th>ODC</th>
                            <td><span id="det-odc"></span></td>
                        </tr>
                        <tr>
                            <th>ODP / Port</th>
                            <td><span id="det-odp"></span></td>
                        </tr>
                        <tr>
                            <th>Koordinat GPS</th>
                            <td><small id="det-coords" class="text-muted"></small></td>
                        </tr>
                        <tr>
                            <th>Alamat Pemasangan</th>
                            <td><span id="det-address"></span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-center flex-wrap" style="gap: 8px;">
                    <a href="#" target="_blank" id="det-btn-direction" class="btn nm-btn nm-btn-sm nm-btn-primary">
                        <i class="fas fa-directions mr-1"></i> Buka Rute GPS
                    </a>
                    <a href="#" target="_blank" id="det-btn-wa" class="btn nm-btn nm-btn-sm nm-btn-success">
                        <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                    </a>
                    <a href="#" target="_blank" id="det-btn-edit" class="btn nm-btn nm-btn-sm">
                        <i class="fas fa-user-edit mr-1"></i> Edit Data
                    </a>
                </div>
            </div>
            <div class="nm-modal-footer">
                <button type="button" class="btn nm-btn nm-btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2: Quick Location Picker (Tandai Lokasi) -->
<div class="modal fade" id="modalLocationPicker" tabindex="-1" role="dialog" aria-labelledby="modalLocationPickerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content nm-modal-content">
            <div class="nm-modal-header">
                <div class="d-flex align-items-center">
                    <div class="nm-header-icon-well mr-2" style="width: 36px; height: 36px; font-size: 1rem;">
                        <i class="fas fa-map-pin text-primary"></i>
                    </div>
                    <h6 class="m-0 font-weight-bold" id="modalLocationPickerLabel" style="color: var(--nm-text-main, #141d2b);">
                        Tentukan Titik Lokasi Pelanggan
                    </h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: var(--nm-text-muted); opacity: 0.8; text-shadow: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <!-- Customer Info Banner -->
                <div class="d-flex align-items-center justify-content-between flex-wrap p-2 mb-3" style="border-radius: var(--nm-radius-sm, 10px); background: var(--nm-bg, #e6ecf4); box-shadow: var(--nm-inset-xs, inset 1px 1px 3px var(--nm-shadow-dark), inset -1px -1px 3px var(--nm-shadow-light)); border: 1px solid rgba(255,255,255,0.45); font-size: 0.85rem;">
                    <div>
                        <strong style="color: var(--nm-text-main, #141d2b);">Pelanggan:</strong> <span id="picker-cust-name" class="font-weight-bold">-</span> (<span id="picker-cust-service" class="nm-badge-code">-</span>)
                    </div>
                    <div>
                        <span class="text-muted"><i class="fas fa-home mr-1"></i> <span id="picker-cust-address">-</span></span>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label font-weight-bold mb-1" style="font-size: 0.8rem; color: var(--nm-text-muted, #4b5b70);">Latitude</label>
                        <input type="text" class="form-control form-control-sm" id="picker-lat" placeholder="Contoh: -6.200000" onchange="onManualCoordinateChange()">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label font-weight-bold mb-1" style="font-size: 0.8rem; color: var(--nm-text-muted, #4b5b70);">Longitude</label>
                        <input type="text" class="form-control form-control-sm" id="picker-lng" placeholder="Contoh: 106.816666" onchange="onManualCoordinateChange()">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap: 6px;">
                    <small class="text-muted">
                        <i class="fas fa-info-circle text-info mr-1"></i> Klik pada peta atau seret (drag) pin merah untuk mengubah koordinat.
                    </small>
                    <button type="button" class="btn nm-btn nm-btn-xs nm-btn-success" onclick="setPickerToCurrentGps()">
                        <i class="fas fa-crosshairs mr-1"></i> Gunakan Lokasi GPS Saya
                    </button>
                </div>

                <!-- Mini Map -->
                <div class="map-screen-inner p-1">
                    <div id="picker-map"></div>
                </div>
                <input type="hidden" id="picker-customer-id">
            </div>
            <div class="nm-modal-footer">
                <button type="button" class="btn nm-btn nm-btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" class="btn nm-btn nm-btn-sm nm-btn-primary font-weight-bold" id="btn-save-coordinate" onclick="saveCustomerCoordinate()">
                    <i class="fas fa-save mr-1"></i> Simpan Titik Lokasi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // System Configurations
    var companyName = "<?= addslashes($company['company_name'] ?? 'ISP') ?>";
    var defaultLat = <?= !empty($company['latitude']) && is_numeric($company['latitude']) ? (float)$company['latitude'] : -6.139333 ?>;
    var defaultLng = <?= !empty($company['longitude']) && is_numeric($company['longitude']) ? (float)$company['longitude'] : 106.674584 ?>;
    var mapboxToken = "<?= maps()['token'] ?? '' ?>";

    // Leaflet Objects
    var mymap = null;
    var clusterGroup = null;
    var searchControl = null;
    var coverageLayerGroup = null;
    var isCoverageVisible = false;
    var allCustomersData = [];
    var currentFilter = 'all';

    // Status Color Map
    var statusColors = {
        'aktif': '#10b981',
        'active': '#10b981',
        'isolir': '#f59e0b',
        'non-aktif': '#ef4444',
        'non-active': '#ef4444',
        'menunggu': '#64748b',
        'waiting': '#64748b',
        'free': '#06b6d4'
    };

    // Initialize Main Map
    function initMainMap() {
        if (mymap !== null) {
            mymap.remove();
            mymap = null;
        }

        // Base Tile Layers
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        var googleHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google Maps Satellite'
        });

        var googleStreets = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google Maps Streets'
        });

        var darkMatter = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://carto.com/">CARTO</a>'
        });

        var baseLayers = {
            'Google Hybrid (Satelit)': googleHybrid,
            'OpenStreetMap': osm,
            'Google Streets': googleStreets,
            'CartoDB Dark Matter': darkMatter
        };

        if (mapboxToken && mapboxToken !== 'your token / api key') {
            var mapboxStreets = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + mapboxToken, {
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                maxZoom: 18,
                attribution: '&copy; Mapbox'
            });
            baseLayers['Mapbox Streets'] = mapboxStreets;
        }

        // Determine default base layer
        var isDark = document.documentElement.classList.contains('dark-mode');
        var initialLayer = isDark ? darkMatter : googleHybrid;

        mymap = L.map('map', {
            preferCanvas: true,
            center: [defaultLat, defaultLng],
            zoom: 13,
            layers: [initialLayer],
            fullscreenControl: false
        });

        // Add single Fullscreen Control explicitly
        if (typeof L.control.fullscreen === 'function') {
            mymap.addControl(L.control.fullscreen({
                position: 'topleft',
                title: {
                    'false': 'Layar Penuh',
                    'true': 'Keluar Layar Penuh'
                }
            }));
        } else if (typeof L.Control.Fullscreen === 'function') {
            mymap.addControl(new L.Control.Fullscreen({
                position: 'topleft',
                title: {
                    'false': 'Layar Penuh',
                    'true': 'Keluar Layar Penuh'
                }
            }));
        }

        // Layer Control
        L.control.layers(baseLayers, null, { position: 'topright' }).addTo(mymap);

        // Marker Cluster Group (Optimized for 1000+ pins with chunked loading)
        clusterGroup = L.markerClusterGroup({
            showCoverageOnHover: false,
            maxClusterRadius: 75,
            spiderfyOnMaxZoom: true,
            zoomToBoundsOnClick: true,
            chunkedLoading: true,
            chunkInterval: 150,
            chunkDelay: 30,
            removeOutsideVisibleBounds: true,
            disableClusteringAtZoom: 19
        });

        // Handle cluster click: zoom to bounds, or spiderfy if all markers are at identical coordinates
        clusterGroup.on('clusterclick', function(a) {
            var childMarkers = a.layer.getAllChildMarkers();
            if (childMarkers && childMarkers.length > 1) {
                var firstLat = childMarkers[0].getLatLng().lat;
                var firstLng = childMarkers[0].getLatLng().lng;
                var allSameLoc = true;
                for (var i = 1; i < childMarkers.length; i++) {
                    if (Math.abs(childMarkers[i].getLatLng().lat - firstLat) > 0.00003 ||
                        Math.abs(childMarkers[i].getLatLng().lng - firstLng) > 0.00003) {
                        allSameLoc = false;
                        break;
                    }
                }
                if (allSameLoc) {
                    a.layer.spiderfy();
                }
            }
        });

        mymap.addLayer(clusterGroup);

        // Coverage Overlay Group
        coverageLayerGroup = L.layerGroup();

        // Invalidate map size after DOM layout settles
        setTimeout(function() {
            if (mymap) mymap.invalidateSize();
        }, 350);
        $(window).on('resize', function() {
            if (mymap) mymap.invalidateSize();
        });

        // Load Markers Data
        reloadMapData(false);
    }

    // Load customer markers from server
    function reloadMapData(showLoader) {
        if (showLoader) {
            $('#map-loader').show();
        }

        $.ajax({
            url: "<?= site_url('maps/getmaps') ?>",
            type: "GET",
            dataType: "json",
            timeout: 15000,
            success: function(data) {
                allCustomersData = data || [];
                renderMarkers(currentFilter);
                updateStatsCounters();
                loadCoverageData();
                $('#map-loader').fadeOut(250);
            },
            error: function(xhr, status, error) {
                console.error("Gagal memuat data pelanggan maps:", error);
                $('#map-loader').fadeOut(250);
            }
        });
    }

    // Render Markers with optional filter (High-Performance Bulk Addition)
    function renderMarkers(filter) {
        currentFilter = filter;
        clusterGroup.clearLayers();

        if (searchControl !== null) {
            mymap.removeControl(searchControl);
            searchControl = null;
        }

        var bounds = [];
        var markersToAdd = [];
        var filterLower = (filter || 'all').toLowerCase().trim();

        for (var i = 0; i < allCustomersData.length; i++) {
            var item = allCustomersData[i];

            // Filter check
            if (filterLower !== 'all') {
                var itemStatus = (item.c_status || '').toLowerCase().trim();
                if (itemStatus !== filterLower) {
                    continue;
                }
            }

            var lat = parseFloat(item.latitude);
            var lng = parseFloat(item.longitude);

            if (isNaN(lat) || isNaN(lng) || (lat === 0 && lng === 0)) {
                continue;
            }

            var marker = createCustomerMarker(item);
            markersToAdd.push(marker);
            bounds.push([lat, lng]);
        }

        // Bulk layer addition: 50x-100x faster than addLayer() in a loop
        if (markersToAdd.length > 0) {
            clusterGroup.addLayers(markersToAdd);
        }

        // Attach Search Control directly to clusterGroup
        if (typeof L.control.search === 'function') {
            searchControl = new L.control.search({
                layer: clusterGroup,
                propertyName: 'search_title',
                initial: false,
                hideMarkerOnCollapse: true,
                textPlaceholder: 'Cari No Layanan / Nama...',
                position: 'topleft',
                zoom: 18,
                autoCollapse: true
            });

            searchControl.on('search:locationfound', function(e) {
                if (e.layer) {
                    if (clusterGroup.hasLayer(e.layer)) {
                        clusterGroup.zoomToShowLayer(e.layer, function() {
                            e.layer.openPopup();
                        });
                    } else if (e.layer.openPopup) {
                        e.layer.openPopup();
                    }
                }
            });

            mymap.addControl(searchControl);
        }

        // Fit bounds if markers exist, else center to company location
        if (bounds.length > 0) {
            mymap.fitBounds(bounds, { padding: [40, 40], maxZoom: 16 });
        } else {
            mymap.setView([defaultLat, defaultLng], 13);
        }
    }

    // Create SVG DivIcon Pin Marker (High-DPI Razor Sharp Vector + Lazy Popup)
    function createCustomerMarker(item) {
        var statusKey = (item.c_status || 'aktif').toLowerCase().trim();
        var color = statusColors[statusKey] || '#10b981';

        var customIcon = L.divIcon({
            className: 'custom-pin-wrapper',
            iconSize: [32, 44],
            iconAnchor: [16, 44],
            popupAnchor: [0, -40],
            html: `
                <div class="custom-svg-pin" title="${escapeHtml(item.name)} (${item.no_services})">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 44" width="32" height="44" shape-rendering="geometricPrecision">
                        <path d="M16 1 C7.716 1 1 7.716 1 16 C1 26.5 16 43 16 43 C16 43 31 26.5 31 16 C31 7.716 24.284 1 16 1 Z" 
                              fill="${color}" 
                              stroke="#ffffff" 
                              stroke-width="2.2" 
                              stroke-linejoin="round"/>
                        <circle cx="16" cy="16" r="6" fill="#ffffff"/>
                        <circle cx="16" cy="16" r="2.8" fill="${color}"/>
                    </svg>
                </div>
            `
        });

        var marker = L.marker([parseFloat(item.latitude), parseFloat(item.longitude)], {
            icon: customIcon,
            search_title: item.no_services + ' - ' + item.name
        });

        // Lazy Popup Content: only rendered and parsed into DOM when the pin is clicked!
        marker.bindPopup(function() {
            return buildCustomerPopupHtml(item);
        }, { maxWidth: 310 });

        return marker;
    }

    // Build Popup Card HTML
    function buildCustomerPopupHtml(item) {
        var statusKey = (item.c_status || 'Aktif').toLowerCase().trim();
        var pillClass = 'nm-pill-badge-menunggu';
        var dotColor = '#64748b';
        if (statusKey === 'aktif' || statusKey === 'active') {
            pillClass = 'nm-pill-badge-aktif';
            dotColor = '#10b981';
        } else if (statusKey === 'isolir') {
            pillClass = 'nm-pill-badge-isolir';
            dotColor = '#f59e0b';
        } else if (statusKey === 'non-aktif' || statusKey === 'non-active') {
            pillClass = 'nm-pill-badge-nonaktif';
            dotColor = '#ef4444';
        } else if (statusKey === 'free') {
            pillClass = 'nm-pill-badge-free';
            dotColor = '#06b6d4';
        }

        var cleanWa = (item.no_wa || '').replace(/[^0-9]/g, '');
        if (cleanWa.startsWith('0')) {
            cleanWa = '62' + cleanWa.substring(1);
        } else if (!cleanWa.startsWith('62')) {
            cleanWa = '62' + cleanWa;
        }

        var directionUrl = `https://www.google.com/maps/dir/?api=1&destination=${item.latitude},${item.longitude}`;
        var waUrl = `https://wa.me/${cleanWa}`;
        var editUrl = `<?= site_url('customer/edit/') ?>${item.customer_id}`;

        return `
            <div class="cust-popup-header">
                <div>
                    <h6>${escapeHtml(item.name)}</h6>
                    <span class="nm-badge-code" style="font-size: 0.72rem; padding: 1px 6px;">ID: ${item.no_services}</span>
                </div>
                <div>
                    <span class="nm-pill-badge ${pillClass}">
                        <span class="chip-dot" style="background: ${dotColor}; width: 6px; height: 6px;"></span>
                        ${escapeHtml(item.c_status)}
                    </span>
                </div>
            </div>
            <div class="cust-popup-body">
                <div class="cust-popup-row">
                    <span class="label"><i class="fas fa-network-wired mr-1"></i> Mode:</span>
                    <span class="val">${escapeHtml(item.mode_user)} (${escapeHtml(item.user_mikrotik)})</span>
                </div>
                <div class="cust-popup-row">
                    <span class="label"><i class="fas fa-broadcast-tower mr-1"></i> Area:</span>
                    <span class="val">${escapeHtml(item.coverage)}</span>
                </div>
                <div class="cust-popup-row">
                    <span class="label"><i class="fas fa-sitemap mr-1"></i> ODC / ODP:</span>
                    <span class="val">${escapeHtml(item.odc)} &bull; ${escapeHtml(item.odp)}</span>
                </div>
                <div class="cust-popup-row">
                    <span class="label"><i class="fas fa-map-marker-alt mr-1"></i> Alamat:</span>
                    <span class="val" style="max-width: 160px; word-break: break-word;">${escapeHtml(item.address)}</span>
                </div>
            </div>
            <div class="cust-popup-actions">
                <a href="${directionUrl}" target="_blank" class="btn nm-btn nm-btn-xs nm-btn-primary" title="Buka Rute GPS">
                    <i class="fas fa-directions"></i> Rute
                </a>
                <a href="${waUrl}" target="_blank" class="btn nm-btn nm-btn-xs nm-btn-success" title="Chat WhatsApp">
                    <i class="fab fa-whatsapp"></i> WA
                </a>
                <a href="${editUrl}" target="_blank" class="btn nm-btn nm-btn-xs" title="Edit Customer">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button type="button" class="btn nm-btn nm-btn-xs" onclick="openDetailModal(${item.customer_id})" title="Rincian Lengkap">
                    <i class="fas fa-eye text-primary"></i> Detail
                </button>
            </div>
        `;
    }

    // Global filter state for unmapped customers table
    var currentTableStatusFilter = 'all';
    var currentTableCoverageFilter = '';
    var isSyncFilterEnabled = false;

    // Filter markers by status on the Map
    function filterByStatus(status) {
        $('.filter-chip').not('.tbl-filter-chip').removeClass('active');
        $(`.filter-chip[data-filter="${status}"]`).not('.tbl-filter-chip').addClass('active');
        renderMarkers(status);

        if (isSyncFilterEnabled) {
            filterTableByStatus(status, false);
        }
    }

    // Toggle Sync Filter between Map and Table
    function toggleSyncFilter() {
        isSyncFilterEnabled = !isSyncFilterEnabled;
        if (isSyncFilterEnabled) {
            $('#btn-sync-toggle').addClass('active-tool');
            var activeMapFilter = $('.filter-chip.active').not('.tbl-filter-chip').data('filter') || 'all';
            filterTableByStatus(activeMapFilter, false);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Sinkronisasi Filter Aktif',
                    text: 'Filter status peta dan tabel kini tersinkronisasi.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        } else {
            $('#btn-sync-toggle').removeClass('active-tool');
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Sinkronisasi Dimatikan',
                    text: 'Filter peta dan tabel dapat diatur secara terpisah.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    }

    // Filter unmapped customers table by Status
    function filterTableByStatus(status, syncMap) {
        currentTableStatusFilter = status;
        $('.tbl-filter-chip').removeClass('active');
        $(`.tbl-filter-chip[data-status="${status}"]`).addClass('active');

        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#dataTable')) {
            var table = $('#dataTable').DataTable();
            if (status === 'all') {
                table.column(4).search('').draw();
            } else {
                // Exact regex search on column 4 (Status)
                var regex = '^' + escapeRegex(status) + '$';
                table.column(4).search(regex, true, false).draw();
            }
        }

        updateTableCounterBadge();

        if (syncMap !== false && isSyncFilterEnabled) {
            filterByStatus(status);
        }
    }

    // Filter unmapped customers table by Coverage Area
    function filterTableByCoverage(area) {
        currentTableCoverageFilter = area;
        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#dataTable')) {
            var table = $('#dataTable').DataTable();
            if (!area) {
                table.column(5).search('').draw();
            } else {
                var regex = '^' + escapeRegex(area) + '$';
                table.column(5).search(regex, true, false).draw();
            }
        }
        updateTableCounterBadge();
    }

    // Update Counter Badge on Table Header
    function updateTableCounterBadge() {
        if (!$.fn.DataTable || !$.fn.DataTable.isDataTable('#dataTable')) return;
        var table = $('#dataTable').DataTable();
        var filteredCount = table.rows({ filter: 'applied' }).count();
        var totalCount = table.rows().count();

        var label = filteredCount + ' Pelanggan';
        if (currentTableStatusFilter !== 'all' || currentTableCoverageFilter) {
            var parts = [];
            if (currentTableStatusFilter !== 'all') parts.push('Status: ' + currentTableStatusFilter);
            if (currentTableCoverageFilter) parts.push('Area: ' + currentTableCoverageFilter);
            label = filteredCount + ' dari ' + totalCount + ' Pelanggan (' + parts.join(', ') + ')';
        }
        $('#table-unmapped-count').text(label);
    }

    // Reset Table Filters
    function resetTableFilters() {
        $('#filter-table-coverage').val('');
        currentTableCoverageFilter = '';
        filterTableByStatus('all', false);
    }

    // Regex Escape Helper
    function escapeRegex(text) {
        if (!text) return '';
        return text.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    }

    // Update Counter Badges
    function updateStatsCounters() {
        var counts = {
            total: allCustomersData.length,
            aktif: 0,
            isolir: 0,
            non_aktif: 0,
            menunggu: 0,
            free: 0
        };

        for (var i = 0; i < allCustomersData.length; i++) {
            var st = (allCustomersData[i].c_status || '').toLowerCase().trim();
            if (st === 'aktif' || st === 'active') counts.aktif++;
            else if (st === 'isolir') counts.isolir++;
            else if (st === 'non-aktif' || st === 'non-active') counts.non_aktif++;
            else if (st === 'menunggu' || st === 'waiting') counts.menunggu++;
            else if (st === 'free') counts.free++;
        }

        $('#count-all').text(counts.total);
        $('#stat-total').text(counts.total);
        $('#count-aktif').text(counts.aktif);
        $('#count-isolir').text(counts.isolir);
        $('#count-non_aktif').text(counts.non_aktif);
        $('#count-menunggu').text(counts.menunggu);
        $('#count-free').text(counts.free);
    }

    // Load Coverage Areas
    function loadCoverageData() {
        coverageLayerGroup.clearLayers();

        $.ajax({
            url: "<?= site_url('maps/get_coverage') ?>",
            type: "GET",
            dataType: "json",
            success: function(areas) {
                if (!areas || areas.length === 0) return;

                for (var i = 0; i < areas.length; i++) {
                    var cov = areas[i];
                    var circle = L.circle([cov.latitude, cov.longitude], {
                        radius: cov.radius || 500,
                        color: '#3b82f6',
                        fillColor: '#60a5fa',
                        fillOpacity: 0.15,
                        weight: 2
                    });

                    circle.bindPopup(`
                        <div style="font-size: 0.85rem; padding: 4px;">
                            <strong><i class="fas fa-broadcast-tower text-primary mr-1"></i> ${escapeHtml(cov.c_name)}</strong><br>
                            <span class="text-muted">Radius: ${cov.radius} meter</span><br>
                            <small class="text-muted">${escapeHtml(cov.address)}</small>
                        </div>
                    `);

                    coverageLayerGroup.addLayer(circle);
                }
            }
        });
    }

    // Toggle Coverage Overlay
    function toggleCoverageOverlay() {
        isCoverageVisible = !isCoverageVisible;
        if (isCoverageVisible) {
            mymap.addLayer(coverageLayerGroup);
            $('#btn-coverage-toggle').addClass('active-tool');
        } else {
            mymap.removeLayer(coverageLayerGroup);
            $('#btn-coverage-toggle').removeClass('active-tool');
        }
    }

    // Fit All Markers on View
    function fitAllMarkers() {
        if (clusterGroup && clusterGroup.getLayers().length > 0) {
            mymap.fitBounds(clusterGroup.getBounds(), { padding: [40, 40], maxZoom: 16 });
        } else {
            mymap.setView([defaultLat, defaultLng], 13);
        }
    }

    // Locate User GPS Position
    function locateUserPosition() {
        if (!navigator.geolocation) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Didukung',
                text: 'Peramban web Anda tidak mendukung Geolocation GPS.'
            });
            return;
        }

        Swal.fire({
            title: 'Mendeteksi Lokasi GPS...',
            text: 'Mohon izinkan akses lokasi pada browser.',
            allowOutsideClick: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                Swal.close();
                var lat = pos.coords.latitude;
                var lng = pos.coords.longitude;
                var accuracy = pos.coords.accuracy.toFixed(0);

                var userMarker = L.circleMarker([lat, lng], {
                    radius: 9,
                    color: '#ffffff',
                    weight: 3,
                    fillColor: '#3b82f6',
                    fillOpacity: 1
                }).addTo(mymap);

                var userCircle = L.circle([lat, lng], {
                    radius: accuracy,
                    color: '#3b82f6',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.12,
                    weight: 1
                }).addTo(mymap);

                userMarker.bindPopup(`
                    <div class="p-2 text-center">
                        <strong class="text-primary"><i class="fas fa-crosshairs"></i> Posisi Anda Saat Ini</strong><br>
                        <small class="text-muted">Akurasi GPS: &plusmn;${accuracy} meter</small>
                    </div>
                `).openPopup();

                mymap.setView([lat, lng], 16);
            },
            function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mendeteksi Lokasi',
                    text: err.message || 'Izin lokasi ditolak atau sinyal GPS tidak tersedia.'
                });
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    // Open Customer Detail Modal
    function openDetailModal(customerId) {
        var customer = allCustomersData.find(function(c) { return c.customer_id == customerId; });
        if (!customer) return;

        $('#det-no-services').text(customer.no_services);
        $('#det-name').text(customer.name);

        var st = (customer.c_status || 'Aktif').toLowerCase().trim();
        var badgeClass = 'nm-pill-badge nm-pill-badge-menunggu';
        var dotColor = '#64748b';
        if (st === 'aktif' || st === 'active') {
            badgeClass = 'nm-pill-badge nm-pill-badge-aktif';
            dotColor = '#10b981';
        } else if (st === 'isolir') {
            badgeClass = 'nm-pill-badge nm-pill-badge-isolir';
            dotColor = '#f59e0b';
        } else if (st === 'non-aktif' || st === 'non-active') {
            badgeClass = 'nm-pill-badge nm-pill-badge-nonaktif';
            dotColor = '#dc2626';
        } else if (st === 'free') {
            badgeClass = 'nm-pill-badge nm-pill-badge-free';
            dotColor = '#06b6d4';
        }
        $('#det-status').attr('class', badgeClass).html(`<span class="chip-dot" style="background: ${dotColor}; width: 6px; height: 6px;"></span> ${escapeHtml(customer.c_status)}`);

        $('#det-phone').text(customer.no_wa || '-');
        $('#det-mode').text(customer.mode_user || '-');
        $('#det-user').text(customer.user_mikrotik || '-');
        $('#det-coverage').text(customer.coverage || '-');
        $('#det-odc').text(customer.odc || '-');
        $('#det-odp').text(customer.odp || '-');
        $('#det-coords').text(`${customer.latitude}, ${customer.longitude}`);
        $('#det-address').text(customer.address || '-');

        var cleanWa = (customer.no_wa || '').replace(/[^0-9]/g, '');
        if (cleanWa.startsWith('0')) cleanWa = '62' + cleanWa.substring(1);
        else if (!cleanWa.startsWith('62')) cleanWa = '62' + cleanWa;

        $('#det-btn-direction').attr('href', `https://www.google.com/maps/dir/?api=1&destination=${customer.latitude},${customer.longitude}`);
        $('#det-btn-wa').attr('href', `https://wa.me/${cleanWa}`);
        $('#det-btn-edit').attr('href', `<?= site_url('customer/edit/') ?>${customer.customer_id}`);

        $('#modalCustomerDetail').modal('show');
    }

    // ==========================================
    // MODAL QUICK LOCATION PICKER LOGIC
    // ==========================================
    var pickerMap = null;
    var pickerMarker = null;

    function openLocationPickerModal(customerId, name, noServices, address) {
        $('#picker-customer-id').val(customerId);
        $('#picker-cust-name').text(name);
        $('#picker-cust-service').text(noServices);
        $('#picker-cust-address').text(address);

        // Default initial coordinates for modal picker
        var initLat = defaultLat;
        var initLng = defaultLng;

        $('#picker-lat').val(initLat.toFixed(6));
        $('#picker-lng').val(initLng.toFixed(6));

        $('#modalLocationPicker').modal('show');

        // Delay initialization until modal is fully visible
        setTimeout(function() {
            initPickerMap(initLat, initLng);
        }, 300);
    }

    function initPickerMap(lat, lng) {
        if (pickerMap !== null) {
            pickerMap.remove();
            pickerMap = null;
        }

        var osmTile = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        });
        var satTile = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20
        });

        pickerMap = L.map('picker-map', {
            center: [lat, lng],
            zoom: 15,
            layers: [satTile]
        });

        L.control.layers({
            'Google Satelit': satTile,
            'OpenStreetMap': osmTile
        }, null, { position: 'topright' }).addTo(pickerMap);

        // Red draggable pin - Razor Sharp High-DPI Vector
        var redIcon = L.divIcon({
            className: 'picker-pin',
            iconSize: [32, 44],
            iconAnchor: [16, 44],
            html: `
                <div style="filter: drop-shadow(0 3px 6px rgba(0,0,0,0.4)); cursor: grab;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 44" width="32" height="44" shape-rendering="geometricPrecision">
                        <path d="M16 1 C7.716 1 1 7.716 1 16 C1 26.5 16 43 16 43 C16 43 31 26.5 31 16 C31 7.716 24.284 1 16 1 Z" 
                              fill="#ef4444" 
                              stroke="#ffffff" 
                              stroke-width="2.2" 
                              stroke-linejoin="round"/>
                        <circle cx="16" cy="16" r="6" fill="#ffffff"/>
                        <circle cx="16" cy="16" r="2.8" fill="#ef4444"/>
                    </svg>
                </div>
            `
        });

        pickerMarker = L.marker([lat, lng], {
            icon: redIcon,
            draggable: true
        }).addTo(pickerMap);

        pickerMarker.on('dragend', function(e) {
            var position = pickerMarker.getLatLng();
            $('#picker-lat').val(position.lat.toFixed(6));
            $('#picker-lng').val(position.lng.toFixed(6));
        });

        pickerMap.on('click', function(e) {
            pickerMarker.setLatLng(e.latlng);
            $('#picker-lat').val(e.latlng.lat.toFixed(6));
            $('#picker-lng').val(e.latlng.lng.toFixed(6));
        });

        pickerMap.invalidateSize();
    }

    function onManualCoordinateChange() {
        var lat = parseFloat($('#picker-lat').val());
        var lng = parseFloat($('#picker-lng').val());
        if (!isNaN(lat) && !isNaN(lng) && pickerMarker && pickerMap) {
            pickerMarker.setLatLng([lat, lng]);
            pickerMap.setView([lat, lng], pickerMap.getZoom());
        }
    }

    function setPickerToCurrentGps() {
        if (!navigator.geolocation) {
            Swal.fire({ icon: 'warning', title: 'GPS Tidak Tersedia', text: 'Browser tidak mendukung GPS.' });
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                var lat = pos.coords.latitude;
                var lng = pos.coords.longitude;
                $('#picker-lat').val(lat.toFixed(6));
                $('#picker-lng').val(lng.toFixed(6));
                if (pickerMarker && pickerMap) {
                    pickerMarker.setLatLng([lat, lng]);
                    pickerMap.setView([lat, lng], 17);
                }
            },
            function(err) {
                Swal.fire({ icon: 'error', title: 'Gagal Mengakses GPS', text: err.message });
            },
            { enableHighAccuracy: true }
        );
    }

    // Save Customer Coordinate via AJAX
    function saveCustomerCoordinate() {
        var customerId = $('#picker-customer-id').val();
        var lat = $.trim($('#picker-lat').val());
        var lng = $.trim($('#picker-lng').val());

        if (!customerId || !lat || !lng) {
            Swal.fire({ icon: 'warning', title: 'Data Belum Lengkap', text: 'Latitude dan Longitude wajib diisi.' });
            return;
        }

        var btn = $('#btn-save-coordinate');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

        $.ajax({
            url: "<?= site_url('maps/save_coordinate') ?>",
            type: "POST",
            dataType: "json",
            data: {
                customer_id: customerId,
                latitude: lat,
                longitude: lng
            },
            success: function(resp) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Titik Lokasi');

                if (resp.status === 'success') {
                    $('#modalLocationPicker').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Lokasi Berhasil Ditandai!',
                        text: resp.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Remove row from unmapped table smoothly
                    var row = $('#unmapped-row-' + customerId);
                    if (row.length > 0) {
                        row.fadeOut(300, function() {
                            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#dataTable')) {
                                $('#dataTable').DataTable().row(row).remove().draw(false);
                            } else {
                                $(this).remove();
                            }
                            updateTableCounterBadge();

                            var remaining = $('#dataTable tbody tr').length;
                            $('#stat-unmapped').text(remaining);

                            // Decrement status count badge
                            if (resp.customer && resp.customer.c_status) {
                                var st = resp.customer.c_status.toLowerCase().trim();
                                var countEl = null;
                                if (st === 'aktif' || st === 'active') countEl = $('#tbl-count-aktif');
                                else if (st === 'isolir') countEl = $('#tbl-count-isolir');
                                else if (st === 'non-aktif' || st === 'non-active') countEl = $('#tbl-count-nonaktif');
                                else if (st === 'menunggu' || st === 'waiting') countEl = $('#tbl-count-menunggu');
                                else if (st === 'free') countEl = $('#tbl-count-free');

                                if (countEl && countEl.length > 0) {
                                    var curVal = parseInt(countEl.text()) || 0;
                                    if (curVal > 0) countEl.text(curVal - 1);
                                }
                                var curTotal = parseInt($('#tbl-count-all').text()) || 0;
                                if (curTotal > 0) $('#tbl-count-all').text(curTotal - 1);
                            }
                        });
                    }

                    // Add new marker dynamically to main map
                    if (resp.customer) {
                        allCustomersData.push(resp.customer);
                        var newMarker = createCustomerMarker(resp.customer);
                        clusterGroup.addLayer(newMarker);
                        updateStatsCounters();

                        // Pan and focus to new marker
                        mymap.setView([resp.customer.latitude, resp.customer.longitude], 17);
                        setTimeout(function() {
                            newMarker.openPopup();
                        }, 400);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: resp.message || 'Terjadi kesalahan sistem.'
                    });
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Titik Lokasi');
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Jaringan',
                    text: 'Gagal menghubungi server: ' + error
                });
            }
        });
    }

    // Utility escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Initialize on DOM Ready
    $(document).ready(function() {
        initMainMap();

        // Safety fallback: ensure map loader doesn't get stuck
        setTimeout(function() {
            $('#map-loader').fadeOut(300);
        }, 4000);
    });
</script>