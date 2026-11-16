<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center mb-3 gap-2">
            <div class="w-100 w-md-auto">
                <input type="text" id="tabelSearch" class="form-control form-control-sm w-100" value="{{ request('search') }}" placeholder="Cari data..." style="max-width: 250px;">
            </div>
            <div>
                {{ $tombolAksi ?? '' }}
            </div>
        </div>
        <div class="table-responsive border rounded" id="tabelContainer">
            {{ $slot }}
        </div>
    </div>
</div>
