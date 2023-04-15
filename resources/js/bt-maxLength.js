(function($) {
  'use strict';
  $('#txtnumero_cas_editar').maxlength({
    alwaysShow: true,
    threshold: 10,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' de ',
    preText: 'Tu tienes ',
    postText: ' caracteres introducidos.',
    validate: true
  });
  $('#txtdias_editar').maxlength({
    alwaysShow: true,
    threshold: 4,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' de ',
    preText: 'Tu tienes ',
    postText: ' caracteres introducidos.',
    validate: true
  });
  $('#txtmeses_editar').maxlength({
    alwaysShow: true,
    threshold: 2,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' de ',
    preText: 'Tu tienes ',
    postText: ' caracteres introducidos.',
    validate: true
  });
  $('#txtanhios_editar').maxlength({
    alwaysShow: true,
    threshold: 2,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' de ',
    preText: 'Tu tienes ',
    postText: ' caracteres introducidos.',
    validate: true
  });
  $('#txtnumero_cas').maxlength({
    alwaysShow: true,
    threshold: 10,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' de ',
    preText: 'Tu tienes ',
    postText: ' caracteres introducidos.',
    validate: true
  });
  $('#txtdias').maxlength({
    alwaysShow: true,
    threshold: 4,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' de ',
    preText: 'Tu tienes ',
    postText: ' caracteres introducidos.',
    validate: true
  });
  $('#txtmeses').maxlength({
    alwaysShow: true,
    threshold: 2,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' de ',
    preText: 'Tu tienes ',
    postText: ' caracteres introducidos.',
    validate: true
  });
  $('#txtanhios').maxlength({
    alwaysShow: true,
    threshold: 2,
    warningClass: "badge mt-1 badge-success",
    limitReachedClass: "badge mt-1 badge-danger",
    separator: ' de ',
    preText: 'Tu tienes ',
    postText: ' caracteres introducidos.',
    validate: true
  });
})(jQuery);
