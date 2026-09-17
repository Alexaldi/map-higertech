/**
 * Internship Page Interactive Modules
 * Handles distinct application modals (SMK vs Mahasiswa),
 * dynamic date range pickers with live duration calculation,
 * custom "Lainnya" toggles for track & major,
 * AJAX submissions with loading indicators, and live tracking.
 */
export function initInternship() {
    let lastRegisteredCode = '';

    function openModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('hidden');
            el.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('hidden');
            el.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    function switchLacakTab(tab) {
        const btnId = document.getElementById('tab-lacak-id');
        const btnEmail = document.getElementById('tab-lacak-email');
        const groupId = document.getElementById('form-lacak-id-group');
        const groupEmail = document.getElementById('form-lacak-email-group');
        if (!btnId || !btnEmail || !groupId || !groupEmail) return;

        if (tab === 'id') {
            btnId.className =
                'py-2 px-3 rounded-lg font-bold text-xs transition-all bg-white dark:bg-[#131D36] text-[#0284c7] dark:text-cyan-400 shadow-sm pointer-events-none cursor-default select-none';
            btnEmail.className =
                'py-2 px-3 rounded-lg font-bold text-xs transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer';
            groupId.classList.remove('hidden');
            groupEmail.classList.add('hidden');
        } else {
            btnEmail.className =
                'py-2 px-3 rounded-lg font-bold text-xs transition-all bg-white dark:bg-[#131D36] text-[#0284c7] dark:text-cyan-400 shadow-sm pointer-events-none cursor-default select-none';
            btnId.className =
                'py-2 px-3 rounded-lg font-bold text-xs transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer';
            groupEmail.classList.remove('hidden');
            groupId.classList.add('hidden');
        }
    }

    function calcDuration(type) {
        const startEl = document.getElementById(`start-date-${type}`);
        const endEl = document.getElementById(`end-date-${type}`);
        const badgeEl = document.getElementById(`duration-badge-${type}`);
        const durationInput = document.getElementById(`duration-hidden-${type}`);
        const periodInput = document.getElementById(`start-period-hidden-${type}`);

        if (!startEl || !endEl) return;

        const todayStr = new Date().toISOString().split('T')[0];
        if (startEl.value && startEl.value < todayStr) {
            startEl.value = todayStr;
        }

        if (startEl.value) {
            endEl.min = startEl.value;
            if (endEl.value && endEl.value < startEl.value) {
                endEl.value = startEl.value;
            }
            const startDate = new Date(startEl.value);
            if (periodInput) {
                const y = startDate.getFullYear();
                const m = String(startDate.getMonth() + 1).padStart(2, '0');
                periodInput.value = `${y}-${m}`;
            }
        }

        if (startEl.value && endEl.value) {
            const start = new Date(startEl.value);
            const end = new Date(endEl.value);

            if (end < start) {
                if (badgeEl) {
                    badgeEl.textContent = 'Tanggal akhir tidak valid';
                    badgeEl.className = 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300 border border-rose-200 dark:border-rose-900';
                }
                return;
            }

            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const approxMonths = Math.round(diffDays / 30.4);

            let durationText = '';
            if (approxMonths >= 1) {
                durationText = `${approxMonths} Bulan (${diffDays} Hari)`;
            } else {
                durationText = `${diffDays} Hari`;
            }

            if (durationInput) durationInput.value = durationText;

            if (badgeEl) {
                badgeEl.textContent = durationText;
                badgeEl.className = type === 'smk'
                    ? 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-cyan-300 border border-blue-200 dark:border-blue-900 shadow-2xs'
                    : 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-800 shadow-2xs';
            }
        }
    }

    function toggleTrackOther(selectEl, type) {
        const groupEl = document.getElementById(`track-other-group-${type}`);
        const inputEl = document.getElementById(`track-other-${type}`);
        if (!groupEl) return;

        if (selectEl.value === 'Lainnya') {
            groupEl.classList.remove('hidden');
            if (inputEl) {
                inputEl.required = true;
                inputEl.focus();
            }
        } else {
            groupEl.classList.add('hidden');
            if (inputEl) {
                inputEl.required = false;
                inputEl.value = '';
            }
        }
    }

    function toggleMajorOther(selectEl) {
        const groupEl = document.getElementById('major-other-group');
        const inputEl = document.getElementById('major-other-univ');
        if (!groupEl) return;

        if (selectEl.value === 'Lainnya') {
            groupEl.classList.remove('hidden');
            if (inputEl) {
                inputEl.required = true;
                inputEl.focus();
            }
        } else {
            groupEl.classList.add('hidden');
            if (inputEl) {
                inputEl.required = false;
                inputEl.value = '';
            }
        }
    }

    function toggleInstitutionOther(selectEl, type) {
        const groupEl = document.getElementById(`institution-other-group-${type}`);
        const inputEl = document.getElementById(`institution-other-${type}`);
        if (!groupEl) return;

        if (selectEl && selectEl.value === 'Lainnya') {
            groupEl.classList.remove('hidden');
            if (inputEl) {
                inputEl.required = true;
                inputEl.focus();
            }
        } else {
            groupEl.classList.add('hidden');
            if (inputEl) {
                inputEl.required = false;
                inputEl.value = '';
            }
        }
    }

    function initSearchableComboboxes() {
        document.querySelectorAll('.searchable-combobox').forEach(combobox => {
            const trigger = combobox.querySelector('.combobox-trigger');
            const panel = combobox.querySelector('.combobox-panel');
            const searchInput = combobox.querySelector('.combobox-search');
            const list = combobox.querySelector('.combobox-list');
            const label = combobox.querySelector('.combobox-label');
            const arrow = combobox.querySelector('.combobox-arrow');
            const notFoundBox = combobox.querySelector('.combobox-notfound');
            const targetInputId = combobox.getAttribute('data-target-input');
            const otherGroupId = combobox.getAttribute('data-other-group');
            const otherInputId = combobox.getAttribute('data-other-input');

            const targetInput = document.getElementById(targetInputId);
            const otherGroup = document.getElementById(otherGroupId);
            const otherInput = document.getElementById(otherInputId);

            if (!trigger || !panel) return;

            function openPanel() {
                document.querySelectorAll('.combobox-panel').forEach(p => {
                    if (p !== panel) {
                        p.classList.add('hidden');
                        const otherArrow = p.parentElement?.querySelector('.combobox-arrow');
                        if (otherArrow) otherArrow.style.transform = 'rotate(0deg)';
                    }
                });
                panel.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
                if (searchInput) {
                    searchInput.value = '';
                    filterOptions('');
                    setTimeout(() => searchInput.focus(), 60);
                }
            }

            function closePanel() {
                panel.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }

            function filterOptions(query) {
                const q = query.toLowerCase().trim();
                let matchCount = 0;
                const options = list ? list.querySelectorAll('.combobox-option:not(.combobox-other)') : [];

                options.forEach(opt => {
                    const text = (opt.textContent || '').toLowerCase();
                    if (!q || text.includes(q)) {
                        opt.classList.remove('hidden');
                        matchCount++;
                    } else {
                        opt.classList.add('hidden');
                    }
                });

                if (notFoundBox) {
                    if (q && matchCount === 0) {
                        notFoundBox.classList.remove('hidden');
                        const queryDisplay = notFoundBox.querySelector('.combobox-query-display');
                        if (queryDisplay) queryDisplay.textContent = query;
                    } else {
                        notFoundBox.classList.add('hidden');
                    }
                }
            }

            function selectOption(val, text, isOther = false, customText = '') {
                if (targetInput) {
                    targetInput.value = val;
                    // Trigger change event if needed
                    targetInput.dispatchEvent(new Event('change'));
                }

                if (label) {
                    label.textContent = text;
                    label.classList.remove('text-slate-500', 'dark:text-slate-400');
                    label.classList.add('text-slate-900', 'dark:text-white', 'font-semibold');
                }

                if (isOther) {
                    if (otherGroup) otherGroup.classList.remove('hidden');
                    if (otherInput) {
                        otherInput.required = true;
                        if (customText) otherInput.value = customText;
                        otherInput.focus();
                    }
                } else {
                    if (otherGroup) otherGroup.classList.add('hidden');
                    if (otherInput) {
                        otherInput.required = false;
                        otherInput.value = '';
                    }
                }

                closePanel();
            }

            trigger.addEventListener('click', function (e) {
                e.stopPropagation();
                if (panel.classList.contains('hidden')) {
                    openPanel();
                } else {
                    closePanel();
                }
            });

            if (searchInput) {
                searchInput.addEventListener('input', function (e) {
                    filterOptions(this.value);
                });
                searchInput.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        closePanel();
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = this.value.trim();
                        const visibleOptions = Array.from(list.querySelectorAll('.combobox-option:not(.combobox-other):not(.hidden)'));
                        if (visibleOptions.length === 1) {
                            visibleOptions[0].click();
                        } else if (query) {
                            selectOption('Lainnya', query ? `Lainnya: ${query}` : 'Lainnya (Input Manual)', true, query);
                        }
                    }
                });
            }

            if (list) {
                list.querySelectorAll('.combobox-option').forEach(opt => {
                    opt.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const val = this.getAttribute('data-value');
                        const text = this.textContent.trim();
                        const isOther = this.classList.contains('combobox-other') || val === 'Lainnya';
                        selectOption(val, text, isOther);
                    });
                });
            }

            if (notFoundBox) {
                notFoundBox.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const query = searchInput ? searchInput.value.trim() : '';
                    selectOption('Lainnya', query ? `Lainnya: ${query}` : 'Lainnya (Input Manual)', true, query);
                });
            }

            document.addEventListener('click', function (e) {
                if (!combobox.contains(e.target)) {
                    closePanel();
                }
            });
        });
    }

    async function submitInternshipForm(e, type) {
        e.preventDefault();
        const form = e.target;
        const isSmk = type === 'smk';
        const alertBox = document.getElementById(isSmk ? 'alert-form-smk' : 'alert-form-mahasiswa');
        const submitBtn = document.getElementById(isSmk ? 'btn-submit-smk' : 'btn-submit-mahasiswa');
        const originalBtnContent = submitBtn ? submitBtn.innerHTML : 'Kirim';

        if (alertBox) {
            alertBox.className = 'hidden';
            alertBox.innerHTML = '';
        }

        function showFormError(messageHtml) {
            if (alertBox) {
                alertBox.className = 'p-3.5 rounded-xl border border-rose-300 dark:border-rose-800 bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 text-xs leading-relaxed block';
                alertBox.innerHTML = messageHtml;
            }
            // Automatically scroll modal container to top so error is immediately seen without manual scrolling
            const modalEl = document.getElementById(isSmk ? 'modal-daftar-smk' : 'modal-daftar-mahasiswa');
            const scrollContainer = form.closest('.overflow-y-auto') || (modalEl ? modalEl.querySelector('.overflow-y-auto') : null);
            if (scrollContainer) {
                scrollContainer.scrollTo({ top: 0, behavior: 'smooth' });
            }
            if (alertBox) {
                alertBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
                alertBox.classList.add('ring-2', 'ring-rose-400');
                setTimeout(() => alertBox.classList.remove('ring-2', 'ring-rose-400'), 1500);
            }
        }

        // Validate file size client-side (max 3MB = 3145728 bytes)
        const fileInputs = form.querySelectorAll('input[type="file"]');
        for (const input of fileInputs) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 3145728) {
                    showFormError(`<strong>Ukuran Berkas Terlalu Besar:</strong> Berkas "${file.name}" berukuran ${(file.size / (1024 * 1024)).toFixed(2)} MB. Maksimal ukuran per berkas adalah 3 MB.`);
                    return;
                }
            }
        }

        const formData = new FormData(form);

        // If individual application, guarantee NO members fields are sent
        const appType = formData.get('application_type');
        if (appType !== 'group') {
            formData.set('application_type', 'individual');
            for (const key of Array.from(formData.keys())) {
                if (key.startsWith('members')) {
                    formData.delete(key);
                }
            }
        }

        // Validate main email format if filled
        const mainEmail = formData.get('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (mainEmail && typeof mainEmail === 'string' && mainEmail.trim()) {
            if (!emailRegex.test(mainEmail.trim())) {
                showFormError(`<strong>Format Email Tidak Valid:</strong> Alamat email "${mainEmail}" tidak valid (contoh: nama@email.com). Pastikan menggunakan tanda titik (.) bukan koma (,).`);
                return;
            }
        }

        // Validate required fields
        const requiredFields = [
            { name: 'name', label: 'Nama Lengkap' },
            { name: 'identity_number', label: isSmk ? 'NISN / NIK' : 'NIM / NIK' },
            { name: 'phone', label: 'Nomor WhatsApp' },
            { name: 'institution', label: isSmk ? 'Asal Sekolah SMK' : 'Asal Perguruan Tinggi' },
            { name: 'grade_level', label: isSmk ? 'Tingkat Kelas' : 'Semester Aktif' },
            { name: 'file_identity', label: isSmk ? 'Kartu Pelajar / KTP' : 'KTM / KTP' },
            { name: 'file_transcript', label: isSmk ? 'Transkrip / Rapor' : 'Transkrip Nilai' },
        ];

        for (const req of requiredFields) {
            const val = formData.get(req.name);
            if (!val || (val instanceof File && val.size === 0)) {
                showFormError(`<strong>Data Wajib Belum Lengkap:</strong> Harap lengkapi <strong>${req.label}</strong> terlebih dahulu.`);
                return;
            }
        }

        // Validate group members if group mode
        if (appType === 'group') {
            const memberCards = form.querySelectorAll('.team-member-card');
            for (let i = 0; i < memberCards.length; i++) {
                const card = memberCards[i];
                const memberNum = i + 2;
                const nameVal = card.querySelector('.member-input-name')?.value.trim();
                const idVal = card.querySelector('.member-input-id')?.value.trim();
                const emailVal = card.querySelector('.member-input-email')?.value.trim();
                const fileId = card.querySelector('.member-input-doc-id')?.files[0];
                const fileCv = card.querySelector('.member-input-doc-cv')?.files[0];
                const fileTrans = card.querySelector('.member-input-doc-transcript')?.files[0];

                if (!nameVal) {
                    showFormError(`<strong>Data Anggota Belum Lengkap:</strong> Nama lengkap Anggota #${memberNum} wajib diisi.`);
                    return;
                }
                if (!idVal) {
                    showFormError(`<strong>Data Anggota Belum Lengkap:</strong> ${isSmk ? 'NISN / NIK' : 'NIM / NIK'} Anggota #${memberNum} wajib diisi.`);
                    return;
                }
                if (!emailVal || !emailRegex.test(emailVal)) {
                    showFormError(`<strong>Email Anggota Tidak Valid:</strong> Email Anggota #${memberNum} ("${emailVal || ''}") tidak valid (contoh: nama@email.com). Pastikan menggunakan tanda titik (.) bukan koma (,).`);
                    return;
                }
                if (!fileId) {
                    showFormError(`<strong>Berkas Anggota Belum Lengkap:</strong> ${isSmk ? 'Kartu Pelajar / KTP' : 'KTM / KTP'} Anggota #${memberNum} wajib diunggah.`);
                    return;
                }
                if (!fileCv) {
                    showFormError(`<strong>Berkas Anggota Belum Lengkap:</strong> CV & Portofolio Anggota #${memberNum} wajib diunggah (Format PDF).`);
                    return;
                }
                if (!fileTrans) {
                    showFormError(`<strong>Berkas Anggota Belum Lengkap:</strong> Transkrip Nilai / Rapor Anggota #${memberNum} wajib diunggah (Format PDF).`);
                    return;
                }
            }
        }

        // Handle "Lainnya" institution for SMK / Univ
        const instVal = formData.get('institution') || form.querySelector('input[name="institution"]')?.value || form.querySelector('select[name="institution_select"]')?.value;
        const instOther = form.querySelector(`input[name="institution_other"]`);
        if (instVal === 'Lainnya') {
            const customInst = instOther ? instOther.value.trim() : '';
            if (!customInst) {
                showFormError('<strong>Asal Sekolah / Kampus Wajib Diisi:</strong> Karena Anda memilih opsi "Lainnya", silakan tuliskan nama SMK / Perguruan Tinggi Anda.');
                instOther?.focus();
                return;
            }
            formData.set('institution', customInst);
        } else if (instVal) {
            formData.set('institution', instVal);
        }

        // Handle "Lainnya" track
        const trackVal = formData.get('track') || form.querySelector('input[name="track"]')?.value || form.querySelector('select[name="track"]')?.value;
        const trackOther = form.querySelector('input[name="track_other"]');
        if (trackVal === 'Lainnya') {
            const customTrack = trackOther ? trackOther.value.trim() : '';
            if (!customTrack) {
                showFormError('<strong>Peminatan Wajib Diisi:</strong> Karena Anda memilih opsi "Lainnya", silakan tuliskan peminatan atau bidang yang Anda minati.');
                trackOther?.focus();
                return;
            }
            formData.set('track', customTrack);
        } else if (trackVal) {
            formData.set('track', trackVal);
        }

        // Handle "Lainnya" major for university
        if (type === 'mahasiswa' || form.querySelector('input[name="major"]') || form.querySelector('select[name="major"]')) {
            const majorVal = formData.get('major') || form.querySelector('input[name="major"]')?.value || form.querySelector('select[name="major"]')?.value;
            const majorOther = form.querySelector('input[name="major_other"]');
            if (majorVal === 'Lainnya') {
                const customMajor = majorOther ? majorOther.value.trim() : '';
                if (!customMajor) {
                    showFormError('<strong>Program Studi Wajib Diisi:</strong> Karena Anda memilih opsi "Lainnya", silakan tuliskan nama Program Studi / Jurusan Anda.');
                    majorOther?.focus();
                    return;
                }
                formData.set('major', customMajor);
            } else if (majorVal) {
                formData.set('major', majorVal);
            }
        }

        // Ensure duration & start_period are calculated if start_date and end_date exist
        const durationType = isSmk ? 'smk' : 'univ';
        calcDuration(durationType);
        const durationInput = document.getElementById(`duration-hidden-${durationType}`);
        const periodInput = document.getElementById(`start-period-hidden-${durationType}`);
        if (durationInput && durationInput.value) formData.set('duration', durationInput.value);
        if (periodInput && periodInput.value) formData.set('start_period', periodInput.value);

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Mengirim Berkas...</span>
            `;
        }

        try {
            const response = await fetch(form.action || '/internship/apply', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            const result = await response.json();

            if (response.ok && result.success) {
                lastRegisteredCode = result.registration_code;
                form.reset();

                // Close application modal
                closeModal(type === 'smk' ? 'modal-daftar-smk' : 'modal-daftar-mahasiswa');

                // Populate and show success dialog
                const regCodeEl = document.getElementById('success-reg-code');
                const detailsEl = document.getElementById('success-applicant-details');
                if (regCodeEl) regCodeEl.textContent = result.registration_code;
                if (detailsEl && result.application) {
                    detailsEl.textContent = `${result.application.name} • ${result.application.institution} (${result.application.start_period || result.application.duration || 'Terjadwal'})`;
                }

                openModal('modal-sukses-daftar');
            } else {
                let errorHtml = '<strong class="block mb-1 font-bold">Mohon periksa data formulir:</strong><ul class="list-disc pl-4 space-y-0.5">';
                if (result.errors) {
                    for (const field in result.errors) {
                        result.errors[field].forEach(err => {
                            errorHtml += `<li>${err}</li>`;
                        });
                    }
                } else {
                    errorHtml += `<li>${result.message || 'Terjadi kesalahan sistem, silakan coba lagi.'}</li>`;
                }
                errorHtml += '</ul>';

                showFormError(errorHtml);
            }
        } catch (err) {
            console.error('Submission error:', err);
            showFormError('<strong>Gagal Mengirim:</strong> Koneksi bermasalah atau server tidak dapat dijangkau. Silakan periksa jaringan Anda.');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            }
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function toggleApplicationType(type, mode) {
        const isSmk = type === 'smk';
        const labels = document.querySelectorAll(isSmk ? '.app-type-label-smk' : '.app-type-label-univ');
        const teamSection = document.getElementById(isSmk ? 'team-section-smk' : 'team-section-univ');

        labels.forEach(label => {
            const labelMode = label.getAttribute('data-mode');
            const radio = label.querySelector('input[type="radio"]');
            if (labelMode === mode) {
                if (radio) radio.checked = true;
                if (isSmk) {
                    label.className = 'app-type-label-smk flex items-center justify-center gap-2 p-2.5 rounded-xl border-2 cursor-pointer transition text-xs font-semibold bg-blue-50/80 border-blue-500 text-blue-800 dark:bg-blue-950/60 dark:border-cyan-500 dark:text-cyan-300';
                } else {
                    label.className = 'app-type-label-univ flex items-center justify-center gap-2 p-2.5 rounded-xl border-2 cursor-pointer transition text-xs font-semibold bg-cyan-50/80 border-cyan-500 text-cyan-900 dark:bg-cyan-950/60 dark:border-cyan-400 dark:text-cyan-200';
                }
            } else {
                if (radio) radio.checked = false;
                label.className = (isSmk ? 'app-type-label-smk' : 'app-type-label-univ') + ' flex items-center justify-center gap-2 p-2.5 rounded-xl border-2 cursor-pointer transition text-xs font-semibold bg-white dark:bg-[#131D36] border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300';
            }
        });

        if (teamSection) {
            const teamInputs = teamSection.querySelectorAll('input, select, textarea');
            if (mode === 'group') {
                teamSection.classList.remove('hidden');
                teamInputs.forEach(inp => {
                    inp.disabled = false;
                    if (inp.classList.contains('member-input-name') || inp.classList.contains('member-input-id')) {
                        inp.required = true;
                    }
                });
                const list = document.getElementById(isSmk ? 'team-members-list-smk' : 'team-members-list-univ');
                if (list && list.children.length === 0) {
                    addTeamMember(type);
                }
            } else {
                teamSection.classList.add('hidden');
                teamInputs.forEach(inp => {
                    inp.disabled = true;
                    inp.required = false;
                });
            }
        }
    }

    function addTeamMember(type) {
        const isSmk = type === 'smk';
        const list = document.getElementById(isSmk ? 'team-members-list-smk' : 'team-members-list-univ');
        if (!list) return;

        const currentCount = list.children.length;
        if (currentCount >= 4) {
            alert('Maksimal penambahan anggota tim adalah 4 orang (total 5 orang termasuk Ketua Tim).');
            return;
        }

        const idx = currentCount;
        const memberNum = idx + 2;
        const card = document.createElement('div');
        card.className = 'team-member-card p-3.5 rounded-2xl border border-slate-200/90 dark:border-slate-700 bg-white dark:bg-[#131D36] space-y-2.5 shadow-2xs animate-in fade-in duration-150';
        card.setAttribute('data-member-idx', idx);

        card.innerHTML = `
            <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                <span class="font-bold text-slate-800 dark:text-white text-xs flex items-center gap-1.5">
                    <span class="w-5 h-5 rounded-full ${isSmk ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-cyan-300' : 'bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300'} flex items-center justify-center font-mono text-[10px] font-bold">${memberNum}</span>
                    <span class="member-card-title">Anggota Tim #${memberNum}</span>
                </span>
                <button type="button" class="btn-remove-member text-rose-500 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 text-xs font-semibold flex items-center gap-1 cursor-pointer transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Hapus</span>
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap Siswa/Mahasiswa: <span class="text-rose-500">*</span></label>
                    <input type="text" name="members[${idx}][name]" required class="member-input-name w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-[#0c1626] text-slate-900 dark:text-white px-3 py-2 text-xs focus:ring-2 ${isSmk ? 'focus:ring-blue-500' : 'focus:ring-cyan-500'}" placeholder="Contoh: Muhammad Rayhan">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">${isSmk ? 'NISN / NIK' : 'NIM / NIK'}: <span class="text-rose-500">*</span></label>
                    <input type="text" name="members[${idx}][identity_number]" required class="member-input-id w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-[#0c1626] text-slate-900 dark:text-white px-3 py-2 text-xs font-mono focus:ring-2 ${isSmk ? 'focus:ring-blue-500' : 'focus:ring-cyan-500'}" placeholder="Contoh: 10221045">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Email Aktif: <span class="text-rose-500">*</span></label>
                    <input type="email" name="members[${idx}][email]" required class="member-input-email w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-[#0c1626] text-slate-900 dark:text-white px-3 py-2 text-xs focus:ring-2 ${isSmk ? 'focus:ring-blue-500' : 'focus:ring-cyan-500'}" placeholder="Contoh: rayhan@mail.com">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">${isSmk ? 'Kartu Pelajar / KTP' : 'KTM / KTP'} <span class="text-rose-500">*</span> <span class="text-slate-400 font-normal">(PDF/Foto)</span>:</label>
                    <input type="file" name="members[${idx}][file_identity]" required accept=".pdf,image/*" class="member-input-doc-id block w-full text-[11px] text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold ${isSmk ? 'file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300' : 'file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300'} cursor-pointer">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">CV / Portofolio <span class="text-rose-500">*</span> <span class="text-slate-400 font-normal">(PDF)</span>:</label>
                    <input type="file" name="members[${idx}][file_cv]" required accept=".pdf" class="member-input-doc-cv block w-full text-[11px] text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold ${isSmk ? 'file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300' : 'file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300'} cursor-pointer">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">${isSmk ? 'Rapor Terakhir' : 'Transkrip Nilai'} <span class="text-rose-500">*</span> <span class="text-slate-400 font-normal">(PDF, Max 3MB)</span>:</label>
                    <input type="file" name="members[${idx}][file_transcript]" required accept=".pdf" class="member-input-doc-transcript block w-full text-[11px] text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold ${isSmk ? 'file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-950 dark:file:text-blue-300' : 'file:bg-cyan-50 file:text-cyan-700 dark:file:bg-cyan-950 dark:file:text-cyan-300'} cursor-pointer">
                </div>
            </div>
        `;

        card.querySelector('.btn-remove-member').addEventListener('click', function () {
            card.remove();
            reindexTeamMembers(type);
        });

        list.appendChild(card);
        reindexTeamMembers(type);
    }

    function reindexTeamMembers(type) {
        const isSmk = type === 'smk';
        const list = document.getElementById(isSmk ? 'team-members-list-smk' : 'team-members-list-univ');
        const addBtn = document.getElementById(isSmk ? 'btn-add-member-smk' : 'btn-add-member-univ');
        if (!list) return;

        const cards = list.querySelectorAll('.team-member-card');
        cards.forEach((card, i) => {
            card.setAttribute('data-member-idx', i);
            const num = i + 2;
            const titleEl = card.querySelector('.member-card-title');
            if (titleEl) titleEl.textContent = `Anggota Tim #${num}`;

            const badgeNum = card.querySelector('.rounded-full');
            if (badgeNum) badgeNum.textContent = num;

            const nameInp = card.querySelector('.member-input-name');
            if (nameInp) nameInp.name = `members[${i}][name]`;

            const idInp = card.querySelector('.member-input-id');
            if (idInp) idInp.name = `members[${i}][identity_number]`;

            const emailInp = card.querySelector('.member-input-email');
            if (emailInp) emailInp.name = `members[${i}][email]`;

            const docIdInp = card.querySelector('.member-input-doc-id');
            if (docIdInp) docIdInp.name = `members[${i}][file_identity]`;

            const docCvInp = card.querySelector('.member-input-doc-cv');
            if (docCvInp) docCvInp.name = `members[${i}][file_cv]`;

            const docTransInp = card.querySelector('.member-input-doc-transcript');
            if (docTransInp) docTransInp.name = `members[${i}][file_transcript]`;
        });

        if (addBtn) {
            addBtn.disabled = cards.length >= 4;
            addBtn.classList.toggle('opacity-50', cards.length >= 4);
            addBtn.classList.toggle('cursor-not-allowed', cards.length >= 4);
        }
    }

    async function searchStatus(e) {
        if (e) e.preventDefault();

        const inputEl = document.getElementById('lookup-query') || document.getElementById('lookup-input-id');
        const query = inputEl ? inputEl.value.trim() : '';

        const alertEl = document.getElementById('lookup-alert');
        const resultEl = document.getElementById('modal-timeline-result');
        const btnEl = document.getElementById('lookup-btn');

        if (alertEl) {
            alertEl.className = 'hidden p-3 rounded-xl border text-xs';
            alertEl.innerHTML = '';
        }
        if (resultEl) resultEl.classList.add('hidden');

        if (!query) {
            if (alertEl) {
                alertEl.className = 'p-3 rounded-xl border border-amber-300 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 text-xs block';
                alertEl.textContent = 'Silakan masukkan nomor registrasi, NIM/NISN, nomor WhatsApp, atau email Anda.';
            }
            return;
        }

        const originalBtnHtml = btnEl ? btnEl.innerHTML : '';
        if (btnEl) {
            btnEl.disabled = true;
            btnEl.innerHTML = `
                <svg class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Mencari...</span>
            `;
        }

        try {
            const res = await fetch(`/internship/track?query=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();

            if (res.ok && data.success && data.data) {
                const app = data.data;

                // Header info
                const ticketEl = document.getElementById('result-ticket-id');
                const infoEl = document.getElementById('result-applicant-info');
                const dateEl = document.getElementById('result-date');
                const badgeEl = document.getElementById('result-status-badge');

                if (ticketEl) ticketEl.textContent = app.registration_code;

                const institutionDetails = [
                    app.institution,
                    app.major ? app.major : null,
                    app.grade_level ? app.grade_level : null
                ].filter(Boolean).join(' • ');

                if (infoEl) infoEl.textContent = `${app.name} (${institutionDetails})`;
                if (dateEl) dateEl.textContent = `Diajukan: ${app.created_at || '-'}`;

                if (badgeEl) {
                    badgeEl.className = `px-2.5 py-1 rounded-md font-mono font-bold text-[10px] w-fit ${app.status_badge_class}`;
                    badgeEl.textContent = app.status_label;
                }

                // Dynamic Timeline
                const timelineEl = document.getElementById('result-timeline');
                if (timelineEl) {
                    let step2Dot = '';
                    let step2Desc = '';
                    let step3Dot = '';
                    let step3Title = '';
                    let step3Desc = '';

                    const isAccepted = app.status === 'accepted' || app.status === 'approved';
                    const isReviewing = app.status === 'reviewing' || app.status === 'under_review';
                    const isRejected = app.status === 'rejected';

                    if (app.status === 'pending') {
                        step2Dot = '<span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-amber-500 text-white flex items-center justify-center text-[9px] animate-pulse font-bold">●</span>';
                        step2Desc = 'Menunggu verifikasi berkas dan ketersediaan kuota pembina Litbang.';
                        step3Dot = '<span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-300 dark:bg-slate-700 text-slate-500 flex items-center justify-center text-[9px] font-bold">3</span>';
                        step3Title = 'Keputusan Tim Litbang';
                        step3Desc = 'Menunggu hasil seleksi administrasi.';
                    } else if (isReviewing) {
                        step2Dot = '<span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-blue-500 text-white flex items-center justify-center text-[9px] animate-pulse font-bold">●</span>';
                        step2Desc = 'Berkas dan portofolio sedang ditinjau langsung oleh tim pembina.';
                        step3Dot = '<span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-300 dark:bg-slate-700 text-slate-500 flex items-center justify-center text-[9px] font-bold">3</span>';
                        step3Title = 'Keputusan Tim Litbang';
                        step3Desc = 'Keputusan akhir akan diumumkan setelah proses wawancara/penilaian.';
                    } else if (isAccepted) {
                        step2Dot = '<span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>';
                        step2Desc = 'Berkas administrasi dan surat rekomendasi terverifikasi memenuhi syarat.';
                        step3Dot = '<span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>';
                        step3Title = 'Diterima Magang di PT Higertech';
                        step3Desc = 'Selamat! Anda dinyatakan lolos seleksi magang. Silakan unduh surat penerimaan resmi di bawah.';
                    } else if (isRejected) {
                        step2Dot = '<span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>';
                        step2Desc = 'Berkas administrasi telah selesai ditinjau.';
                        step3Dot = '<span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-rose-500 text-white flex items-center justify-center text-[9px] font-bold">✕</span>';
                        step3Title = 'Belum Memenuhi Kuota';
                        step3Desc = 'Mohon maaf, saat ini kuota pembina pada track pilihan Anda telah terisi penuh.';
                    }

                    timelineEl.innerHTML = `
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] font-bold">✓</span>
                            <div class="font-bold text-slate-900 dark:text-white">Pengajuan Formulir & Dokumen Digital</div>
                            <div class="text-slate-500 dark:text-slate-400 text-[11px]">Terkirim & tercatat di sistem pada ${app.created_at || '-'}</div>
                        </div>
                        <div class="relative">
                            ${step2Dot}
                            <div class="font-bold text-slate-900 dark:text-white">Verifikasi Administrasi & Kuota Pembina</div>
                            <div class="text-slate-500 dark:text-slate-400 text-[11px]">${step2Desc}</div>
                        </div>
                        <div class="relative">
                            ${step3Dot}
                            <div class="font-bold ${isAccepted ? 'text-emerald-600 dark:text-emerald-400' : (isRejected ? 'text-rose-600 dark:text-rose-400' : 'text-slate-900 dark:text-white')}">${step3Title}</div>
                            <div class="text-slate-500 dark:text-slate-400 text-[11px]">${step3Desc}</div>
                        </div>
                    `;
                }

                // Tim Magang (Jika Permohonan Kelompok)
                const teamContainer = document.getElementById('result-team-container');
                const teamCount = document.getElementById('result-team-count');
                const teamList = document.getElementById('result-team-list');
                if (teamContainer && teamList) {
                    if (app.is_group && app.members && app.members.length > 0) {
                        if (teamCount) teamCount.textContent = app.members.length;
                        teamList.innerHTML = app.members.map((m, idx) => {
                            const roleBadge = m.is_leader
                                ? '<span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">Ketua Tim</span>'
                                : '<span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">Anggota</span>';
                            return `
                                <li class="pt-1.5 flex items-center justify-between text-xs">
                                    <div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">${escapeHtml(m.name)}</span>
                                        <span class="font-mono text-slate-500 text-[11px] ml-1">(${escapeHtml(m.identity_number || '-')})</span>
                                    </div>
                                    <div>${roleBadge}</div>
                                </li>
                            `;
                        }).join('');
                        teamContainer.classList.remove('hidden');
                    } else {
                        teamContainer.classList.add('hidden');
                    }
                }

                // Tombol Unduh Surat Balasan (LoA PDF)
                const loaContainer = document.getElementById('result-loa-container');
                const loaBtn = document.getElementById('result-loa-btn');
                const loaInfo = document.getElementById('result-loa-info');
                if (loaContainer && loaBtn) {
                    const isAccepted = app.status === 'accepted' || app.status === 'approved';
                    if (isAccepted && app.letter_download_url) {
                        loaBtn.href = app.letter_download_url;
                        if (loaInfo) {
                            loaInfo.textContent = `Surat Balasan Penerimaan Resmi telah diterbitkan untuk ${app.name}${app.is_group ? ' dan anggota tim' : ''}.`;
                        }
                        loaContainer.classList.remove('hidden');
                    } else {
                        loaContainer.classList.add('hidden');
                    }
                }

                // Catatan Admin
                const notesContainer = document.getElementById('result-notes-container');
                const notesText = document.getElementById('result-notes-text');
                if (notesContainer && notesText) {
                    if (app.notes && app.notes.trim()) {
                        notesText.textContent = app.notes.trim();
                        notesContainer.classList.remove('hidden');
                    } else {
                        notesContainer.classList.add('hidden');
                    }
                }

                if (resultEl) resultEl.classList.remove('hidden');
            } else {
                if (alertEl) {
                    alertEl.className = 'p-3 rounded-xl border border-rose-300 dark:border-rose-800 bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 text-xs block';
                    alertEl.textContent = data.message || 'Data pendaftaran magang tidak ditemukan. Pastikan nomor registrasi atau data kontak yang dimasukkan sudah sesuai.';
                }
            }
        } catch (err) {
            console.error('Tracking error:', err);
            if (alertEl) {
                alertEl.className = 'p-3 rounded-xl border border-rose-300 dark:border-rose-800 bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 text-xs block';
                alertEl.textContent = 'Gagal menghubungi server pelacakan. Silakan periksa koneksi internet Anda.';
            }
        } finally {
            if (btnEl) {
                btnEl.disabled = false;
                btnEl.innerHTML = originalBtnHtml;
            }
        }
    }

    function copyRegCode() {
        const codeEl = document.getElementById('success-reg-code');
        const code = codeEl ? codeEl.textContent.trim() : lastRegisteredCode;
        if (code) {
            navigator.clipboard.writeText(code).then(() => {
                alert('Nomor registrasi disalin: ' + code);
            }).catch(() => {
                prompt('Salin nomor registrasi berikut:', code);
            });
        }
    }

    function openTrackingWithCode() {
        closeModal('modal-sukses-daftar');
        openModal('modal-lacak-status');
        const queryInput = document.getElementById('lookup-query') || document.getElementById('lookup-input-id');
        if (queryInput && lastRegisteredCode) {
            queryInput.value = lastRegisteredCode;
            searchStatus(null);
        }
    }

    // Initialize all searchable comboboxes on load
    function initDateInputs() {
        const todayStr = new Date().toISOString().split('T')[0];
        ['smk', 'univ'].forEach(type => {
            const s = document.getElementById(`start-date-${type}`);
            const e = document.getElementById(`end-date-${type}`);
            if (s) {
                s.min = todayStr;
                s.addEventListener('input', function () {
                    if (this.value && this.value < todayStr) {
                        this.value = todayStr;
                    }
                    if (e) {
                        e.min = this.value || todayStr;
                        if (e.value && e.value < this.value) {
                            e.value = this.value;
                        }
                    }
                });
            }
            if (e) {
                e.min = todayStr;
                e.addEventListener('input', function () {
                    const minAllowed = s && s.value ? s.value : todayStr;
                    if (this.value && this.value < minAllowed) {
                        this.value = minAllowed;
                    }
                });
            }
        });
    }

    // Initialize all date inputs and searchable comboboxes on load
    initDateInputs();
    initSearchableComboboxes();
    toggleApplicationType('smk', 'individual');
    toggleApplicationType('univ', 'individual');

    // Attach to window so inline onclick handlers in Blade continue working smoothly
    window.openModal = openModal;
    window.closeModal = closeModal;
    window.switchLacakTab = switchLacakTab;
    window.submitInternshipForm = submitInternshipForm;
    window.searchStatus = searchStatus;
    window.copyRegCode = copyRegCode;
    window.openTrackingWithCode = openTrackingWithCode;
    window.calcDuration = calcDuration;
    window.toggleTrackOther = toggleTrackOther;
    window.toggleMajorOther = toggleMajorOther;
    window.toggleInstitutionOther = toggleInstitutionOther;
    window.initSearchableComboboxes = initSearchableComboboxes;
    window.toggleApplicationType = toggleApplicationType;
    window.addTeamMember = addTeamMember;
    window.reindexTeamMembers = reindexTeamMembers;

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal('modal-daftar-smk');
            closeModal('modal-daftar-mahasiswa');
            closeModal('modal-lacak-status');
            closeModal('modal-sukses-daftar');
        }
    });
}
