import './bootstrap';
import Sortable from 'sortablejs';
//import bootstrap from 'bootstrap/dist/js/bootstrap.bundle'
import { Toast } from 'bootstrap'

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
        const toast = new Toast(toastEl);

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

