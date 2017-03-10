$(function()
{
  $('#RadioName').on('keyup', function(e) {
    var slug  = $(this).val().toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');

    if ($('#RadioSlug').prop('readonly')) {
      $('#RadioSlug').val(slug);
    }
  });

  $('.unlock-slug').on('click', function()
  {
    if ($('#RadioSlug').prop('readonly')) {
      $('.unlock-slug i').removeClass('entypo-lock').addClass('entypo-lock-open');
      $('#RadioSlug').removeAttr('readonly');
    } else {
      $('.unlock-slug i').removeClass('entypo-lock-open').addClass('entypo-lock');
      $('#RadioSlug').attr('readonly', true);
    }
  });

  $.validator.addMethod("domain", function(value, element) {
    return this.optional(element) || /^(?!www\.).*$/.test(value);
  }, "Retire o 'www.' do seu domínio.");

  $.validator.addClassRules("domain", { domain: true });

  $('#addToStreamingList').on('click', addFieldsToStreamingList);
  $('.remove-streaming').on('click', removeFromStreamingList);

  function addFieldsToStreamingList(e)
  {
    e.preventDefault();

    var urlPost = newStreamingUrl
      , quantity = $('#streamingLists .form-group').length;

    $.post(urlPost, { index: quantity },function(response)
    {
      $('#streamingLists').append(response);
      $('#streamingLists .remove-streaming').last().on('click', removeFromStreamingList);

      addValidationsToStreamingFields(quantity);
    });
  }

  function addValidationsToStreamingFields(index)
  {
    var rules = [
      {
        required: true,
        maxlength: 100,
        messages: {
          required: 'Campo obrigatório.',
          maxlength: 'O campo não pode ter mais de 100 caracteres.'
        }
      },
      {
        required: true,
        maxlength: 200,
        messages: {
          required: 'Campo obrigatório.',
          maxlength: 'O campo não pode ter mais de 200 caracteres.'
        }
      },
      {
        required: true,
        messages: {
          required: 'Campo obrigatório.'
        }
      },
      {
        required: true,
        messages: {
          required: 'Campo obrigatório.'
        }
      },
    ];

    $('[name^="data[Streaming][' + index + ']"]').each(function(key, value)
    {
      $(this).rules('add', rules[key]);
    });
  }

  function removeFromStreamingList(e)
  {
    e.preventDefault();

    $(this).parent().parent().remove();
  }
});