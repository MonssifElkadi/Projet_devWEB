@extends('layout')

@section('content')
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #f5576c;
        }

        .card h3 {
            margin-top: 0;
            color: #333;
        }

        .card p {
            color: #666;
            margin: 10px 0;
        }

        .card .number {
            font-size: 2em;
            font-weight: bold;
            color: #f5576c;
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #f5576c;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #f093fb;
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Manager Dashboard</h1>
            <p>Welcome, {{ Auth::user()->name }}! Manage resource requests and approvals.</p>
        </div>

        <div class="content-grid">
            <div class="card">
                <h3>📋 Pending Requests</h3>
                <div class="number">0</div>
                <p>Resource requests waiting for approval</p>
                <a href="#" class="btn">View Requests</a>
            </div>

            <div class="card">
                <h3>✅ Approved</h3>
                <div class="number">0</div>
                <p>Approved resource allocations</p>
                <a href="#" class="btn">View Approved</a>
            </div>

            <div class="card">
                <h3>❌ Rejected</h3>
                <div class="number">0</div>
                <p>Rejected requests</p>
                <a href="#" class="btn">View Rejected</a>
            </div>

            <div class="card">
                <h3>💾 My Resources</h3>
                <p>Resources under your management</p>
                <a href="{{ route('resources.index') }}" class="btn">View Resources</a>
            </div>

            <div class="card">
                <h3>📊 Team Activity</h3>
                <p>Monitor your team's resource usage</p>
                <a href="#" class="btn">View Activity</a>
            </div>

            <div class="card">
                <h3>⚙️ Settings</h3>
                <p>Manage your account and preferences</p>
                <a href="{{ route('profile') }}" class="btn">Go to Settings</a>
            </div>
        </div>
    </div>
@endsection