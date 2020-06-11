import './bootstrap';
import '../sass/app.scss';
import Dropzone from 'dropzone';
import 'ekko-lightbox';
import 'daterangepicker';
import moment from 'moment';

$(function () {
    $.urlParam = function (name) {
        var results = new RegExp('[?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return 0;
        }
        return results[1] || 0;
    };

    // Axios Setup
    const errorToast = $('.error-toast');
    axios.interceptors.response.use(
        function (response) {
            return response;
        },
        function (error) {
            if (error.response.status == 422) {
                const errorMessage = error.response.data.errors.email[0];
                $('.toast-body', errorToast).html(errorMessage);
                errorToast.toast('show');
            }
            return Promise.reject(error);
        },
    );

    // Lightbox
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true,
        });
    });

    $('body').tooltip({ selector: '[data-toggle=tooltip]' });

    Dropzone.autoDiscover = false;

    //upload form
    const uploadForm = $('#upload');
    if (uploadForm.length) {
        var uploadSubmit = $('.upload-submit');
        var infoSubmit = $('.info-submit');
        const maxFileSize = 1000;
        const nameInput = uploadForm.find('input[name="submitted_users_name"]');
        const phoneInput = uploadForm.find('input[name="phone_number"]');
        const emailInput = uploadForm.find('input[name="email"]');

        $('#upload .dz-input')
            .addClass('dropzone')
            .dropzone({
                url: uploadForm.attr('action'),
                addRemoveLinks: true,
                autoProcessQueue: false,
                maxFilesize: maxFileSize,
                maxFiles: 100,
                parallelUploads: 30,
                dictDefaultMessage: 'Click to upload from your computer or drag and drop media.',
                dictFallbackMessage: "Your browser doesn't support this upload form.",
                dictFileTooBig: `The file is too big. Max file size: ${maxFileSize}`,
                dictInvalidFileType: 'Invalid file type.',
                dictResponseError: 'Server response invalid.',
                acceptedFiles: 'image/*, .pdf, .wav, .mp3, .mp4',
            });

        var myDropzone = Dropzone.forElement('.dz-input');

        //send all the form data along with the files:
        myDropzone.on('sending', function (data, xhr, formData) {
            formData.append('_token', uploadForm.find('input[name="_token"]').val());
            formData.append('submitted_users_name', nameInput.val());
            formData.append('phone_number', phoneInput.val());
        });

        myDropzone.on('addedfile', function (file) {
            $('.dz-progress').hide();
        });

        const success = () => {
            setTimeout(() => {
                if ($('input[name="metadata"]:checked').val() == 'bulk') {
                    window.location = `/media-item/bulk`;
                } else {
                    axios
                        .get('/batch-submit')
                        .then(function ({ data }) {
                            window.location = `/media-item/${data}/edit`;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            }, 1000);
        };
        myDropzone.on('successmultiple', success);
        myDropzone.on('success', success);

        myDropzone.on('error', function (file) {
            uploadSubmit.prop('disabled', false);
            uploadSubmit.html('Submit for Approval');
        });

        infoSubmit.on('click', () => {
            infoSubmit.prop('disabled', true);
            infoSubmit.html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`,
            );

            const recaptchaInput = uploadForm.find('textarea[name="g-recaptcha-response"]');
            axios
                .post('/api/session-store', {
                    email: emailInput.val(),
                    'g-recaptcha-response': recaptchaInput.length > 0 && recaptchaInput.val(),
                })
                .then(() => $('#media-collapse').collapse('show'))
                .catch((e) => {
                    console.log(e);
                    infoSubmit.prop('disabled', false);
                    infoSubmit.html('Next');
                });
        });
        uploadSubmit.on('click', () => {
            uploadSubmit.prop('disabled', true);
            uploadSubmit.html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`,
            );
            $('.dz-progress').show();
            myDropzone.processQueue();
        });

        uploadForm.find('input[required]').on('input', validateInputs);
        uploadForm.find('textarea').on('change', validateInputs);
        window.recaptcha_callback = () => validateInputs();
        validateInputs();

        function validateInputs() {
            const recaptchaInput = uploadForm.find('textarea[name="g-recaptcha-response"]');
            let valid = true;
            const phoneDigits = phoneInput.val().match(/\d/g);
            if (nameInput.val() == '') valid = false;
            if (!phoneDigits || phoneDigits.length < 10) valid = false;
            if (emailInput.val() == '') valid = false;
            if (recaptcha.length > 0 && recaptchaInput.val() == '') valid = false;

            if (valid) infoSubmit.removeAttr('disabled');
            else infoSubmit.attr('disabled', 'disabled');
        }
    }

    //toast

    var toast = $('.auto-toast');
    toast.toast('show');

    //confirmation modal

    var editForm = $('.edit-form');
    var confirmTrigger = $('#confirm-info-button');
    var modalInputs = $('#info-modal .input');
    var modalSubmit = $('#info-modal-submit');

    confirmTrigger.on('click', function (e) {
        e.preventDefault();
        const copyrightMap = {
            open: 'Open to everyone to use',
            'non-commercial': 'Non-commercial use only',
            closed: 'No re-use permitted',
            na: 'I don’t own the copyright',
        };

        modalInputs.each((i, el) => {
            const name = $(el).data('name');
            let value = $(`[name="${name}"]`, editForm).val();

            if (name == 'copyright') value = copyrightMap[value];
            else if (name == 'authorization') value = value == 'true' ? 'Yes' : 'No';

            $(el).text(value);
        });
    });

    modalSubmit.on('click', function () {
        editForm.submit();
    });

    // Autofill
    $('.previous-autofill').on('click', function (e) {
        e.preventDefault();

        $('[data-previous]').each(function (index, element) {
            const input = $(element);
            input.val(input.data('previous'));
        });
        $('[data-previous-checked]').attr('checked', true);
    });

    // Select All
    $('.accordion-select-all').on('click', function (e) {
        e.preventDefault();
        $('.bulk-select').prop('checked', true);
    });
    $('.accordion-deselect-all').on('click', function (e) {
        e.preventDefault();
        $('.bulk-select').prop('checked', false);
    });
    $('.accordion-group-container .bulk-select').on('click', function (e) {
        e.stopPropagation();
    });

    // Bulk Approve/Reject
    $('.accordion-approve').on('click', function (e) {
        const items = $('.accordion-group-container .bulk-select:checked')
            .map((_, element) => $(element).val())
            .get();
        axios
            .post('/admin/approve', { items })
            .then(() => location.reload())
            .catch((error) => {
                console.log(error);
                location.reload();
            });
    });
    $('.accordion-reject').on('click', function (e) {
        const items = $('.accordion-group-container .bulk-select:checked')
            .map((_, element) => $(element).val())
            .get();
        axios
            .post('/admin/reject', { items })
            .then(() => location.reload())
            .catch((error) => {
                location.reload();
                console.log(error);
            });
    });

    // Date Range
    const dateRange = $('#reportrange');
    if (dateRange.length) {
        const start = moment($.urlParam('start'));
        const end = moment($.urlParam('end'));
        $('span', dateRange).html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        dateRange.daterangepicker(
            {
                startDate: start,
                endDate: end,
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [
                        moment().subtract(1, 'month').startOf('month'),
                        moment().subtract(1, 'month').endOf('month'),
                    ],
                },
            },
            (s, e) => {
                let redirect = `${window.location.origin}${window.location.pathname}`;
                redirect += `?start=${s.format('Y-M-D')}&end=${e.format('Y-M-D')}`;
                window.location = redirect;
            },
        );
    }
});
