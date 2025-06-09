<script>
    const csrfToken = '{{ csrf_token() }}';
    const $input = $('#chapter-pages');
    const $chapterNumberInput = $('#chapter_number');
    const $overrideCheckbox = $('#overrideChapterNumber');
    const defaultChapterNumber = $chapterNumberInput.val();
    const $btnFolder = $('#btn-folder');
    const $btnMulti = $('#btn-multi');
    let pond;

    function toggleChapterNumberReadonly() {
        const isOverride = $overrideCheckbox.is(':checked');
        $chapterNumberInput.prop('readonly', !isOverride);
        if (!isOverride) $chapterNumberInput.val(defaultChapterNumber);
    }

    $overrideCheckbox.on('change', toggleChapterNumberReadonly);
    toggleChapterNumberReadonly();

    FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

    const pondOptions = {
        allowMultiple: true,
        allowReorder: true,
        maxFileSize: '5MB',
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp'],
        server: {
            process: {
                url: '{{ route("chapter_pages.upload") }}',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                onload: res => res,
            },
            revert: {
                url: '{{ route("chapter_pages.delete") }}',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
            },
            load: (source, load, error) => {
                fetch("{{ Storage::url('chapter-pages/') }}" + source)
                    .then(res => res.blob())
                    .then(load)
                    .catch(error);
            }
        }
    };

    $btnFolder.on('click', () => switchUploadMode('folder'));
    $btnMulti.on('click', () => switchUploadMode('multi'));
    setActiveButton($btnMulti);

    function setActiveButton($btn) {
        $btnFolder.removeClass('btn-primary active').addClass('btn-outline-primary');
        $btnMulti.removeClass('btn-secondary active').addClass('btn-outline-secondary');

        if ($btn.is($btnFolder)) {
            $btnFolder.removeClass('btn-outline-primary').addClass('btn-primary active');
        } else if ($btn.is($btnMulti)) {
            $btnMulti.removeClass('btn-outline-secondary').addClass('btn-secondary active');
        }
    }


    async function revertFileOnServer(serverFileName) {
        try {
            const res = await fetch('{{ route("chapter_pages.delete") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: serverFileName
            });
            if (!res.ok) throw new Error('Gagal hapus file di server');
            return true;
        } catch (err) {
            console.error('Error revert file:', serverFileName, err);
            return false;
        }
    }

    async function switchUploadMode(mode) {
        const files = pond.getFiles();
        const newFiles = files.filter(f => (f.origin === 'input' || f.origin === 'limbo') || !f.getMetadata('serverFileName'));

        const filesToRemove = isEditPage ? newFiles : files;

        if (filesToRemove.length > 0) {
            const { isConfirmed } = await Swal.fire({
                title: 'Peringatan',
                text: 'Mode upload akan diubah, dan file yang sudah diupload akan dihapus. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            });
            if (!isConfirmed) return;

            for (const file of filesToRemove) {
                await revertFileOnServer(file.serverId);
            }
        }

        pond.destroy();

        setTimeout(async () => {
            if (mode === 'folder') {
                $input.removeAttr('multiple accept').prop('webkitdirectory', true);
                setActiveButton($btnFolder);
            } else {
                $input.removeAttr('webkitdirectory').attr({ multiple: true, accept: 'image/*' });
                setActiveButton($btnMulti);
            }

            pond = FilePond.create($input[0], pondOptions);

            if (isEditPage) {
                const files = {!! json_encode($chapterPages ?? []) !!};
                for (const file of files) {
                    await pond.addFile("{{ Storage::url('chapter-pages/') }}" + file.filename, {
                        type: 'local',
                        file: { name: file.filename, size: file.size },
                        metadata: { serverFileName: file.filename }
                    });
                }
            }
        }, 0);
    }

    async function initFilePond() {
        pond = FilePond.create($input[0], pondOptions);

        const files = {!! json_encode($chapterPages ?? []) !!};
        for (const file of files) {
            await pond.addFile("{{ Storage::url('chapter-pages/') }}" + file.filename, {
                type: 'local',
                file: { name: file.filename, size: file.size },
                metadata: { serverFileName: file.filename }
            });
        }
    }

    async function reloadFilePondFiles(files) {
        pond.removeFiles();
        for (const file of files) {
            await pond.addFile("{{ Storage::url('chapter-pages/') }}" + file.filename, {
                type: 'local',
                file: { name: file.filename, size: file.size },
                metadata: { serverFileName: file.filename }
            });
        }
    }
</script>
