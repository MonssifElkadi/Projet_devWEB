@foreach ($resources as $resource)
    @php
        $classMap = [1 => 'server', 2 => 'vm', 3 => 'storage', 4 => 'network'];
        $colors = [1 => '#60a5fa', 2 => '#ff6b08', 3 => '#8d01ff', 4 => '#0bc6f5'];
        $color = $colors[$resource->category_id] ?? '#94a3b8';
    @endphp

    <div class="res-card {{ $classMap[$resource->category_id] ?? '' }}">

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="status {{ $resource->state }}">
                {{ $resource->state }}
            </span>
            <small style="color: {{ $color }}; font-weight: 800;">
                {{ $resource->category->name ?? '-' }}
            </small>
        </div>

        <h3>{{ $resource->name }}</h3>

        <div class="specs-grid">
            @if($resource->cpu_cores)
                <div class="spec-box"><small>CPU</small><span>{{ $resource->cpu_cores }}</span></div>
            @endif
            @if($resource->ram_gb)
                <div class="spec-box"><small>RAM</small><span>{{ $resource->ram_gb }} GB</span></div>
            @endif
            @if($resource->storage_gb)
                <div class="spec-box" style="grid-column: span 2;"><small>Capacity</small><span>{{ $resource->storage_gb }}
                        GB</span></div>
            @endif
        </div>

        {{-- Main Action Button - Based on User Role --}}
        @auth
            {{-- For regular users: only show Reserve button --}}
            @if(auth()->user()->canReserve() && !auth()->user()->canManage())
                @if($resource->state === 'available')
                    <button class="btn-reserve" onclick="location.href='{{ route('resources.store') }}?res={{$resource->id}}'">
                        Reserve Resource
                    </button>
                @else
                    <button class="btn-reserve" style="background: #334155; cursor: not-allowed;" disabled>
                        {{ $resource->state === 'maintenance' ? 'Under Maintenance' : 'Occupied' }}
                    </button>
                @endif
            @endif

            {{-- For tech/admin: show full functionality --}}
            @if(auth()->user()->canManage())
                @if($resource->state === 'available')
                    <button class="btn-reserve" onclick="location.href='{{ route('resources.store') }}?res={{$resource->id}}'">
                        Reserve Resource
                    </button>
                @elseif($resource->state === 'maintenance')
                    <form action="{{ route('maintenances.resolve', $resource->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-reserve" style="background-color: #22c55e;">
                            ✅ Mark as Repaired
                        </button>
                    </form>
                @else
                    <button class="btn-reserve" style="background: #334155; cursor: not-allowed;" disabled>
                        Occupied
                    </button>
                @endif
            @endif
        @endauth

        {{-- For guests: no action button, just info --}}
        @guest
            @if($resource->state === 'available')
                <div
                    style="text-align: center; padding: 12px; background: rgba(59, 130, 246, 0.1); border-radius: 8px; color: #3b82f6; font-size: 0.85rem;">
                    ℹ️ Login to reserve resources
                </div>
            @elseif($resource->state !== 'maintenance')
                <button class="btn-reserve" style="background: #334155; cursor: not-allowed;" disabled>
                    Occupied
                </button>
            @endif
        @endguest

        {{-- Edit/Delete buttons - Only for Tech/Admin --}}
        @auth
            @if(auth()->user()->canManage())
                <div class="res-actions">
                    <button class="btn-edit" data-id="{{ $resource->id }}" data-name="{{ $resource->name }}"
                        data-cpu="{{ $resource->cpu_cores ?? 0 }}" data-ram="{{ $resource->ram_gb ?? 0 }}"
                        data-storage="{{ $resource->storage_gb ?? 0 }}" data-state="{{ $resource->state }}"
                        onclick="handleEditClick(this)">
                        Edit
                    </button>

                    <button class="btn-delete" onclick="confirmDelete({{ $resource->id }})">
                        Delete
                    </button>
                </div>
            @endif
        @endauth

    </div>
@endforeach