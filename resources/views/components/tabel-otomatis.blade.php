<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <input type="text" id="tabelSearch" class="form-control form-control-sm" placeholder="Cari data..." style="width: 250px;">
            </div>
            <div>
                {{ $slot }}
            </div>
        </div>
        <div class="table-responsive" id="tabelContainer">
            <!-- Table content loaded via tabel-otomatis.js -->
        </div>
    </div>
</div>
