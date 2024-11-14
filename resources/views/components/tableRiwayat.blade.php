<!-- Table Container -->
<?php
use Carbon\Carbon;
?>
<div class="table-container">
    <div class="w-full flex justify-between items-center mb-3 pl-3">
        <div>
            <h3 class="text-lg font-semibold text-slate-800">Sistem Diagnosa Kesehatan Sapi</h3>
            <p class="text-slate-500">Dinas Peternakan</p>
        </div>
        <div class="text-right ml-40" id="kiri">
            <a href='/diagnosis/add-record'>
                <button type="button"
                    class="border border-blue-800 font-bold text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                    Tambah Diagnosa +
                </button>
            </a>
            <button type="button"
                class="border border-red-400 font-bold text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline"
                id="deleteButton" disabled onclick="submitDeleteForm()">
                Hapus Diagnosa
            </button>
        </div>
    </div>
    <div
        class="relative flex flex-col w-full h-full overflow-x-auto text-green-700 bg-white shadow-md rounded-lg bg-clip-border">
        <form action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <table class="w-full text-left table-auto min-w-max mb-16">
                <thead>
                    <tr class="border-b border-slate-300 bg-slate-50">
                        <th class="text-sm font-bold leading-none text-center text-slate-500">NO</th>
                        <th class="p-4 text-sm font-bold leading-none text-center text-slate-500">Nama Sapi</th>
                        <th class="p-4 text-sm font-bold leading-none text-center text-slate-500">ID Diagnosa</th>
                        <th class="p-4 text-sm font-bold leading-none text-center text-slate-500">Umur Sapi</th>
                        <th class="p-4 text-sm font-bold leading-none text-center text-slate-500">Gejala</th>
                        <th class="p-4 text-sm font-bold leading-none text-center text-slate-500">Status Kesehatan</th>
                        <th class="p-4 text-sm font-bold leading-none text-center text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diagnoses as $diagnosis)
                        <tr class="hover:bg-slate-50 border-2px border-gray-400">
                            <td class="p-4 flex-1 border-b border-slate-200 py-5 text-center">{{ $loop->iteration }}
                            </td>
                            <td class="p-4 flex-1 border-b border-slate-200 py-5">
                                <div class="gambar">
                                    <label class="relative flex cursor-pointer items-center rounded-full p-3"
                                        for="checkbox{{ $diagnosis->id }}" data-ripple-dark="true">
                                        <input type="checkbox" name="diagnosis_ids[]" value="{{ $diagnosis->id }}"
                                            class="peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border transition-all checked:border-pink-500 checked:bg-pink-500 hover:before:opacity-10"
                                            id="checkbox{{ $diagnosis->id }}" onchange="toggleDeleteButton()" />
                                    </label>
                                    <p class="text-sm font-semibold text-slate-800">{{ $diagnosis->cow_name }}</p>
                                </div>
                            </td>

                            <td class="p-4 border-b border-slate-200 text-center py-5">
                                <p class="block font-semibold text-sm text-slate-800">{{ $diagnosis->diagnosis_id }}</p>
                            </td>
                            <td class="p-4 text-center border-b border-slate-200 py-5">
                                <p class="text-sm text-slate-500">{{ $diagnosis->cow_age }} tahun</p>
                            </td>
                            <td class="p-4 text-center border-b border-slate-200 py-5">
                                <p class="text-sm text-slate-500">{{ $diagnosis->symptoms }}</p>
                            </td>
                            <td class="p-4 border-b text-center border-slate-200 py-5">
                                @if ($diagnosis->health_status == 'Sehat')
                                    <button
                                        class="items-center justify-center bg-green-600 rounded-xl text-center py-2 px-4 ml-6 max-w-max text-white">
                                        <i class="fas fa-check text-white mr-2"></i> {{ $diagnosis->health_status }}
                                    </button>
                                @else
                                    <button
                                        class="items-center justify-center bg-red-600 rounded-xl text-center py-2 px-4 ml-6 max-w-max text-white">
                                        <i class="fas fa-times text-white mr-2"></i> {{ $diagnosis->health_status }}
                                    </button>
                                @endif
                            </td>
                            <td class="p-4 text-center border-b border-slate-200 py-5">
                                <button type="button" class="text-slate-500 hover:text-slate-700"
                                    onclick="toggleDetails('accordion-color-body-{{ $diagnosis->id }}')">
                                    Details
                                </button>
                            </td>
                        </tr>
                        <tr id="accordion-color-body-{{ $diagnosis->id }}"
                            class="hidden collapsible-row border-2px border-gray-400">
                            <td colspan="6" class="p-4 border-b border-slate-200">
                                <div class="flex">
                                    <!-- Bagian detail teks -->
                                    <div class="w-full ml-10 text-cyan-950">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <h3 class="font-bold">Nama Sapi</h3>
                                                <p>{{ $diagnosis->cow_name }}</p>
                                            </div>
                                            <div>
                                                <h3 class="font-bold">ID Diagnosa</h3>
                                                <p>{{ $diagnosis->diagnosis_id }}</p>
                                            </div>
                                            <div>
                                                <h3 class="font-bold">Umur Sapi</h3>
                                                <p>{{ $diagnosis->cow_age }} tahun</p>
                                            </div>
                                            <div>
                                                <h3 class="font-bold">Gejala</h3>
                                                <p>{{ $diagnosis->symptoms }}</p>
                                            </div>
                                            <div>
                                                <h3 class="font-bold">Status Kesehatan</h3>
                                                <p>{{ $diagnosis->health_status }}</p>
                                            </div>
                                            <div>
                                                <h3 class="font-bold">Rekomendasi Tindakan</h3>
                                                <p>{{ $diagnosis->treatment_recommendation }}</p>
                                            </div>
                                        </div>
                                        <!-- Bagian tombol -->
                                        <div class="flex justify-end mt-6">
                                            <button type="button"
                                                class="border border-green-400 font-bold text-green-400 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-400 focus:outline-none focus:shadow-outline">
                                                <a href="">Edit</a>
                                            </button>

                                            <button type="button"
                                                class="border border-orange-500 font-bold text-orange-800 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-orange-500 focus:outline-none focus:shadow-outline">
                                                <a href="" class="flex items-center">
                                                    Cetak PDF
                                                </a>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>

<script>
    function toggleDeleteButton() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.disabled = !Array.from(checkboxes).some(checkbox => checkbox.checked);
    }

    function submitDeleteForm() {
        const form = document.getElementById('deleteForm');
        const checkboxes = form.querySelectorAll('input[type="checkbox"]:checked');

        if (checkboxes.length === 0) {
            alert('Silakan pilih setidaknya satu diagnosa untuk dihapus.');
            return;
        }

        if (confirm('Anda yakin ingin menghapus diagnosa yang dipilih?')) {
            form.submit();
        }
    }

    function toggleDetails(id) {
        const detailsRow = document.getElementById(id);
        detailsRow.classList.toggle('hidden');
    }
</script>
