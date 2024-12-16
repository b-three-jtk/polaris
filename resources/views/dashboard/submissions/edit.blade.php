@extends('layouts.dashboard')

@section('title', 'Edit Data Pengajuan')

@section('content')
<script src="https://cdn.tiny.cloud/1/47nw0qlhrh8muk22r37wq3jkboeh6f1s37vhnj54knr72ukl/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: 'textarea#business_process',
    plugins: 'table lists',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
});
tinymce.init({
    selector: 'textarea#business_rules',
    plugins: 'table lists',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
});
</script>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 pl-72 pt-10">
            Edit
            <span class="text-accent-600">Pengajuan Aplikasi</span>
        </h1>


        <form id="submissionForm" action="{{ route('submissions.update', ['submission' => $submission]) }}" method="POST" enctype="multipart/form-data"
            class="max-w-4xl mx-auto">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="relative mb-8 max-w-4xl mx-auto">
                <!-- Stepper Container dengan Background Biru Tua -->
                <div class="relative flex justify-between items-center bg-primary-900 rounded-xl px-20 py-4">
                    <!-- Background Line - Sekarang di dalam container -->
                    <div class="absolute left-0 right-0 top-1/2 transform -translate-y-1/2 mx-20">
                        <div class="h-1 bg-gray-300 rounded-full"></div>
                        <!-- Progress Line - Positioned absolutely over background line -->
                        <div id="stepperProgress"
                            class="absolute top-0 left-0 h-1 bg-accent-light-500 rounded-full transition-all duration-500 ease-in-out"
                            style="width: 0%"></div>
                    </div>

                    <!-- Stepper Steps -->
                    @foreach (range(1, 4) as $step)
                        <div class="stepper-step flex flex-col items-center relative z-10" data-step="{{ $step }}">
                            <!-- Label Stepper -->
                            <div
                                class="stepper-label text-sm text-white font-medium mb-2 transition-all duration-300 ease-in-out">
                                @switch($step)
                                    @case(1)
                                        <span class="text-xl font-bold">01</span> Deskripsi
                                    @break

                                    @case(2)
                                        <span class="text-xl font-bold">02</span> Kebutuhan Aplikasi
                                    @break

                                    @case(3)
                                        <span class="text-xl font-bold">03</span> Detail Aplikasi
                                    @break

                                    @case(4)
                                        <span class="text-xl font-bold">04</span> Referensi
                                    @break
                                @endswitch
                            </div>
                            <!-- Circle Stepper -->
                            <div
                                class="stepper-circle w-12 h-12 rounded-full border-4 border-gray-300 bg-white flex items-center justify-center text-gray-600 font-bold text-xl transition-all duration-300 ease-in-out absolute top-0 -translate-y-1/4">
                                {{ $step }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Step 1: Deskripsi -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md w-full h-900 p-4 step-content hidden" data-step="1">
                <h2 class="text-2xl font-semibold mb-4 my-5">Deskripsi Pengajuan</h2>
                <p class="font-sans text-gray-400 text-xxs my-0">Isi form deskripsi pengajuan sesuai dengan apa yang
                    diinginkan secara detail</p>
                <hr class="border-gray-950 border-t-1 w-full mx-auto my-5">
                <div class="mb-4">
                    <label for="submission_title" class="block mb-2">Judul Pengajuan</label>
                    <input type="text" id="submission_title" name="submission_title"
                        value="{{ old('submission_title', $submission->submission_title) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                
                <div class="mb-4">
                    <label for="problem_description" class="block mb-2">Deskripsi Masalah</label>
                    <textarea id="problem_description" name="problem_description" rows="4"
                        class="w-full border border-gray-300 rounded px-3 py-2">{{ old('problem_description', $submission->problem_description) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="platform" class="block mb-2">Platform</label>
                    <select id="platform" name="platform" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select Platform</option>
                        <option value="web" {{ old('platform', $submission->platform) === 'web' ? 'selected' : '' }}>Web</option>
                        <option value="mobile" {{ old('platform', $submission->platform) === 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="desktop" {{ old('platform', $submission->platform) === 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="multi-platform" {{ old('platform', $submission->platform) === 'multi-platform' ? 'selected' : '' }}>Multi-platform</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="application_purpose" class="block mb-2">Tujuan Aplikasi</label>
                    <textarea id="application_purpose" name="application_purpose" rows="4"
                        class="w-full border border-gray-300 rounded px-3 py-2">{{ $submission->application_purpose }}</textarea>
                </div>
            </div>

            <!-- Step 2: Kebutuhan Aplikasi -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md w-full h-900 p-4 step-content hidden" data-step="2">
                <h2 class="text-2xl font-semibold mb-4 my-5">Kebutuhan Aplikasi</h2>
                <p class="font-sans text-gray-400 text-xxs my-0">Isi form kebutuhan aplikasi sesuai dengan apa yang
                    diinginkan secara detail</p>
                <hr class="border-gray-950 border-t-1 w-full mx-auto my-5">
                <div class="mb-4">
                    <label for="business_process" class="block mb-2">Proses Bisnis</label>
                    <textarea id="business_process" name="business_process" rows="4"
                        class="w-full border border-gray-300 rounded px-3 py-2">{{ old('business_process', $submission->business_process) }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="business_rules" class="block mb-2">Aturan Bisnis</label>
                    <textarea id="business_rules" name="business_rules" rows="4"
                        class="w-full border border-gray-300 rounded px-3 py-2">{{ old('business_rules', $submission->business_rules) }}</textarea>
                </div>
            </div>

            <!-- Step 3: Detail Aplikasi -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md w-full h-900 p-4 step-content hidden" data-step="3">
                <h2 class="text-2xl font-semibold mb-4 my-5">Detail Aplikasi</h2>
                <p class="font-sans text-gray-400 text-xxs my-0">Isi form detail aplikasi sesuai dengan apa yang diinginkan
                    secara detail</p>
                <hr class="border-gray-950 border-t-1 w-full mx-auto my-5">
                <div class="mb-4">
                    <label for="stakeholders" class="block mb-2">Stakeholders</label>
                    <textarea id="stakeholders" name="stakeholders" rows="4" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('stakeholders', $submission->stakeholders) }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="platform" class="block mb-2">Platform</label>
                    <select id="platform" name="platform" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select Platform</option>
                        <option value="web" {{ old('platform', $submission->platform ?? '') == 'web' ? 'selected' : '' }}>Web</option>
                        <option value="mobile" {{ old('platform', $submission->platform ?? '') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="desktop" {{ old('platform', $submission->platform ?? '') == 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="multi-platform" {{ old('platform', $submission->platform ?? '') == 'multi-platform' ? 'selected' : '' }}>Multi-platform</option>
                    </select>
                    @error('platform')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>                
                <div class="mb-4">
                    <label class="block mb-2">Jenis Proyek</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="project_type" value="0" class="form-radio"
                                {{ old('project_type', $submission->project_type ?? '') == '0' ? 'checked' : '' }}>
                            <span class="ml-2">Aplikasi Baru</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="project_type" value="1" class="form-radio"
                                {{ old('project_type', $submission->project_type ?? '') == '1' ? 'checked' : '' }}>
                            <span class="ml-2">Aplikasi Sudah Ada</span>
                        </label>
                    </div>
                    @error('project_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>                
            </div>

            <!-- Step 4: Referensi dan Upload File -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md w-full p-4 step-content" data-step="4">
                <h2 class="text-2xl font-semibold mb-4 my-5">Referensi dan Upload File</h2>
                <p class="font-sans text-gray-400 text-sm my-0">Isi form referensi (opsional) yang relevan dengan aplikasi
                    yang diinginkan</p>
                <hr class="border-gray-200 border-t-1 w-full mx-auto my-5">

                <!-- Button Group -->
                <div class="flex gap-4 mb-6">
                    <button type="button" onclick="addReference('file')"
                        class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 font-semibold py-3 px-4 rounded-lg border border-blue-200 transition-colors duration-200">
                        + Tambah File
                    </button>
                    <button type="button" onclick="addReference('link')"
                        class="flex-1 bg-green-50 hover:bg-green-100 text-green-600 font-semibold py-3 px-4 rounded-lg border border-green-200 transition-colors duration-200">
                        + Tambah Link
                    </button>
                </div>

                <div id="reference-container" class="space-y-4">
                    @foreach($submission->reference as $index => $reference)
                        <div class="reference-item border border-gray-200 rounded-xl p-5 relative bg-gray-100">
                            <button type="button" onclick="removeReference(this)" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <div>
                                <label class="block mb-2 font-semibold">{{ $reference->type === 'file' ? 'Upload File' : 'Link Referensi' }}</label>
                                @if ($reference->type == 'file')
                                @php
                                    $filePath = storage_path('app/public/' . $reference->path);
                                    $fileExtension = pathinfo($reference->path, PATHINFO_EXTENSION);
                                @endphp
                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $reference->path) }}" alt="Referensi Image" style="width: 100%; max-width: 300px;">
                                @elseif (strtolower($fileExtension) == 'pdf')
                                    <embed src="{{ asset('storage/' . $reference->path) }}" type="application/pdf" width="100%" height="600px">
                                @endif
                            @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>

            <!-- Templates for Dynamic Reference Items -->
            <template id="file-template">
                <div class="reference-item border border-gray-200 rounded-xl p-5 relative bg-gray-100">
                    <button type="button" onclick="removeReference(this)"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div>
                        <label class="block mb-2 font-semibold">Upload File</label>
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-gray-400 transition-colors duration-300">
                            <input type="hidden" name="references[{index}][type]" value="file">
                            <input type="file" name="references[{index}][file_path]" class="hidden"
                                onchange="updateFileName(this)">
                            <p class="text-gray-500">Drag & drop file atau klik untuk memilih file</p>
                            <p class="file-name text-sm text-gray-400 mt-2"></p>
                        </div>
                        <div class="mt-4">
                            <label class="block mb-2">Keterangan</label>
                            <input type="text" name="references[{index}][keterangan]"
                                class="w-full border border-gray-300 rounded px-3 py-2"
                                placeholder="Masukkan keterangan file">
                        </div>
                    </div>
                </div>
            </template>

            <template id="link-template">
                <div class="reference-item border border-gray-200 rounded-xl p-5 relative bg-gray-100">
                    <button type="button" onclick="removeReference(this)"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div>
                        <label class="block mb-2 font-semibold">Link Referensi</label>
                        <input type="hidden" name="references[{index}][type]" value="link">
                        <input type="url" name="references[{index}][link_path]"
                            class="w-full border border-gray-300 rounded px-3 py-2 mb-4"
                            placeholder="https://example.com">
                        <div>
                            <label class="block mb-2">Keterangan</label>
                            <input type="text" name="references[{index}][keterangan]"
                                class="w-full border border-gray-300 rounded px-3 py-2"
                                placeholder="Masukkan keterangan link">
                        </div>
                    </div>
                </div>
            </template>

            <div class="flex justify-between mt-8">
                <button type="button" id="prevBtn"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded hidden">Previous</button>
                <div class="flex-grow"></div>
                <button type="button" id="nextBtn"
                    class="bg-accent-light-500 text-white px-4 py-2 rounded">Next</button>
                <button type="submit" id="submitBtn"
                    class="bg-accent-light-500 text-white px-4 py-2 rounded hidden">Submit</button>
            </div>
        </form>

        <div id="successPopup" class="hidden fixed top-4 right-4 z-50">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-lg"
                role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="block sm:inline">Data berhasil disimpan!</span>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // State management
            let currentStep = 1;
            const totalSteps = 4;
            let referenceCount = 0;

            // DOM Elements
            const elements = {
                form: document.getElementById('submissionForm'),
                stepperSteps: document.querySelectorAll('.stepper-step'),
                stepContents: document.querySelectorAll('.step-content'),
                prevBtn: document.getElementById('prevBtn'),
                nextBtn: document.getElementById('nextBtn'),
                submitBtn: document.getElementById('submitBtn'),
                stepperProgress: document.getElementById('stepperProgress'),
                successPopup: document.getElementById('successPopup')
            };

            // Required fields configuration
            const requiredFieldsByStep = {
                1: ['submission_title', 'problem_description', 'application_purpose'],
                2: ['business_process', 'business_process'],
                3: ['stakeholders', 'platform'],
                4: [] // Optional step
            };

            // Utility Functions
            const validateField = (fieldId) => {
                const field = document.getElementById(fieldId);
                if (!field) return false;
                return field.tagName === 'SELECT' ? field.value !== '' : field.value.trim() !== '';
            };

            const validateRadioGroup = (name) => {
                const radioButtons = document.getElementsByName(name);
                return Array.from(radioButtons).some(radio => radio.checked);
            };

            const isStepComplete = (step) => {
                const fields = requiredFieldsByStep[step];

                // Special handling for step 3
                if (step === 3) {
                    const areFieldsFilled = fields.every(validateField);
                    const isRadioSelected = validateRadioGroup('project_type');
                    return areFieldsFilled && isRadioSelected;
                }

                return !fields || fields.length === 0 || fields.every(validateField);
            };

            const canAccessStep = (targetStep) => {
                if (targetStep <= currentStep) return true;
                for (let step = 1; step < targetStep; step++) {
                    if (!isStepComplete(step)) return false;
                }
                return true;
            };

            // UI Update Functions
            const updateStepperUI = (step) => {
                elements.stepperSteps.forEach((s, index) => {
                    const circle = s.querySelector('.stepper-circle');
                    const label = s.querySelector('.stepper-label');
                    const isCompleted = index + 1 <= step;

                    circle.className = `stepper-circle w-12 h-12 rounded-full border-4 flex items-center justify-center text-xl absolute top-0 -translate-y-1/4 ${
                isCompleted ? 'bg-accent-light-500 border-accent-light-500 text-white font-bold' : 'bg-white border-gray-300 text-gray-600 font-bold'
            }`;

                    label.className = `stepper-label text-sm font-medium mb-2 transition-all duration-300 ease-in-out ${
                isCompleted ? 'text-primary-50 font-semibold' : 'text-gray-600'
            }`;
                });

                const progressPercentage = ((step - 1) / (totalSteps - 1)) * 100;
                elements.stepperProgress.style.width = `${progressPercentage}%`;
            };

            const updateButtonVisibility = (step) => {
                elements.prevBtn.classList.toggle('hidden', step === 1);
                elements.nextBtn.classList.toggle('hidden', step === totalSteps);
                elements.submitBtn.classList.toggle('hidden', step !== totalSteps);
            };

            const updateStep = (step) => {
                if (step < 1 || step > totalSteps || !canAccessStep(step)) {
                    alert('Silakan lengkapi step sebelumnya terlebih dahulu.');
                    return;
                }

                elements.stepContents.forEach((content, index) => {
                    content.classList.toggle('hidden', index + 1 !== step);
                });

                updateStepperUI(step);
                updateButtonVisibility(step);
                currentStep = step;
                updateNextButtonState();
            };

            const updateNextButtonState = () => {
                const canProceed = isStepComplete(currentStep);
                elements.nextBtn.disabled = !canProceed;
                elements.nextBtn.classList.toggle('opacity-50', !canProceed);
                elements.nextBtn.classList.toggle('cursor-not-allowed', !canProceed);
                elements.nextBtn.classList.toggle('hover:bg-blue-600', canProceed);
            };

            // Reference Management Functions
            window.addReference = (type) => {
                const container = document.getElementById('reference-container');
                const template = document.getElementById(`${type}-template`);
                const clone = template.content.cloneNode(true);

                clone.querySelectorAll('[name*="{index}"]').forEach(element => {
                    element.name = element.name.replace('{index}', referenceCount);
                });

                if (type === 'file') {
                    setupFileUpload(clone);
                }

                container.appendChild(clone);
                referenceCount++;
            };

            window.removeReference = (button) => {
                button.closest('.reference-item').remove();
            };

            window.updateFileName = (input) => {
                const fileNameElement = input.closest('.border-dashed').querySelector('.file-name');
                fileNameElement.textContent = input.files[0]?.name ? `Selected file: ${input.files[0].name}` :
                    '';
            };

            // Event Listeners
            elements.form.addEventListener('submit', handleFormSubmit);
            elements.prevBtn.addEventListener('click', () => updateStep(currentStep - 1));
            elements.nextBtn.addEventListener('click', () => {
                if (isStepComplete(currentStep)) {
                    updateStep(currentStep + 1);
                } else {
                    alert('Silakan isi semua field yang diperlukan sebelum melanjutkan.');
                }
            });

            elements.stepperSteps.forEach((step, index) => {
                step.addEventListener('click', () => {
                    const targetStep = index + 1;
                    if (canAccessStep(targetStep)) {
                        updateStep(targetStep);
                    }
                });
            });

            // Add input listeners for required fields
            Object.values(requiredFieldsByStep).flat().forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', updateNextButtonState);
                    field.addEventListener('change', updateNextButtonState);
                }
            });

            // Add listeners for radio buttons separately
            const radioButtons = document.getElementsByName('project_type');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', updateNextButtonState);
            });

            // Initialize form
            updateStep(1);


            function setupFileUpload(element) {
                const dropArea = element.querySelector('.border-dashed');
                const fileInput = element.querySelector('input[type="file"]');

                dropArea.addEventListener('click', () => fileInput.click());

                dropArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropArea.classList.add('border-blue-400');
                });

                dropArea.addEventListener('dragleave', () => {
                    dropArea.classList.remove('border-blue-400');
                });

                dropArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropArea.classList.remove('border-blue-400');
                    fileInput.files = e.dataTransfer.files;
                    updateFileName(fileInput);
                });
            }

            async function handleFormSubmit(e) {
                e.preventDefault();

                for (let step = 1; step <= 3; step++) {
                    if (!isStepComplete(step)) {
                        alert('Silakan lengkapi semua field yang diperlukan di semua step.');
                        updateStep(step);
                        return; // Hanya mencegah submit jika ada validasi yang gagal
                    }
                }

                e.target.submit();
            }

            function showSuccessNotification() {
                const successPopup = document.getElementById('successPopup');
                successPopup.classList.remove('hidden');
                successPopup.classList.add('animate-fade-in');

                setTimeout(() => {
                    successPopup.classList.add('hidden');
                }, 3000);
            }
        });
    </script>

    <style>
        .stepper-circle {
            position: relative;
            z-index: 20;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stepper-circle.active {
            border-color: #FD851E;
            background-color: #FD851E;
            color: white;
        }

        .stepper-label {
            transition: all 0.3s ease-in-out;
            white-space: nowrap;
        }

        .stepper-label.active {
            color: #FD851E;
        }

        #stepperProgress {
            transition: width 0.5s ease-in-out;
        }

        /* Animation for success popup */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out forwards;
        }
    </style>
@endsection
