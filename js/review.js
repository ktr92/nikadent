$(document).ready(function () {
  if ($("[data-rating]").length > 0) {
    $("[data-rating] [data-stars]").each(function () {
      let wrapper = $(this);
      wrapper.find("[data-star]").each(function (index) {
        let star = $(this);
        let rating = star.closest("[data-rating]").data("rating");
        if (index < rating) {
          $(this).addClass("active");
        } else {
          return false;
        }
      });
    });
  }
/*   function setFocusAtEnd(element) {
    const range = document.createRange();
    const selection = window.getSelection();

    range.setStart(element, 1);
    range.collapse(true);

    selection.removeAllRanges();
    selection.addRange(range);
  } */
  document.addEventListener("click", (e) => {
    const $element = e.target;
    if (!$element.dataset.togglebutton) return;
    const value = $element.dataset.togglebutton;

    const $target = document.querySelector(`[data-toggleobject="${value}"]`);
    const pretext = $element.dataset.author;
    if (!$target) return;
    $target.hidden = !$target.hidden;

    /* const $fake = $target.querySelector('[data-input="replyformtext"]');
    const $real = $fake.nextElementSibling; */

    if (pretext) {
      const $input = $target.querySelector('[data-input="replyformtext"]');
      $input.focus();
       $input.value = pretext;

      
    /*   setFocusAtEnd($fake); */
    }

   /*  $fake.addEventListener("input", (e) => {
      $real.value = e.target.textContent;
      console.log($real.value);
    }); */
  });

  document.querySelectorAll('.modal_stars').forEach(starsContainer => {
  const radios = starsContainer.querySelectorAll('input[type="radio"]');

  let selectedRating = 0; // текущий выбранный рейтинг (при клике)
  
  // Изначально определяем выбранную оценку
  const checked = starsContainer.querySelector('input[type="radio"]:checked');
  if (checked) {
    selectedRating = parseInt(checked.value);
  }

  // Функция подсветки звезд до count
  function setStars(count) {
    radios.forEach(r => {
      const starWrapper = r.closest('.modal_star');
      starWrapper.classList.remove('active');
      if (parseInt(r.value) <= count) {
        starWrapper.classList.add('active');
      }
    });
  }

  // Изначочно подсвечиваем выбранную
  setStars(selectedRating);

  // Обработчики наведения
  radios.forEach(r => {
    const parentLabel = r.parentElement;

    parentLabel.addEventListener('mouseenter', () => {
      const hoverVal = parseInt(r.value);
      setStars(hoverVal);
    });
    
    parentLabel.addEventListener('mouseleave', () => {
      setStars(selectedRating);
    });

    // Обработка выбора
    r.addEventListener('change', () => {
      selectedRating = parseInt(r.value);
      setStars(selectedRating);
    });
  });
});
});
