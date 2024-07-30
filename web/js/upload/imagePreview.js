$(function () {
  $('input[type="file"]').each(function () {
    $(this).on('change', function (event) {
      const file = event.target.files[0];
      if (file) {
          const blob = new Blob([file], { type: file.type });
          const image = document.createElement('img');
          const url = URL.createObjectURL(blob);

          image.src = url;
          image.style.maxWidth = '477px';
          image.style.marginTop = '24px'
          $(this).parent().append(image);
      }
    })
  })
})
