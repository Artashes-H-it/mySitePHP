$(document).ready(function () {
  //var obj_date = { a: 50, b: 60, c: 70, d: 80 };
  $("form").submit(function (event) {
    var json;

    event.preventDefault();
    $.ajax({
      type: $(this).attr("method"),
      url: $(this).attr("action"),
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (result) {
        console.log(result);
        json = jQuery.parseJSON(result);
        //console.log(json);
        if (json.url) {
          window.location.href = "/" + json.url;
        } else {
          alert(json.status + " - " + json.massage);
        }
      },
    });
  });
});
