$(document).ready(function () {
  // Filter the recipes by a given word.
  $("#search-button").on("click", function (event) {
    event.preventDefault();
    let filter = $("#search-input").val();
    $.ajax({
      url: "filter-recipes",
      type: "GET",
      data: "filter=" + filter + "&type=word",
      success: function (response) {
        renderTemplate($.parseJSON(response), $("#filtered-recipes"), filter);
      }
    });
  });

  // Filter the recipes by a given tag.
  $("span[data-type='tag']").on("click", function (event) {
    let tag = $(event.target).html();
    $.ajax({
      url: "filter-recipes",
      type: "GET",
      data: "filter=" + tag + "&type=tag",
      success: function (response) {
        renderTemplate($.parseJSON(response), $("#filtered-recipes"), tag);
      }
    });
  });

  // Reset the HTML generate by the filter.
  $("span#reset-filter").on("click", function () {
    $("#filtered-recipes").html("");
  });
});

/**
 * Render a template for the filter.
 *
 * @param {string} data
 * @param {jQuery object} div
 * @param {string} filter
 */
function renderTemplate(data, div, filter) {
  div.html("");
  $.each(data, function (key, value) {
    let description = value["rec_description"];
    if (description.length > 255) {
      description = description.substring(0, 255) + "...";
    }
    let difficulty = value["rec_difficulty"];
    let difference = 5 - difficulty;
    let difficultyToDisplay = "";
    for (let i = 0; i < difficulty; i++) {
      difficultyToDisplay += `<span><i class="fas fa-circle"></i></span>`;
    }
    for (let i = 0; i < difference; i++) {
      difficultyToDisplay += `<span><i class="far fa-circle"></i></span>`;
    }
    div.append(
      `<a href="recipe-details?filter=${filter}&id=${value["rec_id"]}" class="card text-dark mb-4 w-100">
        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="/Shlagithon/assets/images/${value["rec_image"]}" class="card-img w-100" alt="image">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">${value["rec_name"]}</h5>
              <p class="card-text">${description}</p>
              <div class="row">
                <div class="col-md-4 text-center"><p class="card-text">${difficultyToDisplay}</p></div>
                <div class="col-md-4 text-center"><p class="card-text"><i class="fas fa-stopwatch"></i> ${value["rec_time"]} min</p></div>
                <div class="col-md-4 text-center"><p class="card-text"><i class="fas fa-users"></i> ${value["rec_nb_persons"]} personne.s</p></div>
              </div>
            </div>
          </div>
        </div>
      </a>`
    );
  });
}