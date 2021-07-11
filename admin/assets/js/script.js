jQuery(document).ready(function ($) {
  $("#addPhotoBtn").click(function (e) {
    e.preventDefault();

    wp.media.editor.open("addPhotoBtn");

    wp.media.editor.send.attachment = function (props, attachment) {
      if (attachment) {
        $("#photo-preview").removeClass("sv-invis");
        $("#addPhotoBtn").text("Replace photo");
        if (attachment.sizes.large) {
          $("#itemPhoto").val(attachment.sizes.large.url);
          $("#photo-preview").attr("src", attachment.sizes.large.url);
        } else {
          $("#itemPhoto").val(attachment.sizes.full.url);
          $("#photo-preview").attr("src", attachment.sizes.full.url);
        }
      }
    };
  });

  $('#player-postions input').change(function() {
    const position = $(this).attr('name');
    const player_positions = $('#player-postions input[name="positions"]');
    let new_player_positions = player_positions.val().split(',').filter(item => item);
    if(this.checked) {
      new_player_positions.push(position);
    }else{
      new_player_positions = new_player_positions.filter(item => item != position);
    }
    $(player_positions).val(new_player_positions.map(item => item.replace('position-','')).join(','))
  })
});
