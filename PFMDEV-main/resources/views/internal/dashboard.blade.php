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
            border-left: 4px solid #667eea;
        }

        .card h3 {
            margin-top: 0;
            color: #333;
        }

        .card p {
            color: #666;
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #764ba2;
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, {{ Auth::user()->name }}!</h1>
            <p>Internal User Dashboard</p>
        </div>

        <div class="content-grid">
            <div class="card">
                <h3>📋 My Resources</h3>
                <p>View and manage your allocated resources.</p>
                <a href="{{ route('resources.index') }}" class="btn">View Resources</a>
            </div>

            <div class="card">
                <h3>📝 Create Reservation</h3>
                <p>Request to reserve available resources.</p>
                <a href="#" class="btn">New Reservation</a>
            </div>

            <div class="card">
                <h3>📊 My Activity</h3>
                <p>Check your recent activities and history.</p>
                <a href="#" class="btn">View Activity</a>
            </div>

            <div class="card">
                <h3>⚙️ Settings</h3>
                <p>Manage your account settings and preferences.</p>
                <a href="{{ route('profile') }}" class="btn">Go to Settings</a>
            </div>
        </div>
    </div>
@endsection