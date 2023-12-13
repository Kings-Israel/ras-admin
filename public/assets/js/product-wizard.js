/**
 *  Form Wizard
 */

'use strict';

(function () {
    // Init custom option check
    // window.Helpers.initCustomOptionCheck();

    // Vertical Wizard
    // --------------------------------------------------------------------

    const productDetailsWizard = document.querySelector('#product-details-wizard');

    if (typeof productDetailsWizard !== undefined && productDetailsWizard !== null) {
        // Wizard form
        const productDetailsWizardForm = productDetailsWizard.querySelector('#product-details-wizard-form');
        // Wizard steps
        const productDetailsWizardFormStep1 = productDetailsWizardForm.querySelector('#product-details');
        const productDetailsWizardFormStep2 = productDetailsWizardForm.querySelector('#product-media');

        // Wizard next prev button
        const productDetailsWizardNext = [].slice.call(productDetailsWizardForm.querySelectorAll('.btn-next'));
        const productDetailsWizardPrev = [].slice.call(productDetailsWizardForm.querySelectorAll('.btn-prev'));

        const validationStepper = new Stepper(productDetailsWizard, {
            linear: true
        });

        // Business Details
        const FormValidation1 = FormValidation.formValidation(productDetailsWizardFormStep1, {
            fields: {
                // * Validate the fields here based on your requirements
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter the product name'
                        }
                    }
                },
                category: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a category'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    // Use this for enabling/changing valid/invalid class
                    // eleInvalidClass: '',
                    eleValidClass: '',
                    rowSelector: '.form-group'
                }),
                submitButton: new FormValidation.plugins.SubmitButton()
            },
        }).on('core.form.valid', function () {
            // Jump to the next step when all fields in the current step are valid
            validationStepper.next();
        });

        // Property Details
        const FormValidation2 = FormValidation.formValidation(productDetailsWizardFormStep2, {
            fields: {
                images: {
                    validators: {
                        notEmpty: {
                            message: 'Please upload an image or images'
                        },
                        file: {
                            extension: 'jpeg,jpg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500000,
                            message: 'The selected file is not valid. Max Size is %MB',
                        },
                    }
                },
                video: {
                    validators: {
                        file: {
                            extension: 'mp4',
                            type: 'video/mp4',
                            maxSize: 10000000,
                            message: 'The selected file is not valid. Max size is 10MB',
                        }
                    }
                },
                description: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter product description'
                        }
                    }
                },
                model_number: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter product model number'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    // Use this for enabling/changing valid/invalid class
                    // eleInvalidClass: '',
                    eleValidClass: '',
                    rowSelector: '.form-group'
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            // Jump to the next step when all fields in the current step are valid
            validationStepper.next();
        });

        productDetailsWizardNext.forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
                // When click the Next button, we will validate the current step
                switch (validationStepper._currentIndex) {
                    case 0:
                        FormValidation1.validate();
                        break;

                    case 1:
                        FormValidation2.validate();
                        break;

                    default:
                        break;
                }
            });
        });

        productDetailsWizardPrev.forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault()
                switch (validationStepper._currentIndex) {
                    case 1:
                        validationStepper.previous();
                        break;

                    case 0:

                    default:
                        break;
                }
            });
        });
    }
})();
