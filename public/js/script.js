$(function () {
    $(".like-btn").click(function (){

        const reaction_id = $(this).data('icmt')

        axios.post('/likes', {
            reaction_id: parseInt(reaction_id)
        }).then(function (response) {
            const display_total_likes = $('#reaction-' + reaction_id);
            $(display_total_likes).html(response.data.likes_total)
        }).catch(function (error) {
            console.log('error', error);
        });
    });
});