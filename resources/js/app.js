import Sortable from 'sortablejs';
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle'
import Choices from 'choices.js'

class PaKuaEvaluations {
    constructor() {

        // Define Components
        this.studentsAccordion = document.getElementById('students-accordion');
        this.form = document.getElementById('itinerant-form');
        this.studentSelectInput = document.getElementById('student');
        this.previewPhoto = document.getElementById('preview-photo');
        this.addNewStudentButton = document.getElementById('add-new-student');
        this.searchStudentButton = document.getElementById('search-student');
        this.studentPhotoContainer = document.getElementById('student-photo-container');
        this.studentNameContainer = document.getElementById('student-name-container');
        this.studentSelectContainer = document.getElementById('student-select-container');
        this.studentPreviewPhotoContainer = document.getElementById('student-preview-container');
        this.deleteItinerancyForm = document.getElementById('delete-itinerancy');
        this.deleteEvaluationForm = document.getElementById('delete-evaluation');
        this.deleteStudentForm = document.getElementById('delete-student');
        this.studentPhotoInput = document.getElementById('photo');

        this.initialize();
        this.attachEventListeners();
    }



    initialize() {
        if (this.studentsAccordion && this.form) {
            Sortable.create(this.studentsAccordion, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                handle: '.row-drag-icon',
                onUpdate: () => this.updateStudentOrder()
            });
        }

        this.initializeChoices();
    }

    initializeChoices() {
        if (this.studentSelectInput) {
            this.studentChoices = new Choices(this.studentSelectInput);

            this.studentChoices.setChoices(() => {
                return fetch('/students/get_all')
                    .then(response => response.json())
                    .then(result => {
                        const { status, data, message = '' } = result;

                        if (status === 'success') {
                            return data;
                        } else {
                            throw new Error(message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            this.studentSelectInput.addEventListener('change', async (event) => {
                const studentId = event.detail.value;

                try {
                    await fetch(`/students/get/${studentId}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                        .then(response => response.json())
                        .then(result => {
                            const { status, message, data } = result;

                            if (status === 'success') {
                                if (this.previewPhoto) {
                                    if (data.photo) {
                                        this.previewPhoto.classList.remove('hidden');
                                        this.previewPhoto.src = `/storage/public/images/${data.photo}`;
                                        this.studentPhotoContainer?.classList.add('hidden');
                                    } else {
                                        this.previewPhoto.classList.add('hidden');
                                        this.previewPhoto.src = '#';
                                        this.studentPhotoContainer?.classList.remove('hidden');
                                        this.searchStudentButton?.classList.add('hidden');
                                    }
                                }
                            } else {
                                throw new Error(message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        }
    }

    attachEventListeners() {
        if (this.addNewStudentButton) {
            this.addNewStudentButton.addEventListener('click', (e) => {
                e.preventDefault();

                this.studentPhotoContainer?.classList.remove('hidden');
                this.studentNameContainer?.classList.remove('hidden');
                this.previewPhoto?.classList.add('hidden');
                this.studentSelectContainer?.classList.add('hidden');
                this.studentPreviewPhotoContainer?.classList.add('hidden');
                this.searchStudentButton?.classList.remove('hidden');
                this.studentChoices?.removeActiveItems();
            });
        }

        if (this.searchStudentButton) {
            this.searchStudentButton.addEventListener('click', (e) => {
                e.preventDefault();

                this.studentChoices?.removeActiveItems();
                this.studentPhotoContainer?.classList.add('hidden');
                this.studentNameContainer?.classList.add('hidden');
                this.studentSelectContainer?.classList.remove('hidden');
                this.studentPreviewPhotoContainer?.classList.remove('hidden');
            });
        }


        if (this.studentPhotoInput) {
            this.studentPhotoInput.addEventListener('change', () => {
                const previewPhoto = document.getElementById('preview');

                if (previewPhoto) {
                    previewPhoto.style.display = 'block';
                    const [file] = this.studentPhotoInput.files;

                    if (file) {
                        previewPhoto.src = URL.createObjectURL(file);
                    }
                }
            });
        }

        if (this.deleteItinerancyForm) {
            const deleteItinerancyBtn = document.querySelectorAll('.delete-itinerancy-btn');
            const deleteItinerancyModal = document.getElementById('delete-itinerancy-modal');
            const deleteItinerancyModalObj = new bootstrap.Modal('#delete-itinerancy-modal');

            deleteItinerancyBtn.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    deleteItinerancyModalObj.show(btn);
                });
            });

            deleteItinerancyModal.addEventListener('show.bs.modal', (e) => {
                const form = deleteItinerancyModal.querySelector('#delete-itinerancy');
                const itinerancyName = deleteItinerancyModal.querySelector('#itinerancy-name');

                form.action = e.relatedTarget.dataset.value;
                itinerancyName.innerHTML = e.relatedTarget.dataset.name;
            });
        }

        if (this.deleteEvaluationForm) {
            const deleteEvaluationBtn = document.querySelectorAll('.delete-evaluation-btn');
            const deleteEvaluationModal = document.getElementById('delete-evaluation-modal');
            const deleteEvaluationModalObj = new bootstrap.Modal('#delete-evaluation-modal');

            deleteEvaluationBtn.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    deleteEvaluationModalObj.show(btn);
                });
            });

            deleteEvaluationModal.addEventListener('show.bs.modal', (e) => {
                const form = deleteEvaluationModal.querySelector('#delete-evaluation');
                const evaluationName = deleteEvaluationModal.querySelector('#evaluation-name');

                form.action = e.relatedTarget.dataset.value;
                evaluationName.innerHTML = e.relatedTarget.dataset.name;
            });
        }

        if (this.deleteStudentForm) {
            const deleteStudentBtn = document.querySelectorAll('.delete-student-btn');
            const deleteStudentModal = document.getElementById('delete-student-modal');
            const deleteStudentModalObj = new bootstrap.Modal('#delete-student-modal');

            deleteStudentBtn.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    deleteStudentModalObj.show(btn);
                });
            });

            deleteStudentModal.addEventListener('show.bs.modal', (e) => {
                const form = deleteStudentModal.querySelector('#delete-student');
                const studentName = deleteStudentModal.querySelector('#student-name');

                form.action = e.relatedTarget.dataset.value;
                studentName.innerHTML = e.relatedTarget.dataset.name;
            });
        }
    }

    async updateStudentOrder() {
        const formData = new FormData(this.form);
        const csrfTokenInput = document.querySelector('input[name="_token"]');
        const toastEl = document.querySelector('.toast');
        const toastElBody = toastEl.querySelector('.toast-body');
        toastElBody.innerHTML = '';
        const toast = bootstrap.Toast.getOrCreateInstance(toastEl);

        try {
            await fetch('/students/update_order', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfTokenInput.value,
                },
                body: formData,
            })
                .then(response => response.json())
                .then(result => {
                    const { status, message } = result;

                    if (status === 'success') {
                        toastElBody.innerHTML = message;

                        const accordionItems = Array.from(document.querySelectorAll('.accordion-item'));
                        let order = 1;

                        accordionItems.forEach(item => {
                            let rowOrder = item.querySelector('.row-id');
                            rowOrder.innerHTML = `# ${order}`;
                            order++;
                        });
                    } else {
                        toastElBody.innerHTML = 'Error Updating Order';
                        throw new Error(message);
                    }

                    toast.show();
                })
                .catch(error => {
                    toastElBody.innerHTML = 'Error Updating Order';
                    console.error('Error:', error);
                });
        } catch (error) {
            toastElBody.innerHTML = 'Error Updating Order';
            console.error('Error:', error);
        }
    }
}

new PaKuaEvaluations();


