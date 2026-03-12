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

  document.querySelectorAll('.modal_stars, .modal_star').forEach(group => {
  // Для каждого контейнера с классом `.modal_stars`
  if (group.classList.contains('modal_stars')) {
    const radios = group.querySelectorAll('input[type="radio"]');
    let currentRating = 0;

    // Изначально берем выбранное
    const checked = group.querySelector('input[type="radio"]:checked');
    if (checked) {
      currentRating = parseInt(checked.value);
    }

    // Функция подсветки
    function setStars(count) {
      radios.forEach(r => {
        const starWrapper = r.closest('.modal_star');
        starWrapper.classList.remove('active');
        if (parseInt(r.value) <= count) {
          starWrapper.classList.add('active');
        }
      });
    }

    // Изначально подсветка
    setStars(currentRating);

    // Наведение и выбор
    radios.forEach(r => {
      const parentLabel = r.parentElement;

      parentLabel.addEventListener('mouseenter', () => {
        const hoverVal = parseInt(r.value);
        setStars(hoverVal);
      });

      parentLabel.addEventListener('mouseleave', () => {
        setStars(currentRating);
      });

      r.addEventListener('change', () => {
        currentRating = parseInt(r.value);
        setStars(currentRating);
      });
    });
  }

  // Для отдельных элементов .modal_star (если есть)
  if (group.classList.contains('modal_star')) {
    const r = group.querySelector('input[type="radio"]');
    if (!r) return;
    let fixedRating = parseInt(r.value);

    // Наведение
    group.addEventListener('mouseenter', () => {
      group.classList.add('hovered');
    });

    group.addEventListener('mouseleave', () => {
      group.classList.remove('hovered');
    });

    // Можно также добавить подсветку, если нужно
    // Но для простоты выбираем только цензурное выделение при hover
    // Или делаем так же, как внутри `.modal_stars`

    r.addEventListener('change', () => {
      fixedRating = parseInt(r.value);
    });
  }
});
});
