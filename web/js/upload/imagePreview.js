$(function () {
  $('input[type="file"]').each(function () {
    $(this).on('change', function (event) {
      const file = event.target.files[0];
      if (file) {
          const blob = new Blob([file], { type: file.type });
          const image = document.createElement('img');
          const url = URL.createObjectURL(blob);

          image.src = url;
          image.className = 'img-fluid my-2'
          $(this).parent().find('img').remove()
          $(this).parent().append(image);
      }
    })
  })
})
