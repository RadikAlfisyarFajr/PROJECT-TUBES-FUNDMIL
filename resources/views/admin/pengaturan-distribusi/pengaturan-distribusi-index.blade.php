@php
$selectedProgramId = (int) old('program_id', optional($selectedProgram)->id ?? optional($programs->first())->id);
$selectedProgram = $selectedProgram ?: $programs->firstWhere('id', $selectedProgramId) ?: $programs->first();
$selectedProgramId = optional($selectedProgram)->id;
$selectedSources = old('sumber_dana', ['zakat_maal']);
$oldMustahikIds = collect(old('mustahik_ids', []))->map(fn ($id) => (int) $id)->all();
$oldManualRecipients = old('manual_recipients', '[]');
$initialSelectedMustahik = $mustahikOptions
->whereIn('id', $oldMustahikIds)
->values()
->map(fn ($item) => [
'id' => $item->id,
'nama' => $item->nama,
'kategori' => $item->kategori_label,
'alamat' => $item->alamat,
]);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>pengaturan distribusi - fundmil soreang</title>
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
                    <h1 class="admin-page-title">pengaturan distribusi</h1>
                    <p class="admin-page-desc">susun rencana penyaluran, booking dana, dan validasi estimasi saldo sebelum eksekusi.</p>
                </div>
                <div class="admin-top-actions">
                    <a class="admin-secondary-btn" href="{{ route('program-penyaluran.index') }}">
                        <i class="bi bi-stars"></i>
                        <span>program</span>
                    </a>
                    <button class="admin-icon-btn has-dot" type="button" aria-label="notifikasi">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <button class="admin-icon-btn" type="button" aria-label="bantuan">
                        <i class="bi bi-question-circle-fill"></i>
                    </button>
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
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
                @endif

                <section aria-label="ringkasan saldo">
                    <div class="distribution-balance-grid">
                        <article class="distribution-card">
                            <div class="distribution-card-head">
                                <h2 class="distribution-card-title">zakat fitrah</h2>
                                <span class="distribution-card-icon"><i class="bi bi-basket2-fill"></i></span>
                            </div>
                            <p class="distribution-card-value">rp {{ number_format($saldo['fitrah_uang'], 0, ',', '.') }}</p>
                            <p class="distribution-card-note">
                                beras {{ number_format($saldo['fitrah_beras_kg'], 2, ',', '.') }} kg
                                <br>
                                nilai setara rp {{ number_format($saldo['fitrah_beras_setara'], 0, ',', '.') }}
                            </p>
                        </article>

                        <article class="distribution-card is-maal">
                            <div class="distribution-card-head">
                                <h2 class="distribution-card-title">zakat maal</h2>
                                <span class="distribution-card-icon"><i class="bi bi-gem"></i></span>
                            </div>
                            <p class="distribution-card-value">rp {{ number_format($saldo['maal_total'], 0, ',', '.') }}</p>
                            <div class="maal-breakdown">
                                @forelse($saldo['maal_breakdown'] as $item)
                                <span class="maal-chip">{{ $item['nama'] }} - rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                                @empty
                                <span class="maal-chip">belum ada transaksi maal</span>
                                @endforelse
                            </div>
                        </article>

                        <article class="distribution-card">
                            <div class="distribution-card-head">
                                <h2 class="distribution-card-title">infaq & sedekah</h2>
                                <span class="distribution-card-icon"><i class="bi bi-heart-fill"></i></span>
                            </div>
                            <p class="distribution-card-value">rp {{ number_format($saldo['infaq_sedekah'], 0, ',', '.') }}</p>
                            <p class="distribution-card-note">saldo kas sosial yang fleksibel untuk program non-zakat.</p>
                        </article>

                        <article class="distribution-card">
                            <div class="distribution-card-head">
                                <h2 class="distribution-card-title">fidyah / kaffarah</h2>
                                <span class="distribution-card-icon"><i class="bi bi-cup-hot-fill"></i></span>
                            </div>
                            <p class="distribution-card-value">rp {{ number_format($saldo['fidyah_kaffarah'], 0, ',', '.') }}</p>
                            <p class="distribution-card-note">dipisahkan agar rencana distribusi tetap sesuai amanah sumber dana.</p>
                        </article>
                    </div>

                    <div class="distribution-total">
                        <div>
                            <p class="distribution-total-label">grand total saldo kas</p>
                            <p class="distribution-total-value">rp {{ number_format($saldo['kas_total'], 0, ',', '.') }}</p>
                        </div>
                        <div class="distribution-total-meta">
                            <span>dana terbooking</span>
                            <strong>rp {{ number_format($saldo['booked_total'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="distribution-total-meta">
                            <span>saldo tersedia</span>
                            <strong>rp {{ number_format($saldo['saldo_tersedia'], 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </section>

                <form id="distribution-form" action="{{ route('pengaturan-distribusi.store') }}" method="post" data-search-url="{{ route('pengaturan-distribusi.mustahik-search') }}">
                    @csrf
                    <div class="distribution-workspace">
                        <section class="distribution-panel" aria-label="antrean penyaluran">
                            <div class="distribution-panel-head">
                                <div>
                                    <h2 class="distribution-panel-title">antrean penyaluran</h2>
                                    <p class="distribution-panel-desc">preview penerima yang akan masuk ke rencana program terpilih.</p>
                                </div>
                                <span class="distribution-badge"><span id="queue-count">0</span> penerima</span>
                            </div>

                            <div class="table-responsive">
                                <table class="distribution-table">
                                    <thead>
                                        <tr>
                                            <th>nama / institusi</th>
                                            <th>program</th>
                                            <th>tujuan penggunaan</th>
                                            <th class="text-end">nominal alokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="queue-body">
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">belum ada penerima dalam antrean.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if($plans->isNotEmpty())
                            <div class="plan-history">
                                @foreach($plans as $plan)
                                <div class="plan-history-item">
                                    <div>
                                        <strong>{{ $plan->kode_rencana }} - {{ $plan->programPenyaluran?->nama_program }}</strong>
                                        <span>{{ $plan->jumlah_penerima }} penerima - {{ $plan->status }}</span>
                                    </div>
                                    <small>rp {{ number_format($plan->total_alokasi, 0, ',', '.') }}</small>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </section>

                        <aside class="distribution-panel" aria-label="formulir konfigurasi rencana">
                            <div class="distribution-panel-head">
                                <div>
                                    <h2 class="distribution-panel-title">formulir konfigurasi rencana</h2>
                                    <p class="distribution-panel-desc">simpan sebagai status siap untuk mengunci dana tanpa memotong saldo utama.</p>
                                </div>
                            </div>

                            <div class="distribution-form-grid">
                                <div class="distribution-field">
                                    <label for="program_id">program penyaluran</label>
                                    <select id="program_id" name="program_id" class="distribution-select" @disabled($programs->isEmpty())>
                                        @forelse($programs as $program)
                                        <option value="{{ $program->id }}" @selected((int) $selectedProgramId===$program->id)>
                                            {{ $program->nama_program }}
                                        </option>
                                        @empty
                                        <option value="">belum ada program</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="distribution-field">
                                    <label for="nominal_per_penerima">alokasi nilai rata per penerima</label>
                                    <input id="nominal_per_penerima" name="nominal_per_penerima" class="distribution-input" type="number" min="0" step="1000" value="{{ old('nominal_per_penerima', 0) }}" placeholder="0">
                                </div>

                                <div class="distribution-field">
                                    <span class="distribution-label">tipe penerima</span>
                                    <div class="recipient-toggle">
                                        <input id="tipe_database" type="radio" name="tipe_penerima" value="database_mustahik" @checked(old('tipe_penerima', 'database_mustahik' )==='database_mustahik' )>
                                        <label for="tipe_database">database mustahik</label>
                                        <input id="tipe_manual" type="radio" name="tipe_penerima" value="manual_mitra" @checked(old('tipe_penerima')==='manual_mitra' )>
                                        <label for="tipe_manual">input manual / mitra</label>
                                    </div>
                                </div>

                                <div class="distribution-field">
                                    <span class="distribution-label">sumber dana</span>
                                    <div class="source-grid">
                                        @foreach($sourceLabels as $key => $label)
                                        <label class="source-option">
                                            <input type="checkbox" name="sumber_dana[]" value="{{ $key }}" data-balance="{{ $saldo['source_balances'][$key] ?? 0 }}" @checked(in_array($key, $selectedSources, true))>
                                            <span>
                                                {{ $label }}
                                                <small>rp {{ number_format($saldo['source_balances'][$key] ?? 0, 0, ',', '.') }}</small>
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div id="database-recipient-panel" class="distribution-field">
                                    <label for="mustahik_search">cari database mustahik</label>
                                    <div class="recipient-search-box">
                                        <input id="mustahik_search" class="distribution-input" type="search" placeholder="ketik nama, nik, alamat, atau asnaf">
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
                                            <div class="p-3 text-muted">belum ada mustahik aktif.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div id="selected-mustahik-inputs"></div>
                                </div>

                                <div id="manual-recipient-panel" class="distribution-field d-none">
                                    <span class="distribution-label">input manual / mitra</span>
                                    <div class="manual-entry-grid">
                                        <div>
                                            <label for="manual_nama">nama mitra</label>
                                            <input id="manual_nama" class="distribution-input" type="text" placeholder="contoh yayasan amanah">
                                        </div>
                                        <div>
                                            <label for="manual_tujuan">tujuan penggunaan</label>
                                            <input id="manual_tujuan" class="distribution-input" type="text" placeholder="contoh paket sembako">
                                        </div>
                                        <button id="add-manual-recipient" class="distribution-add-btn" type="button">
                                            <i class="bi bi-plus-lg"></i>
                                            tambah
                                        </button>
                                    </div>
                                    <input id="manual_recipients" name="manual_recipients" type="hidden" value="{{ $oldManualRecipients }}">
                                </div>

                                <div class="distribution-field">
                                    <label for="tujuan_penggunaan">tujuan penggunaan default</label>
                                    <input id="tujuan_penggunaan" name="tujuan_penggunaan" class="distribution-input" type="text" value="{{ old('tujuan_penggunaan', 'bantuan sesuai program') }}" placeholder="contoh bantuan biaya hidup">
                                </div>

                                <div class="distribution-field">
                                    <label for="catatan">catatan rencana</label>
                                    <textarea id="catatan" name="catatan" class="distribution-textarea" placeholder="opsional">{{ old('catatan') }}</textarea>
                                </div>

                                <div class="simulation-widget">
                                    <div class="distribution-panel-head mb-2">
                                        <div>
                                            <h2 class="distribution-panel-title">simulasi saldo</h2>
                                            <p class="distribution-panel-desc">saldo awal dikurangi total antrean.</p>
                                        </div>
                                    </div>
                                    <div class="simulation-row">
                                        <span>saldo awal</span>
                                        <strong id="sim-start">rp 0</strong>
                                    </div>
                                    <div class="simulation-row">
                                        <span>nominal x antrean</span>
                                        <strong id="sim-total">rp 0</strong>
                                    </div>
                                    <div id="sim-result-row" class="simulation-result">
                                        <span>estimasi sisa saldo</span>
                                        <strong id="sim-left">rp 0</strong>
                                    </div>
                                    <p id="sim-warning" class="simulation-warning">saldo tidak cukup. tombol simpan rencana dimatikan sampai nominal, sumber dana, atau antrean diperbaiki.</p>
                                </div>
                            </div>
                        </aside>
                    </div>

                    <div class="final-actions">
                        <button class="distribution-ghost-btn" type="button" onclick="window.print()">
                            <i class="bi bi-printer"></i>
                            cetak bukti penyerahan
                        </button>
                        <a class="distribution-ghost-btn" href="{{ route('penyaluran.create') }}">
                            <i class="bi bi-send-check"></i>
                            eksekusi penyaluran massal
                        </a>
                        <button id="save-plan-button" class="distribution-submit-btn" type="submit">
                            <i class="bi bi-lock-fill"></i>
                            simpan rencana
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

        const initialSelectedMustahik = @json($initialSelectedMustahik);
        const initialManualRecipients = @json(json_decode($oldManualRecipients, true) ?? []);

        initialSelectedMustahik.forEach((item) => selectedMustahik.set(String(item.id), item));
        manualRecipients = Array.isArray(initialManualRecipients) ? initialManualRecipients.filter((item) => item && item.nama) : [];

        const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        })[char]);

        const formatRupiah = (value) => {
            const number = Number(value) || 0;
            const prefix = number < 0 ? '-rp ' : 'rp ';
            return prefix + Math.abs(Math.round(number)).toLocaleString('id-id');
        };

        const activeType = () => document.querySelector('input[name="tipe_penerima"]:checked')?.value || 'database_mustahik';

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

        const currentNominal = () => Number(nominalInput.value || 0);

        const currentBalance = () => sourceInputs
            .filter((input) => input.checked)
            .reduce((total, input) => {
                    const raw = input.dataset.balance;
                    const value = raw === undefined || raw === '' ? 0 : Number(raw);
                    return total + (Number.isNaN(value) ? 0 : value);

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

                    const renderQueue = () => {
                        const recipients = activeRecipients();
                        const nominal = currentNominal();
                        queueCount.textContent = recipients.length;
                        manualRecipientsInput.value = JSON.stringify(manualRecipients);
                        renderHiddenMustahikInputs();

                        if (recipients.length === 0) {
                            queueBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">belum ada penerima dalam antrean.</td></tr>';
                            updateSimulation();
                            return;
                        }

                        queueBody.innerHTML = recipients.map((item, index) => {
                            const safeName = escapeHtml(item.nama);
                            const safeProgram = escapeHtml(selectedProgramName());
                            const safePurpose = escapeHtml(rowPurpose(item));
                            const safeMeta = escapeHtml(item.kategori || item.alamat || 'mitra manual');
                            const removeButton = item.tipe === 'manual_mitra' ?
                                `<button class="btn btn-sm btn-link text-danger p-0" type="button" data-remove-manual="${index}">hapus</button>` :
                                `<button class="btn btn-sm btn-link text-danger p-0" type="button" data-remove-mustahik="${escapeHtml(item.id)}">hapus</button>`;

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

                    const updateSimulation = () => {
                        const recipients = activeRecipients().length;
                        const balance = currentBalance();
                        const total = currentNominal() * recipients;
                        const left = balance - total;
                        const hasMinus = left < 0;
                        const hasValidPlan = recipients > 0 && sourceInputs.some((input) => input.checked) && programSelect?.value;

                        simStart.textContent = formatRupiah(balance);
                        simTotal.textContent = formatRupiah(total);
                        simLeft.textContent = formatRupiah(left);
                        simResultRow.classList.toggle('is-minus', hasMinus);
                        simWarning.classList.toggle('is-visible', hasMinus);
                        savePlanButton.disabled = hasMinus || !hasValidPlan;
                    };

                    const renderSearchResults = (items) => {
                        if (!items.length) {
                            searchResultList.innerHTML = '<div class="p-3 text-muted">data mustahik tidak ditemukan.</div>';
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