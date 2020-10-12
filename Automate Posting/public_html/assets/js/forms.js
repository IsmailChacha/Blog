/*
*  Dirtyness Change Events
*  Are-You-Sure fires off "dirty" and "clean" events when the form's state
*  changes. You can bind() or on(), these events to implement your own form
*  state logic.  A good example is enabling/disabling a Save button.
*
*  "this" refers to the form that fired the event.
*/
$('form').on('dirty.areYouSure', function() {
  // Enable save button only as the form is dirty.
  $(this).find('button').removeAttr('disabled');
});
$('form').on('clean.areYouSure', function() {
  // Form is clean so nothing to save - disable the save button.
  $(this).find('button').attr('disabled', 'disabled');
});