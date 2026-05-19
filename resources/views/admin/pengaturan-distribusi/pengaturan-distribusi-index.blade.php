@php
$selectedProgramId = (int) old('program_id', optional($selectedProgram)->id ?? optional($programs->first())->id);
$selectedProgram = $selectedProgram ?: $programs->firstWhere('id', $selectedProgramId) ?: $programs->first();
$selectedProgramId = optional($selectedProgram)->id;
$selectedSources = old('sumber_dana', ['zakat_maal']);
$oldMustahikIds = collect(old('mustahik_ids', []))->map(fn ($id) => (int) $id)->all();
$oldManualRecipients = old('manual_recipients', '[]');
$initialManualRecipients = json_decode($oldManualRecipients, true) ?: [];
$initialSelectedMustahik = $mustahikOptions
    ->whereIn('id', $oldMustahikIds)
    ->values()
    ->map(fn ($item) => [
        'id' => $item->id,
        'nama' => $item->nama,
        'kategori' => $item->kategori_label,
        'alamat' => $item->alamat,
    ]);
$readyPlans = $plans->where('status', 'siap');
$completedPlans = $plans->where('status', 'selesai');
$initialSelectedMustahikJson = $initialSelectedMustahik->toJson();
$initialManualRecipientsJson = json_encode($initialManualRecipients);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rencana Distribusi Dana - Fundmil Soreang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
</head>

<body class="sidebar-expanded">
    <div class="admin-layout">
        @include('admin.partials.sidebar', ['active' => 'distribusi'])

        <main class="admin-page-content distribution-page">
            <header class="admin-page-topbar">
                <div>
                    <h1 class="admin-page-title">Rencana Distribusi Dana</h1>
                    <p class="admin-page-desc">Siapkan penerima, nominal, dan sumber dana sebelum penyaluran dieksekusi.</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('program-penyaluran.index') }}">
                        <i class="bi bi-stars"></i>
                        <span>Program</span>
                    </a>
                    <a class="admin-secondary-btn" href="{{ route('penyaluran.create') }}">
                        <i class="bi bi-send-check"></i>
                        <span>Eksekusi</span>
                    </a>
                    @include('admin.partials.account-identity', [
                        'nameClass' => 'admin-user-name',
                        'roleClass' => 'admin-user-role',
                        'avatarClass' => 'admin-avatar',
                    ])
                </div>
            </header>

            <div class="admin-content-wrap">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <section class="distribution-overview" aria-label="Ringkasan dana distribusi">
                    <div class="distribution-balance-grid">
                        <article class="distribution-card">
                            <div class="distribution-card-head">
                                <h2 class="distribution-card-title">Zakat Fitrah</h2>
                                <span class="distribution-card-icon"><i class="bi bi-basket2-fill"></i></span>
                            </div>
                            <p class="distribution-card-value">Rp {{ number_format($saldo['fitrah_uang'], 0, ',', '.') }}</p>
                            <p class="distribution-card-note">
                                Beras {{ number_format($saldo['fitrah_beras_kg'], 2, ',', '.') }} kg
                                <br>
                                Setara Rp {{ number_format($saldo['fitrah_beras_setara'], 0, ',', '.') }}
                            </p>
                        </article>

                        <article class="distribution-card is-maal">
                            <div class="distribution-card-head">
                                <h2 class="distribution-card-title">Zakat Maal</h2>
                                <span class="distribution-card-icon"><i class="bi bi-gem"></i></span>
                            </div>
                            <p class="distribution-card-value">Rp {{ number_format($saldo['maal_total'], 0, ',', '.') }}</p>
                            <div class="maal-breakdown">
                                @forelse($saldo['maal_breakdown'] as $item)
                                <span class="maal-chip">{{ str($item['nama'])->title() }} - Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                                @empty
                                <span class="maal-chip">Belum ada transaksi maal</span>
                                @endforelse
                            </div>
                        </article>

                        <article class="distribution-card">
                            <div class="distribution-card-head">
                                <h2 class="distribution-card-title">Infaq & Sedekah</h2>
                                <span class="distribution-card-icon"><i class="bi bi-heart-fill"></i></span>
                            </div>
                            <p class="distribution-card-value">Rp {{ number_format($saldo['infaq_sedekah'], 0, ',', '.') }}</p>
                            <p class="distribution-card-note">Dana sosial fleksibel untuk program non-zakat.</p>
                        </article>

                        <article class="distribution-card">
                            <div class="distribution-card-head">
                                <h2 class="distribution-card-title">Fidyah / Kaffarah</h2>
                                <span class="distribution-card-icon"><i class="bi bi-cup-hot-fill"></i></span>
                            </div>
                            <p class="distribution-card-value">Rp {{ number_format($saldo['fidyah_kaffarah'], 0, ',', '.') }}</p>
                            <p class="distribution-card-note">Dipisahkan agar amanah sumber dana tetap jelas.</p>
                        </article>
                    </div>

                    <div class="distribution-total">
                        <div>
                            <p class="distribution-total-label">Total Dana Tercatat</p>
                            <p class="distribution-total-value">Rp {{ number_format($saldo['kas_total'], 0, ',', '.') }}</p>
                        </div>
                        <div class="distribution-total-meta">
                            <span>Dana Dicadangkan</span>
                            <strong>Rp {{ number_format($saldo['booked_total'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="distribution-total-meta">
                            <span>Siap Direncanakan</span>
                            <strong>Rp {{ number_format($saldo['saldo_tersedia'], 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </section>

                <div class="distribution-status-grid">
                    <article class="distribution-status-card">
                        <span class="distribution-step">1</span>
                        <div>
                            <strong>Pilih program</strong>
                            <p>Program menentukan tujuan dan kategori penyaluran.</p>
                        </div>
                    </article>
                    <article class="distribution-status-card">
                        <span class="distribution-step">2</span>
                        <div>
                            <strong>Tambahkan penerima</strong>
                            <p>Gunakan data mustahik aktif atau input mitra manual.</p>
                        </div>
                    </article>
                    <article class="distribution-status-card">
                        <span class="distribution-step">3</span>
                        <div>
                            <strong>Simpan rencana</strong>
                            <p>Rencana berstatus siap akan muncul di menu eksekusi.</p>
                        </div>
                    </article>
                </div>

                <form id="distribution-form" action="{{ route('pengaturan-distribusi.store') }}" method="post" data-search-url="{{ route('pengaturan-distribusi.mustahik-search') }}">
                    @csrf
                    <input id="initial_selected_mustahik" type="hidden" value="{{ $initialSelectedMustahikJson }}">
                    <input id="initial_manual_recipients" type="hidden" value="{{ $initialManualRecipientsJson }}">
                    <div class="distribution-workspace">
                        <section class="distribution-panel" aria-label="Pratinjau rencana distribusi">
                            <div class="distribution-panel-head">
                                <div>
                                    <h2 class="distribution-panel-title">Pratinjau Penerima</h2>
                                    <p class="distribution-panel-desc">Daftar ini yang akan disimpan sebagai rencana distribusi.</p>
                                </div>
                                <span class="distribution-badge"><span id="queue-count">0</span> penerima</span>
                            </div>

                            <div class="distribution-empty-guide" id="queue-empty-guide">
                                <i class="bi bi-person-plus-fill"></i>
                                <div>
                                    <strong>Belum ada penerima dipilih</strong>
                                    <span>Tambahkan penerima dari panel kanan untuk melihat nominal distribusi.</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="distribution-table">
                                    <thead>
                                        <tr>
                                            <th>Penerima</th>
                                            <th>Program</th>
                                            <th>Tujuan</th>
                                            <th class="text-end">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="queue-body">
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada penerima.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if($plans->isNotEmpty())
                            <div class="plan-history">
                                <div class="plan-history-head">
                                    <h3>Rencana Terakhir</h3>
                                    <span>{{ $readyPlans->count() }} siap, {{ $completedPlans->count() }} selesai</span>
                                </div>
                                @foreach($plans as $plan)
                                <div class="plan-history-item">
                                    <div>
                                        <strong>{{ $plan->kode_rencana }} - {{ $plan->programPenyaluran?->nama_program }}</strong>
                                        <span>{{ $plan->jumlah_penerima }} penerima - {{ str($plan->status)->title() }}</span>
                                    </div>
                                    <small>Rp {{ number_format($plan->total_alokasi, 0, ',', '.') }}</small>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </section>

                        <aside class="distribution-panel" aria-label="Form rencana distribusi">
                            <div class="distribution-panel-head">
                                <div>
                                    <h2 class="distribution-panel-title">Detail Rencana</h2>
                                    <p class="distribution-panel-desc">Isi data rencana sebelum disimpan ke antrean eksekusi.</p>
                                </div>
                            </div>

                            <div class="distribution-form-grid">
                                <div class="distribution-field">
                                    <label for="program_id">Program penyaluran</label>
                                    <select id="program_id" name="program_id" class="distribution-select" @disabled($programs->isEmpty())>
                                        @forelse($programs as $program)
                                        <option value="{{ $program->id }}" @selected((int) $selectedProgramId === $program->id)>
                                            {{ $program->nama_program }}
                                        </option>
                                        @empty
                                        <option value="">Belum ada program aktif</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="distribution-field">
                                    <label for="nominal_per_penerima">Nominal per penerima</label>
                                    <input id="nominal_per_penerima" name="nominal_per_penerima" class="distribution-input" type="number" min="0" step="1000" value="{{ old('nominal_per_penerima', 0) }}" placeholder="0">
                                </div>

                                <div class="distribution-field">
                                    <span class="distribution-label">Jenis penerima</span>
                                    <div class="recipient-toggle">
                                        <input id="tipe_database" type="radio" name="tipe_penerima" value="database_mustahik" @checked(old('tipe_penerima', 'database_mustahik') === 'database_mustahik')>
                                        <label for="tipe_database">Data Mustahik</label>
                                        <input id="tipe_manual" type="radio" name="tipe_penerima" value="manual_mitra" @checked(old('tipe_penerima') === 'manual_mitra')>
                                        <label for="tipe_manual">Mitra / Manual</label>
                                    </div>
                                </div>

                                <div class="distribution-field">
                                    <span class="distribution-label">Sumber dana</span>
                                    <div class="source-grid">
                                        @foreach($sourceLabels as $key => $label)
                                        <label class="source-option">
                                            <input type="checkbox" name="sumber_dana[]" value="{{ $key }}" data-balance="{{ $saldo['source_balances'][$key] ?? 0 }}" @checked(in_array($key, $selectedSources, true))>
                                            <span>
                                                {{ str($label)->title() }}
                                                <small>Rp {{ number_format($saldo['source_balances'][$key] ?? 0, 0, ',', '.') }}</small>
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div id="database-recipient-panel" class="distribution-field">
                                    <label for="mustahik_search">Cari mustahik aktif</label>
                                    <div class="recipient-search-box">
                                        <input id="mustahik_search" class="distribution-input" type="search" placeholder="Nama, NIK, alamat, atau asnaf">
                                        <div id="search-result-list" class="search-result-list">
                                            @forelse($mustahikOptions as $mustahik)
                                            <button class="search-result-item" type="button" data-id="{{ $mustahik->id }}" data-nama="{{ $mustahik->nama }}" data-kategori="{{ $mustahik->kategori_label }}" data-alamat="{{ $mustahik->alamat }}">
                                                <span>
                                                    <strong>{{ $mustahik->nama }}</strong>
                                                    <small class="d-block text-muted">{{ $mustahik->kategori_label }} - {{ $mustahik->alamat ?: 'alamat belum diisi' }}</small>
                                                </span>
                                                <i class="bi bi-plus-circle"></i>
                                            </button>
                                            @empty
                                            <div class="p-3 text-muted">Belum ada mustahik aktif.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div id="selected-mustahik-inputs"></div>
                                </div>

                                <div id="manual-recipient-panel" class="distribution-field d-none">
                                    <span class="distribution-label">Penerima manual / mitra</span>
                                    <div class="manual-entry-grid">
                                        <div>
                                            <label for="manual_nama">Nama penerima</label>
                                            <input id="manual_nama" class="distribution-input" type="text" placeholder="Contoh Yayasan Amanah">
                                        </div>
                                        <div>
                                            <label for="manual_tujuan">Tujuan</label>
                                            <input id="manual_tujuan" class="distribution-input" type="text" placeholder="Contoh paket sembako">
                                        </div>
                                        <button id="add-manual-recipient" class="distribution-add-btn" type="button">
                                            <i class="bi bi-plus-lg"></i>
                                            Tambah
                                        </button>
                                    </div>
                                    <input id="manual_recipients" name="manual_recipients" type="hidden" value="{{ $oldManualRecipients }}">
                                </div>

                                <div class="distribution-field">
                                    <label for="tujuan_penggunaan">Tujuan default</label>
                                    <input id="tujuan_penggunaan" name="tujuan_penggunaan" class="distribution-input" type="text" value="{{ old('tujuan_penggunaan', 'bantuan sesuai program') }}" placeholder="Contoh bantuan biaya hidup">
                                </div>

                                <div class="distribution-field">
                                    <label for="catatan">Catatan internal</label>
                                    <textarea id="catatan" name="catatan" class="distribution-textarea" placeholder="Opsional">{{ old('catatan') }}</textarea>
                                </div>

                                <div class="simulation-widget">
                                    <div class="distribution-panel-head mb-2">
                                        <div>
                                            <h2 class="distribution-panel-title">Ringkasan Rencana</h2>
                                            <p class="distribution-panel-desc">Total dihitung dari nominal dan jumlah penerima.</p>
                                        </div>
                                    </div>
                                    <div class="simulation-row">
                                        <span>Saldo sumber dana</span>
                                        <strong id="sim-start">Rp 0</strong>
                                    </div>
                                    <div class="simulation-row">
                                        <span>Total rencana</span>
                                        <strong id="sim-total">Rp 0</strong>
                                    </div>
                                    <div id="sim-result-row" class="simulation-result">
                                        <span>Estimasi sisa saldo</span>
                                        <strong id="sim-left">Rp 0</strong>
                                    </div>
                                    <p id="sim-warning" class="simulation-warning">Saldo sumber dana tidak cukup untuk rencana ini.</p>
                                </div>
                            </div>
                        </aside>
                    </div>

                    <div class="final-actions">
                        <button class="distribution-ghost-btn" type="button" onclick="window.print()">
                            <i class="bi bi-printer"></i>
                            Cetak Pratinjau
                        </button>
                        <a class="distribution-ghost-btn" href="{{ route('penyaluran.create') }}">
                            <i class="bi bi-send-check"></i>
                            Buka Eksekusi
                        </a>
                        <button id="save-plan-button" class="distribution-submit-btn" type="submit">
                            <i class="bi bi-lock-fill"></i>
                            Simpan Rencana Distribusi
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        sidebarToggle?.addEventListener('click', () => document.body.classList.toggle('sidebar-expanded'));

        const form = document.getElementById('distribution-form');
        const programSelect = document.getElementById('program_id');
        const nominalInput = document.getElementById('nominal_per_penerima');
        const sourceInputs = [...document.querySelectorAll('input[name="sumber_dana[]"]')];
        const typeInputs = [...document.querySelectorAll('input[name="tipe_penerima"]')];
        const databasePanel = document.getElementById('database-recipient-panel');
        const manualPanel = document.getElementById('manual-recipient-panel');
        const searchInput = document.getElementById('mustahik_search');
        const searchResultList = document.getElementById('search-result-list');
        const selectedMustahikInputs = document.getElementById('selected-mustahik-inputs');
        const manualRecipientsInput = document.getElementById('manual_recipients');
        const addManualRecipient = document.getElementById('add-manual-recipient');
        const manualNama = document.getElementById('manual_nama');
        const manualTujuan = document.getElementById('manual_tujuan');
        const tujuanPenggunaan = document.getElementById('tujuan_penggunaan');
        const queueBody = document.getElementById('queue-body');
        const queueCount = document.getElementById('queue-count');
        const queueEmptyGuide = document.getElementById('queue-empty-guide');
        const savePlanButton = document.getElementById('save-plan-button');
        const simStart = document.getElementById('sim-start');
        const simTotal = document.getElementById('sim-total');
        const simLeft = document.getElementById('sim-left');
        const simResultRow = document.getElementById('sim-result-row');
        const simWarning = document.getElementById('sim-warning');
        const searchUrl = form.dataset.searchUrl;
        const selectedMustahik = new Map();
        let manualRecipients = [];
        let searchTimer = null;
        const initialSelectedMustahikInput = document.getElementById('initial_selected_mustahik');
        const initialManualRecipientsInput = document.getElementById('initial_manual_recipients');

        const parseInitialJson = (input) => {
            try {
                return JSON.parse(input?.value || '[]');
            } catch {
                return [];
            }
        };

        parseInitialJson(initialSelectedMustahikInput).forEach((item) => selectedMustahik.set(String(item.id), item));
        manualRecipients = parseInitialJson(initialManualRecipientsInput).filter((item) => item && item.nama);

        const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        })[char]);

        const formatRupiah = (value) => {
            const number = Number(value) || 0;
            const prefix = number < 0 ? '-Rp ' : 'Rp ';
            return prefix + Math.abs(Math.round(number)).toLocaleString('id-ID');
        };

        const activeType = () => document.querySelector('input[name="tipe_penerima"]:checked')?.value || 'database_mustahik';
        const currentNominal = () => Number(nominalInput.value || 0);
        const currentBalance = () => sourceInputs
            .filter((input) => input.checked)
            .reduce((total, input) => {
                const raw = input.dataset.balance;
                const value = raw === undefined || raw === '' ? 0 : Number(raw);
                return total + (Number.isNaN(value) ? 0 : value);
            }, 0);

        const selectedProgramName = () => {
            const option = programSelect?.selectedOptions?.[0];
            return option ? option.textContent.trim() : '-';
        };

        const rowPurpose = (item) => item.tujuan || tujuanPenggunaan.value || 'bantuan sesuai program';

        const activeRecipients = () => {
            if (activeType() === 'manual_mitra') {
                return manualRecipients.map((item) => ({
                    ...item,
                    tipe: 'manual_mitra'
                }));
            }

            return [...selectedMustahik.values()].map((item) => ({
                ...item,
                tipe: 'database_mustahik'
            }));
        };

        const renderHiddenMustahikInputs = () => {
            selectedMustahikInputs.innerHTML = '';
            selectedMustahik.forEach((item) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'mustahik_ids[]';
                input.value = item.id;
                selectedMustahikInputs.appendChild(input);
            });
        };

        const updateSimulation = () => {
            const recipients = activeRecipients().length;
            const balance = currentBalance();
            const total = currentNominal() * recipients;
            const left = balance - total;
            const hasMinus = left < 0;
            const hasValidPlan = recipients > 0 && currentNominal() > 0 && sourceInputs.some((input) => input.checked) && programSelect?.value;

            simStart.textContent = formatRupiah(balance);
            simTotal.textContent = formatRupiah(total);
            simLeft.textContent = formatRupiah(left);
            simResultRow.classList.toggle('is-minus', hasMinus);
            simWarning.classList.toggle('is-visible', hasMinus);
            savePlanButton.disabled = hasMinus || !hasValidPlan;
        };

        const renderQueue = () => {
            const recipients = activeRecipients();
            const nominal = currentNominal();

            queueCount.textContent = recipients.length;
            queueEmptyGuide.classList.toggle('d-none', recipients.length > 0);
            manualRecipientsInput.value = JSON.stringify(manualRecipients);
            renderHiddenMustahikInputs();

            if (recipients.length === 0) {
                queueBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Belum ada penerima.</td></tr>';
                updateSimulation();
                return;
            }

            queueBody.innerHTML = recipients.map((item, index) => {
                const safeName = escapeHtml(item.nama);
                const safeProgram = escapeHtml(selectedProgramName());
                const safePurpose = escapeHtml(rowPurpose(item));
                const safeMeta = escapeHtml(item.kategori || item.alamat || 'mitra manual');
                const removeButton = item.tipe === 'manual_mitra'
                    ? `<button class="btn btn-sm btn-link text-danger p-0" type="button" data-remove-manual="${index}">Hapus</button>`
                    : `<button class="btn btn-sm btn-link text-danger p-0" type="button" data-remove-mustahik="${escapeHtml(item.id)}">Hapus</button>`;

                return `
                    <tr>
                        <td>
                            <p class="recipient-name">${safeName}</p>
                            <p class="recipient-meta">${safeMeta} ${removeButton}</p>
                        </td>
                        <td>${safeProgram}</td>
                        <td>${safePurpose}</td>
                        <td class="text-end">${formatRupiah(nominal)}</td>
                    </tr>
                `;
            }).join('');

            updateSimulation();
        };

        const renderSearchResults = (items) => {
            if (!items.length) {
                searchResultList.innerHTML = '<div class="p-3 text-muted">Data mustahik tidak ditemukan.</div>';
                return;
            }

            searchResultList.innerHTML = items.map((item) => `
                <button class="search-result-item" type="button" data-id="${escapeHtml(item.id)}" data-nama="${escapeHtml(item.nama)}" data-kategori="${escapeHtml(item.kategori || '-')}" data-alamat="${escapeHtml(item.alamat || '')}">
                    <span>
                        <strong>${escapeHtml(item.nama)}</strong>
                        <small class="d-block text-muted">${escapeHtml(item.kategori || '-')} - ${escapeHtml(item.alamat || 'alamat belum diisi')}</small>
                    </span>
                    <i class="bi bi-plus-circle"></i>
                </button>
            `).join('');
        };

        const searchMustahik = () => {
            const q = searchInput.value.trim();

            fetch(`${searchUrl}?q=${encodeURIComponent(q)}`, {
                headers: {
                    accept: 'application/json',
                },
            })
                .then((response) => response.json())
                .then((payload) => renderSearchResults(payload.data || []))
                .catch(() => renderSearchResults([]));
        };

        searchResultList.addEventListener('click', (event) => {
            const button = event.target.closest('.search-result-item');

            if (!button) {
                return;
            }

            selectedMustahik.set(String(button.dataset.id), {
                id: button.dataset.id,
                nama: button.dataset.nama,
                kategori: button.dataset.kategori,
                alamat: button.dataset.alamat,
            });

            renderQueue();
        });

        queueBody.addEventListener('click', (event) => {
            const removeManual = event.target.closest('[data-remove-manual]');
            const removeMustahik = event.target.closest('[data-remove-mustahik]');

            if (removeManual) {
                manualRecipients.splice(Number(removeManual.dataset.removeManual), 1);
                renderQueue();
            }

            if (removeMustahik) {
                selectedMustahik.delete(String(removeMustahik.dataset.removeMustahik));
                renderQueue();
            }
        });

        addManualRecipient.addEventListener('click', () => {
            const nama = manualNama.value.trim();
            const tujuan = manualTujuan.value.trim() || tujuanPenggunaan.value.trim();

            if (!nama) {
                manualNama.focus();
                return;
            }

            manualRecipients.push({
                nama,
                tujuan
            });
            manualNama.value = '';
            manualTujuan.value = '';
            renderQueue();
        });

        typeInputs.forEach((input) => input.addEventListener('change', () => {
            const isManual = activeType() === 'manual_mitra';
            databasePanel.classList.toggle('d-none', isManual);
            manualPanel.classList.toggle('d-none', !isManual);
            renderQueue();
        }));

        [nominalInput, programSelect, tujuanPenggunaan, ...sourceInputs].forEach((element) => {
            element?.addEventListener('input', renderQueue);
            element?.addEventListener('change', renderQueue);
        });

        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(searchMustahik, 250);
        });

        document.addEventListener('DOMContentLoaded', () => {
            const isManual = activeType() === 'manual_mitra';
            databasePanel.classList.toggle('d-none', isManual);
            manualPanel.classList.toggle('d-none', !isManual);
            renderQueue();
        });
    </script>
</body>

</html>
