@extends('layout')

@section('content')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        margin: 0 0 10px 0;
        font-size: 2rem;
    }

    .dashboard-header p {
        margin: 0;
        opacity: 0.9;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #667eea;
    }

    .stat-card.users { border-left-color: #3498db; }
    .stat-card.resources { border-left-color: #2ecc71; }
    .stat-card.occupied { border-left-color: #f39c12; }
    .stat-card.maintenance { border-left-color: #e74c3c; }

    .stat-card h3 {
        margin: 0 0 10px 0;
        color: #7f8c8d;
        font-size: 0.9em;
        text-transform: uppercase;
    }

    .stat-card .number {
        font-size: 2em;
        font-weight: bold;
        color: #333;
        margin: 5px 0;
    }

    .content-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table thead tr {
        background: #ecf0f1;
    }

    .table th {
        padding: 12px;
        text-align: left;
        border-bottom: 2px solid #bdc3c7;
        font-weight: 600;
    }

    .table td {
        padding: 12px;
        border-bottom: 1px solid #ecf0f1;
    }

    .table tr:hover {
        background: #f8f9fa;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
    }

    .badge.active {
        background: #d4edda;
        color: #155724;
    }

    .badge.inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        background: #667eea;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.9em;
        transition: background 0.3s;
        margin-right: 5px;
    }

    .btn:hover {
        background: #764ba2;
    }

    .btn.danger {
        background: #e74c3c;
    }

    .btn.danger:hover {
        background: #c0392b;
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}! Manage your system.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card users">
            <h3>👥 Users</h3>
            <div class="number">{{ $totalUsers ?? 0 }}</div>
            <p style="margin: 0; color: #7f8c8d; font-size: 0.9em;">Total registered users</p>
        </div>

        <div class="stat-card resources">
            <h3>💾 Resources</h3>
            <div class="number">{{ $totalResources ?? 0 }}</div>
            <p style="margin: 0; color: #7f8c8d; font-size: 0.9em;">Total resources</p>
        </div>

        <div class="stat-card occupied">
            <h3>📌 In Use</h3>
            <div class="number">{{ $resourcesOccupied ?? 0 }}</div>
            <p style="margin: 0; color: #7f8c8d; font-size: 0.9em;">Currently occupied</p>
        </div>

        <div class="stat-card maintenance">
            <h3>🔧 Maintenance</h3>
            <div class="number">{{ $resourcesMaintenance ?? 0 }}</div>
            <p style="margin: 0; color: #7f8c8d; font-size: 0.9em;">Under maintenance</p>
        </div>
    </div>

    <div class="content-section">
        <h2 style="margin-top: 0;">User Management</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td><span style="text-transform: capitalize;">{{ $user->role }}</span></td>
                    <td>
                        @if($user->is_active)
                            <span class="badge active">Active</span>
                        @else
                            <span class="badge inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        @if(!$user->is_active)
                            <a href="{{ route('admin.users.activate', $user) }}" class="btn">Activate</a>
                        @endif
                        <a href="{{ route('admin.users.deactivate', $user) }}" class="btn danger">Deactivate</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #7f8c8d;">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="content-section">
        <h2 style="margin-top: 0;">Resources Management</h2>
        <a href="{{ route('admin.resources.index') }}" class="btn">Manage Resources</a>
    </div>
</div>
@endsection