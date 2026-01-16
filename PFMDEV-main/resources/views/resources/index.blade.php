<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataCenter</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🖥️</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0b1120;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .container-wrapper {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        aside {
            width: 0;
            background: #020617;
            border-right: 1px solid #334155;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            position: fixed;
            left: -280px;
            top: 0;
            height: 100vh;
            z-index: 1000;
            transition: left 0.3s ease;
        }

        aside.active {
            left: 0;
        }

        @media (min-width: 1400px) {
            aside {
                position: relative;
                left: 0 !important;
                width: 280px;
                display: flex;
            }
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 10px;
            z-index: 1001;
            flex-direction: column;
            gap: 5px;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .sidebar-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: white;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover span {
            background-color: #ef4444;
        }

        .sidebar-toggle.button-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        @media (max-width: 1399px) {
            .sidebar-toggle {
                display: flex;
            }

            aside {
                width: 280px;
                left: -280px;
            }

            aside.active {
                left: 0;
            }
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 900;
            font-size: 1.25rem;
            margin-bottom: 3rem;
        }

        .logo-box {
            width: 40px;
            height: 40px;
            background: #ef4444;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        aside nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        aside nav a {
            display: block;
            padding: 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 0;
            font-weight: 600;
            width: 100%;
            border: 1px solid transparent;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        aside nav a:hover {
            background: rgba(148, 163, 184, 0.05);
            border-color: #475569;
        }

        aside nav a.active {
            background: rgba(239, 68, 68, 0.15);
            color: #ff6b6b;
            border: 1px solid #ef4444;
        }

        main {
            flex: 1;
            padding: 2.5rem;
            overflow-y: auto;
            overflow-x: hidden;
            max-width: 100%;
        }

        header h1 {
            font-size: 2rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }

        header p {
            color: #94a3b8;
            margin-bottom: 2rem;
        }

        .filter-section {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .search-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        input,
        select {
            background: #0f172a;
            border: 1px solid #334155;
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            flex: 1;
            min-width: 200px;
        }

        input:focus {
            border-color: #ef4444;
        }

        .range-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #334155;
        }

        .range-item label {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .range-item label span {
            color: #ef4444;
        }

        input[type="range"] {
            width: 100%;
            height: 5px;
            cursor: pointer;
        }

        #inventory-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            width: 100%;
        }

        @media (max-width: 768px) {
            #inventory-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (min-width: 769px) and (max-width: 1200px) {
            #inventory-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1201px) {
            #inventory-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .res-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 4px solid #ef4444;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            cursor: pointer;
        }

        .res-card:hover {
            border-color: #ef4444;
            background: #334155;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(239, 68, 68, 0.2);
        }

        .status {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
            width: fit-content;
        }

        .status.available {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        .status.maintenance {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .status.disabled {
            background: rgba(148, 163, 184, 0.15);
            color: #94a3b8;
        }

        .guest-message {
            background: #e8f6f3;
            color: #27ae60;
            padding: 20px;
            border-left: 5px solid #2ecc71;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .guest-message h3 {
            color: #27ae60;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .guest-message p {
            color: #555;
            margin-bottom: 15px;
        }

        .guest-message a {
            display: inline-block;
            padding: 12px 25px;
            margin-right: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .guest-message a:first-of-type {
            background: #2ecc71;
            color: white;
        }

        .guest-message a.login {
            background: #3498db;
            color: white;
        }

        .res-card.server {
            border-left: 4px solid #60a5fa;
        }

        .res-card.vm {
            border-left: 4px solid #ff6b08;
        }

        .res-card.storage {
            border-left: 4px solid #8d01ff;
        }

        .res-card.network {
            border-left: 4px solid #0bc6f5;
        }

        .res-card .status {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            background: rgba(34, 197, 94, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
        }

        .res-card h3 {
            font-size: 1.1rem;
            margin: 12px 0;
        }

        .res-actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }

        .btn-edit {
            background: #0f172a;
            border: 1px solid #38bdf8;
            color: #38bdf8;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-delete {
            background: #0f172a;
            border: 1px solid #ef4444;
            color: #ef4444;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
        }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 1.5rem 0;
            flex: 1;
        }

        .spec-box {
            background: #0f172a;
            padding: 12px 8px;
            border-radius: 6px;
            text-align: center;
            border: 1px solid #334155;
            transition: all 0.2s ease;
        }

        .spec-box:hover {
            border-color: #60a5fa;
            background: rgba(96, 165, 250, 0.05);
        }

        .spec-box small {
            font-size: 0.65rem;
            color: #94a3b8;
            text-transform: uppercase;
            display: block;
            font-weight: 600;
        }

        .spec-box span {
            font-size: 0.95rem;
            font-weight: 700;
            color: #60a5fa;
            display: block;
            margin-top: 4px;
        }

        .btn-reserve {
            width: 100%;
            background: #447aef;
            color: white;
            border: none;
            padding: 14px 12px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: auto;
            font-size: 0.95rem;
        }

        .btn-reserve:hover {
            background: #1b5ef0;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(68, 122, 239, 0.3);
        }

        .btn-reserve:disabled {
            background: #334155;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, 0.7);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .modal-box {
            background: #020617;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 2rem;
            width: 360px;
        }

        .modal-box h3 {
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .modal-box input,
        .modal-box select {
            width: 100%;
            margin-bottom: 1rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-cancel {
            background: transparent;
            border: 1px solid #334155;
            color: #94a3b8;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-create {
            background: #ef4444;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 800;
            cursor: pointer;
        }

        .btn-create:hover {
            background: #dc2626;
        }

        .user-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-left: 8px;
        }

        .badge-guest {
            background: rgba(148, 163, 184, 0.2);
            color: #94a3b8;
        }

        .badge-user {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        .badge-tech {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .badge-admin {
            background: rgba(168, 85, 247, 0.2);
            color: #a855f7;
        }

        .guest-message {
            background: #e8f6f3;
            padding: 20px;
            border-left: 5px solid #2ecc71;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .guest-message h3 {
            color: #27ae60;
            margin-top: 0;
        }

        .guest-message p {
            color: #555;
        }

        .guest-message a {
            display: inline-block;
            background: #2ecc71;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-right: 10px;
            margin-top: 10px;
        }

        .guest-message a.login {
            background: #3498db;
        }
    </style>
</head>

<body>

    <!-- NAVIGATION EN HAUT -->
    <nav>
        <div class="nav-left">
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="{{ asset('images/logo.jpg') }}" alt="DataCenter Logo"
                    style="height: 60px; width: 120px; border-radius: 50%; border: 0 solid white;">
            </a>
        </div>

        <div class="nav-center">
            <a href="{{ route('home') }}"
                style="{{ request()->routeIs('home') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                {{ __('Home') }}
            </a>

            <a href="{{ route('rules') }}"
                style="{{ request()->routeIs('rules') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                {{ __('Rules') }}
            </a>

            @auth
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        style="{{ request()->routeIs('admin.dashboard') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                        {{ __('Users') }}
                    </a>
                    <a href="{{ route('admin.resources.index') }}"
                        style="{{ request()->routeIs('admin.resources.*') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                        {{ __('Resources') }}
                    </a>

                @elseif(Auth::user()->role == 'manager')
                    <a href="{{ route('manager.dashboard') }}"
                        style="{{ request()->routeIs('manager.*') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                        {{ __('Manager Area') }}
                    </a>

                @elseif(Auth::user()->role == 'internal')
                    <a href="{{ route('internal.dashboard') }}"
                        style="{{ request()->routeIs('internal.*') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                        {{ __('My Area') }}
                    </a>
                @endif
            @endauth
        </div>

        <div class="nav-right">
            <div style="margin-right: 20px; font-size: 0.9em; display:flex; align-items:center;">
                <a href="{{ route('lang.switch', 'fr') }}"
                    style="margin: 0; padding:0; border:none; {{ app()->getLocale() == 'fr' ? 'font-weight:bold; color:white;' : 'color:#bdc3c7; font-weight:normal;' }}">FR</a>
                <span style="color: white; opacity: 0.3; margin: 0 5px;">|</span>
                <a href="{{ route('lang.switch', 'en') }}"
                    style="margin: 0; padding:0; border:none; {{ app()->getLocale() == 'en' ? 'font-weight:bold; color:white;' : 'color:#bdc3c7; font-weight:normal;' }}">EN</a>
            </div>

            @auth
                <a href="{{ route('profile') }}"
                    style="{{ request()->routeIs('profile') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }} display: flex; align-items: center; gap: 8px;">

                    @if (Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Profile"
                            style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #ecf0f1;">
                    @endif
                    <span>{{ __('My Profile') }}</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; color: white; cursor: pointer; text-decoration: none;">
                        {{ __('Logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="{{ request()->routeIs('login') ? 'color: #3498db;' : '' }}">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}"
                    style="background: #3498db; color: white; padding: 8px 15px; border-radius: 4px; border:none; margin-left: 10px; {{ request()->routeIs('register') ? 'background: #2980b9;' : '' }}">
                    {{ __('Register') }}
                </a>
            @endauth
        </div>
    </nav>

    <div class="container-wrapper">
        <aside>
            <div class="logo">
                <div class="logo-box">L</div>
                <span>LARAVEL DC</span>
            </div>
            <nav>
                <a href="{{ route('resources.index') }}"
                    class="{{ request()->routeIs('resources.index') ? 'active' : '' }}">
                    📦 Inventory
                </a>

                @auth
                    @if(auth()->user()->canAccessMaintenance())
                        <a href="{{ route('maintenances.index') }}"
                            class="{{ request()->routeIs('maintenances.index') ? 'active' : '' }}">
                            🔧 Maintenance
                        </a>
                    @endif
                @endauth
            </nav>

            <div style="margin-top: auto; background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 12px;">
                <small style="color: #94a3b8; display: block; margin-bottom: 4px;">User</small>
                <strong style="font-size: 0.9rem;">
                    @auth
                        {{ auth()->user()->name }}
                        <span class="user-badge badge-{{ auth()->user()->role }}">
                            {{ auth()->user()->role }}
                        </span>
                    @else
                        Guest <span class="user-badge badge-guest">visitor</span>
                    @endauth
                </strong>
            </div>
        </aside>

        <main>
            <header>
                <h1>Resource Inventory</h1>
                <p>Direct access to the DataCenter's hardware and virtual assets.</p>
            </header>

            <!-- MESSAGE POUR LES VISITEURS NON CONNECTÉS -->
            @guest
                <div class="guest-message">
                    <h3>Vous n'avez pas de compte ?</h3>
                    <p>Pour réserver des ressources, vous devez créer un compte et être approuvé par un administrateur.</p>
                    <a href="{{ route('register') }}">📝 Créer un compte</a>
                    <a href="{{ route('login') }}" class="login">🔐 Se connecter</a>
                </div>
            @endguest

            @auth
                @if(auth()->user()->canManage())
                    <div style="display:flex; justify-content:flex-end; margin-bottom:1rem;">
                        <button class="btn-create" onclick="openAddPanel()">
                            + Create resource
                        </button>
                    </div>
                @endif
            @endauth

            <div class="filter-section">
                <div class="search-bar">
                    <input type="text" id="search-input" placeholder="Search by name...">
                    <select id="category-filter">
                        <option value="ALL">All Categories</option>
                        <option value="Serveur">Serveurs</option>
                        <option value="Machine Virtuelle">VMs</option>
                        <option value="Stockage">Storage</option>
                        <option value="Réseau">Réseau</option>
                    </select>
                </div>
                <div class="range-group">
                    <div class="range-item">
                        <label>Min CPU Cores <span id="cpu-val">0</span></label>
                        <input type="range" id="cpu-filter" min="0" max="100" value="0">
                    </div>
                    <div class="range-item">
                        <label>Min RAM (GB) <span id="ram-val">0</span></label>
                        <input type="range" id="ram-filter" min="0" max="212" value="0">
                    </div>
                    <div class="range-item">
                        <label>Min Storage (TB) <span id="storage-val">0</span></label>
                        <input type="range" id="storage-filter" min="0" max="1000" value="0">
                    </div>
                </div>
            </div>

            <div id="inventory-grid">
                @include('resources.partials.grid', ['resources' => $resources])
            </div>
        </main>
    </div>

    @auth
        @if(auth()->user()->canManage())
            <!-- Edit Modal - Only for Tech/Admin -->
            <div id="editModal" class="modal-overlay">
                <div class="modal-box">
                    <h3>Edit resource</h3>
                    <form method="POST" id="editForm">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="name" id="editName" placeholder="Name" required>
                        <input type="number" name="cpu_cores" id="editCpu" min="0" placeholder="CPU cores">
                        <input type="number" name="ram_gb" id="editRam" min="0" placeholder="RAM (GB)">
                        <input type="number" name="storage_gb" id="editStorage" min="0" placeholder="Storage (GB)">
                        <select name="state" id="editState" required>
                            <option value="available">Available</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        <div class="modal-actions">
                            <button type="submit" class="btn-reserve">Save</button>
                            <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <form id="deleteForm" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

            <!-- Add Panel - Only for Tech/Admin -->
            <div id="addPanel" class="modal-overlay">
                <div class="modal-box" style="width:420px;">
                    <h3>Create resource</h3>
                    <form id="createForm" method="POST" action="{{ route('resources.store') }}">
                        @csrf
                        <input type="text" name="name" placeholder="Resource name" class="mb-2">
                        <select name="category_id" id="createCategory" onchange="switchCreateFields()" class="mb-2">
                            <option value="">Choose type</option>
                            <option value="1">Serveur</option>
                            <option value="2">Machine Virtuelle</option>
                            <option value="3">Stockage</option>
                            <option value="4">Réseau</option>
                        </select>

                        <div id="create-compute" style="display:none;">
                            <input type="number" name="cpu_cores" placeholder="CPU cores">
                            <input type="number" name="ram_gb" placeholder="RAM (GB)">
                            <input type="number" name="compute_storage" placeholder="Storage (GB)">
                        </div>

                        <div id="create-storage" style="display:none;">
                            <input type="number" name="storage_storage" placeholder="Storage (GB)">
                            <input type="text" name="storage_type" placeholder="Storage type (HDD/SSD)">
                        </div>

                        <div id="create-network" style="display:none;">
                            <input type="number" name="bandwidth_mbps" placeholder="Bandwidth (Mbps)">
                        </div>

                        <select name="state" required>
                            <option value="available">Available</option>
                            <option value="maintenance">Maintenance</option>
                        </select>

                        <div class="modal-actions">
                            <button type="submit" class="btn-reserve">Create</button>
                            <button type="button" class="btn-cancel" onclick="closeAddPanel()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <script>
        'use strict';

        // ====== GLOBAL STATE ======
        let currentEditResourceId = null;

        // ====== MODAL & PANEL FUNCTIONS ======
        function openAddPanel() {
            const panel = document.getElementById('addPanel');
            if (panel) {
                panel.style.display = 'flex';
                console.log('Add panel opened');
            }
        }

        function closeAddPanel() {
            const panel = document.getElementById('addPanel');
            if (panel) {
                panel.style.display = 'none';
            }
        }

        function openEditModal(id, name, cpu, ram, storage, state) {
            console.log('Opening edit modal for resource:', id);
            currentEditResourceId = id;
            const modal = document.getElementById('editModal');
            if (!modal) {
                console.error('Edit modal not found');
                alert('Error: Modal not found');
                return;
            }
            modal.style.display = 'flex';
            document.getElementById('editName').value = name || '';
            document.getElementById('editCpu').value = cpu || '';
            document.getElementById('editRam').value = ram || '';
            document.getElementById('editStorage').value = storage || '';
            document.getElementById('editState').value = state || 'available';
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        function handleEditClick(button) {
            console.log('Edit button clicked');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const cpu = button.getAttribute('data-cpu');
            const ram = button.getAttribute('data-ram');
            const storage = button.getAttribute('data-storage');
            const state = button.getAttribute('data-state');
            console.log('Edit data:', { id, name, cpu, ram, storage, state });
            openEditModal(id, name, cpu, ram, storage, state);
        }

        function closeAllModals() {
            closeEditModal();
            closeAddPanel();
        }

        // ====== SIDEBAR TOGGLE ======
        function toggleSidebar() {
            console.log('Toggle sidebar called');
            const aside = document.querySelector('aside');
            const toggle = document.querySelector('.sidebar-toggle');
            if (!aside || !toggle) {
                console.error('Sidebar or toggle button not found');
                return;
            }
            aside.classList.toggle('active');
            toggle.classList.toggle('button-hidden');
            console.log('Sidebar toggled');
        }

        // ====== DELETE CONFIRMATION ======
        function confirmDelete(id) {
            if (!confirm('Are you sure you want to delete this resource?')) {
                return;
            }
            const form = document.getElementById('deleteForm');
            form.action = '/resources/' + id;
            form.submit();
        }

        // ====== FORM FIELD VISIBILITY ======
        function switchCreateFields() {
            const categoryId = document.getElementById('createCategory')?.value;
            if (!categoryId) return;

            document.getElementById('create-compute').style.display = 'none';
            document.getElementById('create-storage').style.display = 'none';
            document.getElementById('create-network').style.display = 'none';

            if (categoryId === '1' || categoryId === '2') {
                document.getElementById('create-compute').style.display = 'block';
            } else if (categoryId === '3') {
                document.getElementById('create-storage').style.display = 'block';
            } else if (categoryId === '4') {
                document.getElementById('create-network').style.display = 'block';
            }
        }

        // ====== MAIN INITIALIZATION ======
        document.addEventListener('DOMContentLoaded', function () {
            const search = document.getElementById('search-input');
            const category = document.getElementById('category-filter');
            const cpu = document.getElementById('cpu-filter');
            const ram = document.getElementById('ram-filter');
            const storage = document.getElementById('storage-filter');

            const cpuVal = document.getElementById('cpu-val');
            const ramVal = document.getElementById('ram-val');
            const storageVal = document.getElementById('storage-val');

            function fetchResources() {
                const params = new URLSearchParams({
                    search: search.value,
                    category: category.value,
                    min_cpu: cpu.value,
                    min_ram: ram.value,
                    min_storage: storage.value,
                });

                fetch('/resources/ajax-filter?' + params.toString())
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('inventory-grid').innerHTML = html;
                    })
                    .catch((err) => {
                        console.error('AJAX filter error:', err);
                    });
            }

            if (cpu) {
                cpu.addEventListener('input', () => {
                    if (cpuVal) cpuVal.textContent = cpu.value;
                    fetchResources();
                });
            }

            if (ram) {
                ram.addEventListener('input', () => {
                    if (ramVal) ramVal.textContent = ram.value;
                    fetchResources();
                });
            }

            if (storage) {
                storage.addEventListener('input', () => {
                    if (storageVal) storageVal.textContent = storage.value;
                    fetchResources();
                });
            }

            if (search) search.addEventListener('input', fetchResources);
            if (category) category.addEventListener('change', fetchResources);

            // CREATE FORM SUBMISSION
            @auth
                @if(auth()->user()->canManage())
                    const createForm = document.getElementById('createForm');
                    if (createForm) {
                        createForm.addEventListener('submit', function (e) {
                            e.preventDefault();
                            console.log('Create form submitted');

                            const nameField = this.querySelector('input[name="name"]');
                            const categoryField = document.getElementById('createCategory');
                            const categoryValue = categoryField.value;

                            if (nameField.value.trim() === '') {
                                alert('❌ Please enter a Resource Name.');
                                nameField.focus();
                                return;
                            }

                            if (categoryValue === '') {
                                alert('❌ Please select a Resource Type.');
                                categoryField.focus();
                                return;
                            }

                            let containerId = '';
                            let requiredInputs = [];
                            let fieldMapping = {};

                            if (categoryValue === '1' || categoryValue === '2') {
                                containerId = 'create-compute';
                                requiredInputs = ['cpu_cores', 'ram_gb', 'compute_storage'];
                                fieldMapping = { 'compute_storage': 'storage_gb' };
                            } else if (categoryValue === '3') {
                                containerId = 'create-storage';
                                requiredInputs = ['storage_storage', 'storage_type'];
                                fieldMapping = { 'storage_storage': 'storage_gb' };
                            } else if (categoryValue === '4') {
                                containerId = 'create-network';
                                requiredInputs = ['bandwidth_mbps'];
                                fieldMapping = {};
                            }

                            if (containerId) {
                                const container = document.getElementById(containerId);
                                for (let inputName of requiredInputs) {
                                    const input = container.querySelector(`[name="${inputName}"]`);
                                    if (!input || input.value.trim() === '') {
                                        const label = inputName.replace(/_/g, ' ').toUpperCase();
                                        alert(`❌ Please fill the field: ${label}`);
                                        if (input) input.focus();
                                        return;
                                    }
                                }
                            }

                            // Submit via AJAX
                            const formData = new FormData(this);

                            // Rename fields: compute_storage -> storage_gb, storage_storage -> storage_gb
                            for (let [oldName, newName] of Object.entries(fieldMapping)) {
                                if (formData.has(oldName)) {
                                    formData.set(newName, formData.get(oldName));
                                    formData.delete(oldName);
                                }
                            }

                            console.log('Submitting form data...');
                            console.log('Form fields:', {
                                name: formData.get('name'),
                                category_id: formData.get('category_id'),
                                state: formData.get('state')
                            });

                            fetch('/resources', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                                .then(response => {
                                    console.log('Response received:', response.status);
                                    if (response.ok || response.status === 201) {
                                        return response.json().then(data => {
                                            alert('✅ Resource created successfully!');
                                            closeAddPanel();
                                            setTimeout(() => location.reload(), 500);
                                        });
                                    } else if (response.status === 422) {
                                        return response.json().then(data => {
                                            console.error('Validation errors:', data.errors);
                                            let errorMsg = '❌ Validation errors:\n';
                                            for (let field in data.errors) {
                                                errorMsg += `\n${field}: ${data.errors[field].join(', ')}`;
                                            }
                                            alert(errorMsg);
                                        });
                                    } else {
                                        return response.json().then(data => {
                                            console.error('Server error:', data);
                                            throw new Error(data.error || `HTTP ${response.status}`);
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('❌ Error creating resource: ' + error.message);
                                });
                        });
                    }
                @endif
            @endauth

                // EDIT FORM SUBMISSION (via AJAX)
                @auth
                    @if(auth()->user()->canManage())
                        const editForm = document.getElementById('editForm');
                        if (editForm) {
                            editForm.addEventListener('submit', function (e) {
                                e.preventDefault();
                                console.log('Edit form submitted');

                                if (!currentEditResourceId) {
                                    alert('❌ Error: Resource ID not found');
                                    return;
                                }

                                // Get form inputs using querySelector
                                const form = this;
                                
                                // Log form structure
                                console.log('Form:', form);
                                console.log('Form HTML:', form.innerHTML.substring(0, 200));
                                
                                const nameInput = form.querySelector('input[name="name"]');
                                const stateInput = form.querySelector('select[name="state"]');
                                const cpuInput = form.querySelector('input[name="cpu_cores"]');
                                const ramInput = form.querySelector('input[name="ram_gb"]');
                                const storageInput = form.querySelector('input[name="storage_gb"]');
                                const tokenInput = form.querySelector('input[name="_token"]');

                                // Get values
                                const nameValue = nameInput ? nameInput.value.trim() : '';
                                const stateValue = stateInput ? stateInput.value : '';
                                const cpuValue = cpuInput ? cpuInput.value : '';
                                const ramValue = ramInput ? ramInput.value : '';
                                const storageValue = storageInput ? storageInput.value : '';
                                const tokenValue = tokenInput ? tokenInput.value : '';

                                console.log('Found inputs:', {
                                    name: !!nameInput,
                                    state: !!stateInput,
                                    cpu: !!cpuInput,
                                    ram: !!ramInput,
                                    storage: !!storageInput,
                                    token: !!tokenInput,
                                });

                                console.log('Input values:', {
                                    nameValue: nameValue,
                                    stateValue: stateValue,
                                    cpuValue: cpuValue,
                                    ramValue: ramValue,
                                    storageValue: storageValue,
                                    tokenValue: tokenValue,
                                });
                                if (!nameValue) {
                                    alert('❌ Please enter a Resource Name.');
                                    if (nameInput) nameInput.focus();
                                    return;
                                }

                                if (!stateValue) {
                                    alert('❌ Please select a State.');
                                    if (stateInput) stateInput.focus();
                                    return;
                                }

                                // Create JSON data instead of FormData
                                const jsonData = {
                                    name: nameValue,
                                    state: stateValue,
                                };
                                if (cpuValue) jsonData.cpu_cores = cpuValue;
                                if (ramValue) jsonData.ram_gb = ramValue;
                                if (storageValue) jsonData.storage_gb = storageValue;

                                console.log('Sending update for resource:', currentEditResourceId);
                                console.log('Data (JSON):', jsonData);

                                fetch(`/resources/${currentEditResourceId}`, {
                                    method: 'PATCH',
                                    body: JSON.stringify(jsonData),
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': tokenValue,
                                    }
                                })
                                    .then(response => {
                                        console.log('Response received:', response.status);
                                        if (response.ok) {
                                            return response.json().then(data => {
                                                alert('✅ Resource updated successfully!');
                                                closeEditModal();
                                                setTimeout(() => location.reload(), 500);
                                            });
                                        } else if (response.status === 422) {
                                            return response.json().then(data => {
                                                console.error('Validation errors:', data.errors);
                                                let errorMsg = '❌ Validation errors:\n';
                                                for (let field in data.errors) {
                                                    errorMsg += `\n${field}: ${data.errors[field].join(', ')}`;
                                                }
                                                alert(errorMsg);
                                            });
                                        } else if (response.status === 419) {
                                            throw new Error('CSRF token expired - please refresh the page');
                                        } else {
                                            return response.json().then(data => {
                                                console.error('Server error:', data);
                                                throw new Error(data.error || `HTTP ${response.status}`);
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('❌ Error updating resource: ' + error.message);
                                    });
                            });
                        }
                    @endif
                @endauth

            // EDIT MODAL CLOSE HANDLER
            document.addEventListener('click', function (e) {
                const editModal = document.getElementById('editModal');
                if (editModal && e.target === editModal) {
                    closeEditModal();
                }

                const addPanel = document.getElementById('addPanel');
                if (addPanel && e.target === addPanel) {
                    closeAddPanel();
                }
            });

            // SIDEBAR CLOSE ON OUTSIDE CLICK
            document.addEventListener('click', function (event) {
                const aside = document.querySelector('aside');
                const toggle = document.querySelector('.sidebar-toggle');

                if (window.innerWidth < 1400 && aside && toggle) {
                    if (!aside.contains(event.target) && !toggle.contains(event.target)) {
                        aside.classList.remove('active');
                        toggle.classList.remove('button-hidden');
                    }
                }
            });

            // SIDEBAR CLOSE ON RESIZE
            window.addEventListener('resize', function () {
                const aside = document.querySelector('aside');
                const toggle = document.querySelector('.sidebar-toggle');
                if (window.innerWidth >= 1400 && aside && toggle) {
                    aside.classList.remove('active');
                    toggle.classList.remove('button-hidden');
                }
            });
        });
    </script>

</body>

</html>