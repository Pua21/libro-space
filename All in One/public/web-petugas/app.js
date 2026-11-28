'use strict';

const D = window.LibroDemo;
const { esc, icon, money, formatDate } = D;
const app = document.querySelector('#app');
const dialog = document.querySelector('#dialog');
const toast = document.querySelector('#toast');
let toastTimer;
let state = D.read();
let page = 'dashboard';
let reportDate = state.today;
const draft = { member: '', books: [] };
const filters = { buku: { query: '', value: '' }, anggota: { query: '', value: '' }, riwayat: { query: '', value: '' }, denda: { query: '', value: 'belum' }, pengembalian: { query: '', value: '' } };
const conditions = { baik: 'Baik', rusak_ringan: 'Rusak ringan', rusak_berat: 'Rusak berat', hilang: 'Hilang' };
const types = ['Mahasiswa', 'Dosen', 'Staf', 'Umum'];
const accountStatus = { aktif: 'Aktif', nonaktif: 'Nonaktif', suspend: 'Suspend' };
const pages = {
    dashboard: ['dashboard', 'Dashboard'],
    buku: ['menu_book', 'Data buku'],
    anggota: ['groups', 'Data anggota'],
    peminjaman: ['outbox', 'Peminjaman'],
    pengembalian: ['move_to_inbox', 'Pengembalian'],
    denda: ['receipt_long', 'Pembayaran denda'],
    riwayat: ['history', 'Riwayat transaksi'],
    laporan: ['assignment', 'Laporan harian'],
    profil: ['person', 'Profil'],
};

const badge = (label, tone = 'neutral') => `<span class="badge ${tone}">${esc(label)}</span>`;
const iconBox = (symbol, tone = 'info') => `<span class="icon-box ${tone}">${icon(symbol)}</span>`;
const btn = (label, action, id = '', classes = '', symbol = '') =>
    `<button type="button" class="button ${classes}" data-action="${action}" data-id="${esc(id)}">${symbol ? icon(symbol) : ''}${esc(label)}</button>`;
const link = (label, hash, classes = '', symbol = '') => `<a class="button ${classes}" href="#${hash}">${symbol ? icon(symbol) : ''}${esc(label)}</a>`;
const person = (id) => D.person(state, id);
const book = (id) => D.book(state, id);
const status = (value) => badge(accountStatus[value], value === 'aktif' ? 'success' : value === 'suspend' ? 'danger' : 'neutral');
const count = (list) => list.length;
const sum = (items, field) => items.reduce((total, item) => total + item[field], 0);
const findLoan = (id) => state.loans.find((loan) => loan.id === id);
const findFine = (id) => state.fines.find((fine) => fine.id === id);
const empty = (message, symbol = 'search') => `<div class="empty">${iconBox(symbol)}<strong>${esc(message)}</strong></div>`;
const title = (heading, description, action = '') => `<div class="page-heading spread"><div><h1>${heading}</h1><p>${description}</p></div>${action}</div>`;
const detail = (label, value) => `<div><dt>${label}</dt><dd>${esc(value)}</dd></div>`;
const table = (headings, rows, fallback = 'Tidak ada data yang cocok.') => rows.length
    ? `<div class="table-scroll" tabindex="0" aria-label="Tabel data"><table><thead><tr>${headings.map((heading) => `<th scope="col">${heading}</th>`).join('')}</tr></thead><tbody>${rows.join('')}</tbody></table></div>`
    : empty(fallback);
const row = (...cells) => '<tr>' + cells.map((cell) => '<td>' + cell + '</td>').join('') + '</tr>';
const options = (items, selectedValue) => items.map(([value, label]) =>
    `<option value="${esc(value)}" ${value === selectedValue ? 'selected' : ''}>${esc(label)}</option>`).join('');
const displayPerson = (item) => `<div class="flow person-row"><span class="avatar">${esc(D.initials(item.name))}</span><div><strong>${esc(item.name)}</strong><small class="mono">${esc(item.id)}</small></div></div>`;
const loanStatus = (loan) => {
    const entry = D.loanLabel(state, loan);
    return badge(entry.label, entry.tone);
};
const filterBar = (placeholder, selects = []) => {
    const filter = filters[page];
    return `<div class="filter-bar flow"><label class="search-box">${icon('search')}<input data-filter="query" aria-label="${esc(placeholder)}" placeholder="${esc(placeholder)}" value="${esc(filter.query)}"></label>
        ${selects.length ? `<select class="input" aria-label="Filter data" data-filter="value">${options(selects, filter.value)}</select>` : ''}</div>`;
};

function shell(content) {
    const menu = Object.entries(pages).map(([key, [symbol, label]]) =>
        `${key === 'peminjaman' ? '<div class="nav-group-title">Sirkulasi</div>' : key === 'riwayat' ? '<div class="nav-group-title">Administrasi</div>' : ''}
        <a href="#${key}" ${page === key ? 'aria-current="page"' : ''}>${icon(symbol)}${label}</a>`).join('');
            const staffAvatar = state.staff.avatar
                ? `<span class="avatar" style="overflow:hidden;padding:0;"><img src="${esc(state.staff.avatar)}" alt="${esc(state.staff.name)}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" onerror="this.parentElement.textContent='${esc(D.initials(state.staff.name))}'"></span>`
                : `<span class="avatar">${esc(D.initials(state.staff.name))}</span>`;
            return `<div class="shell">
        <aside class="sidebar site-chrome" id="sidebar"><a class="brand" href="#dashboard"><span class="brand-mark">${icon('local_library')}</span><span><span class="brand-label">Libro Space</span><span class="brand-role">Portal Petugas</span></span></a>
            <nav aria-label="Menu petugas">${menu}</nav>
            <div class="sidebar-footer"><div><span class="status-dot"></span>Mode demo lokal</div></div>
        </aside>
        <button class="mobile-shade" type="button" data-action="menu" aria-label="Tutup menu" tabindex="-1"></button>
        <div class="workspace">
            <header class="topbar site-chrome"><div class="flow">
                <button class="icon-button mobile-menu" type="button" aria-label="Menu petugas" aria-controls="sidebar" aria-expanded="false" data-action="menu">${icon('menu')}</button>
                <form class="search-wrap" data-form="quick-search">
                    <label class="search-box">${icon('search')}<input id="quick-search" name="query" type="search" placeholder="Cari judul, kode buku, atau anggota" aria-label="Pencarian cepat" autocomplete="off" aria-controls="quick-results"></label>
                    <div id="quick-results" class="top-search-results" hidden></div>
                </form>
            </div><a class="profile-link" href="#profil"><div><strong>${esc(state.staff.name)}</strong><small>Petugas Sirkulasi</small></div>${staffAvatar}</a></header>
            <main id="konten" tabindex="-1">${content}</main>
            <footer class="footer site-chrome"><span>© Libro Space · Portal Petugas</span><span>Data simulasi perpustakaan</span></footer>
        </div></div>`;
}

function dashboard() {
    const today = state.today;
    const loans = state.loans;
    const due = loans.filter((loan) => !loan.returnedOn && loan.dueOn === today);
    const late = loans.filter((loan) => !loan.returnedOn && D.overdue(state, loan)).sort((a, b) => a.dueOn.localeCompare(b.dueOn));
    const stats = [
        ['Peminjaman hari ini', count(loans.filter((loan) => loan.openedOn === today)), 'outbox', 'info', 'Transaksi sirkulasi keluar'],
        ['Pengembalian hari ini', count(loans.filter((loan) => loan.returnedOn === today)), 'move_to_inbox', 'success', 'Transaksi sirkulasi masuk'],
        ['Jatuh tempo hari ini', count(due), 'calendar_month', 'warning', 'Buku yang perlu dikembalikan'],
        ['Anggota terlambat', new Set(late.map((loan) => loan.memberId)).size, 'warning', 'danger', 'Denda berjalan ' + money(late.reduce((total, loan) => total + D.overdue(state, loan) * D.dailyFine, 0))],
    ];
    const statCards = stats.map(([label, value, symbol, tone, note]) => `<div class="panel stat">
        <div class="spread"><span class="label">${label}</span>${iconBox(symbol, tone)}</div><div class="stat-number">${value}</div><span class="stat-foot">${note}</span></div>`).join('');
    const rows = late.map((loan) => row(displayPerson(person(loan.memberId)), `<div class="overdue-book"><strong>${esc(book(loan.bookId).title)}</strong><small>${money(D.overdue(state, loan) * D.dailyFine)}</small></div>`,
        formatDate(loan.dueOn), badge(D.overdue(state, loan) + ' hari', 'danger'), btn('Detail', 'loan-detail', loan.id, 'flat compact')));
    const actions = [['peminjaman', 'add', 'Catat peminjaman', 'info'], ['pengembalian', 'move_to_inbox', 'Proses pengembalian', 'success'], ['denda', 'receipt_long', 'Pembayaran denda', 'warning']];
    return `<section class="hero" aria-labelledby="dashboard-title"><div class="hero-copy">
        <span class="hero-date">${icon('calendar_month')}${formatDate(today, true)}</span>
        <h1 id="dashboard-title">Dashboard Operasional</h1><p>Ringkasan peminjaman dan pengembalian di meja sirkulasi.</p>
        ${link('Peminjaman baru', 'peminjaman', '', 'add')}</div>
        <div class="hero-art" aria-hidden="true"><div class="hero-books"><i></i><i></i><i></i></div></div></section>
        <section class="stat-grid" aria-label="Ringkasan hari ini">${statCards}</section>
        <div class="dashboard-grid">
            <section class="panel due-panel"><div class="section-heading spread"><div class="flow overdue-title">${iconBox('history', 'danger')}<div><h2>Anggota terlambat</h2><p>Peminjaman yang melewati tenggat</p></div></div>${badge(late.length + ' buku', late.length ? 'danger' : 'success')}</div>
                ${table(['Anggota', 'Judul buku', 'Jatuh tempo', 'Terlambat', 'Aksi'], rows, 'Tidak ada pinjaman terlambat.')}
                <p class="panel-foot">${icon('info')} Denda keterlambatan ${money(D.dailyFine)} per hari.</p></section>
            <aside class="stack"><section class="panel"><div class="section-heading"><h2>Aksi cepat</h2><p>Transaksi meja layanan</p></div>
                <div class="action-list">${actions.map(([hash, symbol, label, tone]) => `<a class="quick-action" href="#${hash}">${iconBox(symbol, tone)}${label}${icon('chevron_right')}</a>`).join('')}</div></section>
                <div class="panel sidebar-note">${icon('calendar_month')}<div><strong>Jam layanan</strong><small>08.00–16.30 WIB</small></div></div>
            </aside>
        </div>`;
}

function bookRows() {
    const { query, value } = filters.buku;
    const rows = state.books.filter((item) => D.matches(query, item.title, item.author, item.isbn, item.id, item.category))
        .filter((item) => !value || (value === 'tersedia' ? item.stock > 0 : item.stock === 0))
        .map((item) => row(`<strong>${esc(item.title)}</strong><small>${esc(item.author)}</small>`, `<span class="mono">${esc(item.id)}</span>`,
            esc(item.category), esc(item.rack), badge(item.stock ? item.stock + ' tersedia' : 'Stok habis', item.stock ? 'success' : 'warning'),
            btn('Edit', 'edit-book', item.id, 'compact', 'edit')));
    return table(['Judul', 'Kode buku', 'Kategori', 'Rak', 'Stok', 'Aksi'], rows);
}

function memberRows() {
    const { query, value } = filters.anggota;
    const rows = state.members.filter((item) => D.matches(query, item.name, item.id, item.email, item.unit) && (!value || item.status === value))
        .map((item) => row(displayPerson(item), esc(item.type), esc(item.unit || '—'), status(item.status), formatDate(item.expiresOn),
            btn('Edit', 'edit-member', item.id, 'compact', 'edit')));
    return table(['Anggota', 'Jenis', 'Jurusan / unit', 'Status', 'Berlaku hingga', 'Aksi'], rows);
}

function selectedMemberSummary(item) {
    if (!item) return '<p class="muted option-result">Pilih anggota untuk memeriksa status dan kuota.</p>';
    return `<div class="panel pad option-result"><div class="spread">${displayPerson(item)}${status(item.status)}</div>
        <dl class="detail-list">${detail('Pinjaman aktif', D.active(state, item.id).length + ' dari ' + D.loanLimit)}${detail('Denda belum lunas', money(sum(D.outstanding(state, item.id), 'total')))}</dl></div>`;
}

function blockers(data, id, itemIds) {
    const member = D.person(data, id);
    if (!member) return ['Pilih anggota.'];
    const reasons = [];
    if (member.status !== 'aktif' || member.expiresOn < data.today) reasons.push('Keanggotaan tidak aktif atau sudah berakhir.');
    if (D.active(data, id).length + itemIds.length > D.loanLimit) reasons.push('Kuota maksimal ' + D.loanLimit + ' buku terlampaui.');
    if (D.outstanding(data, id).length) reasons.push('Anggota memiliki denda yang belum lunas.');
    if (itemIds.some((itemId) => !D.book(data, itemId)?.stock)) reasons.push('Stok salah satu buku sudah habis.');
    return reasons;
}

function borrowing() {
    const member = person(draft.member);
    const reasons = blockers(state, draft.member, draft.books);
    const ready = Boolean(draft.books.length && !reasons.length);
    const cards = draft.books.map((id) => {
        const item = book(id);
        return `<div class="spread selected-item"><div><strong>${esc(item.title)}</strong><p class="muted">${esc(item.id)} · Rak ${esc(item.rack)}</p></div>${btn('Hapus', 'remove-book', item.id, 'compact', 'remove')}</div>`;
    }).join('');
    return title('Peminjaman baru', 'Pilih anggota dan buku untuk mencatat transaksi sirkulasi.') + `<div class="form-layout">
        <div class="stack">
            <section class="panel form-step"><h2>Identifikasi anggota</h2><label class="field">Nomor anggota atau nama<select id="borrow-member"><option value="">Pilih anggota</option>${options(state.members.map((item) => [item.id, item.id + ' · ' + item.name]), draft.member)}</select></label>${selectedMemberSummary(member)}</section>
            <section class="panel form-step"><h2>Tambah buku</h2><form data-form="add-draft-book" class="flow"><label class="search-box flex-main">${icon('search')}<input name="book" list="book-codes" placeholder="Judul, kode, atau ISBN" aria-label="Judul, kode, atau ISBN" autocomplete="off" required></label>
                <datalist id="book-codes">${state.books.map((item) => `<option value="${esc(item.id)}">${esc(item.title)}</option>`).join('')}</datalist><button class="button primary">${icon('add')} Tambah buku</button></form>
                ${cards || '<p class="muted option-result">Belum ada buku yang dipilih.</p>'}</section>
        </div>
        <section class="panel pad stack"><h2>Ringkasan sirkulasi</h2><dl class="detail-list">
            ${detail('Buku dipilih', draft.books.length)}${detail('Masa pinjam', D.loanDays + ' hari')}${detail('Jatuh tempo', formatDate(D.addDays(state.today, D.loanDays)))}</dl>
            <div class="hint ${ready ? 'success' : reasons.length && member ? 'warning' : 'info'}">${icon(ready ? 'check_circle' : 'info')}<div>${ready ? 'Stok, status anggota, kuota, dan denda memenuhi syarat.' : reasons.length ? reasons.map(esc).join('<br>') : 'Tambahkan minimal satu buku.'}</div></div>
            <button type="button" class="button primary" data-action="save-loan" ${ready ? '' : 'disabled'}>${icon('check')} Simpan transaksi</button></section>
        </div>`;
}

function returnRows() {
    const { query } = filters.pengembalian;
    const rows = state.loans.filter((loan) => !loan.returnedOn && D.matches(query, loan.id, person(loan.memberId).name, loan.memberId, book(loan.bookId).title))
        .map((loan) => row(`<span class="mono">${esc(loan.id)}</span>`, displayPerson(person(loan.memberId)), esc(book(loan.bookId).title),
            formatDate(loan.dueOn), loanStatus(loan), btn('Proses', 'return-loan', loan.id, 'compact primary')));
    return table(['Transaksi', 'Anggota', 'Judul', 'Jatuh tempo', 'Status', 'Aksi'], rows, 'Tidak ada pinjaman aktif yang cocok.');
}

function fineRows() {
    const { query, value } = filters.denda;
    const rows = state.fines.filter((fine) => (value === '' || (value === 'lunas') === Boolean(fine.paidOn)) &&
        D.matches(query, fine.id, person(fine.memberId).name, fine.memberId, book(findLoan(fine.loanId).bookId).title))
        .map((fine) => row(`<span class="mono">${esc(fine.id)}</span>`, displayPerson(person(fine.memberId)), esc(book(findLoan(fine.loanId).bookId).title),
            money(fine.total), fine.paidOn ? badge('Lunas', 'success') : badge('Belum lunas', 'warning'),
            fine.paidOn ? btn('Bukti', 'fine-receipt', fine.id, 'compact') : btn('Bayar', 'pay-fine', fine.id, 'compact primary')));
    return table(['Tagihan', 'Anggota', 'Buku', 'Total', 'Status', 'Aksi'], rows, 'Tidak ada tagihan untuk filter ini.');
}

function activity() {
    const loans = state.loans.map((loan) => ({ id: loan.id, loanId: loan.id, date: loan.openedOn, kind: 'Peminjaman', memberId: loan.memberId, bookId: loan.bookId }));
    const returns = state.loans.filter((loan) => loan.returnedOn).map((loan) => ({ id: loan.id, loanId: loan.id, date: loan.returnedOn, kind: 'Pengembalian', memberId: loan.memberId, bookId: loan.bookId }));
    const payments = state.fines.filter((fine) => fine.paidOn).map((fine) => ({ id: fine.id, loanId: fine.loanId, date: fine.paidOn, kind: 'Pembayaran denda', memberId: fine.memberId, bookId: findLoan(fine.loanId).bookId, amount: fine.total }));
    return [...payments.reverse(), ...returns.reverse(), ...loans.reverse()].sort((a, b) => b.date.localeCompare(a.date));
}

function activityTable(entries) {
    return table(['Tanggal', 'Transaksi', 'Jenis', 'Anggota', 'Judul buku', 'Aksi'], entries.map((entry) =>
        row(formatDate(entry.date), `<span class="mono">${esc(entry.id)}</span>`, badge(entry.kind, entry.kind === 'Pengembalian' ? 'success' : entry.amount ? 'warning' : 'info'),
            esc(person(entry.memberId).name), esc(book(entry.bookId).title),
            btn('Detail', entry.amount ? 'fine-receipt' : 'loan-detail', entry.id, 'flat compact'))));
}

function historyRows() {
    const { query, value } = filters.riwayat;
    return activityTable(activity().filter((entry) => (!value || entry.kind === value) && D.matches(query, entry.id, entry.kind, book(entry.bookId).title, person(entry.memberId).name)));
}

function report() {
    const entries = activity().filter((entry) => entry.date === reportDate);
    const reportStats = [
        ['Peminjaman', entries.filter((entry) => entry.kind === 'Peminjaman').length, 'outbox'],
        ['Pengembalian', entries.filter((entry) => entry.kind === 'Pengembalian').length, 'move_to_inbox'],
        ['Denda diterima', money(entries.reduce((total, entry) => total + (entry.amount || 0), 0)), 'receipt_long'],
    ];
    return title('Laporan harian', 'Ringkasan transaksi pada ' + formatDate(reportDate, true) + '.',
        `<div class="flow non-print">${btn('Unduh CSV','export-report','','','download')}${btn('Cetak','print-report','','primary','print')}</div>`) +
        `<section class="panel stack"><div class="filter-bar non-print"><label class="field" style="max-width:230px">Tanggal laporan<input id="report-date" type="date" value="${reportDate}" required></label></div>
        <div class="pad flow">${reportStats.map(([label, metric, symbol]) => `<div class="flow" style="min-width:170px">${iconBox(symbol)}<div><strong>${metric}</strong><div class="muted">${label}</div></div></div>`).join('')}</div>${activityTable(entries)}</section>`;
}

function profile() {
    const staff = state.staff;
    const avatarContent = staff.avatar
        ? `<img src="${esc(staff.avatar)}" alt="${esc(staff.name)}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" onerror="this.parentElement.textContent='${esc(D.initials(staff.name))}'">`
        : esc(D.initials(staff.name));

    return title('Profil petugas', 'Informasi petugas meja sirkulasi.') + `<section class="panel pad stack" style="max-width:630px">
        <div class="flow" style="align-items:center;gap:16px;">
            <div style="position:relative;display:inline-block;">
                <span class="avatar" id="staffPageAvatar" style="width:64px;height:64px;font-size:22px;border-radius:50%;overflow:hidden;border:2px solid var(--border,#e2e8f0);box-shadow:0 4px 10px rgba(0,0,0,0.06);display:grid;place-items:center;background:var(--primary-soft,#eef2ff);color:var(--primary,#534dec);">${avatarContent}</span>
                <button type="button" class="button compact" data-action="change-staff-avatar" style="position:absolute;bottom:-4px;right:-4px;padding:0;width:28px;height:28px;min-height:28px;border-radius:50%;background:#ffffff;border:1px solid #cbd5e1;box-shadow:0 2px 6px rgba(0,0,0,0.15);display:flex;align-items:center;justify-content:center;cursor:pointer;color:#475569;" title="Ganti Foto Profil">
                    ${icon('photo_camera')}
                </button>
                <input type="file" id="staffAvatarInput" accept="image/*" style="display:none">
            </div>
            <div>
                <h2>${esc(staff.name)}</h2>
                <p class="muted">${esc(staff.unit)}</p>
            </div>
        </div>
        <dl class="detail-list">
            ${detail('NIP', staff.nip)}
            ${detail('Email', staff.email)}
            ${detail('Telepon', staff.phone)}
            ${detail('Hak akses', 'Petugas')}
        </dl>
        <div class="flow">
            ${btn('Edit kontak','edit-staff','','','edit')}
            ${btn('Ganti Foto Profil','change-staff-avatar','','outline','photo_camera')}
        </div>
    </section>`;
}

const lists = { buku: bookRows, anggota: memberRows, pengembalian: returnRows, denda: fineRows, riwayat: historyRows };
const listConfig = {
    buku: ['Data buku', 'Kelola judul, lokasi, dan stok eksemplar perpustakaan.', 'Cari judul, penulis, atau kode', [['','Semua stok'],['tersedia','Tersedia'],['habis','Stok habis']]],
    anggota: ['Data anggota', 'Lihat profil dan status keanggotaan perpustakaan.', 'Cari nama atau nomor anggota', [['','Semua status'],...Object.entries(accountStatus)]],
    pengembalian: ['Pengembalian', 'Cari pinjaman aktif dan catat kondisi buku yang dikembalikan.', 'Cari transaksi, anggota, atau judul', []],
    denda: ['Pembayaran denda', 'Periksa tagihan dan catat pembayaran di meja sirkulasi.', 'Cari tagihan, anggota, atau judul', [['','Semua tagihan'],['belum','Belum lunas'],['lunas','Lunas']]],
    riwayat: ['Riwayat transaksi', 'Telusuri peminjaman, pengembalian, dan pembayaran yang tercatat.', 'Cari kode transaksi, anggota, atau judul', [['','Semua transaksi'],...['Peminjaman','Pengembalian','Pembayaran denda'].map((key) => [key,key])]],
};

function render() {
    state = D.read();
    const hash = location.hash.slice(1);
    if (hash !== 'konten') page = Object.hasOwn(pages, hash) ? hash : 'dashboard';
    const standalone = { dashboard, peminjaman: borrowing, laporan: report, profil: profile };
    let content;
    if (Object.hasOwn(standalone, page)) {
        content = standalone[page]();
    } else {
        const [heading, description, placeholder, selects] = listConfig[page];
        const action = page === 'buku' ? btn('Tambah buku', 'edit-book', '', 'primary', 'add') :
            page === 'anggota' ? btn('Tambah anggota', 'edit-member', '', 'primary', 'add') : '';
        content = title(heading, description, action) + `<section class="panel">${filterBar(placeholder, selects)}<div id="list-results">${lists[page]()}</div></section>`;
    }
    app.innerHTML = shell(content);
    document.title = pages[page][1] + ' Petugas | Libro Space';
}

function showToast(message, error = false) {
    if (error && dialog.open) {
        const content = dialog.querySelector('.dialog-content');
        content.querySelector('[role="alert"]')?.remove();
        const warning = document.createElement('p');
        warning.className = 'hint danger';
        warning.setAttribute('role', 'alert');
        warning.textContent = message;
        content.prepend(warning);
        return;
    }
    clearTimeout(toastTimer);
    toast.hidden = false;
    toast.classList.toggle('error', error);
    toast.textContent = message;
    toastTimer = setTimeout(() => { toast.hidden = true; }, 4800);
}

function openDialog(heading, body) {
    dialog.innerHTML = `<div class="dialog-head"><h2 id="dialog-title">${heading}</h2><button type="button" class="icon-button" aria-label="Tutup dialog" data-action="close">${icon('close')}</button></div><div class="dialog-content">${body}</div>`;
    if (!dialog.open) dialog.showModal();
}

const formActions = (label) => `<div class="dialog-actions">${btn('Batal', 'close')}<button class="button primary" type="submit">${label}</button></div>`;
const input = (label, name, value = '', attrs = 'required') => `<label class="field">${label}<input name="${name}" value="${esc(value)}" ${attrs}></label>`;
const select = (label, name, values, selected) => `<label class="field">${label}<select name="${name}">${options(values, selected)}</select></label>`;

function bookDialog(id) {
    const item = book(id) || {};
    openDialog(id ? 'Edit buku' : 'Tambah buku', `<form data-form="save-book" data-id="${esc(id)}"><div class="form-grid">
        ${input('Judul buku','title', item.title, 'required maxlength="120"')}${input('Pengarang','author', item.author, 'required maxlength="100"')}
        ${input('Kategori','category',item.category,'required maxlength="40"')}${input('Rak','rack',item.rack,'required maxlength="15"')}
        ${input('ISBN','isbn',item.isbn,'required inputmode="numeric" pattern="[0-9]{10,13}"')}${input('Stok tersedia','stock',item.stock ?? 1,'required type="number" min="0" max="999"')}
        ${input('Harga acuan (Rp)','price',item.price ?? 0,'required type="number" min="0" max="99999999"')}${input('Tahun terbit','year',item.year ?? new Date().getFullYear(),'required type="number" min="1400" max="2100"')}
        </div>${formActions('Simpan buku')}</form>`);
}

function memberDialog(id) {
    const item = person(id) || {};
    openDialog(id ? 'Edit anggota' : 'Tambah anggota', `<form data-form="save-member" data-id="${esc(id)}"><div class="form-grid">
        ${input('Nama lengkap','name',item.name,'required maxlength="100"')}${input('Email','email',item.email,'required type="email" maxlength="100"')}
        ${select('Jenis anggota','type',types.map((key) => [key,key]),item.type)}${select('Status akun','status',Object.entries(accountStatus),item.status)}
        ${input('No. telepon','phone',item.phone,'required type="tel" maxlength="20"')}${input('Jurusan / unit','unit',item.unit,'maxlength="100"')}
        ${input('Masa berlaku','expiresOn',item.expiresOn || D.addDays(state.today,365),'required type="date"')}
        ${input('Alamat','address',item.address,'maxlength="170"')}</div>${formActions('Simpan anggota')}</form>`);
}

function loanReceipt(loan, heading = 'Detail peminjaman') {
    openDialog(heading, `<dl class="detail-list">${detail('Kode transaksi',loan.id)}${detail('Anggota',person(loan.memberId).name)}
        ${detail('Buku',book(loan.bookId).title)}${detail('Dipinjam',formatDate(loan.openedOn))}${detail('Jatuh tempo',formatDate(loan.dueOn))}
        ${detail('Tanggal kembali',formatDate(loan.returnedOn))}${loan.condition ? detail('Kondisi buku',conditions[loan.condition]) : ''}
        ${loan.notes ? detail('Catatan',loan.notes) : ''}</dl><div class="dialog-actions">${loan.returnedOn ? '' : btn('Proses pengembalian','return-loan',loan.id)}
        ${btn('Cetak bukti','print-dialog','','primary','print')}</div>`);
}

function projectedFine(loan, condition, data = state) {
    const late = D.overdue(data, loan) * D.dailyFine;
    const conditionFee = { baik: 0, rusak_ringan: 5000, rusak_berat: 20000, hilang: D.book(data, loan.bookId).price }[condition];
    return { late, conditionFee, total: late + conditionFee };
}

function returnDialog(loan) {
    openDialog('Proses pengembalian', `<form data-form="save-return" data-id="${esc(loan.id)}" class="stack">
        <div><strong>${esc(book(loan.bookId).title)}</strong><p class="muted">${esc(person(loan.memberId).name)} · ${esc(loan.id)}</p></div>
        ${select('Kondisi buku','condition',Object.entries(conditions),'baik')}
        <label class="field">Catatan pemeriksaan<textarea name="notes" maxlength="180" placeholder="Opsional"></textarea></label>
        <div class="hint warning">${icon('receipt_long')}<span>Perkiraan denda <strong id="return-total">${money(projectedFine(loan,'baik').total)}</strong></span></div>
        ${formActions('Simpan pengembalian')}</form>`);
}

function payDialog(fine) {
    openDialog('Pembayaran denda', `<form data-form="save-fine" data-id="${esc(fine.id)}" class="stack">
        <dl class="detail-list">${detail('Anggota',person(fine.memberId).name)}${detail('Total tagihan',money(fine.total))}</dl>
        ${select('Metode pembayaran','method',[['Tunai','Tunai'],['QRIS','QRIS (simulasi)'],['Transfer','Transfer (simulasi)']],'Tunai')}
        ${input('Nominal diterima (Rp)','tender',fine.total,'required type="number" min="' + fine.total + '" max="99999999"')}
        ${formActions('Catat pembayaran')}</form>`);
}

function fineReceipt(fine) {
    openDialog('Bukti pembayaran denda', `<dl class="detail-list">${detail('Nomor bukti',fine.id)}${detail('Anggota',person(fine.memberId).name)}
        ${detail('Tanggal',formatDate(fine.paidOn))}${detail('Metode',fine.method)}${detail('Tagihan',money(fine.total))}
        ${detail('Diterima',money(fine.tender))}${detail('Kembalian',money(fine.tender - fine.total))}</dl>
        <div class="dialog-actions">${btn('Cetak bukti','print-dialog','','primary','print')}</div>`);
}

function saveBorrowing() {
    const [id, ...others] = D.update((data) => {
        const reasons = blockers(data, draft.member, draft.books);
        if (reasons.length) throw new Error(reasons.join(' '));
        if (!draft.books.length) throw new Error('Tambahkan minimal satu buku.');
        return draft.books.map((itemId) => {
            const item = D.book(data,itemId);
            item.stock -= 1;
            item.popularity += 1;
            const id = D.nextId(data,'PJ');
            const dueOn = D.addDays(data.today,D.loanDays);
            data.loans.push({ id, memberId: draft.member, bookId: itemId, openedOn: data.today, dueOn, returnedOn: null, condition: null, extensions: 0 });
            D.notify(data,draft.member,'Peminjaman baru',item.title + ' jatuh tempo ' + formatDate(dueOn) + '.', 'info','outbox');
            return id;
        });
    });
    draft.member = '';
    draft.books = [];
    render();
    showToast('Tersimpan: ' + [id,...others].join(', ') + '.');
    if (others.length) {
        openDialog('Bukti peminjaman', `<div class="stack">${[id,...others].map((code) => `<p><strong>${code}</strong> · ${esc(book(findLoan(code).bookId).title)}<br><span class="muted">Jatuh tempo ${formatDate(findLoan(code).dueOn)}</span></p>`).join('')}</div><div class="dialog-actions">${btn('Cetak bukti','print-dialog','','primary','print')}</div>`);
    } else {
        loanReceipt(findLoan(id),'Bukti peminjaman');
    }
}

function handleForm(form) {
    const id = form.dataset.id;
    const values = Object.fromEntries([...new FormData(form)].map(([key, value]) => [key, value.trim()]));
    switch (form.dataset.form) {
        case 'quick-search': {
            if (!values.query) return;
            const first = document.querySelector('#quick-results a');
            if (first) return first.click();
            filters.buku.query = values.query;
            if (page === 'buku') render();
            else location.hash = 'buku';
            return;
        }
        case 'add-draft-book': {
            if (!values.book) throw new Error('Masukkan judul, kode, atau ISBN buku.');
            const exact = state.books.find((item) => [item.id, item.isbn, item.title].some((value) => value.toLowerCase() === values.book.toLowerCase()));
            const related = state.books.filter((item) => D.matches(values.book, item.title, item.id, item.isbn));
            const item = exact || (related.length === 1 && related[0]);
            if (!item) throw new Error(related.length ? 'Ada beberapa buku. Ketik judul lengkap atau gunakan kode buku.' : 'Buku tidak ditemukan.');
            if (draft.books.includes(item.id)) throw new Error('Buku sudah ditambahkan.');
            if (!item.stock) throw new Error('Stok buku habis.');
            draft.books.push(item.id);
            render();
            document.querySelector('input[name="book"]').focus();
            return;
        }
        case 'save-book':
            D.update((data) => {
                if (!values.title || !values.author || !values.category || !values.rack) throw new Error('Lengkapi judul, pengarang, kategori, dan rak.');
                if (data.books.some((item) => item.isbn === values.isbn && item.id !== id)) throw new Error('ISBN sudah tercatat.');
                const updates = { ...values, price: Number(values.price), stock: Number(values.stock), year: Number(values.year) };
                if (id) Object.assign(D.book(data,id), updates);
                else data.books.push({ id: D.nextId(data,'BK'), ...updates, cover: null, popularity: 0, description: '' });
            });
            break;
        case 'save-member':
            D.update((data) => {
                if (!values.name || !values.phone) throw new Error('Nama dan telepon wajib diisi.');
                const registeredOn = id ? D.person(data,id).registeredOn : data.today;
                if (values.expiresOn < registeredOn) throw new Error('Masa berlaku harus sesudah tanggal registrasi.');
                if (data.members.some((item) => item.id !== id && item.email.toLowerCase() === values.email.toLowerCase())) throw new Error('Email sudah tercatat.');
                if (id) Object.assign(D.person(data,id), values);
                else data.members.push({ id: D.nextId(data,'AGT'), ...values, registeredOn: data.today });
            });
            break;
        case 'save-return':
            D.update((data) => {
                const loan = data.loans.find((entry) => entry.id === id);
                if (!loan || loan.returnedOn) throw new Error('Peminjaman sudah dikembalikan.');
                loan.returnedOn = data.today;
                loan.condition = values.condition;
                loan.notes = values.notes;
                const item = D.book(data, loan.bookId);
                if (loan.condition === 'baik') {
                    const wasUnavailable = item.stock === 0;
                    item.stock += 1;
                    if (wasUnavailable) {
                        for (const reminder of data.reminders.filter((entry) => entry.bookId === item.id)) {
                            D.notify(data,reminder.memberId,'Buku tersedia',item.title + ' kembali tersedia di katalog.','success','menu_book');
                        }
                        data.reminders = data.reminders.filter((entry) => entry.bookId !== item.id);
                    }
                }
                const { total, late, conditionFee } = projectedFine(loan,loan.condition,data);
                if (total) data.fines.push({ id: D.nextId(data,'DN'), memberId: loan.memberId, loanId: loan.id, total, late, conditionFee, recordedOn: data.today, paidOn: null, method: null, tender: null });
                D.notify(data,loan.memberId,'Pengembalian tercatat',item.title + ' sudah dikembalikan.' + (total ? ' Tagihan denda ' + money(total) + '.' : ''),'success','move_to_inbox');
            });
            dialog.close();
            render();
            showToast('Pengembalian tercatat.');
            loanReceipt(findLoan(id),'Bukti pengembalian');
            return;
        case 'save-fine':
            D.update((data) => {
                const fine = data.fines.find((entry) => entry.id === id);
                const tender = Number(values.tender);
                if (!fine || fine.paidOn) throw new Error('Tagihan sudah lunas.');
                if (tender < fine.total) throw new Error('Nominal pembayaran kurang.');
                Object.assign(fine, { paidOn: data.today, tender, method: values.method });
                D.notify(data,fine.memberId,'Denda lunas','Pembayaran ' + fine.id + ' sebesar ' + money(fine.total) + ' sudah dicatat.','success','receipt_long');
            });
            dialog.close();
            render();
            showToast('Pembayaran tercatat.');
            fineReceipt(findFine(id));
            return;
        case 'save-staff':
            const staffFileInput = form.querySelector('#staffDialogAvatarInput');
            if (staffFileInput && staffFileInput.files?.[0]) {
                handleStaffAvatarChange({ target: staffFileInput });
            }
            D.update((data) => { Object.assign(data.staff, values); });
            break;
        default:
            return;
    }
    dialog.close();
    render();
    showToast('Perubahan disimpan.');
}

function exportReport() {
    const csvCell = (value) => {
        const text = String(value);
        return '"' + (/^[=+\-@\t\r]/.test(text) ? "'" : '') + text.replace(/"/g,'""') + '"';
    };
    const rows = [['Tanggal','Kode','Jenis','Anggota','Judul','Denda diterima'], ...activity().filter((entry) => entry.date === reportDate)
        .map((entry) => [entry.date,entry.id,entry.kind,person(entry.memberId).name,book(entry.bookId).title,entry.amount || 0])];
    const blob = new Blob(['\uFEFF' + rows.map((cells) => cells.map(csvCell).join(',')).join('\r\n')], { type: 'text/csv;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const anchor = Object.assign(document.createElement('a'), { href: url, download: 'laporan-libro-' + reportDate + '.csv' });
    anchor.click();
    setTimeout(() => URL.revokeObjectURL(url), 1000);
    showToast('Laporan CSV diunduh.');
}

function menuToggle() {
    const open = document.querySelector('.sidebar').classList.toggle('open');
    document.querySelector('.mobile-shade').classList.toggle('open',open);
    document.querySelector('.mobile-menu').setAttribute('aria-expanded',String(open));
    if (open) document.querySelector('.sidebar nav a').focus();
    else document.querySelector('.mobile-menu').focus();
}

function updateQuickResults(query) {
    const results = document.querySelector('#quick-results');
    if (!query.trim()) { results.hidden = true; return; }
    const books = state.books.filter((item) => D.matches(query,item.title,item.id,item.isbn)).slice(0,3);
    const members = state.members.filter((item) => D.matches(query,item.name,item.id)).slice(0,3);
    results.innerHTML = books.map((item) => `<a href="#buku" data-action="jump-filter" data-id="buku" data-query="${esc(item.id)}">${icon('menu_book')}<span>${esc(item.title)}<small class="muted"> · ${esc(item.id)}</small></span></a>`).join('') +
        members.map((item) => `<a href="#anggota" data-action="jump-filter" data-id="anggota" data-query="${esc(item.id)}">${icon('person')}<span>${esc(item.name)}<small class="muted"> · ${esc(item.id)}</small></span></a>`).join('');
    if (!results.innerHTML) results.innerHTML = '<div class="pad muted">Tidak ada hasil.</div>';
    results.hidden = false;
}

const actions = {
    menu: menuToggle,
    close: () => dialog.close(),
    'edit-book': bookDialog,
    'edit-member': memberDialog,
    'loan-detail': (id) => loanReceipt(findLoan(id)),
    'return-loan': (id) => returnDialog(findLoan(id)),
    'pay-fine': (id) => payDialog(findFine(id)),
    'fine-receipt': (id) => fineReceipt(findFine(id)),
    'save-loan': saveBorrowing,
    'remove-book': (id) => { draft.books = draft.books.filter((itemId) => id !== itemId); render(); },
    'export-report': exportReport,
    'print-report': () => { document.body.classList.add('print-report'); window.print(); document.body.classList.remove('print-report'); },
    'print-dialog': () => window.print(),
    'jump-filter': (id, element) => { filters[id] = { query: element.dataset.query, value: '' }; if (page === id) render(); },
    'edit-staff': () => openDialog('Edit kontak petugas', `<form data-form="save-staff" class="stack">${input('Email','email',state.staff.email,'required type="email" maxlength="100"')}${input('Telepon','phone',state.staff.phone,'required type="tel" maxlength="20"')}<label class="field">Ganti Foto Profil (Opsional)<input type="file" name="avatar_file" id="staffDialogAvatarInput" accept="image/*"><small class="muted" style="font-size:11px;">Format JPG, PNG, atau WebP (maks. 5MB).</small></label>${formActions('Simpan kontak')}</form>`),
    'change-staff-avatar': () => {
        let input = document.getElementById('staffAvatarInput');
        if (!input) {
            input = document.createElement('input');
            input.type = 'file';
            input.id = 'staffAvatarInput';
            input.accept = 'image/*';
            input.style.display = 'none';
            document.body.appendChild(input);
            input.addEventListener('change', handleStaffAvatarChange);
        }
        input.click();
    },
};

async function handleStaffAvatarChange(event) {
    const file = event.target.files?.[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        showToast('File yang dipilih harus berupa gambar (JPG, PNG, WebP).', true);
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        showToast('Ukuran gambar maksimal 5 MB.', true);
        return;
    }

    const reader = new FileReader();
    reader.onload = async (e) => {
        const base64Data = e.target.result;
        
        // Update local state staff
        D.update((data) => {
            if (data.staff) data.staff.avatar = base64Data;
        });
        state = D.read();
        render();
        showToast('Memperbarui foto profil petugas...');

        // Kirim ke backend Laravel
        try {
            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('avatar_base64', base64Data);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const res = await fetch('/petugas/update-avatar', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (res.ok) {
                const resData = await res.json();
                if (resData.success && resData.avatar_url) {
                    D.update((data) => {
                        if (data.staff) data.staff.avatar = resData.avatar_url;
                    });
                    state = D.read();
                    render();
                    showToast('Foto profil berhasil disimpan ke server!');
                }
            } else {
                showToast('Foto profil tersimpan secara lokal.');
            }
        } catch (err) {
            console.warn('Backend update avatar notice:', err);
            showToast('Foto profil berhasil diperbarui.');
        }
    };
    reader.readAsDataURL(file);
}

document.addEventListener('change', (event) => {
    if (event.target.id === 'staffAvatarInput') {
        handleStaffAvatarChange(event);
    }
});

document.addEventListener('click', (event) => {
    if (event.target.closest('.sidebar a') && document.querySelector('.sidebar.open')) menuToggle();
    const item = event.target.closest('[data-action]');
    if (item) {
        try { actions[item.dataset.action]?.(item.dataset.id, item); }
        catch (error) { showToast(error.message,true); }
    }
    if (!event.target.closest('.search-wrap')) document.querySelector('#quick-results').hidden = true;
});
document.addEventListener('submit', (event) => {
    if (!event.target.dataset.form) return;
    event.preventDefault();
    try { handleForm(event.target); }
    catch (error) { showToast(error.message,true); }
});
document.addEventListener('input', (event) => {
    if (event.target.id === 'quick-search') updateQuickResults(event.target.value);
    if (event.target.dataset.filter) {
        filters[page][event.target.dataset.filter] = event.target.value;
        document.querySelector('#list-results').innerHTML = lists[page]();
    }
});
document.addEventListener('change', (event) => {
    if (event.target.id === 'borrow-member') { draft.member = event.target.value; render(); document.querySelector('#borrow-member').focus(); }
    if (event.target.id === 'report-date' && event.target.value) { reportDate = event.target.value; render(); }
    if (event.target.name === 'condition' && event.target.form.dataset.form === 'save-return') {
        document.querySelector('#return-total').textContent = money(projectedFine(findLoan(event.target.form.dataset.id),event.target.value).total);
    }
});
document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    if (document.querySelector('.sidebar.open') && !dialog.open) menuToggle();
    document.querySelector('#quick-results').hidden = true;
});
window.addEventListener('hashchange', () => {
    if (location.hash === '#konten') return;
    if (dialog.open) dialog.close();
    render();
    window.scrollTo(0,0);
    document.querySelector('#konten').focus({ preventScroll: true });
});
window.addEventListener('storage', (event) => { if (event.key === D.storageKey && !dialog.open) render(); });
render();
