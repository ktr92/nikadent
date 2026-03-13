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
    document.querySelectorAll(`[data-toggleobject]`).forEach((item) => {
      if (item !== $target) {
        item.hidden = true;
      }
    });
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

  document.querySelectorAll(".modal_stars, .modal_star").forEach((group) => {
    if (group.classList.contains("modal_stars")) {
      const radios = group.querySelectorAll('input[type="radio"]');
      let currentRating = 0;

      const checked = group.querySelector('input[type="radio"]:checked');
      if (checked) {
        currentRating = parseInt(checked.value);
      }

      function setStars(count) {
        radios.forEach((r) => {
          const starWrapper = r.closest(".modal_star");
          starWrapper.classList.remove("active");
          if (parseInt(r.value) <= count) {
            starWrapper.classList.add("active");
          }
        });
      }

      setStars(currentRating);

      radios.forEach((r) => {
        const parentLabel = r.parentElement;

        parentLabel.addEventListener("mouseenter", () => {
          const hoverVal = parseInt(r.value);
          setStars(hoverVal);
        });

        parentLabel.addEventListener("mouseleave", () => {
          setStars(currentRating);
        });

        r.addEventListener("change", () => {
          currentRating = parseInt(r.value);
          setStars(currentRating);
        });
      });
    }

    if (group.classList.contains("modal_star")) {
      const r = group.querySelector('input[type="radio"]');
      if (!r) return;
      let fixedRating = parseInt(r.value);

      group.addEventListener("mouseenter", () => {
        group.classList.add("hovered");
      });

      group.addEventListener("mouseleave", () => {
        group.classList.remove("hovered");
      });

      r.addEventListener("change", () => {
        fixedRating = parseInt(r.value);
      });
    }
  });

  document.querySelectorAll("form.reviewblock-form").forEach((form) => {
    form.addEventListener("submit", function (e) {
      let valid = true;
      // Удаляем все старые ошибки
      form
        .querySelectorAll(".modal_error-message")
        .forEach((el) => el.remove());

      // Проверка оценки (звезды)
      const stars = form.querySelectorAll(
        'input[type="radio"][name="modal_rating"][data-validation="stars"]',
      );
      const isStarSelected = Array.from(stars).some((r) => r.checked);
      if (!isStarSelected) {
        valid = false;
        let error = document.createElement("div");
        error.className = "modal_error-message";
        error.style.color = "red";
        error.innerText = "Пожалуйста, выберите оценку.";
        stars[0].closest('[data-validation="container"]').appendChild(error);
      }

      const multiFields = form.querySelectorAll('[data-validation="multiple"]');
      if (multiFields && multiFields.length) {
        const isAnyFilled = Array.from(multiFields).some((field) => {
          if (
            field.tagName.toLowerCase() === "input" ||
            field.tagName.toLowerCase() === "textarea"
          ) {
            return field.value.trim() !== "";
          }
          return false;
        });

        if (!isAnyFilled) {
          valid = false;
          const container = multiFields[0].closest(
            'div[data-validation="container"]',
          );

          if (!container.querySelector(".modal_error-message")) {
            let error = document.createElement("div");
            error.className = "modal_error-message";
            error.style.color = "red";
            error.innerText =
              'Пожалуйста, заполните хотя бы одно из полей: "Преимущества", "Недостатки" или "Комментарии".';
            container.appendChild(error);
          }
        }
      }

      const checkbox = form.querySelector(
        'input[type="checkbox"][data-validation="confirm"]',
      );
      if (!checkbox.checked) {
        valid = false;
        const checkGroup = checkbox.closest('[data-validation="container"]');
        if (checkGroup && !checkGroup.querySelector(".modal_error-message")) {
          const error = document.createElement("div");
          error.className = "modal_error-message";
          error.style.color = "red";
          error.innerText = "Пожалуйста, дайте согласие.";
          checkGroup.appendChild(error);
        }
      }

      if (!valid) {
        e.preventDefault(); // не даем форме отправиться, пока есть ошибки
      }
    });
  });
});
