'use strict';

window.LibroDemo = (() => {
    const storageKey = 'libro-space.demo.sirkulasi.v1';
    const rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
    const shortDate = new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short', year: 'numeric', timeZone: 'UTC' });
    const longDate = new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC' });
    const loanLimit = 3;
    const loanDays = 14;
    const dailyFine = 1000;
    const memberId = 'AGT-DEMO-001';
    let inMemory;

    const date = (value) => new Date(value + 'T12:00:00Z');
    const today = () => new Date().toLocaleDateString('sv-SE', { timeZone: 'Asia/Jakarta' });
    const addDays = (value, count) => {
        const result = date(value);
        result.setUTCDate(result.getUTCDate() + count);
        return result.toISOString().slice(0, 10);
    };
    const daysBetween = (start, end) => Math.round((date(end) - date(start)) / 86400000);
    const initials = (name) => name.trim().split(/\s+/).slice(0, 2).map((word) => word.at(0)).join('').toUpperCase();
    const esc = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
    })[character]);
    const icon = (name) => '<span class="symbol" aria-hidden="true">' + esc(name) + '</span>';
    const money = (amount) => rupiah.format(amount);
    const formatDate = (value, full = false) => value ? (full ? longDate : shortDate).format(date(value)) : '—';
    const person = (state, id) => state.members.find((member) => member.id === id);
    const book = (state, id) => state.books.find((item) => item.id === id);
    const active = (state, id) => state.loans.filter((loan) => loan.memberId === id && !loan.returnedOn);
    const outstanding = (state, id) => state.fines.filter((fine) => fine.memberId === id && !fine.paidOn);
    const overdue = (state, loan) => Math.max(0, daysBetween(loan.dueOn, loan.returnedOn || state.today));
    const matches = (query, ...values) => {
        const terms = String(query).trim().toLocaleLowerCase('id-ID').split(/\s+/);
        const record = values.join(' ').toLocaleLowerCase('id-ID');
        return terms.every((term) => record.includes(term));
    };

    function createState() {
        const base = today();
        const near = (days) => addDays(base, days);
        const books = [
            { id: 'BK-001', title: 'Laskar Pelangi', author: 'Andrea Hirata', category: 'Fiksi', isbn: '9789793062792', rack: 'A-01', stock: 4, price: 99000, cover: 'laskar', year: 2005, popularity: 118, description: 'Sepuluh anak di Belitung berjuang mempertahankan sekolahnya dan menemukan arti persahabatan, keberanian, dan pendidikan.' },
            { id: 'BK-002', title: 'Filosofi Teras', author: 'Henry Manampiring', category: 'Filsafat', isbn: '9786024125189', rack: 'B-03', stock: 3, price: 110000, cover: 'filosofi', year: 2018, popularity: 102, description: 'Pengantar filsafat Stoa untuk menghadapi situasi sehari-hari. Buku ini mengajak pembaca memusatkan perhatian pada hal-hal yang dapat dikendalikan.' },
            { id: 'BK-003', title: 'Cantik Itu Luka', author: 'Eka Kurniawan', category: 'Fiksi', isbn: '9786020312583', rack: 'A-02', stock: 2, price: 125000, cover: 'cantik', year: 2002, popularity: 76, description: 'Di kota pesisir Halimunda, kisah beberapa generasi keluarga Dewi Ayu bertaut dengan sejarah Indonesia dan cerita rakyat setempat.' },
            { id: 'BK-004', title: 'Atomic Habits', author: 'James Clear', category: 'Pengembangan Diri', isbn: '9786020633176', rack: 'C-01', stock: 2, price: 120000, cover: 'atomic', year: 2018, popularity: 142, description: 'Panduan membangun kebiasaan kecil yang bertahan lama melalui perubahan lingkungan, rutinitas, dan cara mengukur kemajuan.' },
            { id: 'BK-005', title: 'Sapiens', author: 'Yuval Noah Harari', category: 'Sejarah', isbn: '9786024244163', rack: 'D-01', stock: 0, price: 130000, cover: 'sapiens', year: 2011, popularity: 94, description: 'Gambaran sejarah umat manusia dari masyarakat pemburu dan peramu hingga dunia modern, dengan menelusuri peran bahasa, pertanian, dan ilmu pengetahuan.' },
            { id: 'BK-006', title: 'Negeri 5 Menara', author: 'Ahmad Fuadi', category: 'Fiksi', isbn: '9789792248616', rack: 'A-03', stock: 1, price: 95000, cover: 'negeri', year: 2009, popularity: 108, description: 'Perjalanan Alif di pesantren bersama lima sahabat yang belajar mengejar cita-cita melalui disiplin, persahabatan, dan tekad.' },
            { id: 'BK-007', title: 'Bumi Manusia', author: 'Pramoedya Ananta Toer', category: 'Fiksi', isbn: '9789799731234', rack: 'A-04', stock: 1, price: 125000, cover: 'bumi', year: 1980, popularity: 98, description: 'Minke, seorang pemuda Jawa pada akhir abad ke-19, menyaksikan bagaimana pendidikan, cinta, dan hukum kolonial membentuk jalan hidupnya.' },
        ];
        const members = [
            { id: memberId, name: 'Rina Maharani', status: 'aktif', type: 'Mahasiswa', unit: 'Sistem Informasi', email: 'rina@example.test', phone: '081200000142', address: 'Jl. Melati 14', registeredOn: near(-163), expiresOn: near(202) },
            { id: 'AGT-DEMO-002', name: 'Dimas Pradana', status: 'aktif', type: 'Mahasiswa', unit: 'Informatika', email: 'dimas@example.test', phone: '081200000087', address: '', registeredOn: near(-152), expiresOn: near(213) },
            { id: 'AGT-DEMO-003', name: 'Sari Kusuma', status: 'aktif', type: 'Dosen', unit: 'Ilmu Perpustakaan', email: 'sari@example.test', phone: '081200000089', address: '', registeredOn: near(-84), expiresOn: near(281) },
            { id: 'AGT-DEMO-004', name: 'Lintang Pratama', status: 'aktif', type: 'Mahasiswa', unit: 'Desain Komunikasi Visual', email: 'lintang@example.test', phone: '081200000048', address: '', registeredOn: near(-75), expiresOn: near(290) },
            { id: 'AGT-DEMO-005', name: 'Bella Anindita', status: 'nonaktif', type: 'Umum', unit: '', email: 'bella@example.test', phone: '081200000175', address: '', registeredOn: near(-370), expiresOn: near(-5) },
        ];
        const loan = (number, member, item, opened, due, extensions = 0, returned = null) => ({
            id: 'PJ-' + String(number).padStart(4, '0'), memberId: members[member].id, bookId: books[item].id,
            openedOn: near(opened), dueOn: near(due), extensions,
            returnedOn: returned === null ? null : near(returned), condition: returned === null ? null : 'baik',
        });
        return {
            today: base,
            books,
            members,
            loans: [
                loan(1, 0, 1, -10, 4),
                loan(2, 0, 3, -27, 1, 2),
                loan(3, 0, 6, -16, -2),
                loan(4, 1, 5, 0, 14),
                loan(5, 2, 0, -14, 0),
                loan(6, 3, 4, -19, -5),
                loan(7, 0, 2, -37, -23, 0, -21),
                loan(8, 2, 3, -14, 0, 0, 0),
                loan(9, 0, 0, -64, -50, 0, -51),
            ],
            fines: [{ id: 'DN-0001', loanId: 'PJ-0007', memberId, total: 2000, late: 2000, conditionFee: 0, recordedOn: near(-21), paidOn: null, method: null, tender: null }],
            notices: [
                { id: 'NT-0001', memberId, title: 'Atomic Habits jatuh tempo besok', body: 'Kembalikan buku ke meja sirkulasi sebelum batas waktu.', date: base, read: false, tone: 'warning', icon: 'calendar_month' },
                { id: 'NT-0002', memberId, title: 'Bumi Manusia terlambat 2 hari', body: 'Serahkan buku ke petugas untuk menyelesaikan pengembalian.', date: base, read: false, tone: 'danger', icon: 'warning' },
            ],
            reservations: [],
            reminders: [],
            staff: { name: 'Petugas Demo', unit: 'Sirkulasi & Layanan', email: 'petugas.demo@example.test', phone: '0215550123', nip: 'PTG-DEMO-001' },
            sequences: { PJ: 9, DN: 1, NT: 2, RS: 0, BK: 7, AGT: 5 },
        };
    }

    function read() {
        try {
            const raw = localStorage.getItem(storageKey);
            if (raw) return JSON.parse(raw);
            inMemory ??= createState();
            localStorage.setItem(storageKey, JSON.stringify(inMemory));
        } catch {
            inMemory ??= createState();
        }
        return structuredClone(inMemory);
    }

    function update(change) {
        const state = read();
        const result = change(state);
        inMemory = state;
        try {
            localStorage.setItem(storageKey, JSON.stringify(state));
        } catch {
            // Demo tetap dapat dipakai saat penyimpanan browser diblokir.
        }
        return result;
    }

    function nextId(state, prefix) {
        state.sequences[prefix] += 1;
        const length = ['BK', 'AGT'].includes(prefix) ? 3 : 4;
        const namespace = prefix === 'AGT' ? 'AGT-DEMO' : prefix;
        return namespace + '-' + String(state.sequences[prefix]).padStart(length, '0');
    }

    function notify(state, id, title, body, tone = 'info', symbol = 'notifications') {
        state.notices.unshift({ id: nextId(state, 'NT'), memberId: id, title, body, tone, date: state.today, read: false, icon: symbol });
    }

    function loanLabel(state, loan) {
        if (loan.returnedOn) return { label: 'Dikembalikan', tone: 'neutral' };
        const remaining = daysBetween(state.today, loan.dueOn);
        if (remaining < 0) return { label: 'Terlambat ' + -remaining + ' hari', tone: 'danger' };
        if (remaining === 0) return { label: 'Jatuh tempo hari ini', tone: 'warning' };
        if (remaining === 1) return { label: 'Besok', tone: 'warning' };
        return { label: remaining + ' hari lagi', tone: 'success' };
    }

    return { read, update, storageKey, memberId, book, person, active, outstanding, overdue, loanLabel, loanLimit, loanDays, dailyFine, nextId, notify, addDays, daysBetween, formatDate, initials, matches, money, esc, icon };
})();
