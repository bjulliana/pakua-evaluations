import Sortable from 'sortablejs';
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle'

const studentsAccordion = document.getElementById('students-accordion');
const form = document.getElementById('itinerant-form');

if (studentsAccordion && form) {
    Sortable.create(studentsAccordion, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        handle: '.row-drag-icon',
        onUpdate: function (e) {
            updateStudentOrder()
        },
    });

    async function updateStudentOrder() {
        const formData = new FormData(form);
        const csrfTokenInput = document.querySelector('input[name="_token"]');
        const toastEl = document.querySelector('.toast');
        const toastElBody = toastEl.querySelector('.toast-body');
        toastElBody.innerHTML = '';
        const toast = bootstrap.Toast.getOrCreateInstance(toastEl)

        try {
            await fetch("/students/update_order", {
                method: "POST",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfTokenInput.value
                },
                body: formData,
            }).then(response => {
                return response.json();
            }).then(result => {
                const {
                    status,
                    message
                } = result;

                if (status === 'success') {
                    toastElBody.innerHTML = message;

                    const accordionItems = Array.from(document.querySelectorAll('.accordion-item'));
                    let order = 1;

                    accordionItems.forEach(item => {
                        let rowOrder = item.querySelector('.row-id');
                        rowOrder.innerHTML = `# ${order}`;
                        order++;
                    })

                } else {
                    toastElBody.innerHTML = 'Error Updating Order';
                    throw new Error(message);
                }

                toast.show();
            }).catch(error => {
                toastElBody.innerHTML = 'Error Updating Order';
                console.error("Error:", error);
            });
        } catch (error) {
            toastElBody.innerHTML = 'Error Updating Order';
            console.error("Error:", error);
        }
    }
}

const studentPhotoInput = document.getElementById('photo');

if (studentPhotoInput) {
    studentPhotoInput.addEventListener('change', () => {
        const previewPhoto = document.getElementById('preview');

        if (previewPhoto) {
            previewPhoto.style.display = 'block';
            const [file] = studentPhotoInput.files;

            if (file) {
                previewPhoto.src = URL.createObjectURL(file);
            }
        }
    })
}

const deleteItinerancyForm = document.getElementById('delete-itinerancy');
const deleteEvaluationForm = document.getElementById('delete-evaluation');
const deleteStudentForm = document.getElementById('delete-student');

if (deleteItinerancyForm) {
    const deleteItinerancyBtn = document.querySelectorAll('.delete-itinerancy-btn');
    const deleteItinerancyModal = document.getElementById('delete-itinerancy-modal');
    const deleteItinerancyModalObj = new bootstrap.Modal('#delete-itinerancy-modal');

    deleteItinerancyBtn.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            deleteItinerancyModalObj.show(btn);
        })
    })

    deleteItinerancyModal.addEventListener('show.bs.modal', (e) => {
        const form = deleteItinerancyModal.querySelector('#delete-itinerancy');
        const itinerancyName = deleteItinerancyModal.querySelector('#itinerancy-name');

        form.action = e.relatedTarget.dataset.value;
        itinerancyName.innerHTML = e.relatedTarget.dataset.name;
    })
}


if (deleteEvaluationForm) {
    const deleteEvaluationBtn = document.querySelectorAll('.delete-evaluation-btn');
    const deleteEvaluationModal = document.getElementById('delete-evaluation-modal');
    const deleteEvaluationModalObj = new bootstrap.Modal('#delete-evaluation-modal');

    deleteEvaluationBtn.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            deleteEvaluationModalObj.show(btn);
        })
    })

    deleteEvaluationModal.addEventListener('show.bs.modal', (e) => {
        const form = deleteEvaluationModal.querySelector('#delete-evaluation');
        const evaluationName = deleteEvaluationModal.querySelector('#evaluation-name');

        form.action = e.relatedTarget.dataset.value;
        evaluationName.innerHTML = e.relatedTarget.dataset.name;
    })
}


if (deleteStudentForm) {
    const deleteStudentBtn = document.querySelectorAll('.delete-student-btn');
    const deleteStudentModal = document.getElementById('delete-student-modal');
    const deleteStudentModalObj = new bootstrap.Modal('#delete-student-modal');

    deleteStudentBtn.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            deleteStudentModalObj.show(btn);
        })
    })

    deleteStudentModal.addEventListener('show.bs.modal', (e) => {
        const form = deleteStudentModal.querySelector('#delete-student');
        const studentName = deleteStudentModal.querySelector('#student-name');

        form.action = e.relatedTarget.dataset.value;
        studentName.innerHTML = e.relatedTarget.dataset.name;
    })
}



