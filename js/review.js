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
          return false
        }
      })
    })
  }

});