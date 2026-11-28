'use strict';

const D = window.LibroDemo;
const { esc, icon, formatDate, money } = D;
const app = document.querySelector('#app');
const dialog = document.querySelector('#dialog');
const toast = document.querySelector('#toast');
const defaultCatalogFilters = { query: '', category: '', stock: '', sort: 'judul' };
const catalog = { ...defaultCatalogFilters };
let state = D.read();
let page = 'beranda';
let routeId = '';
let toastTimer;
const navigation = [
    ['beranda','home','Beranda'], ['katalog','menu_book','Katalog Buku'], ['pinjaman','library_books','Pinjaman'],
    ['notifikasi','notifications','Notifikasi'], ['profil','person','Profil'],
];
const routeLabels = { beranda: 'Beranda', katalog: 'Katalog Buku', detail: 'Detail Buku', pinjaman: 'Pinjaman Aktif', riwayat: 'Riwayat Peminjaman', denda: 'Denda Saya', notifikasi: 'Notifikasi', profil: 'Profil Saya', kartu: 'Kartu Anggota Digital', reservasi: 'Reservasi Saya' };
const tints = { laskar: '#f4e9ee', filosofi: '#e3f1e9', cantik: '#f4e8ed', atomic: '#f3eee3', sapiens: '#eeeae5', negeri: '#f5ebdf', bumi: '#e5e9fd' };

const badge = (label, tone = 'neutral') => `<span class="badge ${tone}">${esc(label)}</span>`;
const iconBox = (name, tone = 'info') => `<span class="icon-box ${tone}">${icon(name)}</span>`;
const button = (label, action, id = '', style = '', name = '') => `<button class="button ${style}" type="button" data-action="${action}" data-id="${esc(id)}">${name ? icon(name) : ''}${esc(label)}</button>`;
const link = (label, hash, style = '', name = '') => `<a class="button ${style}" href="#${hash}">${name ? icon(name) : ''}${esc(label)}</a>`;
const detail = (label, value) => `<div><dt>${label}</dt><dd>${esc(value)}</dd></div>`;
const currentMember = () => D.person(state,D.memberId);
const myLoans = () => D.active(state,D.memberId);
const myNotices = () => state.notices.filter((notice) => notice.memberId === D.memberId);
const findLoan = (id) => state.loans.find((loan) => loan.id === id && loan.memberId === D.memberId);
const getBook = (id) => D.book(state,id);
const categoryOptions = () => [...new Set(state.books.map((item) => item.category))].sort((a,b) => a.localeCompare(b,'id'));
const option = (value, label, selected) => `<option value="${esc(value)}" ${value === selected ? 'selected' : ''}>${esc(label)}</option>`;
const heading = (title, subtitle = '', actions = '') => `<div class="page-heading spread"><div><h1>${title}</h1>${subtitle ? '<p>' + subtitle + '</p>' : ''}</div>${actions}</div>`;
const empty = (title, subtitle = '', symbol = 'info') => `<div class="empty">${iconBox(symbol)}<strong>${title}</strong>${subtitle ? '<p>' + subtitle + '</p>' : ''}</div>`;
const stockBadge = (item) => item.stock > 0 ? badge('Tersedia','success') : badge('Stok habis','warning');
const thumb = (item) => Object.hasOwn(tints, item.cover)
    ? `<img class="loan-thumb" src="assets/${item.cover}.webp" alt="" loading="lazy">`
    : `<span class="loan-thumb fallback-cover">${icon('menu_book')}</span>`;
const table = (columns, rows, fallback) => rows.length
    ? `<div class="table-scroll" tabindex="0" aria-label="Tabel data"><table><thead><tr>${columns.map((label) => `<th scope="col">${label}</th>`).join('')}</tr></thead><tbody>${rows.join('')}</tbody></table></div>`
    : empty(fallback);
const row = (...cells) => `<tr>${cells.map((cell) => `<td>${cell}</td>`).join('')}</tr>`;

function menu(isMobile) {
    const active = ['riwayat','denda','reservasi'].includes(page) ? 'pinjaman' : page === 'detail' ? 'katalog' : page === 'kartu' ? 'profil' : page;
    const unread = myNotices().filter((item) => !item.read).length;
    return `<nav class="${isMobile ? 'bottom-nav' : 'top-nav'}" aria-label="Menu anggota">${navigation.map(([hash, name, label]) =>
        `<a href="#${hash}" ${active === hash ? 'aria-current="page"' : ''}>${icon(name)}<span>${isMobile && hash === 'katalog' ? 'Katalog' : label}</span>
        ${hash === 'notifikasi' && unread ? `<span class="notice-count" aria-label="${unread} belum dibaca">${unread}</span>` : ''}</a>`).join('')}</nav>`;
}

function shell(content) {
    const member = currentMember();
    const navAvatar = member.avatar
        ? `<span class="avatar" style="overflow:hidden;padding:0;"><img src="${esc(member.avatar)}" alt="${esc(member.name)}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" onerror="this.parentElement.textContent='${esc(D.initials(member.name))}'"></span>`
        : `<span class="avatar">${esc(D.initials(member.name))}</span>`;

    return `<header class="header site-chrome"><div class="header-inner">
        <a class="brand" href="#beranda"><span class="brand-mark">${icon('local_library')}</span><span><b>Libro Space</b><small>Perpustakaan Mandiri</small></span></a>
        ${menu(false)}<a class="nav-profile" href="#profil" aria-label="Profil anggota"><div><strong>${esc(member.name)}</strong><small class="mono">${esc(member.id)}</small></div>${navAvatar}</a>
        </div></header><main id="konten" tabindex="-1">${content}</main>
        <footer class="footer site-chrome"><div><span>© Libro Space · Portal Anggota</span><span>Mode demo · Jam layanan 08.00–16.30 WIB</span></div></footer>${menu(true)}`;
}

function bookArtwork(item) {
    const picture = Object.hasOwn(tints, item.cover)
        ? `<img class="book-cover" src="assets/${item.cover}.webp" alt="Sampul ${esc(item.title)}" loading="lazy" decoding="async">`
        : '';
    return `<div class="book-art" style="--cover-tint:${tints[item.cover] || '#eeeef9'}">
        ${picture}
        <div class="cover-placeholder" ${picture ? 'hidden' : ''}>${icon('library_books')}<small>Sampul belum tersedia</small></div>
    </div>`;
}

function bookCard(item) {
    return `<article class="book-card">
        ${bookArtwork(item)}
        <div class="book-card-text">
            <div class="book-card-meta">${stockBadge(item)}<span>${esc(item.category)}</span></div>
            <h3>${esc(item.title)}</h3>
            <p>${esc(item.author)}</p>
        </div>
        <div class="book-card-actions">
            <a class="button book-card-action" href="#detail/${encodeURIComponent(item.id)}" aria-label="Lihat buku ${esc(item.title)}">Lihat buku ${icon('arrow_forward')}</a>
        </div>
    </article>`;
}

function eligible(data, loan) {
    if (!loan || loan.returnedOn) return 'Pinjaman ini sudah selesai.';
    if (D.person(data,D.memberId).status !== 'aktif' || D.person(data,D.memberId).expiresOn < data.today) return 'Keanggotaan tidak aktif atau sudah berakhir.';
    if (D.overdue(data,loan)) return 'Pinjaman terlambat. Kembalikan buku ke meja sirkulasi.';
    if (loan.extensions >= 2) return 'Batas dua kali perpanjangan sudah tercapai.';
    return '';
}

function loanLine(loan) {
    const item = getBook(loan.bookId);
    const status = D.loanLabel(state,loan);
    const action = eligible(state,loan) ? button('Detail','loan-detail',loan.id,'compact') : button('Perpanjang','extend-loan',loan.id,'compact','sync');
    return `<div class="loan-line"><div class="flow">${thumb(item)}<div class="flex-main"><strong>${esc(item.title)}</strong><small>${esc(item.author)}</small></div></div>
        <div>${badge(status.label,status.tone)}<small>${formatDate(loan.dueOn)}</small></div><div class="actions">${action}</div></div>`;
}

const alertCard = (loan, symbol, label, copy, tone) => `<button type="button" class="alert-card ${tone}" data-action="loan-detail" data-id="${loan.id}">
    ${iconBox(symbol,tone)}<span><strong>${esc(label)}</strong><small>${esc(copy)}</small></span>${icon('chevron_right')}</button>`;

function home() {
    const member = currentMember();
    const loans = myLoans();
    const soon = loans.filter((loan) => {
        const days = D.daysBetween(state.today,loan.dueOn);
        return days >= 0 && days <= 1;
    }).sort((a,b) => a.dueOn.localeCompare(b.dueOn))[0];
    const late = loans.filter((loan) => D.overdue(state,loan)).sort((a,b) => a.dueOn.localeCompare(b.dueOn))[0];
    const showcase = ['BK-001','BK-002','BK-003','BK-005'].map(getBook).filter(Boolean);
    const popular = [...state.books].sort((a,b) => b.popularity - a.popularity).slice(0,3);
    return `<section class="member-hero" aria-labelledby="welcome-title"><div><span class="hero-id">${icon('badge')} Anggota · ${esc(member.id)}</span>
        <h1 id="welcome-title">Halo, ${esc(member.name.split(/\s+/)[0])}!</h1><p>Temukan bacaan berikutnya dan kelola pinjamanmu di Libro Space.</p>
        <form data-form="home-search" class="hero-search"><label class="search-box">${icon('search')}<input name="query" type="search" aria-label="Cari buku" placeholder="Cari judul, pengarang, atau ISBN"></label><button class="button primary" type="submit">Cari buku</button></form>
        </div></section>
        ${soon || late ? `<section class="alert-grid" aria-label="Pengingat pinjaman">
        ${soon ? alertCard(soon,'calendar_month',getBook(soon.bookId).title + ' ' + (soon.dueOn === state.today ? 'jatuh tempo hari ini' : 'jatuh tempo besok'),'Batas pengembalian ' + formatDate(soon.dueOn),'warning') : ''}
        ${late ? alertCard(late,'warning',getBook(late.bookId).title + ' terlambat ' + D.overdue(state,late) + ' hari','Denda berjalan ' + money(D.overdue(state,late) * D.dailyFine),'danger') : ''}</section>` : ''}
        <div class="home-grid">
            <section class="panel"><div class="section-heading spread"><div><h2>Pinjaman Aktif ${badge(loans.length,'info')}</h2><p>${loans.length} dari ${D.loanLimit} kuota buku sedang dipinjam</p></div>
                ${link('Lihat semua','pinjaman','flat compact','arrow_forward')}</div>
                <div class="active-list">${loans.length ? loans.map(loanLine).join('') : empty('Belum ada pinjaman aktif.')}</div></section>
            <aside class="stack"><section class="panel member-card pad"><div class="spread member-card-top"><div><h2>Kartu anggota</h2><p>Siapkan QR saat di meja sirkulasi.</p></div>${iconBox('qr_code_2')}</div>
                <div class="card-id mono">${esc(member.id)}</div>${link('Buka kartu digital','kartu','primary compact','qr_code_2')}</section>
                <section class="panel member-shortcuts" aria-label="Akses cepat">
                    <a href="#denda">${icon('receipt_long')} Denda Saya</a><a href="#riwayat">${icon('history')} Riwayat Peminjaman</a></section></aside>
        </div>
        <section class="panel shelf-panel"><div class="spread"><div><h2>Buku Baru</h2><p>Koleksi yang tersedia di katalog perpustakaan</p></div>${link('Buka katalog','katalog','flat compact','arrow_forward')}</div>
            <div class="shelf">${showcase.map(bookCard).join('')}</div></section>
        <section class="panel shelf-panel" style="margin-top:16px"><div class="spread"><div><h2>Buku Populer</h2><p>Judul yang sering dipinjam</p></div></div>
            ${popular.map((item) => `<div class="loan-line"><div class="flow">${thumb(item)}<div><strong>${esc(item.title)}</strong><small>${esc(item.author)}</small></div></div><span class="muted">${item.popularity} peminjaman</span>${link('Detail','detail/' + item.id,'flat compact','chevron_right')}</div>`).join('')}</section>`;
}

function catalogResults() {
    const query = catalog.query.trim();
    const list = state.books.filter((item) => {
        const matchesQuery = D.matches(query, item.title, item.author, item.isbn, item.category, item.id);
        const matchesCategory = !catalog.category || item.category === catalog.category;
        const matchesStock = !catalog.stock || (catalog.stock === 'tersedia' ? item.stock > 0 : item.stock === 0);
        return matchesQuery && matchesCategory && matchesStock;
    });
    const comparators = {
        judul: (a,b) => a.title.localeCompare(b.title,'id'),
        populer: (a,b) => b.popularity - a.popularity,
        terbit: (a,b) => b.year - a.year,
    };
    list.sort(comparators[catalog.sort]);

    const hasFilters = query || catalog.category || catalog.stock || catalog.sort !== defaultCatalogFilters.sort;
    const results = list.length
        ? `<div class="shelf catalog-grid">${list.map(bookCard).join('')}</div>`
        : `<div class="panel">${empty('Buku tidak ditemukan','Coba kata kunci lain atau atur ulang filter.','search')}</div>`;
    return `<div class="catalog-meta spread">
        <p class="muted" role="status">${list.length} dari ${state.books.length} judul${query ? ` untuk “${esc(query)}”` : ''}</p>
        ${hasFilters ? button('Atur ulang filter','catalog-reset','','compact') : ''}
    </div>${results}`;
}

function catalogPage() {
    return `<header class="catalog-heading">
        <div class="catalog-heading-icon">${icon('library_books')}</div>
        <div><h1>Katalog Buku</h1><p>Cari judul, cek ketersediaan, dan reservasi buku perpustakaan.</p></div>
    </header>
    <div class="panel catalog-bar" role="search" aria-label="Cari dan filter buku">
        <div class="field catalog-query">
            <label for="catalog-query">Pencarian</label>
            <div class="search-box">${icon('search')}<input id="catalog-query" type="search" data-catalog="query" placeholder="Judul, pengarang, atau ISBN" value="${esc(catalog.query)}"></div>
        </div>
        <div class="field">
            <label for="catalog-category">Kategori</label>
            <select id="catalog-category" data-catalog="category">${option('','Semua kategori',catalog.category)}${categoryOptions().map((key) => option(key,key,catalog.category)).join('')}</select>
        </div>
        <div class="field">
            <label for="catalog-stock">Ketersediaan</label>
            <select id="catalog-stock" data-catalog="stock">${option('','Semua status',catalog.stock)}${option('tersedia','Tersedia',catalog.stock)}${option('habis','Stok habis',catalog.stock)}</select>
        </div>
        <div class="field">
            <label for="catalog-sort">Urutkan</label>
            <select id="catalog-sort" data-catalog="sort">${option('judul','Judul A–Z',catalog.sort)}${option('populer','Paling populer',catalog.sort)}${option('terbit','Tahun terbit',catalog.sort)}</select>
        </div>
    </div><section id="catalog-results" aria-label="Hasil pencarian buku">${catalogResults()}</section>`;
}

function bookDetail() {
    const item = getBook(routeId);
    if (!item) return heading('Buku tidak ditemukan') + link('Kembali ke katalog','katalog','primary','arrow_back');
    const reservation = state.reservations.find((entry) => entry.memberId === D.memberId && entry.bookId === item.id && !entry.cancelled);
    const reminder = state.reminders.some((entry) => entry.memberId === D.memberId && entry.bookId === item.id);
    const action = reservation ? link('Lihat reservasi','reservasi','primary','receipt_long') :
        item.stock ? button('Reservasi buku','reserve-dialog',item.id,'primary','book') :
            button(reminder ? 'Hapus pengingat' : 'Ingatkan saya', 'toggle-reminder',item.id,'primary','notifications');
    return `<p style="margin-bottom:13px">${link('Kembali ke katalog','katalog','flat compact','arrow_back')}</p>
        <section class="panel book-detail">${bookArtwork(item)}<div class="pad stack">
            <div><div class="flow book-detail-meta">${stockBadge(item)}<p class="mono muted">${esc(item.id)} · ${esc(item.category)}</p></div><h1>${esc(item.title)}</h1><p class="muted">${esc(item.author)}</p></div>
            <dl class="detail-list">${detail('ISBN',item.isbn)}${detail('Tahun terbit',item.year)}${detail('Lokasi rak',item.rack)}${detail('Eksemplar tersedia',item.stock)}</dl>
            <div class="flow">${action}</div></div></section>
        <section class="panel pad stack" style="margin-top:14px"><h2>Sinopsis</h2><p class="muted">${esc(item.description || 'Sinopsis belum tersedia untuk judul ini.')}</p></section>`;
}

function loanTabs() {
    return `<div class="tabs" aria-label="Opsi pinjaman">${[['pinjaman','Aktif'],['riwayat','Riwayat'],['denda','Denda'],['reservasi','Reservasi']].map(([hash,label]) =>
        `<a href="#${hash}" ${hash === page ? 'aria-current="page"' : ''}>${label}</a>`).join('')}</div>`;
}

function currentLoans() {
    const loans = myLoans();
    return heading('Pinjaman saya','Lihat tenggat pengembalian dan perpanjang buku yang memenuhi syarat.') +
        `<section class="panel">${loanTabs()}<div class="active-list">${loans.length ? loans.map(loanLine).join('') : empty('Belum ada pinjaman aktif.','Jelajahi koleksi untuk mencari bacaan berikutnya.','library_books')}</div></section>`;
}

function history() {
    const data = state.loans.filter((loan) => loan.memberId === D.memberId && loan.returnedOn).sort((a,b) => b.returnedOn.localeCompare(a.returnedOn));
    const rows = data.map((loan) => row(`<strong>${esc(getBook(loan.bookId).title)}</strong><small>${esc(loan.id)}</small>`, formatDate(loan.openedOn), formatDate(loan.returnedOn),
        badge('Dikembalikan','success'),button('Detail','loan-detail',loan.id,'compact')));
    return heading('Riwayat Peminjaman','Daftar buku yang sudah dikembalikan.') + `<section class="panel">${loanTabs()}
        ${table(['Judul buku','Dipinjam','Dikembalikan','Status','Aksi'],rows,'Belum ada riwayat pengembalian.')}</section>`;
}

function myFines() {
    const data = state.fines.filter((fine) => fine.memberId === D.memberId);
    const unpaid = data.filter((fine) => !fine.paidOn).reduce((total,fine) => total + fine.total,0);
    const rows = data.map((fine) => row(`<strong>${esc(getBook(findLoan(fine.loanId).bookId).title)}</strong><small>${esc(fine.id)}</small>`,
        formatDate(fine.recordedOn),money(fine.total),fine.paidOn ? badge('Lunas','success') : badge('Belum lunas','warning'),
        button('Rincian','fine-detail',fine.id,'compact')));
    return heading('Denda Saya','Pembayaran dicatat oleh Petugas di meja sirkulasi.') + `<section class="panel">${loanTabs()}
        <div class="section-heading spread"><div><h2>Total belum lunas</h2><p>Tagihan pengembalian yang sudah tercatat</p></div>${badge(money(unpaid),unpaid ? 'warning' : 'success')}</div>
        ${table(['Buku','Tanggal','Tagihan','Status','Aksi'],rows,'Belum ada tagihan tercatat.')}</section>`;
}

function reservationList() {
    const data = state.reservations.filter((entry) => entry.memberId === D.memberId).reverse();
    const rows = data.map((entry) => row(`<strong>${esc(getBook(entry.bookId).title)}</strong><small>${esc(entry.id)}</small>`, formatDate(entry.date),
        entry.cancelled ? badge('Dibatalkan') : badge('Menunggu pengambilan','info'), entry.cancelled ? '—' : button('Batalkan','cancel-reservation',entry.id,'compact')));
    return heading('Reservasi Saya','Periksa status reservasi sebelum datang ke meja sirkulasi.',link('Cari buku','katalog','','search')) +
        `<section class="panel">${loanTabs()}${table(['Buku','Dibuat','Status','Aksi'],rows,'Belum ada reservasi.')}</section>`;
}

function notifications() {
    const notices = myNotices();
    const unread = notices.filter((notice) => !notice.read).length;
    return heading('Notifikasi',unread + ' pesan belum dibaca.',unread ? button('Tandai semua dibaca','read-all','','','check') : '') +
        `<section class="panel">${notices.length ? notices.map((notice) => `<article class="notice-item ${notice.read ? '' : 'unread'}">${iconBox(notice.icon,notice.tone)}
        <div class="flex-main"><h3>${esc(notice.title)}</h3><p>${esc(notice.body)}</p><small>${formatDate(notice.date)}</small></div>
        ${notice.read ? '' : button('Tandai dibaca','read-notice',notice.id,'flat compact')}</article>`).join('') : empty('Belum ada notifikasi.','','notifications')}</section>`;
}

function profile() {
    const member = currentMember();
    const avatarContent = member.avatar
        ? `<img src="${esc(member.avatar)}" alt="${esc(member.name)}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" onerror="this.parentElement.textContent='${esc(D.initials(member.name))}'">`
        : esc(D.initials(member.name));

    return heading('Profil Saya','Periksa data keanggotaan dan perbarui kontak.') + `<section class="panel pad stack" style="max-width:700px">
        <div class="spread">
            <div class="flow" style="align-items:center;gap:16px;">
                <div style="position:relative;display:inline-block;">
                    <span class="avatar" id="profilePageAvatar" style="width:64px;height:64px;font-size:22px;border-radius:50%;overflow:hidden;border:2px solid var(--border,#e2e8f0);box-shadow:0 4px 10px rgba(0,0,0,0.06);display:grid;place-items:center;background:var(--primary-soft,#eef2ff);color:var(--primary,#534dec);">${avatarContent}</span>
                    <button type="button" class="button compact" data-action="change-avatar" style="position:absolute;bottom:-4px;right:-4px;padding:0;width:28px;height:28px;min-height:28px;border-radius:50%;background:#ffffff;border:1px solid #cbd5e1;box-shadow:0 2px 6px rgba(0,0,0,0.15);display:flex;align-items:center;justify-content:center;cursor:pointer;color:#475569;" title="Ganti Foto Profil">
                        ${icon('photo_camera')}
                    </button>
                    <input type="file" id="memberAvatarInput" accept="image/*" style="display:none">
                </div>
                <div>
                    <h2>${esc(member.name)}</h2>
                    <p class="mono muted">${esc(member.id)}</p>
                </div>
            </div>
            ${badge(member.status === 'aktif' ? 'Aktif' : member.status, member.status === 'aktif' ? 'success' : 'warning')}
        </div>
        <dl class="detail-list">
            ${detail('Jenis anggota',member.type)}
            ${detail('Jurusan / unit', member.unit || '—')}
            ${detail('Email',member.email)}
            ${detail('WhatsApp',member.phone)}
            ${detail('Alamat',member.address || '—')}
            ${detail('Berlaku hingga',formatDate(member.expiresOn))}
        </dl>
        <div class="flow">
            ${button('Edit profil','edit-profile','','primary','edit')}
            ${button('Ganti Foto Profil','change-avatar','','secondary','photo_camera')}
            ${link('Kartu anggota','kartu','','qr_code_2')}
        </div>
    </section>`;
}

function membership() {
    const member = currentMember();
    return heading('Kartu Anggota Digital','Tunjukkan QR atau nomor anggota kepada petugas.',link('Kembali ke profil','profil','compact','arrow_back')) +
        `<div class="stack" style="max-width:620px"><section class="member-id-card">
        <div class="spread"><div><strong>Libro Space</strong><p class="muted">Kartu anggota perpustakaan</p></div>${iconBox('local_library')}</div>
        <div class="flow"><div class="membership-meta"><h3>${esc(member.name)}</h3><p class="mono">${esc(member.id)}</p><p class="muted" style="margin-top:9px">Berlaku hingga ${formatDate(member.expiresOn)}</p></div>
        <img src="assets/kartu-anggota.png" alt="QR nomor anggota ${esc(member.id)}"></div></section>
        <div class="flow non-print"><a class="button primary" download="QR-${esc(member.id)}.png" href="assets/kartu-anggota.png">${icon('download')} Unduh QR</a>
        ${button('Cetak kartu','print-card','','','print')}</div></div>`;
}

const views = { beranda: home, katalog: catalogPage, detail: bookDetail, pinjaman: currentLoans, riwayat: history, denda: myFines, reservasi: reservationList, notifikasi: notifications, profil: profile, kartu: membership };

function render() {
    state = D.read();
    if (location.hash !== '#konten') {
        const [next, id] = location.hash.slice(1).split('/');
        page = Object.hasOwn(views,next) ? next : 'beranda';
        routeId = id || '';
    }
    app.innerHTML = shell(views[page]());
    document.title = routeLabels[page] + ' | Libro Space';
}

function showToast(message, error = false) {
    if (error && dialog.open) {
        const body = dialog.querySelector('.dialog-content');
        body.querySelector('[role="alert"]')?.remove();
        const warning = document.createElement('p');
        warning.className = 'hint danger';
        warning.setAttribute('role','alert');
        warning.textContent = message;
        body.prepend(warning);
        return;
    }
    clearTimeout(toastTimer);
    toast.hidden = false;
    toast.classList.toggle('error',error);
    toast.textContent = message;
    toastTimer = setTimeout(() => { toast.hidden = true; },4600);
}

function openDialog(title, content) {
    dialog.innerHTML = `<div class="dialog-head"><h2 id="dialog-title">${title}</h2><button class="icon-button" data-action="close" type="button" aria-label="Tutup dialog">${icon('close')}</button></div><div class="dialog-content">${content}</div>`;
    if (!dialog.open) dialog.showModal();
}

const dialogActions = (label, action, id = '') => `<div class="dialog-actions">${button('Batal','close')}${button(label,action,id,'primary')}</div>`;

function loanDialog(id) {
    const loan = findLoan(id);
    const status = D.loanLabel(state,loan);
    const block = eligible(state,loan);
    openDialog('Detail pinjaman', `<div class="spread"><h3>${esc(getBook(loan.bookId).title)}</h3>${badge(status.label,status.tone)}</div>
        <dl class="detail-list">${detail('Kode',loan.id)}${detail('Dipinjam',formatDate(loan.openedOn))}${detail('Jatuh tempo',formatDate(loan.dueOn))}
        ${detail('Perpanjangan',loan.extensions + ' dari 2 kali')}${loan.returnedOn ? detail('Dikembalikan',formatDate(loan.returnedOn)) : ''}
        ${D.overdue(state,loan) && !loan.returnedOn ? detail('Denda berjalan',money(D.overdue(state,loan) * D.dailyFine)) : ''}</dl>
        ${block && !loan.returnedOn ? `<p class="hint warning">${icon('info')}${esc(block)}</p>` : ''}
        <div class="dialog-actions">${block ? button('Tutup','close') : button('Perpanjang','extend-loan',id,'primary','sync')}</div>`);
}

function extendDialog(id) {
    const loan = findLoan(id);
    const reason = eligible(state,loan);
    if (reason) throw new Error(reason);
    openDialog('Konfirmasi perpanjangan', `<p class="muted">Perpanjang pinjaman <strong>${esc(getBook(loan.bookId).title)}</strong> selama 7 hari.</p>
        <dl class="detail-list">${detail('Tenggat sekarang',formatDate(loan.dueOn))}${detail('Tenggat baru',formatDate(D.addDays(loan.dueOn,7)))}</dl>
        ${dialogActions('Ya, perpanjang','confirm-extend',id)}`);
}

function reserveDialog(id) {
    const item = getBook(id);
    openDialog('Reservasi buku', `<p>Kamu akan memesan <strong>${esc(item.title)}</strong>. Tunjukkan kartu anggota saat datang ke meja sirkulasi.</p>
        ${dialogActions('Konfirmasi reservasi','confirm-reserve',id)}`);
}

function profileDialog() {
    const member = currentMember();
    openDialog('Edit profil', `<form data-form="edit-profile" class="stack">
        <label class="field">Nama lengkap<input name="name" required maxlength="100" value="${esc(member.name)}"></label>
        <label class="field">Email<input name="email" type="email" required maxlength="100" value="${esc(member.email)}"></label>
        <label class="field">Nomor WhatsApp<input name="phone" type="tel" required maxlength="20" value="${esc(member.phone)}"></label>
        <label class="field">Alamat<textarea name="address" maxlength="170">${esc(member.address)}</textarea></label>
        <label class="field">Ganti Foto Profil (Opsional)
            <input type="file" name="avatar_file" id="dialogAvatarInput" accept="image/*">
            <small class="muted" style="font-size:11px;">Format JPG, PNG, atau WebP (maks. 5MB).</small>
        </label>
        <div class="dialog-actions">${button('Batal','close')}<button class="button primary">Simpan profil</button></div></form>`);
}

function complete(message) {
    if (dialog.open) dialog.close();
    render();
    showToast(message);
}

const actions = {
    close: () => dialog.close(),
    'catalog-reset': () => {
        Object.assign(catalog, defaultCatalogFilters);
        render();
        document.querySelector('[data-catalog="query"]').focus();
    },
    'loan-detail': loanDialog,
    'extend-loan': extendDialog,
    'reserve-dialog': reserveDialog,
    'edit-profile': profileDialog,
    'change-avatar': () => {
        let input = document.getElementById('memberAvatarInput');
        if (!input) {
            input = document.createElement('input');
            input.type = 'file';
            input.id = 'memberAvatarInput';
            input.accept = 'image/*';
            input.style.display = 'none';
            document.body.appendChild(input);
            input.addEventListener('change', handleAvatarFileChange);
        }
        input.click();
    },
    'print-card': () => { document.body.classList.add('print-report'); window.print(); document.body.classList.remove('print-report'); },
    'fine-detail': (id) => {
        const fine = state.fines.find((entry) => entry.id === id && entry.memberId === D.memberId);
        openDialog('Rincian denda', `<dl class="detail-list">${detail('Kode tagihan',fine.id)}${detail('Keterlambatan',money(fine.late))}${detail('Kondisi buku',money(fine.conditionFee))}
            ${detail('Total',money(fine.total))}${detail('Pembayaran',fine.paidOn ? formatDate(fine.paidOn) + ' · ' + fine.method : 'Belum lunas')}</dl>
            <div class="dialog-actions">${button('Tutup','close')}</div>`);
    },
    'confirm-extend': (id) => {
        const date = D.update((data) => {
            const loan = data.loans.find((entry) => entry.id === id && entry.memberId === D.memberId);
            const block = eligible(data,loan);
            if (block) throw new Error(block);
            loan.dueOn = D.addDays(loan.dueOn,7);
            loan.extensions += 1;
            D.notify(data,D.memberId,'Peminjaman diperpanjang',D.book(data,loan.bookId).title + ' jatuh tempo ' + formatDate(loan.dueOn) + '.','success','sync');
            return loan.dueOn;
        });
        complete('Pinjaman diperpanjang hingga ' + formatDate(date) + '.');
    },
    'confirm-reserve': (id) => {
        const code = D.update((data) => {
            const item = D.book(data,id);
            const member = D.person(data,D.memberId);
            if (member.status !== 'aktif' || member.expiresOn < data.today) throw new Error('Kartu anggota tidak aktif.');
            if (!item.stock) throw new Error('Stok buku sudah habis.');
            if (data.reservations.some((entry) => entry.memberId === member.id && entry.bookId === id && !entry.cancelled)) throw new Error('Buku ini sudah direservasi.');
            const code = D.nextId(data,'RS');
            data.reservations.push({ id: code, memberId: member.id, bookId: id, date: data.today, cancelled: false });
            D.notify(data,member.id,'Reservasi tercatat',item.title + ' · ' + code + '.','success','book');
            return code;
        });
        complete('Reservasi ' + code + ' tercatat.');
    },
    'cancel-reservation': (id) => openDialog('Batalkan reservasi?', '<p>Reservasi akan ditandai sebagai dibatalkan.</p>' + dialogActions('Ya, batalkan','confirm-cancel',id)),
    'confirm-cancel': (id) => {
        D.update((data) => { data.reservations.find((entry) => entry.id === id && entry.memberId === D.memberId).cancelled = true; });
        complete('Reservasi dibatalkan.');
    },
    'toggle-reminder': (id) => {
        const added = D.update((data) => {
            const item = D.book(data,id);
            if (item.stock) throw new Error('Buku ini sudah tersedia. Buka ulang detail untuk membuat reservasi.');
            const index = data.reminders.findIndex((entry) => entry.memberId === D.memberId && entry.bookId === id);
            if (index >= 0) { data.reminders.splice(index,1); return false; }
            data.reminders.push({ memberId: D.memberId, bookId: id });
            return true;
        });
        complete(added ? 'Pengingat ketersediaan diaktifkan.' : 'Pengingat dihapus.');
    },
    'read-notice': (id) => {
        D.update((data) => { data.notices.find((notice) => notice.id === id && notice.memberId === D.memberId).read = true; });
        render();
    },
    'read-all': () => {
        D.update((data) => { data.notices.filter((notice) => notice.memberId === D.memberId).forEach((notice) => { notice.read = true; }); });
        render();
    },
};

async function handleAvatarFileChange(event) {
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
        
        // Update data profil anggota di demo store
        D.update((data) => {
            const person = D.person(data, D.memberId);
            if (person) person.avatar = base64Data;
        });
        render();
        showToast('Memperbarui foto profil...');

        // Kirim ke backend Laravel
        try {
            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('avatar_base64', base64Data);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const res = await fetch('/anggota/update-avatar', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (res.ok) {
                const data = await res.json();
                if (data.success && data.avatar_url) {
                    D.update((state) => {
                        const person = D.person(state, D.memberId);
                        if (person) person.avatar = data.avatar_url;
                    });
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
    if (event.target.id === 'memberAvatarInput') {
        handleAvatarFileChange(event);
    }
});

document.addEventListener('click', (event) => {
    const target = event.target.closest('[data-action]');
    if (!target) return;
    try { actions[target.dataset.action]?.(target.dataset.id); }
    catch (error) { showToast(error.message,true); }
});
document.addEventListener('submit', (event) => {
    const form = event.target;
    const formType = form.dataset.form;
    if (!formType) return;
    event.preventDefault();
    const values = Object.fromEntries([...new FormData(form)].map(([key,value]) => [key,value.trim()]));
    try {
        if (formType === 'home-search') {
            Object.assign(catalog, defaultCatalogFilters, { query: values.query });
            location.hash = 'katalog';
        }
        if (formType === 'edit-profile') {
            const avatarFileInput = form.querySelector('#dialogAvatarInput');
            if (avatarFileInput && avatarFileInput.files?.[0]) {
                handleAvatarFileChange({ target: avatarFileInput });
            }
            D.update((data) => {
                if (!values.name || !values.phone) throw new Error('Nama dan nomor WhatsApp wajib diisi.');
                if (data.members.some((member) => member.id !== D.memberId && member.email.toLowerCase() === values.email.toLowerCase())) throw new Error('Email sudah digunakan oleh anggota lain.');
                Object.assign(D.person(data,D.memberId),values);
            });
            complete('Profil berhasil diperbarui.');
        }
    } catch (error) { showToast(error.message,true); }
});
document.addEventListener('input', (event) => {
    const key = event.target.dataset.catalog;
    if (!key) return;
    catalog[key] = event.target.value;
    document.querySelector('#catalog-results').innerHTML = catalogResults();
});
document.addEventListener('error', (event) => {
    if (!event.target.matches?.('.book-cover')) return;
    const cover = event.target;
    cover.hidden = true;
    cover.parentElement.querySelector('.cover-placeholder').hidden = false;
}, true);
window.addEventListener('hashchange', () => {
    if (location.hash === '#konten') return;
    if (dialog.open) dialog.close();
    render();
    window.scrollTo(0,0);
    document.querySelector('#konten').focus({ preventScroll: true });
});
window.addEventListener('storage', (event) => { if (event.key === D.storageKey && !dialog.open) render(); });
render();
